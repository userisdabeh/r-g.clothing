-- ADMIN user, full access
CREATE USER 'admin'@'%' IDENTIFIED BY 'Dlsu1234!'; 
GRANT ALL PRIVILEGES ON rg_clothing.* TO 'admin'@'%' WITH GRANT OPTION;

-- STAFF user, partial access
CREATE USER 'staff'@'%' IDENTIFIED BY 'Dlsu1234!';
-- Read & manage products, see orders
GRANT SELECT, INSERT, UPDATE ON rg_clothing.products TO 'staff'@'%';
GRANT SELECT ON rg_clothing.orders TO 'staff'@'%';

-- CUSTOMER user, read-only
CREATE USER 'customer'@'%' IDENTIFIED BY 'Dlsu1234!';
GRANT SELECT ON rg_clothing.products TO 'customer'@'%';
GRANT SELECT, INSERT ON rg_clothing.orders TO 'customer'@'%';
GRANT SELECT ON rg_clothing.order_items TO 'customer'@'%';
