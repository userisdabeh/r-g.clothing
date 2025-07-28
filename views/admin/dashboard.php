<?php
    session_start();
    $activePage = 'dashboard';

    include_once '../../config/dbconn.php';

    $user_id = $_SESSION['user_id'];
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
    }

    $getAllProducts = mysqli_query($dbconn, "CALL get_all_products()");
    $getAllProductsResult = [];
    $totalProducts = 0;
    while ($row = mysqli_fetch_assoc($getAllProducts)) {
        $getAllProductsResult[] = $row;
        $totalProducts++;
    }
    mysqli_free_result($getAllProducts);
    mysqli_next_result($dbconn);

    $getAllUsers = mysqli_query($dbconn, "CALL get_all_users()");
    $getAllUsersResult = [];
    $totalUsers = 0;
    while ($row = mysqli_fetch_assoc($getAllUsers)) {
        $getAllUsersResult[] = $row;
        $totalUsers++;
    }
    mysqli_free_result($getAllUsers);
    mysqli_next_result($dbconn);

    $getTotalRevenue = mysqli_query($dbconn, "CALL get_revenue()");
    $getTotalRevenueResult = mysqli_fetch_assoc($getTotalRevenue);
    mysqli_free_result($getTotalRevenue);
    mysqli_next_result($dbconn);

    $getTopProducts = mysqli_query($dbconn, "CALL get_top_five_product_by_revenue()");
    $getTopProductsResult = [];
    while ($row = mysqli_fetch_assoc($getTopProducts)) {
        $getTopProductsResult[] = $row;
    }
    mysqli_free_result($getTopProducts);
    mysqli_next_result($dbconn);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>R+G Clothing | Admin Dashboard</title>
        <link rel="shortcut icon" href="../../public/assets/logo-square.png" type="image/x-icon">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../public/css/global/base.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="../../public/css/global/employees.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="../../public/css/components/admin/dashboard.css?v=<?php echo time(); ?>">
    </head>
    <body>
        <?php include 'components/navigation.php'; ?>
        <main>
            <section class="summary-cards mb-4">
                <div class="summary-card">
                    <div class="summary-card-header">
                        <p class="summary-card-title">Total Products</p>
                        <i class="bi bi-box-seam summary-card-icon"></i>
                    </div>
                    <div class="summary-card-body">
                        <p class="summary-card-value"><?php echo $totalProducts; ?></p>
                        <p class="summary-card-description">Total number of products in the inventory</p>
                    </div>
                    <a href="products.php" class="summary-card-link link-hover-line">View Products</a>
                </div>
                <div class="summary-card">
                    <div class="summary-card-header">
                        <p class="summary-card-title">Total Users</p>
                        <i class="bi bi-people-fill summary-card-icon"></i>
                    </div>
                    <div class="summary-card-body">
                        <p class="summary-card-value"><?php echo $totalUsers; ?></p>
                        <p class="summary-card-description">Total number of users</p>
                    </div>
                    <a href="users.php" class="summary-card-link link-hover-line">View Users</a>
                </div>
                <div class="summary-card">
                    <div class="summary-card-header">
                        <p class="summary-card-title">Total Revenue</p>
                        <i class="bi bi-cash-coin summary-card-icon"></i>
                    </div>
                    <div class="summary-card-body">
                        <p class="summary-card-value"><?php echo $getTotalRevenueResult['revenue']; ?></p>
                        <p class="summary-card-description">Total revenue generated</p>
                    </div>
                </div>
            </section>
            <section class="top-quick">
                <div class="top-products"> <!-- Max of 5 products -->
                    <div class="top-products-header mb-2">
                        <p class="top-products-title">Top Products</p>
                        <i class="bi bi-box-seam top-products-icon"></i>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Product</th>
                                <th scope="col">Revenue</th>
                                <th scope="col"># of Orders</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($getTopProductsResult as $product): ?>
                            <tr>
                                <td scope="row"><?php echo $product['product_id']; ?></td>
                                <td><?php echo $product['product_name']; ?></td>
                                <td>PHP <?php echo $product['total_revenue']; ?></td>
                                <td><?php echo $product['total_quantity_sold']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="quick-actions">
                    <div class="quick-actions-header">
                        <p class="quick-actions-title">Quick Actions</p>
                        <i class="bi bi-gear-fill quick-actions-icon"></i>
                    </div>
                    <ul class="quick-actions-list">
                        <li>
                            <a href="products.php" class="quick-action">
                                <i class="bi bi-box-seam"></i>
                                <p class="quick-action-title">Add New Product</p>
                                <!-- Products -->
                            </a>
                        </li>
                        <li>
                            <a href="orders.php" class="quick-action">
                                <i class="bi bi-bag-dash"></i>
                                <p class="quick-action-title">View All Orders</p> <!-- Pending Orders -->
                                <!-- Orders -->
                            </a>
                        </li>
                        <li>
                            <a href="orders.php" class="quick-action">
                                <i class="bi bi-people-fill"></i>
                                <p class="quick-action-title">View All Users</p>
                                <!-- Users -->
                            </a>
                        </li>
                        <li>
                            <a href="reports.php" class="quick-action">
                                <i class="bi bi-file-earmark-bar-graph"></i>
                                <p class="quick-action-title">Generate Reports</p>
                                <!-- Reports -->
                            </a>
                        </li>
                    </ul>
                </div>
            </section>
        </main>
    </body>
</html>