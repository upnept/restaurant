<?php
require_once('util/valid_user.php');
include 'views/layout/header.php';
?>
<main>
    <h1>Order #<?php echo $order['id']; ?></h1>

    <p>Status: <?php echo htmlspecialchars($order['status']); ?></p>
    <p>Address: <?php echo htmlspecialchars($order['address']); ?></p>

    <section>
        <table>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
            <?php foreach ($orderItems as $item) : ?>
            <tr>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td class="right"><?php echo $item['quantity']; ?></td>
                <td class="right">$<?php echo number_format($item['price_at_order'], 2); ?></td>
                <td class="right">$<?php echo number_format($item['price_at_order'] * $item['quantity'], 2); ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"><b>Total</b></td>
                <td class="right">$<?php echo number_format($order['total'], 2); ?></td>
            </tr>
        </table>
    </section>

    <p><a href=".?action=order_history">Back to My Orders</a></p>
</main>
<?php include 'views/layout/footer.php'; ?>