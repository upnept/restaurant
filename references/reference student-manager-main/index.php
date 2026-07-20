<?php
// Start session management with a persistent cookie
$lifetime = 60 * 60 * 24 * 365 * 3;    // 3 yr in sec
session_set_cookie_params($lifetime, '/');
session_start();

/*
Cookie
*/

if (!isset($_COOKIE['lastVisit'])) {
    setcookie("lastVisit", date("Y-m-d H:i:s"), time() + (86400 * 30), "/");
    $welcomeMessage = "Welcome! This is your first visit.";
} else {
    $welcomeMessage = "Welcome back! Last visit: " . $_COOKIE['lastVisit'];

    // Update cookie
    setcookie("lastVisit", date("Y-m-d H:i:s"), time() + (86400 * 30), "/");
}

/*
--------------------------------------------------------------------
----------Debug, comment out if not debugging-----------------------
--------------------------------------------------------------------
*/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//include database functions
require_once('model/initializeDB.php');
require_once('Config/database.php');
//require_once('student_db.php');

//Include Paths
require_once(__DIR__.'/Config/paths.php');
//include other required functions
require_once(MODELS_PATH.'/Students.php');


// Get the action to perform
$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        $action = 'list_students';
    }
}

/* ===========================
   CONTROLLER
=========================== */

switch ($action) {

    // Display all students
    case 'list_students':

        $students = getStudents();

        include(VIEWS_PATH . '/tables/student_list.php');

        break;


    // Show Add Student page
    case 'show_add_form':

        include(VIEWS_PATH . '/tables/student_add.php');

        break;


    // Add new student
    case 'add_student':

        $firstname = filter_input(INPUT_POST, 'firstname');
        $lastname  = filter_input(INPUT_POST, 'lastname');
        $dob       = filter_input(INPUT_POST, 'dob');
        $email     = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

        if ($firstname == NULL ||
            $lastname == NULL ||
            $dob == NULL ||
            $email == FALSE) {

            $error_message = "Please complete all fields correctly.";
            include(MODELS_PATH . '/database_error.php');

        } else {

            $result = createStudent($firstname, $lastname, $dob, $email);

            if ($result === true) {
                $_SESSION['message'] = "Student added successfully.";
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['message'] = $result;
            }

            header("Location: index.php");
            exit();
        }

        break;


    // Show Edit page
    case 'show_edit_form':

        $studentid = filter_input(INPUT_POST, 'studentid', FILTER_VALIDATE_INT);

        if ($studentid === null || $studentid === false) {
            $studentid = filter_input(INPUT_GET, 'studentid', FILTER_VALIDATE_INT);
        }

        if ($studentid === false || $studentid === null) {
            // Handle invalid or missing student ID
            exit('Invalid student ID.');
        }

        $student = retrieveStudent($studentid);

        include(VIEWS_PATH . '/tables/student_edit.php');

    break;


    // Update student
    case 'update_student':

        $studentid = filter_input(INPUT_POST, 'studentid', FILTER_VALIDATE_INT);
        $firstname = filter_input(INPUT_POST, 'firstname');
        $lastname  = filter_input(INPUT_POST, 'lastname');
        $dob       = filter_input(INPUT_POST, 'dob');
        $email     = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

        $result = update_student($studentid, $firstname, $lastname, $dob, $email);

        if ($result === true) {
            $_SESSION['message'] = "Student updated successfully.";
        } else {
            $_SESSION['message'] = $result;
        }

        header("Location: index.php");
        exit();

        break;


    // Delete student
    case 'delete_student':

        $studentid = filter_input(INPUT_GET, 'studentid', FILTER_VALIDATE_INT);

        removeStudent($studentid);

        $_SESSION['message'] = "Student deleted successfully.";

        header("Location: index.php");
        exit();

        break;


    // Unknown action
    default:

        $students = getStudents();

        include(VIEWS_PATH . '/tables/student_list.php');

        break;
}

/* Add or update cart as needed
switch($action) {
    case 'init_DB':
        createStudentsTable();
        createClassesTable();
        createEnrollmentsTable();
        break;
    case 'add':
        $product_key = filter_input(INPUT_POST, 'productkey');
        $item_qty = filter_input(INPUT_POST, 'itemqty');
        add_item($product_key, $item_qty);
        include('cart_view.php');
        break;
    case 'update':
        $new_qty_list = filter_input(INPUT_POST, 'newqty', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        foreach($new_qty_list as $key => $qty) {
            if ($_SESSION['cart12'][$key]['qty'] != $qty) {
                update_item($key, $qty);
            }
        }
        include('cart_view.php');
        break;
    case 'show_cart':
        include('cart_view.php');
        break;
    case 'show_add_item':
        include('add_item_view.php');
        break;
    case 'empty_cart':
        unset($_SESSION['cart12']);
        include('cart_view.php');
        break;
}
        
?>
*/

?>
