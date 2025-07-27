USE rg_clothing;

-- LOG TABLE PATI TRIGGER for ORDER STATUS CHANGES --
CREATE TABLE IF NOT EXISTS order_status_log (
    log_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NULL,
    old_status ENUM('Pending', 'Paid', 'Shipped', 'Delivery', 'Delivered', 'Cancelled'),
    new_status ENUM('Pending', 'Paid', 'Shipped', 'Delivery', 'Delivered', 'Cancelled'),
    changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE SET NULL
);

DELIMITER $$
CREATE TRIGGER log_order_status_trigger
AFTER UPDATE ON orders
FOR EACH ROW
BEGIN
    IF NEW.order_status <> OLD.order_status THEN
        INSERT INTO order_status_log (order_id, old_status, new_status)
        VALUES (NEW.order_id, OLD.order_status, NEW.order_status);
    END IF;
END$$
DELIMITER ;

-- TESTING
-- Insert a test order
INSERT INTO orders (user_id, total_amount, currency_id) VALUES (1, 0.00, 1);

-- Change the order status
UPDATE orders SET order_status = 'Shipped' WHERE order_id = 1;

-- View log
SELECT * FROM order_status_log;


-- LOG TABLE PATI TRIGGER for PRODUCT STOCK CHANGES --
CREATE TABLE IF NOT EXISTS stock_log (
    log_id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NULL,
    old_stock INT,
    new_stock INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE SET NULL
);


DELIMITER $$
CREATE TRIGGER log_stock_change_trigger
AFTER UPDATE ON products
FOR EACH ROW
BEGIN
    IF NEW.stock <> OLD.stock THEN
        INSERT INTO stock_log (product_id, old_stock, new_stock)
        VALUES (NEW.product_id, OLD.stock, NEW.stock);
    END IF;
END$$
DELIMITER ;

-- TESTING
-- Insert product
INSERT INTO products (product_name, product_description, price, stock, size, color, category, currency_id)
VALUES ('Test Hoodie', 'Sample product', 500.00, 50, 'M', 'Black', 'Streetwear', 1);

-- Change stock
UPDATE products SET stock = 45 WHERE product_id = 1;

-- View stock log
SELECT * FROM stock_log;


-- AUTO-UPDATE ORDER STATUS TO "Paid" --
DELIMITER $$
CREATE TRIGGER update_order_status_paid_trigger
AFTER INSERT ON transaction_log
FOR EACH ROW
BEGIN
    IF NEW.payment_status = 'Paid' THEN
        UPDATE orders
        SET order_status = 'Paid'
        WHERE order_id = NEW.order_id;
    END IF;
END$$
DELIMITER ;

-- TESTING
-- Check order status
SELECT order_status FROM orders WHERE order_id = 1;

-- Insert a payment with status Paid
INSERT INTO transaction_log (order_id, payment_method, payment_status, amount)
VALUES (1, 'GCash', 'Paid', 500.00);

-- Check updated status
SELECT order_status FROM orders WHERE order_id = 1;


-- VALIDATE PRODUCT RATING BEFORE INSERT --
DELIMITER $$
CREATE TRIGGER validate_product_rating_trigger
BEFORE INSERT ON order_items
FOR EACH ROW
BEGIN
    IF NEW.product_rating < 1 OR NEW.product_rating > 5 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Product rating must be between 1 and 5.';
    END IF;
END$$
DELIMITER ;

-- TESTING
-- VALID:
INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase, product_rating)
VALUES (1, 1, 2, 500.00, 5);

-- INVALID:
INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase, product_rating)
VALUES (1, 1, 2, 500.00, 6);


-- UPDATE ORDER TOTAL WHEN ITEM IS ADDED --
DELIMITER $$
CREATE TRIGGER update_order_total_trigger
AFTER INSERT ON order_items
FOR EACH ROW
BEGIN
    UPDATE orders
    SET total_amount = total_amount + (NEW.price_at_purchase * NEW.quantity)
    WHERE order_id = NEW.order_id;
END$$
DELIMITER ;

-- TESTING
-- Check current total
SELECT total_amount FROM orders WHERE order_id = 1;

-- Add order item
INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase, product_rating)
VALUES (1, 1, 2, 500.00, 4);  

-- Check updated total
SELECT total_amount FROM orders WHERE order_id = 1;
