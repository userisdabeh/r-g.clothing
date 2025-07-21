<?php
session_start();
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
            <span class="cart-count">(0)</span>
        </a>
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
    </div>
</header>