<?php
function place_order($userId, $cartItems, $address) {
    global $db;

    if (empty($cartItems)) {
        return false;
    }

    $total = 0;
    foreach ($cartItems as $item) {
        $total += $item['price'] * $item['qty'];
    }

    $query = 'INSERT INTO orders (user_id, status, total, address)
              VALUES (:user_id, :status, :total, :address)';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $userId);
    $statement->bindValue(':status', 'placed');
    $statement->bindValue(':total', $total);
    $statement->bindValue(':address', $address);
    $statement->execute();
    $statement->closeCursor();

    $orderId = $db->lastInsertId();

    $itemQuery = 'INSERT INTO order_items (order_id, menu_item_id, quantity, price_at_order)
                  VALUES (:order_id, :menu_item_id, :quantity, :price)';
    $itemStatement = $db->prepare($itemQuery);

    foreach ($cartItems as $key => $item) {
        $itemStatement->bindValue(':order_id', $orderId);
        $itemStatement->bindValue(':menu_item_id', $key);
        $itemStatement->bindValue(':quantity', $item['qty']);
        $itemStatement->bindValue(':price', $item['price']);
        $itemStatement->execute();
    }
    $itemStatement->closeCursor();

    return $orderId;
}

function get_orders_for_user($userId) {
    global $db;
    $query = 'SELECT * FROM orders WHERE user_id = :user_id ORDER BY id DESC';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $userId);
    $statement->execute();
    return $statement;
}

function get_order_for_user($orderId, $userId) {
    global $db;
    $query = 'SELECT * FROM orders WHERE id = :id AND user_id = :user_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $orderId);
    $statement->bindValue(':user_id', $userId);
    $statement->execute();
    $row = $statement->fetch();
    $statement->closeCursor();
    return $row;
}

function get_order_items($orderId) {
    global $db;
    $query = 'SELECT oi.*, mi.name
              FROM order_items oi
              JOIN menu_items mi ON oi.menu_item_id = mi.id
              WHERE oi.order_id = :order_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':order_id', $orderId);
    $statement->execute();
    return $statement;
}
?>