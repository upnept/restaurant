<?php
require_once '__DIR__./../Config/database.php';
//Enrollments table structure is 
/*
|enrollmentid | int unsigned | NOT NULL | Primary key | No default | auto_increment
|studentid    | int unsigned | NULLABLE | Foreign Key | No default |
|classid      | int unsigned | NULLABLE | Foreign Key | No default |
|grade        | varchar(3)   | NULLABLE |             | No default |
*/

function createEnrollment($studentid, $classid, $grade) {
    global $db;
    $sql = "INSERT INTO Enrollments (studentid, classid, grade)
                    VALUES (:studentid, :classid, :grade)";

    try {
        $stmt = $db->prepare($sql);

        return $stmt->execute([
            ':studentid' => $studentid,
            ':classid' => $classid,
            ':grade' => $grade
        ]);
        return true;
    }
    catch (PDOException $e) {
        if ($e->getCode() == '23000') {
            return "Enrollment already exists.";
        }
        throw $e;
    }
}

function getEnrollments() {
    global $db;
    $sql = "SELECT * FROM Enrollments
            ORDER BY enrollmentid";
    $statement = $db->prepare($sql);
    $statement->execute();
    return $statement;
}

function retrieveEnrollments($enrollmentid) {
    global $db;

    $sql = "SELECT * FROM Enrollments
            WHERE enrollmentid = :enrollmentid";

    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':enrollmentid' => $enrollmentid
    ]);

    $enrollment = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$enrollment) {
        throw new Exception("Enrollment with ID {$enrollmentid} does not exist.");
    }

    return $enrollment;
}
//update functions
function editGrade($enrollmentid, $newGrade) {
    global $db;

    $sql = "UPDATE Enrollments
            SET grade = :grade
            WHERE enrollmentid = :enrollmentid";

    try {
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':grade' => $newGrade
        ]);

        if ($stmt->rowCount() === 0) {
            throw new Exception("Enrollment with ID {$enrollmentid} does not exist.");
        }

        return true;

    } catch (PDOException $e) {

        throw $e;
    }
}

function removeEnrollment($enrollmentid) {
    global $db;

    $sql = "DELETE FROM Enrollments
            WHERE enrollmentid = :enrollmentid";

    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':enrollmentid' => $enrollmentid
    ]);

    // If no rows were deleted, the student doesn't exist
    if ($stmt->rowCount() === 0) {
        throw new Exception("Enrollment with ID {$enrollmentid} does not exist.");
    }

    return true;
}
?>