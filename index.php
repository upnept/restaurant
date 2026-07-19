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

require_once('models/initializeDB.php');
require_once('models/database.php');

require_once('models/Students.php');


$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        $action = 'list_students'; // default if no action
    }
}

switch ($action) {
    case 'list_students':
        $students = getStudents();

        include(VIEWS_PATH . '/tables/student_list.php');

        break;
    case 'show_add_form':
        include(VIEWS_PATH . '/tables/student_add.php');

        break;
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
    case 'delete_student':
        $studentid = filter_input(INPUT_GET, 'studentid', FILTER_VALIDATE_INT);

        removeStudent($studentid);

        $_SESSION['message'] = "Student deleted successfully.";

        header("Location: index.php");
        exit();

        break;

    default:
        $students = getStudents();

        include(VIEWS_PATH . '/tables/student_list.php');

        break;
}
?>