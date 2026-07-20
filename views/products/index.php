<?php include 'views/layout/header.php'; ?>
<main>
    <h1>Menu List</h1>
    <section>
        <h2>Menu</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>&nbsp;</th>
            </tr>
            <?php foreach ($items as $item) : ?>
            <tr>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td><?php echo htmlspecialchars($item['description']); ?></td>
                <td class="right">$<?php echo number_format($item['price'], 2); ?></td>
                <td>
                    <form action="." method="post">
                        <input type="hidden" name="action" value="add_to_cart">
                        <input type="hidden" name="menu_item_id" value="<?php echo $item['id']; ?>">
                        <input type="text" class="cart_qty" name="quantity" value="1">
                        <input type="submit" value="Add to Cart">
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </section>
</main>
<?php include 'views/layout/footer.php' ?>