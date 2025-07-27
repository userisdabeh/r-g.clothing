<?php
    $activePage = 'dashboard';
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
                        <p class="summary-card-value">100</p>
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
                        <p class="summary-card-value">100</p>
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
                        <p class="summary-card-value">100</p>
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
                            <tr>
                                <td scope="row">1</td>
                                <td>Product Name</td>
                                <td>PHP 100</td>
                                <td>10</td>
                            </tr>
                            <tr>
                                <td scope="row">2</td>
                                <td>Product Name</td>
                                <td>PHP 100</td>
                                <td>10</td>
                            </tr>
                            <tr>
                                <td scope="row">3</td>
                                <td>Product Name</td>
                                <td>PHP 100</td>
                                <td>10</td>
                            </tr>
                            <tr>
                                <td scope="row">4</td>
                                <td>Product Name</td>
                                <td>PHP 100</td>
                                <td>10</td>
                            </tr>
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