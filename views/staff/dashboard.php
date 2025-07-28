<?php
    session_start();
    $activePage = 'dashboard';

    include_once '../../config/dbconn.php';

    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit;
    }

    $user_id = $_SESSION['user_id'];

    $getAllProducts = mysqli_query($dbconn, "CALL get_all_products()");
    $getAllProductsResult = [];
    $totalProducts = 0;
    while ($row = mysqli_fetch_assoc($getAllProducts)) {
        $getAllProductsResult[] = $row;
        $totalProducts++;
    }
    mysqli_free_result($getAllProducts);
    mysqli_next_result($dbconn);

    $getAllOrders = mysqli_query($dbconn, "CALL get_all_orders()");
    $getAllOrdersResult = [];
    $totalOrders = 0;
    $pendingOrders = 0;
    $paidOrders = 0;
    $shippedOrders = 0;
    $deliveredOrders = 0;
    $deliveryOrders = 0;
    $cancelledOrders = 0;
    while ($row = mysqli_fetch_assoc($getAllOrders)) {
        $getAllOrdersResult[] = $row;
        $totalOrders++;
        if ($row['order_status'] === 'Pending') {
            $pendingOrders++;
        } else if ($row['order_status'] === 'Paid') {
            $paidOrders++;
        } else if ($row['order_status'] === 'Shipped') {
            $shippedOrders++;
        } else if ($row['order_status'] === 'Delivery') {
            $deliveryOrders++;
        } else if ($row['order_status'] === 'Delivered') {
            $deliveredOrders++;
        } else if ($row['order_status'] === 'Cancelled') {
            $cancelledOrders++;
        }
    }
    mysqli_free_result($getAllOrders);
    mysqli_next_result($dbconn);

    $getRecentOrders = mysqli_query($dbconn, "CALL get_recent_orders_limit_five()");
    $getRecentOrdersResult = [];
    while ($row = mysqli_fetch_assoc($getRecentOrders)) {
        $getRecentOrdersResult[] = $row;
    }
    mysqli_free_result($getRecentOrders);
    mysqli_next_result($dbconn);
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>R+G Clothing - Staff Dashboard</title>
        <link rel="shortcut icon" href="../../public/assets/logo-square.png" type="image/x-icon">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../public/css/global/base.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="../../public/css/global/employees.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="../../public/css/components/staff/dashboard.css?v=<?php echo time(); ?>">
    </head>
    <body>
        <?php include 'components/navigation.php'; ?>
        <main>
            <section class="summary-cards">
                <div class="summary-card">
                    <div class="summary-card-header">
                        <p class="summary-card-title">Total Products</p>
                        <i class="bi bi-box-seam summary-card-icon"></i>
                    </div>
                    <div class="summary-card-body">
                        <p class="summary-card-value"><?php echo $totalProducts; ?></p>
                        <p class="summary-card-description">Total number of products in the inventory</p>
                    </div>
                    <a href="stocks.php" class="summary-card-link link-hover-line">View Stocks</a>
                </div>
                <div class="summary-card">
                    <div class="summary-card-header">
                        <p class="summary-card-title">Process Orders</p>
                        <i class="bi bi-bag-dash summary-card-icon"></i>
                    </div>
                    <div class="summary-card-body">
                        <p class="summary-card-value"><?php echo $pendingOrders; ?></p>
                        <p class="summary-card-description">Pending orders</p>
                    </div>
                    <a href="orders.php" class="summary-card-link link-hover-line">View Orders</a>
                </div>
            </section>
            <section class="quick-details-actions">
                <section class="quick-details">
                    <div class="quick-products quick-detail">
                        <div class="quick-detail-header">
                            <div class="header-title">
                                <i class="bi bi-box-seam"></i>
                                <p class="header-title-text">Products</p>
                            </div>
                            <a href="products.php" class="link-hover-line">View All</a>
                        </div>
                        <table class="quick-detail-table">
                            <colgroup>
                                <col style="width: 40%;">
                                <col style="width: 20%;">
                                <col style="width: 10%;">
                                <col style="width: 15%;">
                                <col style="width: 15%;">
                            </colgroup>
                            <thead>
                                <th class="table-header">NAME</th>
                                <th class="table-header">CATEGORY</th>
                                <th class="table-header">SIZE</th>
                                <th class="table-header">COLOR</th>
                                <th class="table-header">STOCK</th>
                            </thead>
                            <tbody>
                                <?php for ($i = 0; $i < 5; $i++): ?>
                                <tr>
                                    <td><?php echo $getAllProductsResult[$i]['product_name']; ?></td>
                                    <td><?php echo $getAllProductsResult[$i]['category']; ?></td>
                                    <td><?php echo $getAllProductsResult[$i]['size']; ?></td>
                                    <td><?php echo $getAllProductsResult[$i]['color']; ?></td>
                                    <td><?php echo $getAllProductsResult[$i]['stock']; ?></td>
                                </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="quick-orders quick-detail">
                        <div class="quick-detail-header">
                            <div class="header-title">
                                <i class="bi bi-bag-dash"></i>
                                <p class="header-title-text">Recent Orders</p>
                            </div>
                            <a href="orders.php" class="link-hover-line">View All</a>
                        </div>
                        <table class="quick-detail-table">
                            <colgroup>
                                <col style="width: 40%;">
                                <col style="width: 15%;">
                                <col style="width: 15%;">
                                <col style="width: 15%;">
                                <col style="width: 15%;">
                            </colgroup>
                            <thead>
                                <th>Product</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Quantity</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                <?php foreach ($getRecentOrdersResult as $order): ?>
                                <tr>
                                    <td><?php echo $order['product_name']; ?></td>
                                    <td><?php echo $order['size']; ?></td>
                                    <td><?php echo $order['color']; ?></td>
                                    <td><?php echo $order['quantity']; ?></td>
                                    <td>
                                        <span class="badge <?php echo $order['order_status'] === 'Pending' ? 'text-bg-danger' : ($order['order_status'] === 'Paid' ? 'text-bg-success' : ($order['order_status'] === 'Shipped' ? 'text-bg-primary' : ($order['order_status'] === 'Delivery' ? 'text-bg-warning' : ($order['order_status'] === 'Delivered' ? 'text-bg-info' : 'text-bg-secondary')))); ?>"><?php echo $order['order_status']; ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>
                <section class="quick-actions">
                    <div class="header-title quick-actions-header">
                        <i class="bi bi-lightning-charge"></i>
                        <p class="header-title-text">Quick Actions</p>
                    </div>
                    <ul class="quick-actions-list">
                        <li>
                            <a href="stocks.php" class="quick-action">
                                <i class="bi bi-box-seam"></i>
                                <p class="quick-action-title">View All Products</p>
                            </a>
                        </li>
                        <li>
                            <a href="orders.php" class="quick-action">
                                <i class="bi bi-bag-dash"></i>
                                <p class="quick-action-title">View All Orders</p>
                            </a>
                        </li>
                    </ul>
                </section>
            </section>
        </main>
    </body>
</html>