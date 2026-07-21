<?php include 'views/layout/header.php'; ?>
<main>
    <h1>Register</h1>

    <?php if (!empty($errors)) : ?>
        <ul class="error">
            <?php foreach ($errors as $error) : ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="." method="post">
    <input type="hidden" name="action" value="do_register">
    <fieldset>
        <legend>Account Information</legend>

        <label>Name:</label>
        <input type="text" name="name"
               value="<?php echo htmlspecialchars($name); ?>"><br>

        <label>Email:</label>
        <input type="text" name="email"
               value="<?php echo htmlspecialchars($email); ?>"><br>

        <label>Password:</label>
        <input type="password" name="password" value=""><br>

        <label>Confirm Password:</label>
        <input type="password" name="confirm_password" value=""><br>

        <label>Phone:</label>
        <input type="text" name="phone"
               value="<?php echo htmlspecialchars($phone); ?>"
               placeholder="000-000-0000"><br>

        <label>Address:</label>
        <input type="text" name="address"
               value="<?php echo htmlspecialchars($address); ?>"><br>
    </fieldset>
    <fieldset>
        <legend>Submit Registration</legend>

        <label>&nbsp;</label>
        <input type="submit" value="Register"/><br>
    </fieldset>
    </form>
    <p>Already have an account? <a href=".?action=login">Login here</a>.</p>
</main>
<?php include 'views/layout/footer.php'; ?>