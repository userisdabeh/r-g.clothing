<?php
session_start();
include_once '../../config/dbconn.php';

function get_or_create_cart_id($dbconn) {
    $user_id = $_SESSION['user_id'] ?? null;
    $session_id = session_id();

    $cart_id = null;

    if ($user_id) {
        // Look for a cart associated with the logged-in user
        $stmt = $dbconn->prepare("SELECT cart_id FROM carts WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $cart_id = $row['cart_id'];
        }
        $stmt->close();

        if ($session_id && $cart_id) {
            $stmt_guest = $dbconn->prepare("SELECT cart_id FROM carts WHERE session_id = ? AND user_id IS NULL");
            $stmt_guest->bind_param("s", $session_id);
            $stmt_guest->execute();
            $result_guest = $stmt_guest->get_result();
            if ($guest_cart = $result_guest->fetch_assoc()) {
                $guest_cart_id = $guest_cart['cart_id'];

                $dbconn->begin_transaction();
                try {
                    $stmt_move = $dbconn->prepare("
                        INSERT INTO cart_items (cart_id, product_id, quantity, size, color, price)
                        SELECT ?, product_id, quantity, size, color, price
                        FROM cart_items
                        WHERE cart_id = ?
                        ON DUPLICATE KEY UPDATE
                            quantity = cart_items.quantity + VALUES(quantity)
                    ");
                    $stmt_move->bind_param("ii", $cart_id, $guest_cart_id);
                    $stmt_move->execute();
                    $stmt_move->close();

                    // Delete the old guest cart (and its items via CASCADE DELETE on foreign key)
                    $stmt_delete_guest_cart = $dbconn->prepare("DELETE FROM carts WHERE cart_id = ?");
                    $stmt_delete_guest_cart->bind_param("i", $guest_cart_id);
                    $stmt_delete_guest_cart->execute();
                    $stmt_delete_guest_cart->close();

                    $dbconn->commit(); // Commit transaction if successful
                } catch (mysqli_sql_exception $e) {
                    $dbconn->rollback(); // Rollback on error
                    error_log("Error merging guest cart: " . $e->getMessage());
                }
            }
            $stmt_guest->close();
        }

    } elseif ($session_id) {
        $stmt = $dbconn->prepare("SELECT cart_id FROM carts WHERE session_id = ? AND user_id IS NULL");
        $stmt->bind_param("s", $session_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $cart_id = $row['cart_id'];
        }
        $stmt->close();
    }

    if (!$cart_id) {
        $dbconn->begin_transaction(); // Start transaction for new cart creation
        try {
            if ($user_id) {
                // Create cart linked to user
                $stmt = $dbconn->prepare("INSERT INTO carts (user_id) VALUES (?)");
                $stmt->bind_param("i", $user_id);
            } else {
                // Create cart linked to session ID for guest
                $stmt = $dbconn->prepare("INSERT INTO carts (session_id) VALUES (?)");
                $stmt->bind_param("s", $session_id);
            }
            $stmt->execute();
            $cart_id = $dbconn->insert_id; // Get the ID of the newly created cart
            $stmt->close();
            $dbconn->commit(); 
        } catch (mysqli_sql_exception $e) {
            $dbconn->rollback(); 
            error_log("Error creating new cart: " . $e->getMessage());
            return null; // Return null if cart creation fails
        }
    }
    return $cart_id;
}

$current_cart_id = get_or_create_cart_id($dbconn);

if ($_SERVER["REQUEST_METHOD"] === "POST" && $current_cart_id) {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $product_id = filter_var($_POST['product_id'] ?? '', FILTER_VALIDATE_INT);
        $quantity = filter_var($_POST['quantity'] ?? 1, FILTER_VALIDATE_INT);
        $product_size = trim($_POST['product_size'] ?? '');
        $product_color = trim($_POST['product_color'] ?? '');

        if ($product_id && $quantity > 0) {
            try {
              
                $stmt_product = $dbconn->prepare("SELECT product_name, price, stock FROM products WHERE product_id = ?");
                $stmt_product->bind_param("i", $product_id);
                $stmt_product->execute();
                $result_product = $stmt_product->get_result();
                $db_product = $result_product->fetch_assoc();
                $stmt_product->close();

                if ($db_product) {
                    $product_price = $db_product['price'];
                    $available_stock = $db_product['stock'];

                    $stmt_check_item = $dbconn->prepare("SELECT item_id, quantity FROM cart_items WHERE cart_id = ? AND product_id = ? AND size = ? AND color = ?");
                    $stmt_check_item->bind_param("iiss", $current_cart_id, $product_id, $product_size, $product_color);
                    $stmt_check_item->execute();
                    $result_check_item = $stmt_check_item->get_result();
                    $existing_item = $result_check_item->fetch_assoc();
                    $stmt_check_item->close();

                    $dbconn->begin_transaction(); // Start transaction for add/update item
                    if ($existing_item) {
                        // Update quantity of existing item
                        $new_quantity_sum = $existing_item['quantity'] + $quantity;
                        $final_quantity = min($new_quantity_sum, $available_stock); // Cap quantity at available stock

                        $stmt_update = $dbconn->prepare("UPDATE cart_items SET quantity = ? WHERE item_id = ?");
                        $stmt_update->bind_param("ii", $final_quantity, $existing_item['item_id']);
                        $stmt_update->execute();
                        $stmt_update->close();
                    } else {
                        // Add new item to cart_items
                        $final_quantity = min($quantity, $available_stock); // Cap quantity at available stock
                        $stmt_insert = $dbconn->prepare("INSERT INTO cart_items (cart_id, product_id, quantity, size, color, price) VALUES (?, ?, ?, ?, ?, ?)");
                        $stmt_insert->bind_param("iiisss", $current_cart_id, $product_id, $final_quantity, $product_size, $product_color, $product_price);
                        $stmt_insert->execute();
                        $stmt_insert->close();
                    }
                    $dbconn->commit(); 
                }
            } catch (mysqli_sql_exception $e) {
                $dbconn->rollback();
                error_log("Error adding item to cart_items: " . $e->getMessage());
            }
        }
    } elseif ($action === 'remove') {
        $item_id_to_remove = filter_var($_POST['item_id'] ?? '', FILTER_VALIDATE_INT);
        if ($item_id_to_remove) {
            try {
                // Delete the specific cart item from the database
                $stmt = $dbconn->prepare("DELETE FROM cart_items WHERE item_id = ? AND cart_id = ?");
                $stmt->bind_param("ii", $item_id_to_remove, $current_cart_id);
                $stmt->execute();
                $stmt->close();
            } catch (mysqli_sql_exception $e) {
                error_log("Error removing item from cart_items: " . $e->getMessage());
            }
        }
    } elseif ($action === 'update_quantity') {
        $item_id_to_update = filter_var($_POST['item_id'] ?? '', FILTER_VALIDATE_INT);
        $new_quantity = filter_var($_POST['quantity'] ?? 1, FILTER_VALIDATE_INT);

        if ($item_id_to_update) {
            try {
                // Fetch product_id from cart_items to get its stock
                $stmt_get_item = $dbconn->prepare("SELECT product_id FROM cart_items WHERE item_id = ? AND cart_id = ?");
                $stmt_get_item->bind_param("ii", $item_id_to_update, $current_cart_id);
                $stmt_get_item->execute();
                $result_get_item = $stmt_get_item->get_result();
                $cart_item_data = $result_get_item->fetch_assoc();
                $stmt_get_item->close();

                if ($cart_item_data) {
                    $product_id = $cart_item_data['product_id'];

                    // Re-fetch stock from 'products' table to ensure quantity doesn't exceed available stock
                    $stmt_stock = $dbconn->prepare("SELECT stock FROM products WHERE product_id = ?");
                    $stmt_stock->bind_param("i", $product_id);
                    $stmt_stock->execute();
                    $result_stock = $stmt_stock->get_result();
                    $db_product_stock = $result_stock->fetch_assoc();
                    $stmt_stock->close();

                    if ($db_product_stock) {
                        $available_stock = $db_product_stock['stock'];
                        $final_quantity = min($new_quantity, $available_stock); 

                        if ($final_quantity > 0) {
                            // Update quantity in cart_items table
                            $stmt_update = $dbconn->prepare("UPDATE cart_items SET quantity = ? WHERE item_id = ? AND cart_id = ?");
                            $stmt_update->bind_param("iii", $final_quantity, $item_id_to_update, $current_cart_id);
                            $stmt_update->execute();
                            $stmt_update->close();
                        } else {
                            $stmt_delete = $dbconn->prepare("DELETE FROM cart_items WHERE item_id = ? AND cart_id = ?");
                            $stmt_delete->bind_param("ii", $item_id_to_update, $current_cart_id);
                            $stmt_delete->execute();
                            $stmt_delete->close();
                        }
                    }
                }
            } catch (mysqli_sql_exception $e) {
                error_log("Error updating cart_items quantity: " . $e->getMessage());
            }
        }
    }

    header("Location: cart.php");
    exit();
}


