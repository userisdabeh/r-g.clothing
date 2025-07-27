INSERT INTO currencies (currency_code, symbol, exchange_rate_to_usd)
VALUES ('PHP', '₱', 0.018);

INSERT INTO products ( product_name, product_description, price, stock, size, color, category, status, currency_id) 
VALUES
('Oversized Graphic Tee', 'Soft cotton tee with a bold front graphic print.', 599.00, 50, 'L', 'Black', 'Streetwear', 'active', 1),
('Cropped Hoodie', 'Cropped hoodie with adjustable drawstring and fleece lining.', 899.00, 30, 'M', 'Beige', 'Casual', 'active', 1),
('Techwear Joggers', 'Water-resistant cargo joggers with zipper pockets.', 1299.00, 25, 'L', 'Gray', 'Athletic', 'active', 1),
('Denim Jacket', 'Classic blue denim jacket with distressed details.', 1499.00, 20, 'XL', 'Blue', 'Workwear', 'active', 1),
('Box Logo Tee', 'Minimalist tee with a small box logo on the chest.', 499.00, 40, 'M', 'White', 'Hypebeast', 'active', 1),
('Tie-Dye Shirt', 'Colorful tie-dye design on breathable cotton fabric.', 549.00, 35, 'L', 'Multicolor', 'Streetwear', 'active', 1);

SELECT * FROM currencies;
SELECT * FROM products;

