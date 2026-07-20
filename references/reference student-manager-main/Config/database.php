<?php
//Establish PDO and database connection
    $db_host = 'localhost';
    $db_name = 'student_db';
    $dsn = 'mysql:host=localhost;dbname=student_db';
    $username = 'stdnt_mngr';
    $password = 'password';
    $db;

    //Attempt connection to Database
    try {
        $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        $error_message =$e->getMessage();
        include('database_error.php');
        exit();
    }

    ?>