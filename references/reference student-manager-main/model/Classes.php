<?php
require_once '__DIR__./../Config/database.php';
//Classes table structure is 
/*
|classid   | int unsigned | NOT NULL | Primary key | No default | auto_increment
|classname | varchar(50)  | NOT NULL |             | No default |
|teacher   | varchar(50)  | NOT NULL |             | No default |
*/

function createClass($classname, $teacher) {
    global $db;
    $sql = "INSERT INTO Classes (classid, classname, teacher)
                    VALUES (:classid, :classname, :teacher)";

    try {
        $stmt = $db->prepare($sql);

        return $stmt->execute([
            ':classname' => $classname,
            'teacher' => $teacher,
        ]);
        return true;
    }
    catch (PDOException $e) {
        throw $e;
    }
}

function getClasses() {
    global $db;
    $sql = "SELECT * FROM Classes
            ORDER BY classid";
    $statement = $db->prepare($sql);
    $statement->execute();
    return $statement;
}

function retrieveStudent($classid) {
    global $db;

    $sql = "SELECT * FROM Classes
            WHERE classid = :classid";

    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':classid' => $classid
    ]);

    $class = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$class) {
        throw new Exception("Class with ID {$classid} does not exist.");
    }

    return $class;
}
//update functions
function editClassName($classid, $newClassName) {
    global $db;

    $sql = "UPDATE Classes
            SET classname = :classname
            WHERE classid = :classid";

    try {
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':classname' => $newClassName,
            ':classid' => $classid
        ]);

        if ($stmt->rowCount() === 0) {
            throw new Exception("Class with ID {$classid} does not exist.");
        }

        return true;

    } catch (PDOException $e) {
        throw $e;
    }
}

function editClassTeacher($classid, $newTeacher) {
    global $db;

    $sql = "UPDATE Classes
            SET teacher = :teacher
            WHERE classid = :classid";
    
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':teacher' => $newTeacher,
            ':classid' => $classid
        ]);

        if ($stmt->rowCount() === 0) {
            throw new Exception("Class with ID {$classid} does not exist.");
        }

        return true;

    } catch (PDOException $e) {
        throw $e;
    }
}

function removeClass($classid) {
    global $db;

    $sql = "DELETE FROM Classes
            WHERE classid = :classid";

    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':classid' => $classid
    ]);

    // If no rows were deleted, the student doesn't exist
    if ($stmt->rowCount() === 0) {
        throw new Exception("Class with ID {$classid} does not exist.");
    }

    return true;
}
?>