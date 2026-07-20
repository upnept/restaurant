<?php
function getItems() {
    global $db;
    $sql = "SELECT * FROM menu_items
            ORDER BY id";
    $statement = $db->prepare($sql);
    $statement->execute();
    return $statement;
}

function getItemById($itemId) {
    global $db;
    $sql = "SELECT * FROM menu_items WHERE id = :id";
    $statement = $db->prepare($sql);
    $statement->bindValue(':id', $itemId);
    $statement->execute();
    $row = $statement->fetch();
    $statement->closeCursor();
    return $row;
}
?>
