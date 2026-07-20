<?php

function add_item($menuItemId, $quantity) {
    if ($quantity < 1) return;

    if (isset($_SESSION['cart'][$menuItemId])) {
        $quantity += $_SESSION['cart'][$menuItemId]['qty'];
        update_item($menuItemId, $quantity);
        return;
    }

    $menuItem = getItemById($menuItemId);
    if (!$menuItem) return;

    $price = $menuItem['price'];
    $total = $price * $quantity;
    $item = array(
        'name'  => $menuItem['name'],
        'price' => $price,
        'qty'   => $quantity,
        'total' => $total
    );
    $_SESSION['cart'][$menuItemId] = $item;
}

function update_item($menuItemId, $quantity) {
    $quantity = (int) $quantity;
    if (isset($_SESSION['cart'][$menuItemId])) {
        if ($quantity <= 0) {
            unset($_SESSION['cart'][$menuItemId]);
        } else {
            $_SESSION['cart'][$menuItemId]['qty'] = $quantity;
            $total = $_SESSION['cart'][$menuItemId]['price'] * $_SESSION['cart'][$menuItemId]['qty'];
            $_SESSION['cart'][$menuItemId]['total'] = $total;
        }
    }
}

function get_subtotal() {
    $subtotal = 0;
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $subtotal += $item['total'];
        }
    }
    $subtotal_f = number_format($subtotal, 2);
    return $subtotal_f;
}

?>