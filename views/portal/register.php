<?php include 'views/layout/header.php'; ?>
<main>
    <form action="." method="post">
    <input type="hidden" name="action" value="do_register">
    <fieldset>
        <legend>Account Information</legend>

        <label>Name:</label>
        <input type="text" name="name"
               value="<?php echo htmlspecialchars($name); ?>">
        <?php echo $fields->getField('name')->getHTML(); ?><br>

        <label>Email:</label>
        <input type="text" name="email"
               value="<?php echo htmlspecialchars($email); ?>">
        <?php echo $fields->getField('email')->getHTML(); ?><br>

        <label>Password:</label>
        <input type="password" name="password" value="">
        <?php echo $fields->getField('password')->getHTML(); ?><br>

        <label>Confirm Password:</label>
        <input type="password" name="confirm_password" value="">
        <?php echo $fields->getField('confirm_password')->getHTML(); ?><br>

        <label>Phone:</label>
        <input type="text" name="phone"
               value="<?php echo htmlspecialchars($phone); ?>">
        <?php echo $fields->getField('phone')->getHTML(); ?><br>

        <label>Address:</label>
        <input type="text" name="address"
               value="<?php echo htmlspecialchars($address); ?>">
        <?php echo $fields->getField('address')->getHTML(); ?><br>
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