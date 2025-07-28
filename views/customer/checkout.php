<?php
    include_once '../../config/dbconn.php';
    
    session_start();

    $user_id = $_SESSION['user_id'];

    if (!$user_id) {
        header("Location: ../login.php");
        exit;
    }

    // Get cart items
    $getCartItems = $dbconn->prepare("SELECT * FROM carts c JOIN cart_items ci ON c.cart_id = ci.cart_id WHERE c.user_id = ?");
    $getCartItems->bind_param("i", $user_id);
    $getCartItems->execute();
    $resultCartItems = $getCartItems->get_result();
    $cartItems = $resultCartItems->fetch_all(MYSQLI_ASSOC);
    $getCartItems->close();

    if (empty($cartItems)) {
        header("Location: ../customer/cart.php");
        exit;
    }

    try {
        $dbconn->begin_transaction();

        $currency_id = 1;

        // Insert order
        $insertOrder = $dbconn->prepare("INSERT INTO orders (user_id, order_status, total_amount, currency_id) VALUES (?, 'Pending', 0, ?)");
        $insertOrder->bind_param("ii", $user_id, $currency_id);
        $insertOrder->execute();
        $order_id = $insertOrder->insert_id;
        $insertOrder->close();

        $orderTotal = 0;

        // Insert cart items into order items
        foreach ($cartItems as $cartItem) {
            $product_id = $cartItem['product_id'];
            $quantity = $cartItem['quantity'];
            $price = $cartItem['price'];

            // Check if product is in stock
            $checkStock = $dbconn->prepare("SELECT stock FROM products WHERE product_id = ?");
            $checkStock->bind_param("i", $product_id);
            $checkStock->execute();
            $checkStockResult = $checkStock->get_result()->fetch_assoc();
            $checkStock->close();

            if ($checkStockResult['stock'] < $quantity) {
                throw new Exception("Product is out of stock");
            }

            // Insert order item
            $insertOrderItem = $dbconn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase) VALUES (?, ?, ?, ?)");
            $insertOrderItem->bind_param("iiid", $order_id, $product_id, $quantity, $price);
            $insertOrderItem->execute();
            $insertOrderItem->close();

            // Update product stock
            $deductStock = $dbconn->prepare("UPDATE products SET stock = stock - ? WHERE product_id = ?");
            $deductStock->bind_param("ii", $quantity, $product_id);
            $deductStock->execute();
            $deductStock->close();


            $orderTotal += $price * $quantity;
        }

        // Update order total
        $updateOrderTotal = $dbconn->prepare("UPDATE orders SET total_amount = ?, order_status = 'Paid' WHERE order_id = ?");
        $updateOrderTotal->bind_param("di", $orderTotal, $order_id);
        $updateOrderTotal->execute();
        $updateOrderTotal->close();

        // Clear cart items
        $removeCartItem = $dbconn->prepare("DELETE ci FROM cart_items ci JOIN carts c ON ci.cart_id = c.cart_id WHERE c.user_id = ?");
        $removeCartItem->bind_param("i", $user_id);
        $removeCartItem->execute();
        $removeCartItem->close();

        // Delete cart record
        $deleteCart = $dbconn->prepare("DELETE FROM carts WHERE user_id = ?");
        $deleteCart->bind_param("i", $user_id);
        $deleteCart->execute();
        $deleteCart->close();

        $dbconn->commit();

        header("Location: catalog.php");
        exit;

    } catch (Exception $e) {
        $dbconn->rollback();
        header("Location: cart.php?error=1");
        exit;
    }
?>