$cart_items = [];
if ($current_cart_id) {
    try {
        $sql = "SELECT ci.item_id, ci.product_id, ci.quantity, ci.size, ci.color, ci.price,
                       p.product_name, p.product_description, p.stock
                FROM cart_items ci
                JOIN products p ON ci.product_id = p.product_id
                WHERE ci.cart_id = ?";
        $stmt = $dbconn->prepare($sql);
        $stmt->bind_param("i", $current_cart_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $row['product_image'] = 'https://placehold.co/400x300/E0E0E0/333333?text=No+Image';
            $cart_items[] = $row;
        }
        $stmt->close();
    } catch (mysqli_sql_exception $e) {
        error_log("Error fetching cart items for display: " . $e->getMessage());
        $cart_items = []; 
    }
}


// --- Calculate Cart Summary ---
$total = 0;
$shipping = 0;


foreach ($cart_items as $item) {
    $item_subtotal = $item['quantity'] * $item['price']; 
    $total += $item_subtotal;

    $cutForShipping = $item_subtotal * 0.005; // 0.5% of item's subtotal
    $shipping += $cutForShipping;
}

// Round shipping to 2 decimal places
$shipping = round($shipping, 2);

// Final total
$final_total = $total + $shipping;

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="../../public/assets/logo-square.png" type="image/x-icon">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
        <link rel="stylesheet" href="../../public/css/global/base.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="../../public/css/global/customer.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="../../public/css/components/cart.css?v=<?php echo time(); ?>">
        <!-- The cart.js can be used for client-side interactions like quantity +/- without full page reload -->
        <!-- For this example, quantity changes trigger a form submit for server-side processing -->
        <script src="../../public/js/cart.js?v=<?php echo time(); ?>" defer></script>
        <title>R+G Clothing | Cart</title>
    </head>
    <body>
        <?php include '../includes/catalog_header.php'; ?>
        <main class="main-wrapper">
            <h2 class="cart-title">Shopping Cart</h2>
            <section class="main-container">
                <div class="cart-items">
                    <?php if (empty($cart_items)): // Check $cart_items array, which is populated from DB ?>
                        <p class="text-center w-100 text-gray-600">Your cart is empty. <a href="catalog.php" class="text-blue-500 hover:underline">Start shopping!</a></p>
                    <?php else: ?>
                        <?php foreach ($cart_items as $item) : ?>
                            <div class="cart-item">
                                <div class="cart-item-left">
                                    <img src="<?php echo htmlspecialchars($item['product_image']); ?>" alt="Product Image" class="cart-item-image" onerror="this.src='../../public/assets/image-placeholder.svg'">
                                    <div class="cart-item-details">
                                        <a href="product.php?id=<?php echo htmlspecialchars($item['product_id']); ?>" class="link-hover-line cart-item-name"><?php echo htmlspecialchars($item['product_name']); ?></a>
                                        <p class="cart-item-size-color">
                                            <span class="cart-item-size">Size: <?php echo htmlspecialchars($item['size']); ?></span> | 
                                            <span class="cart-item-color">Color: <?php echo htmlspecialchars($item['color']); ?></span>
                                        </p>
                                        <h5 class="cart-item-price">₱<?php echo htmlspecialchars(number_format($item['price'], 2)); ?></h5>
                                    </div>
                                </div>
                                <div class="cart-item-actions">
                                    <!-- Quantity Update Form -->
                                    <form action="cart.php" method="POST" class="quantity-form">
                                        <input type="hidden" name="action" value="update_quantity">
                                        <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($item['item_id']); ?>">
                                        <div class="input-group">
                                            <button type="submit" name="quantity" value="<?php echo htmlspecialchars($item['quantity'] - 1); ?>" class="btn btn-outline-secondary btn-sm" <?php echo ($item['quantity'] <= 1) ? 'disabled' : ''; ?>>-</button>
                                            <input type="text" name="display_quantity" class="form-control text-center quantity-input" value="<?php echo htmlspecialchars($item['quantity']); ?>" readonly>
                                            <button type="submit" name="quantity" value="<?php echo htmlspecialchars($item['quantity'] + 1); ?>" class="btn btn-outline-secondary btn-sm" <?php echo ($item['quantity'] >= $item['stock']) ? 'disabled' : ''; ?>>+</button>
                                        </div>
                                    </form>

                                    <!-- Remove Item Form -->
                                    <form action="cart.php" method="POST" class="remove-form">
                                        <input type="hidden" name="action" value="remove">
                                        <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($item['item_id']); ?>">
                                        <button type="submit" class="btn btn-danger remove-item">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="cart-summary">
                    <h3 class="cart-summary-title">Order Summary</h3>
                    <div class="price-breakdown">
                        <div class="breakdown-item">
                            <p class="price-label">Subtotal</p>
                            <p class="price-value">₱<?php echo number_format($total, 2); ?></p>
                        </div>
                        <div class="breakdown-item">
                            <p class="price-label">Shipping</p>
                            <p class="price-value">₱<?php echo number_format($shipping, 2); ?></p>
                        </div>
                    </div>
                    <div class="total-price">
                        <p class="price-label">Total</p>
                        <p class="price-value">₱<?php echo number_format($final_total, 2); ?></p>
                    </div>
                    <form action="checkout.php" method="post">
                        <div class="checkout-button mt-1">
                            <button class="btn btn-primary w-100" <?php echo empty($cart_items) ? 'disabled' : ''; ?>>Proceed to Checkout</button>
                        </div>
                    </form>
                    
                </div>
            </section>
        </main>
    </body>
</html>
