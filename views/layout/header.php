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
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>

    <body>
        <header>
            <h1>Restaurant</h1>
            <p><?php echo $welcomeMessage; ?></p>
        </header>

        <header>
            <nav>
                <p><a href=".?action=menu">Menu</a></p>
                <p><a href=".?action=cart">Cart</a></p>
                <?php if (isset($_SESSION['user_id'])) : ?>
                    <p><a href=".?action=order_history">My Orders</a></p>
                    <p>Hi, <?= htmlspecialchars($_SESSION['user_name']) ?></p>
                    <p><a href=".?action=logout">Logout</a></p>
                <?php else : ?>
                    <p><a href=".?action=login">Login</a></p>
                    <p><a href=".?action=register">Register</a></p>
                <?php endif; ?>
            </nav>
        </header>