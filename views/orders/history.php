<?php
require_once('util/valid_user.php');
include 'views/layout/header.php';
?>
<main>
    <h1>My Orders</h1>

    <section>
        <table>
            <tr>
                <th>Order #</th>
                <th>Status</th>
                <th>Total</th>
                <th>&nbsp;</th>
            </tr>
            <?php foreach ($orders as $order) : ?>
            <tr>
                <td><?php echo $order['id']; ?></td>
                <td><?php echo htmlspecialchars($order['status']); ?></td>
                <td class="right">$<?php echo number_format($order['total'], 2); ?></td>
                <td><a href="?action=view_order&orderid=<?php echo $order['id']; ?>">view details</a></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </section>

    <p><a href=".?action=menu">Back to Menu</a></p>
</main>
<?php include 'views/layout/footer.php'; ?>