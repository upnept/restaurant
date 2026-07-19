CREATE DATABASE IF NOT EXISTS restaurant;
USE restaurant;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    address VARCHAR(255),
);

CREATE TABLE menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description VARCHAR(150) NOT NULL,
    price DECIMAL(6,2) NOT NULL,
    category VARCHAR(50) NOT NULL,
    image_url VARCHAR(255),
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    status VARCHAR(30) NOT NULL,
    total DECIMAL(8,2) NOT NULL,
    address VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    menu_item_id INT NOT NULL,
    quantity INT NOT NULL,
    price_at_order DECIMAL(6,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (menu_item_id) REFERENCES menu_items(id) ON DELETE CASCADE
);

INSERT INTO menu_items (name, description, price, category) VALUES
('CheeseBurger', 'A classic delicious cheeseburger', 4.99, 'Food'),
('Fries', 'French fries fried in peanut oil.', 1.99, 'Food'),
('Soda', 'Any sort of beverage available', 2.99, 'Drink'),