<?php
/**
 * Contains functions for the initial creation of tables.
 */

require_once '_DIR_./../Config/database.php';

// students: student_id (prim key), first_name, last_name, dob, email
// classes: class_id (prim key), class_name, teacher
// enrollments: enrollment_id (prim key), student_id (foreign key), class_id (foreign key), grade

function createStudentsTable(): void
{
    try {
        global $db;

        $sql = "CREATE TABLE IF NOT EXISTS Students (
            studentid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(50) NOT NULL,
            lastname VARCHAR(50) NOT NULL,
            dob DATE NOT NULL,
            email VARCHAR(50) NOT NULL
        )";

        $db->exec($sql);
        echo "Student table created";
    } catch (PDOException $e) {
        echo "Error creating Students table:<br>" . $e->getMessage();
    }
}

function createClassesTable(): void
{
    try {
        global $db;

        $sql = "CREATE TABLE IF NOT EXISTS Classes (
            classid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            classname VARCHAR(50) NOT NULL,
            teacher VARCHAR(50) NOT NULL
        )";

        $db->exec($sql);
        echo "Classes table created";
    } catch (PDOException $e) {
        echo "Error creating Classes table:<br>" . $e->getMessage();
    }
}

function createEnrollmentsTable(): void
{
    try {
        global $db;

        $sql = "CREATE TABLE IF NOT EXISTS Enrollments (
            enrollmentid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            studentid INT(6) UNSIGNED,
            classid INT(6) UNSIGNED,
            grade VARCHAR(3),
            CONSTRAINT fk_student
                FOREIGN KEY (studentid)
                REFERENCES Students(studentid),
            CONSTRAINT fk_class
                FOREIGN KEY (classid)
                REFERENCES Classes(classid)
        )";

        $db->exec($sql);
        echo "Enrollments table created";
    } catch (PDOException $e) {
        echo "Error creating Enrollments table:<br>" . $e->getMessage();
    }
}
?>