<?php
    //Establish PDO and database connection
    $db_host = 'localhost';
    $db_name = 'restaurant';
    $dsn = 'mysql:host=localhost;dbname=restaurant';
    $username = 'food_mngr';
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