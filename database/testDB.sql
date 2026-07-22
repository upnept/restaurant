USE restaurant;

INSERT IGNORE INTO users (name, email, password, phone, address, is_admin)
VALUES ('admin', 'admin@gmail.com', '$2y$10$Q7SnEecfURHM.eafcUkfBOkrJK/FDhDG3Y1HMndTJyC0ynPIWUbPi', '000-000-0000', '000 Str', 1);

INSERT INTO menu_items (name, description, price, category, image_url) VALUES
('CheeseBurger', 'A classic cheeseburger', 9.99, 'Food', ''),
('Fries', 'French fries', 3.99, 'Food', ''),
('Soda', 'Any soda', 2.99, 'Drink', '');