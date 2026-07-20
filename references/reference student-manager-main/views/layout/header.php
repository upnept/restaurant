<?php if (isset($_SESSION['message'])) : ?>
    <div class="message">
        <?= htmlspecialchars($_SESSION['message']) ?>
    </div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<!DOCTYPE html>

<html>
    <head>
        <title>Student Manager</title>
        <link rel="stylesheet" type="text/css" href="main.css">
    </head>

    <body>
        <header>
            <h1>Student Manager</h1>
        </header>

        <header>
            <nav>
                <p><a href=".?action=list_students">Home</a></p>
                <p><a href=".?action=list_students">View Students</a></p>
                <p><a href=".?action=show_add_form">Add Student</a></p>
            </nav>
        </header>
