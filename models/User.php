<?php
function add_user($name, $email, $password, $phone, $address) {
    global $db;
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $query = 'INSERT INTO users (name, email, password, phone, address, is_admin)
              VALUES (:name, :email, :password, :phone, :address, 0)';
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $hash);
    $statement->bindValue(':phone', $phone);
    $statement->bindValue(':address', $address);
    $statement->execute();
    $statement->closeCursor();

    return $db->lastInsertId();
}

function email_exists($email) {
    global $db;
    $query = 'SELECT id FROM users WHERE email = :email';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $row = $statement->fetch();
    $statement->closeCursor();
    return $row !== false;
}

function is_valid_user_login($email, $password) {
    global $db;
    $query = 'SELECT * FROM users WHERE email = :email';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $row = $statement->fetch();
    $statement->closeCursor();

    if ($row === false) {
        return false;   // no user with that email
    }

    if (password_verify($password, $row['password'])) {
        return $row;
    }

    return false;
}

function get_user_by_id($userId) {
    global $db;
    $query = 'SELECT id, name, email, phone, address, is_admin FROM users WHERE id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $userId);
    $statement->execute();
    $row = $statement->fetch();
    $statement->closeCursor();
    return $row;
}

function update_user($userId, $name, $phone, $address) {
    global $db;
    $query = 'UPDATE users SET name = :name, phone = :phone, address = :address
              WHERE id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':phone', $phone);
    $statement->bindValue(':address', $address);
    $statement->bindValue(':id', $userId);
    $statement->execute();
    $statement->closeCursor();
}
?>