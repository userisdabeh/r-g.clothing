<?php
include_once '../../config/dbconn.php';

// Function to get the current cart item count
function get_cart_item_count($dbconn) {
    $count = 0;
    $user_id = $_SESSION['user_id'] ?? null;
    $session_id = session_id();

    $cart_id = null;
    if ($user_id) {
        $stmt = $dbconn->prepare("SELECT cart_id FROM carts WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $cart_id = $row['cart_id'];
        }
        $stmt->close();
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

    if ($cart_id) {
        try {
            $stmt = $dbconn->prepare("SELECT SUM(quantity) AS total_quantity FROM cart_items WHERE cart_id = ?");
            $stmt->bind_param("i", $cart_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $count = (int) $row['total_quantity'];
            }
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            error_log("Error fetching cart count: " . $e->getMessage());
            $count = 0; 
        }
    }
    return $count;
}


$cart_item_count = get_cart_item_count($dbconn);
?>

<header>
    <a href="../customer/catalog.php">
        <img src="../../public/assets/logo-landscape.png" alt="R+G Clothing Logo" class="logo">
    </a>
    <div class="header-details">
        <select name="currency" id="currency">
            <option value="PHP">PHP</option>
            <option value="USD">USD</option>
            <option value="EUR">EUR</option>
        </select>
        <a href="cart.php">
            <i class="bi bi-cart"></i>
            <span class="cart-count">(<?php echo $cart_item_count; ?>)</span>
        </a>
        <a href="../customer/orders.php">My Orders</a>
        <a href="profile.php">
            <i class="bi bi-person"></i>
            <span class="username">
                <?php
                    if (isset($_SESSION['user_name'])) {
                        echo htmlspecialchars($_SESSION['user_name']);
                    } else {
                        echo 'Guest';
                    }
                ?>
            </span>
        </a>
        <?php if (isset($_SESSION['user_name'])): ?>
            <a href="../logout.php" class="btn btn-sm btn-outline-secondary ml-2">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        <?php endif; ?>
    </div>
</header>
