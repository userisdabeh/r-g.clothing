CREATE DATABASE IF NOT EXISTS rg_clothing;
USE rg_clothing;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL, -- Add password for login
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;


DROP TABLE IF EXISTS user_address;
CREATE TABLE user_address (
    address_id INT PRIMARY KEY AUTO_INCREMENT,
    province VARCHAR(100) NOT NULL,
    city VARCHAR(200) NOT NULL,
    barangay VARCHAR(200) NOT NULL,
    street_address VARCHAR(255) NOT NULL,
    postal_code VARCHAR(10) NOT NULL,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB;


DROP TABLE IF EXISTS currencies;
CREATE TABLE currencies (
    currency_id INT PRIMARY KEY AUTO_INCREMENT,
    currency_code VARCHAR(10) NOT NULL,     -- e.g., PHP, USD, KRW
    symbol VARCHAR(5) NOT NULL,             -- ₱, $, ₩
    exchange_rate_to_usd DECIMAL(10, 4) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;


DROP TABLE IF EXISTS products;
CREATE TABLE products (
    product_id INT PRIMARY KEY AUTO_INCREMENT,
    product_name VARCHAR(255) NOT NULL,
    product_description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    stock INT UNSIGNED NOT NULL,
    size VARCHAR(255) NOT NULL,
    color VARCHAR(255) NOT NULL,
    category ENUM('Streetwear', 'Hypebeast', 'Casual', 'Athletic', 'Workwear') NOT NULL,
    status ENUM('active', 'discontinued') DEFAULT 'active',
    currency_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (currency_id) REFERENCES currencies(currency_id)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS orders;
CREATE TABLE orders (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    order_status ENUM('Pending', 'Paid', 'Shipped', 'Delivery', 'Delivered', 'Cancelled') DEFAULT 'Pending',
    total_amount DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    currency_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (currency_id) REFERENCES currencies(currency_id)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS order_items;
CREATE TABLE order_items (
    order_item_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT UNSIGNED NOT NULL,
    price_at_purchase DECIMAL(10,2) NOT NULL,
    product_rating TINYINT UNSIGNED CHECK (product_rating BETWEEN 1 AND 5),
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
) ENGINE=InnoDB;


DROP TABLE IF EXISTS transaction_log;
CREATE TABLE transaction_log (
    transaction_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    payment_method ENUM('GCash', 'Credit Card', 'PayPal', 'Cash on Delivery') NOT NULL,
    payment_status ENUM('Pending', 'Paid', 'Failed', 'Refunded') DEFAULT 'Pending',
    amount DECIMAL(10,2) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE
) ENGINE=InnoDB;
