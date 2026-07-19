<?php require_once(__DIR__.'/../../Config/paths.php'); ?>
<?php include VIEWS_PATH.'/layout/header.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <title>Create Student</title>
</head>

<body>

<h1>Create Student</h1>

<?php if (!empty($message)): ?>
    <p><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="post">
    <input type="hidden" name="action" value="add_student">
    
    <label>First Name</label><br>
    <input type="text" name="firstname"><br><br>

    <label>Last Name</label><br>
    <input type="text" name="lastname"><br><br>

    <label>Date of Birth</label><br>
    <input type="date" name="dob"><br><br>

    <label>Email</label><br>
    <input type="email" name="email"><br><br>

    <button type="submit">Create Student</button>

</form>
<?php require_once(VIEWS_PATH.'/layout/footer.php'); ?>
