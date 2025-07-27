DELIMITER $$
CREATE PROCEDURE place_order (
    IN p_user_id INT,
    IN p_currency_id INT,
    OUT p_order_id INT
)
BEGIN
    INSERT INTO orders (user_id, total_amount, currency_id, order_status)
    VALUES (p_user_id, 0.00, p_currency_id, 'Pending');

    SET p_order_id = LAST_INSERT_ID();
END$$
DELIMITER ;

-- Declare a variable to hold the new order ID
SET @order_id := 0;

-- Call the procedure (example: user_id = 1, currency_id = 1)
CALL place_order(1, 1, @order_id);

-- Check the result
SELECT @order_id;

-- Verify the order was added
SELECT * FROM orders WHERE order_id = @order_id;

DELIMITER $$
CREATE PROCEDURE add_order_item (
    IN p_order_id INT,
    IN p_product_id INT,
    IN p_quantity INT,
    IN p_price_at_purchase DECIMAL(10,2),
    IN p_rating TINYINT
)
BEGIN
    INSERT INTO order_items (
        order_id, product_id, quantity, price_at_purchase, product_rating
    )
    VALUES (
        p_order_id, p_product_id, p_quantity, p_price_at_purchase, p_rating
    );
END$$
DELIMITER ;


CALL add_order_item(
    @order_id,     
    2,            
    1,            
    999.99,       
    5              
);

-- TESTING
SELECT * FROM order_items WHERE order_id = @order_id;

DELIMITER $$
CREATE PROCEDURE log_payment (
    IN p_order_id INT,
    IN p_payment_method ENUM('GCash', 'Credit Card', 'PayPal', 'Cash on Delivery'),
    IN p_status ENUM('Pending', 'Paid', 'Failed', 'Refunded'),
    IN p_amount DECIMAL(10,2)
)
BEGIN
    INSERT INTO transaction_log (order_id, payment_method, payment_status, amount)
    VALUES (p_order_id, p_payment_method, p_status, p_amount);
END$$
DELIMITER ;

CALL log_payment(
    @order_id,          
    'GCash',            
    'Paid',            
    999.99             
);

-- Verify the transaction was logged
SELECT * FROM transaction_log WHERE order_id = @order_id;
