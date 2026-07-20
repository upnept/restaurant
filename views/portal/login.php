<?php include 'views/layout/header.php'; ?>
<main>
    <h1>Login</h1>

    <form action="." method="post" id="login_form" class="aligned">
        <input type="hidden" name="action" value="do_login">

        <label>Email:</label>
        <input type="text" class="text" name="email">
        <br>

        <label>Password:</label>
        <input type="password" class="text" name="password">
        <br>

        <label>&nbsp;</label>
        <input type="submit" value="Login">
    </form>

    <?php if (!empty($login_message)) : ?>
        <p><?php echo htmlspecialchars($login_message); ?></p>
    <?php endif; ?>

    <p>Don't have an account? <a href=".?action=register">Register here</a>.</p>
</main>
<?php include 'views/layout/footer.php'; ?>
