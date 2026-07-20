<?php
    $db_host = 'localhost';
    $db_name = 'restaurant';
    $dsn = 'mysql:host=localhost';
    $username = 'food_mngr';
    $password = 'password';

    try {
        $db = new PDO($dsn, $username, $password);

        $sqlContent = file_get_contents('database/createDB.sql'); // newer method of executing the sql on init

        $queries = array_filter(array_map('trim', explode(';', $sqlContent)));

        foreach ($queries as $query) {
            if ($query !== '') {
                if (!$db->query($query)) {
                    $errorInfo = $db->errorInfo();
                    throw new Exception("Error executing query: " . $errorInfo[2]);
                }
            }
        }
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('database/database_error.php');
        exit();
    }
?>
