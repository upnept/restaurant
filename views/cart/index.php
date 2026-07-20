<?php include 'views/layout/header.php'; ?>
    <main>
        <h1>Your Cart</h1>
        <?php if (empty($_SESSION['cart']) || count($_SESSION['cart']) == 0) : ?>
            <p>There are no items in your cart.</p>
        <?php else: ?>
            <form action="." method="post">
            <input type="hidden" name="action" value="update_cart">
            <table>
                <tr id="cart_header">
                    <th class="left">Item</th>
                    <th class="right">Item Price</th>
                    <th class="right">Quantity</th>
                    <th class="right">Item Total</th>
                </tr>
            <?php foreach ($_SESSION['cart'] as $key => $item) :
                $price = number_format($item['price'], 2);
                $total = number_format($item['total'], 2);
            ?>
                <tr>
                    <td>
                        <?php echo htmlspecialchars($item['name']); ?>
                    </td>
                    <td class="right">
                        $<?php echo $price; ?>
                    </td>
                    <td class="right">
                        <input type="text" class="cart_qty"
                            name="newqty[<?php echo $key; ?>]"
                            value="<?php echo $item['qty']; ?>">
                    </td>
                    <td class="right">
                        $<?php echo $total; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
                <tr id="cart_footer">
                    <td colspan="3"><b>Subtotal</b></td>
                <td>$<?php echo get_subtotal(); ?></td>
                </tr>
                <tr>
                    <td colspan="4" class="right">
                        <input type="submit" value="Update Cart"/>
                    </td>
                </tr>
            </table>
            <p>Click "Update Cart" to update quantities in your
                cart. Enter a quantity of 0 to remove an item.
            </p>
            </form>

            <?php if (isset($_SESSION['user_id'])) : ?>
                <p><a href=".?action=checkout">Checkout</a></p>
            <?php else : ?>
                <p>You must <a href=".?action=login">login</a> before checking out.</p>
            <?php endif; ?>
        <?php endif; ?>
        <p><a href=".?action=menu">Add More Items</a></p>
    </main>
<?php include 'views/layout/footer.php'; ?>