<?php
function getItems() {
    global $db;
    $sql = "SELECT * FROM menu_items
            ORDER BY id";
    $statement = $db->prepare($sql);
    $statement->execute();
    return $statement;
}
?>