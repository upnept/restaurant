<?php
$lifetime = 60 * 60 * 24 * 365 * 3;
session_set_cookie_params($lifetime, '/');
session_start();

if (!isset($_COOKIE['lastVisit'])) {
    setcookie("lastVisit", date("Y-m-d H:i:s"), time() + (86400 * 30), "/");
    $welcomeMessage = "Welcome! This is your first visit.";
} else {
    $welcomeMessage = "Welcome back! Last visit: " . $_COOKIE['lastVisit'];
    setcookie("lastVisit", date("Y-m-d H:i:s"), time() + (86400 * 30), "/");
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// database
require_once('database/database.php');

// models
require_once('models/item.php');
require_once('models/user.php');
require_once('models/order.php');
require_once('models/cart.php');

$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        $action = 'menu';
    }
}

switch ($action) {
    case 'menu':
        $items = getItems();
        include('views/products/index.php');
        break;

    case 'cart':
        include('views/cart/index.php');
        break;

    case 'add_to_cart':
        $menuItemId = filter_input(INPUT_POST, 'menu_item_id', FILTER_VALIDATE_INT);
        $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);

        if ($menuItemId !== false && $menuItemId !== null &&
            $quantity !== false && $quantity !== null) {
            add_item($menuItemId, $quantity);
        }

        header("Location: .?action=cart");
        exit();
        break;

    case 'update_cart':
        $new_qty_list = filter_input(INPUT_POST, 'newqty', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        if ($new_qty_list) {
            foreach ($new_qty_list as $key => $qty) {
                update_item($key, $qty);
            }
        }

        header("Location: .?action=cart");
        exit();
        break;

    case 'register':
        $name = '';
        $email = '';
        $phone = '';
        $address = '';
        $errors = [];

        include('views/portal/register.php');
        break;

    case 'do_register':
        $name = trim(filter_input(INPUT_POST, 'name'));
        $email = trim(filter_input(INPUT_POST, 'email'));
        $password = filter_input(INPUT_POST, 'password');
        $confirm_password = filter_input(INPUT_POST, 'confirm_password');
        $phone = trim(filter_input(INPUT_POST, 'phone'));
        $address = trim(filter_input(INPUT_POST, 'address'));

        $errors = [];

        if ($name === '') {
            $errors[] = 'Name is required.';
        }

        $email_pattern = '/^[^@\s]+@[^@\s]+\.[^@\s]+$/';
        if ($email === '') {
            $errors[] = 'Email is required.';
        } elseif (!preg_match($email_pattern, $email)) {
            $errors[] = 'Please enter a valid email address.';
        } elseif (email_exists($email)) {
            $errors[] = 'An account with that email already exists.';
        }

        $password_pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
        if ($password === '') {
            $errors[] = 'Password is required.';
        } elseif (!preg_match($password_pattern, $password)) {
            $errors[] = 'Password must be at least 8 characters and include an uppercase letter, lowercase letter, number, and special character.';
        } elseif ($password !== $confirm_password) {
            $errors[] = 'Passwords do not match.';
        }

        $phone_pattern = '/^\d{3}-\d{3}-\d{4}$/';
        if ($phone !== '' && !preg_match($phone_pattern, $phone)) {
            $errors[] = 'Phone must be in 000-000-0000 format.';
        }

        if (!empty($errors)) {
            include('views/portal/register.php');
        } else {
            $userId = add_user($name, $email, $password, $phone, $address);

            $_SESSION['user_id'] = $userId;
            $_SESSION['user_name'] = $name;
            $_SESSION['is_admin'] = false;
            $_SESSION['user_address'] = $address;

            $_SESSION['message'] = "Welcome, $name! Your account has been created.";
            header("Location: .?action=menu");
            exit();
        }
        break;

    case 'login':
        $login_message = '';
        include('views/portal/login.php');
        break;

    case 'do_login':
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');

        $user = is_valid_user_login($email, $password);

        if ($user !== false) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['is_admin'] = (bool) $user['is_admin'];
            $_SESSION['user_address'] = $user['address'];

            if ($_SESSION['is_admin']) {
                header("Location: .?action=admin_menu");
            } else {
                header("Location: .?action=menu");
            }
            exit();
        } else {
            $login_message = 'Invalid email or password.';
            include('views/portal/login.php');
        }
        break;

    case 'logout':
        $_SESSION = array();
        session_destroy();
        header("Location: .?action=menu");
        exit();
        break;

    case 'checkout':
        require_once('util/valid_user.php');
        $checkout_message = '';
        include('views/orders/checkout.php');
        break;

    case 'place_order':
        require_once('util/valid_user.php');
        $address = trim(filter_input(INPUT_POST, 'address'));

        if (empty($address)) {
            $checkout_message = 'Address is required.';
            include('views/orders/checkout.php');
        } else {
            $cartItems = $_SESSION['cart'] ?? [];
            $orderId = place_order($_SESSION['user_id'], $cartItems, $address);

            if ($orderId === false) {
                $checkout_message = 'Your cart is empty.';
                include('views/orders/checkout.php');
            } else {
                unset($_SESSION['cart']);
                $_SESSION['message'] = "Order #$orderId placed successfully!";
                header("Location: .?action=view_order&orderid=$orderId");
                exit();
            }
        }
        break;

    case 'order_history':
        require_once('util/valid_user.php');
        $orders = get_orders_for_user($_SESSION['user_id']);
        include('views/orders/history.php');
        break;

    case 'view_order':
        require_once('util/valid_user.php');
        $orderId = filter_input(INPUT_GET, 'orderid', FILTER_VALIDATE_INT);
        $order = get_order_for_user($orderId, $_SESSION['user_id']);

        if ($order === false) {
            header("Location: .?action=order_history");
            exit();
        }

        $orderItems = get_order_items($orderId);
        include('views/orders/view.php');
        break;

    default:
        $items = getItems();
        include('views/products/index.php');
        break;
}
?>
