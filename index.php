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

// init database
require_once('database/database.php');

// init models
//require_once('models/Students.php');

$action = filter_input(INPUT_POST, 'action');

switch ($action) {
    case 'menu':
        $items = getItems();

        include('views/products/index.php');

        break;
    case 'cart':
        include('views/cart/index.php');

        break;
    case 'login':
        include('views/portal/login.php');

        break;
    case 'register':
        include('views/portal/register.php');

        break;
    default:
        $items = getItems();

        include('views/products/index.php');

        break;
}
?>