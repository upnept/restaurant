
<?php require_once(__DIR__.'/../../Config/paths.php'); ?>
<?php include VIEWS_PATH.'/layout/header.php'; ?>

<main>
    <h1>Edit Student</h1>
    <form action="index.php" method="post">
        <input type="hidden" name="action" value="update_student">
        <input type="hidden" name="studentid" value="<?= $student['studentid'] ?>">

        <label>First Name:</label>
        <input type="text" name="firstname" value="<?= htmlspecialchars($student['firstname']) ?>" required/>
        <br>

        <label>Last Name:</label>
        <input type="text" name="lastname" value="<?= htmlspecialchars($student['lastname']) ?>" required/>
        <br>

        <label>DOB:</label>
        <input type="text" name="dob" value="<?= htmlspecialchars($student['dob']) ?>" required/>
        <br>

        <label>Email:</label>
        <input type="text" name="email" value="<?= htmlspecialchars($student['email']) ?>" required/>
        <br>

        <label>&nbsp;</label>
        <input type="submit" value="Submit"/>
        <br>
    </form>
</main>

<?php include VIEWS_PATH.'/layout/footer.php' ?>
