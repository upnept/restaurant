<?php
require_once('util/valid_user.php');
include 'views/layout/header.php';
?>
<main>
    <h1>Checkout</h1>

    <?php if (!empty($checkout_message)) : ?>
        <p><?php echo htmlspecialchars($checkout_message); ?></p>
    <?php endif; ?>

    <form action="." method="post">
        <input type="hidden" name="action" value="place_order">

        <label>Delivery Address:</label>
        <input type="text" name="address"
               value="<?php echo htmlspecialchars($_SESSION['user_address'] ?? ''); ?>">
        <br>

        <label>&nbsp;</label>
        <input type="submit" value="Place Order">
    </form>
</main>
<?php include 'views/layout/footer.php'; ?>