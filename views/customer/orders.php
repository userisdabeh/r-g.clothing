<?php
    session_start();
    include_once '../../config/dbconn.php';

    $user_id = $_SESSION['user_id'];

    if (!$user_id) {
        header("Location: ../login.php");
        exit;
    }

    $getOrders = $dbconn->prepare("SELECT o.order_id, o.user_id, o.order_status, o.total_amount, o.created_at, oi.order_item_id, oi.product_id, oi.quantity, oi.price_at_purchase, p.product_name FROM orders o JOIN order_items oi ON o.order_id = oi.order_id JOIN products p ON oi.product_id = p.product_id WHERE o.user_id = ?");
    $getOrders->bind_param("i", $user_id);
    $getOrders->execute();
    $resultOrders = $getOrders->get_result();
    $orders = $resultOrders->fetch_all(MYSQLI_ASSOC);
    $getOrders->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../public/assets/logo-square.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="../../public/css/global/base.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../../public/css/global/customer.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../../public/css/components/orders.css?v=<?php echo time(); ?>">
    <title>R+G Clothing | Orders</title>
</head>
<body>
    <?php include '../includes/catalog_header.php'; ?>
    <main class="main-wrapper">
        <h3 class="main-header-title">Orders</h3>
        <section class="main-container">
            <div class="orders-container">
                <?php if (count($orders) === 0): ?>
                    <p class="no-orders-message">No orders found</p>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <div class="order-card">
                            <h4 class="product-name"><?php echo $order['product_name']; ?></h4>
                            <ul class="product-details">
                                <li class="product-quantity">Quantity: <?php echo $order['quantity']; ?></li>
                                <li class="product-price">Price: <?php echo $order['price_at_purchase']; ?></li>
                                <li class="product-total">Total: <?php echo $order['total_amount']; ?></li>
                                <li class="product-status">Status: <?php echo $order['order_status']; ?></li>
                                <li class="product-date">Date: <?php echo $order['created_at']; ?></li>
                            </ul>
                            <a href="../customer/order_details.php?order_item_id=<?php echo $order['order_item_id']; ?>" class="view-details-btn">View Details</a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    </main>
</body>
</html>