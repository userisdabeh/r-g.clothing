DELIMITER $$
CREATE PROCEDURE update_stock(
	IN p_new_stock INT,
    IN p_product_id INT
)
BEGIN
	UPDATE products
    SET stock = p_new_stock
    WHERE product_id = p_product_id;
END
$$ DELIMITER ;

DELIMITER $$
CREATE PROCEDURE create_product(
	IN p_product_name VARCHAR(255),
    IN p_product_description TEXT,
    IN p_price DECIMAL(10,2),
    IN p_stock INT,
    IN p_size VARCHAR(255),
    IN p_color VARCHAR(255),
    IN p_category VARCHAR(255),
    IN p_currency INT
)
BEGIN
	INSERT INTO products(
		product_name, 
        product_description,
        price,
        stock,
        size,
        color,
        category,
        status,
        currency_id
	) VALUES (
		p_product_name,
        p_product_description,
        p_price,
        p_stock,
        p_size,
        p_color,
        p_category,
        'active',
        p_currency
    );
END
$$ DELIMITER ;

DELIMITER $$
CREATE PROCEDURE get_all_products ()
BEGIN
	SELECT * 
    FROM products;
END
$$ DELIMITER ;

DELIMITER $$
CREATE PROCEDURE get_all_orders()
BEGIN
	SELECT *
    FROM orders;
END
$$ DELIMITER ;

DELIMITER $$
CREATE PROCEDURE get_recent_orders_limit_five()
BEGIN
	SELECT p.product_name, p.size, p.color, oi.quantity, o.order_status
	FROM order_items oi
	JOIN orders o ON oi.order_id = o.order_id
	JOIN products p ON oi.product_id = p.product_id
	ORDER BY o.created_at DESC
	LIMIT 5;
END
$$ DELIMITER ;

DELIMITER $$
CREATE PROCEDURE get_products_by_search (
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
END
$$ DELIMITER ;

DELIMITER $$
CREATE PROCEDURE get_orders_list()
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
END
$$ DELIMITER ;

DELIMITER $$
CREATE PROCEDURE get_orders_by_search(
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
END
$$

DELIMITER ;

DELIMITER $$
CREATE PROCEDURE update_order_status(
	IN p_order_id INT,
    IN p_new_status VARCHAR(30)
)
BEGIN
	UPDATE orders
    SET order_status = p_new_status
    WHERE order_id = p_order_id;
END
$$ DELIMITER ;

DELIMITER $$
CREATE PROCEDURE get_all_users()
BEGIN
	SELECT *
    FROM users;
END
$$ DELIMITER ;

DELIMITER $$
CREATE PROCEDURE get_revenue()
BEGIN
	SELECT SUM(total_amount) AS revenue
    FROM orders;
END
$$ DELIMITER ;

DELIMITER $$
CREATE PROCEDURE get_top_five_product_by_revenue()
BEGIN
	SELECT 
		p.product_id,
		p.product_name,
		SUM(oi.quantity) AS total_quantity_sold,
		SUM(oi.price_at_purchase * oi.quantity) AS total_revenue
	FROM order_items oi
	JOIN products p ON p.product_id = oi.product_id
	GROUP BY p.product_id, p.product_name
	ORDER BY total_revenue DESC
	LIMIT 5;
END
$$ DELIMITER ;

DELIMITER $$
CREATE PROCEDURE admin_view_orders()
BEGIN
	SELECT oi.order_id, p.product_name, oi.price_at_purchase, o.order_status
	FROM order_items oi
	JOIN orders o ON o.order_id = oi.order_id
	JOIN products p ON oi.product_id = p.product_id;
END
$$ DELIMITER ;

DELIMITER $$
CREATE PROCEDURE update_user_role(
	IN p_user_id INT,
	IN p_new_role VARCHAR(40)
)
BEGIN
	UPDATE users
    SET user_role = p_new_role
    WHERE user_id = p_user_id;
END
$$ DELIMITER ;