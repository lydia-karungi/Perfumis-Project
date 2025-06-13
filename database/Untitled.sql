CREATE DATABASE perfumis_db;
USE perfumis_db;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    role ENUM('admin', 'customer') DEFAULT 'customer',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100),
    category_type ENUM('standard', 'featured') DEFAULT 'standard'
);

CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    description TEXT,
    price DECIMAL(10,2),
    stock INT,
    category_id INT,
    image_url VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(category_id)
);

CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_price DECIMAL(10,2),
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    order_type ENUM('Online', 'In-Store'),
    channel VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT,
    unit_price DECIMAL(10,2),
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);


CREATE TABLE reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);


CREATE TABLE reports (
    report_id INT AUTO_INCREMENT PRIMARY KEY,
    report_name VARCHAR(100),
    date_generated DATE,
    report_type ENUM('Sales', 'Users', 'Inventory'),
    status ENUM('Completed', 'In Progress'),
    generated_by INT,
    FOREIGN KEY (generated_by) REFERENCES users(user_id)
);

CREATE TABLE tickets (
    ticket_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    subject VARCHAR(255),
    description TEXT,
    status ENUM('Open', 'Closed', 'Pending') DEFAULT 'Open',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);


INSERT INTO categories (category_name, category_type)
VALUES 
('Men\'s Fragrance', 'standard'),
('Women\'s Fragrance', 'standard'),
('Unisex', 'standard'),
('Luxury Scents', 'featured'),
('Best Sellers', 'featured'),
('New Arrivals', 'featured'),
('Gift Sets', 'featured'),
('Everyday Wear', 'standard');

INSERT INTO users (name, email, password, role)
VALUES 
('Admin User', 'admin@perfumis.com', 'hashed_admin_pw', 'admin'),
('Brenda Chelimo', 'brenda@email.com', 'hashed_pw_123', 'customer'),
('Lydia Karungi', 'lydia@email.com', 'hashed_pw_456', 'customer');


INSERT INTO products (name, description, price, stock, category_id, image_url)
VALUES 
('Rose Bloom', 'A romantic floral scent with hints of rose and jasmine.', 89.99, 50, 1, 'images/rose_bloom.jpg'),
('Oud Intense', 'Deep woody fragrance with spicy undertones.', 120.00, 25, 2, 'images/oud_intense.jpg'),
('Mystic Amber', 'Warm oriental scent with amber and vanilla.', 105.50, 30, 3, 'images/mystic_amber.jpg');

INSERT INTO orders (user_id, total_price, order_type, channel)
VALUES 
(2, 89.99, 'Online', 'web'),
(3, 225.50, 'Online', 'mobile');

INSERT INTO order_items (order_id, product_id, quantity, unit_price)
VALUES 
(1, 1, 1, 89.99),
(2, 2, 1, 120.00),
(2, 3, 1, 105.50);


INSERT INTO reviews (user_id, product_id, rating, comment)
VALUES 
(2, 1, 5, 'Absolutely loved this fragrance! Long-lasting and sweet.'),
(3, 2, 4, 'Very strong scent. Great for evenings.');


INSERT INTO reports (report_name, date_generated, report_type, status, generated_by)
VALUES 
('Monthly Sales - May', '2025-05-29', 'Sales', 'Completed', 1),
('Inventory Snapshot', '2025-05-29', 'Inventory', 'Completed', 1);


INSERT INTO tickets (user_id, subject, description)
VALUES 
(3, 'Missing Order', 'I placed an order two days ago but haven’t received a confirmation.'),
(2, 'Wrong Product Delivered', 'I received a different perfume from what I ordered.');

SELECT 
    users.name AS customer_name,
    products.name AS product_name,
    orders.order_date,
    order_items.quantity,
    order_items.unit_price
FROM orders
JOIN users ON orders.user_id = users.user_id
JOIN order_items ON orders.order_id = order_items.order_id
JOIN products ON order_items.product_id = products.product_id;