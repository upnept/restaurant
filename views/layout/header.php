<?php if (isset($_SESSION['message'])) : ?>
    <div class="message">
        <?= htmlspecialchars($_SESSION['message']) ?>
    </div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<!DOCTYPE html>

<html>
    <head>
        <title>Restaurant</title>
        <link rel="stylesheet" type="text/css" href="main.css">
    </head>

    <body>
        <header>
            <h1>Restaurant</h1>
        </header>

        <header>
            <nav>
                <p><a href=".?action=menu">Menu</a></p>
                <p><a href=".?action=cart">Cart</a></p>
                <p><a href=".?action=login">Login</a></p>
                <p><a href=".?action=register">Register</a></p>
            </nav>
        </header>
