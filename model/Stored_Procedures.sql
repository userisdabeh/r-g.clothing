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


-- MASTER PROCEDURE FOR TRANSACTION MANAGEMENT --
DELIMITER $$
CREATE PROCEDURE checkout_transaction (
    IN p_user_id INT,
    IN p_currency_id INT,
    IN p_product_id INT,
    IN p_quantity INT,
    IN p_price_at_purchase DECIMAL(10,2),
    IN p_rating TINYINT,
    IN p_payment_method ENUM('GCash', 'Credit Card', 'PayPal', 'Cash on Delivery'),
    IN p_payment_amount DECIMAL(10,2)
)
BEGIN
    DECLARE v_order_id INT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
    END;

    START TRANSACTION;

    INSERT INTO orders (user_id, total_amount, currency_id, order_status)
    VALUES (p_user_id, 0.00, p_currency_id, 'Pending');
    SET v_order_id = LAST_INSERT_ID();

    INSERT INTO order_items (
        order_id, product_id, quantity, price_at_purchase, product_rating
    )
    VALUES (
        v_order_id, p_product_id, p_quantity, p_price_at_purchase, p_rating
    );

    INSERT INTO transaction_log (
        order_id, payment_method, payment_status, amount
    )
    VALUES (
        v_order_id, p_payment_method, 'Paid', p_payment_amount
    );

    COMMIT;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`student2`@`localhost` PROCEDURE `get_all_orders`()
BEGIN
	SELECT *
    FROM orders;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`student2`@`localhost` PROCEDURE `get_all_products`()
BEGIN
	SELECT * 
    FROM products;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`student2`@`localhost` PROCEDURE `get_all_users`()
BEGIN
	SELECT *
    FROM users;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`student2`@`localhost` PROCEDURE `get_orders_by_search`(
    IN p_keyword VARCHAR(100)
)
BEGIN
    SELECT 
        o.order_id, 
        o.order_status, 
        o.created_at, 
        GROUP_CONCAT(
            CASE 
                WHEN 
                    o.order_id LIKE CONCAT('%', p_keyword, '%') OR
                    o.order_status LIKE CONCAT('%', p_keyword, '%') OR
                    p.product_name LIKE CONCAT('%', p_keyword, '%') OR
                    p.size LIKE CONCAT('%', p_keyword, '%') OR
                    p.color LIKE CONCAT('%', p_keyword, '%')
                THEN CONCAT(p.product_name, ' (', p.size, ', ', p.color, ', x', oi.quantity, ')')
                ELSE NULL
            END
            SEPARATOR '; '
        ) AS items_summary
    FROM orders o
    JOIN order_items oi ON oi.order_id = o.order_id
    JOIN products p ON p.product_id = oi.product_id
    WHERE 
        o.order_id LIKE CONCAT('%', p_keyword, '%') OR
        o.order_status LIKE CONCAT('%', p_keyword, '%') OR
        p.product_name LIKE CONCAT('%', p_keyword, '%') OR
        p.size LIKE CONCAT('%', p_keyword, '%') OR
        p.color LIKE CONCAT('%', p_keyword, '%')
    GROUP BY o.order_id;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`student2`@`localhost` PROCEDURE `get_orders_list`()
BEGIN
	SELECT 
		o.order_id, 
		o.order_status, 
        o.created_at, 
        GROUP_CONCAT(CONCAT(p.product_name, ' (', p.size, ', ' , p.color, ', x' , oi.quantity, ')') SEPARATOR '; ') AS items_summary
	FROM orders o
	JOIN order_items oi ON oi.order_id = o.order_id
	JOIN products p ON p.product_id = oi.product_id
	GROUP BY o.order_id;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`student2`@`localhost` PROCEDURE `get_products_by_search`(
	IN p_search_value VARCHAR(255)
)
BEGIN
	SELECT *
    FROM products
    WHERE product_name LIKE CONCAT('%', p_search_value, '%')
		OR CAST(price AS CHAR) LIKE CONCAT('%', p_search_value, '%')
        OR CAST(stock AS CHAR) LIKE CONCAT('%', p_search_value, '%')
        OR CAST(product_id AS CHAR) LIKE CONCAT('%', p_search_value, '%')
        OR size LIKE CONCAT('%', p_search_value, '%')
        OR color LIKE CONCAT('%', p_search_value, '%');
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`student2`@`localhost` PROCEDURE `get_recent_orders_limit_five`()
BEGIN
	SELECT p.product_name, p.size, p.color, oi.quantity, o.order_status
	FROM order_items oi
	JOIN orders o ON oi.order_id = o.order_id
	JOIN products p ON oi.product_id = p.product_id
	ORDER BY o.created_at DESC
	LIMIT 5;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`student2`@`localhost` PROCEDURE `get_revenue`()
BEGIN
	SELECT SUM(total_amount) AS revenue
    FROM orders;
END$$
DELIMITER ;

