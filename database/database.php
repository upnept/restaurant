<?php
    $db_host = 'localhost';
    $db_name = 'restaurant';
    $dsn = 'mysql:host=localhost;dbname=restaurant';
    $username = 'food_mngr';
    $password = 'password';

    try {
        $db = new PDO($dsn, $username, $password);

        $sqlContent = file_get_contents('database/createDB.sql'); // newer method of executing the sql on init

        $queries = array_filter(array_map('trim', explode(';', $sqlContent)));

        foreach ($queries as $query) {
            if ($query !== '') {
                if (!$db->query($query)) {
                    throw new Exception("Error executing query: " . $mysqli->error);
                }
            }
        }

        echo "Init SQL executed successfully.";
    } catch (PDOException $e) {
        $error_message =$e->getMessage();
        include('database_error.php');
        exit();
    }
?>
