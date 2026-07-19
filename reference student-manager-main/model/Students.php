<?php
/*
Library of Student related functions for adding, editing, removing, and otherwise manipulating the Student table
*/
require_once '__DIR__./../Config/database.php';
//Students table structure is 
/*
|studentid | int unsigned | NOT NULL | Primary key | No default | auto_increment
|firstname | varchar(50)  | NOT NULL |             | No default |
|lastname  | varchar(50)  | NOT NULL |             | No default |
|dob       | varchar(50)  | NOT NULL |             | No default |
|email     | varchar(50)  | NOT NULL |             | No default |

*/

function createStudent($fn, $ln, $dob, $email) {
    global $db;
    $sql = "INSERT INTO Students (firstname, lastname, dob, email)
                    VALUES (:firstname, :lastname, :dob, :email)";

    try {
        $stmt = $db->prepare($sql);

        return $stmt->execute([
            ':firstname' => $fn,
            ':lastname' => $ln,
            ':dob' => $dob,
            ':email' => $email
        ]);
        return true;
    }
    catch (PDOException $e) {
        if ($e->getCode() == '23000') {
            return "Email already exists.";
        }
        throw $e;
    }
}

function getStudents() {
    global $db;
    $sql = "SELECT * FROM Students
            ORDER BY studentid";
    $statement = $db->prepare($sql);
    $statement->execute();
    return $statement;
}

function retrieveStudent($studentID) {
    global $db;

    $sql = "SELECT * FROM Students
            WHERE studentid = :studentid";

    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':studentid' => $studentID
    ]);

    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        throw new Exception("Student with ID {$studentID} does not exist.");
    }

    return $student;
}
//update functions
function update_student($studentid, $firstname, $lastname, $dob, $email) {
    global $db;

    $sql = "UPDATE Students
            SET firstname = :firstname,
                lastname = :lastname,
                dob = :dob,
                email = :email
            WHERE studentid = :studentid";

    try {
        $stmt = $db->prepare($sql);

        $stmt->execute([
            ':studentid' => $studentid,
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':dob' => $dob,
            ':email' => $email
        ]);

        return true;

    } catch (PDOException $e) {

        if ($e->getCode() == 23000) {
            return "Email already exists.";
        }

        throw $e;
    }
}

function removeStudent($studentID) {
    global $db;

    $sql = "DELETE FROM Students
            WHERE studentid = :studentid";

    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':studentid' => $studentID
    ]);

    // If no rows were deleted, the student doesn't exist
    if ($stmt->rowCount() === 0) {
        throw new Exception("Student with ID {$studentID} does not exist.");
    }

    return true;
}
?>
