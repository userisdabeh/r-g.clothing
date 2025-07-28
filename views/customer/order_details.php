<?php
    session_start();
    include_once '../../config/dbconn.php';

    $user_id = $_SESSION['user_id'];

    if (!$user_id) {
        header("Location: ../login.php");
        exit;
    }

    $order_item_id = $_GET['order_item_id'];

    $getProduct = $dbconn->prepare("SELECT oi.order_item_id, oi.order_id, oi.quantity, oi.price_at_purchase, oi.product_rating, p.product_name, p.product_description, p.size, p.color, o.order_status, o.created_at FROM order_items oi JOIN products p ON oi.product_id = p.product_id JOIN orders o ON oi.order_id = o.order_id WHERE oi.order_item_id = ?");
    $getProduct->bind_param("i", $order_item_id);
    $getProduct->execute();
    $getProductResult = $getProduct->get_result()->fetch_assoc();
    $getProduct->close();

    $getAddress = $dbconn->prepare("SELECT * FROM user_address WHERE user_id = ?");
    $getAddress->bind_param("i", $user_id);
    $getAddress->execute();
    $getAddressResult = $getAddress->get_result()->fetch_assoc();
    $getAddress->close();
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
        <link rel="stylesheet" href="../../public/css/components/order_details.css?v=<?php echo time(); ?>">
        <script src="../../public/js/order_details.js?v=<?php echo time(); ?>" defer></script>
        <title>R+G Clothing | Order Details</title>
    </head>
    <body>
        <?php include '../includes/catalog_header.php'; ?>
        <main class="main-wrapper">
            <h3 class="main-header-title">Order Details</h3>
            <section class="main-container">
                <section class="product-details">
                    <img src="https://placehold.co/400x300/E0E0E0/333333?text=No+Image" alt="Product Image" class="product-image">
                    <div class="product-details-content">
                        <h4 class="product-name"><?php echo $getProductResult['product_name']; ?></h4>
                        <ul class="product-details">
                            <li class="product-description">Product Description: <span class="product-description-value"><?php echo $getProductResult['product_description']; ?></span></li>
                            <li class="product-price">Price: <span class="product-price-value">₱<?php echo $getProductResult['price_at_purchase']; ?></span></li>
                            <li class="product-quantity">Quantity: <span class="product-quantity-value"><?php echo $getProductResult['quantity']; ?></span></li>
                            <li class="product-color">Color: <span class="product-color-value"><?php echo $getProductResult['color']; ?></span></li>
                            <li class="product-size">Size: <span class="product-size-value"><?php echo $getProductResult['size']; ?></span></li>
                        </ul>
                    </div>
                </section>
                <section class="order-details">
                    <h4 class="order-details-title">Order Details</h4>
                    <ul class="order-details">
                        <li class="order-id">Order ID: <span class="order-id-value"><?php echo $getProductResult['order_id']; ?></span></li>
                        <li class="order-status">Status: <span class="order-status-value"><?php echo $getProductResult['order_status']; ?></span></li>
                        <li class="order-total">Total: <span class="order-total-value">₱<?php echo $getProductResult['price_at_purchase'] * $getProductResult['quantity']; ?></span></li>
                        <li class="order-date">Date: <span class="order-date-value"><?php echo $getProductResult['created_at']; ?></span></li>
                        <li class="order-address">Address: <span class="order-address-value"><?php echo $getAddressResult['street_address']. ', ' . $getAddressResult['barangay'] . ', ' . $getAddressResult['city'] . ', ' . $getAddressResult['province'] . ', ' . $getAddressResult['postal_code']; ?></span></li>
                    </ul>
                    <?php if ($getProductResult['product_rating']): ?>
                        <h4 class="review-title">Your Review</h4>
                        <div class="star-rating disabled" id="starRating">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span class="star <?php echo $i <= $getProductResult['product_rating'] ? 'selected' : ''; ?>">&#9733;</span>
                            <?php endfor; ?>
                        </div>
                        <p class="text-muted">You rated this product <?php echo $getProductResult['product_rating']; ?> star(s).</p>
                    <?php else: ?>
                        <h4 class="review-title">Leave a Review</h4>
                        <form action="rateProduct.php" method="post">
                            <div class="star-rating mb-3" id="starRating">
                                <span class="star" data-value="1">&#9733;</span>
                                <span class="star" data-value="2">&#9733;</span>
                                <span class="star" data-value="3">&#9733;</span>
                                <span class="star" data-value="4">&#9733;</span>
                                <span class="star" data-value="5">&#9733;</span>
                            </div>
                            <input type="hidden" name="rating-value" id="ratingValue">
                            <input type="hidden" name="order_item_id" value="<?php echo $order_item_id; ?>">
                            <button type="submit" class="btn btn-primary">Submit Review</button>
                        </form>
                    <?php endif; ?>
                </section>
            </section>
        </main>
    </body>
</html>