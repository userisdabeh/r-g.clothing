<?php
    $activePage = 'dashboard';
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
                        <p class="summary-card-value">100</p>
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
                        <p class="summary-card-value">192</p>
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
                            <tbody> <!-- Maximum of 5 products only -->
                                <tr>
                                    <td>Leather Jacket</td>
                                    <td>Workwear</td>
                                    <td>S</td>
                                    <td>White</td>
                                    <td>100</td>
                                </tr>
                                <tr>
                                    <td>Leather Jacket</td>
                                    <td>Workwear</td>
                                    <td>M</td>
                                    <td>White</td>
                                    <td>100</td>
                                </tr>
                                <tr>
                                    <td>Leather Jacket</td>
                                    <td>Workwear</td>
                                    <td>L</td>
                                    <td>White</td>
                                    <td>100</td>
                                </tr>
                                <tr>
                                    <td>Leather Jacket</td>
                                    <td>Workwear</td>
                                    <td>XL</td>
                                    <td>White</td>
                                    <td>100</td>
                                </tr>
                                <tr>
                                    <td>Leather Jacket</td>
                                    <td>Workwear</td>
                                    <td>S</td>
                                    <td>Black</td>
                                    <td>100</td>
                                </tr>
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
                            <tbody> <!-- Maximum of 6 orders only -->
                                <tr>
                                    <td>Leather Jacket</td>
                                    <td>S</td>
                                    <td>White</td>
                                    <td>100</td>
                                    <td>
                                        <span class="badge text-bg-danger">Pending</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Leather Jacket</td>
                                    <td>M</td>
                                    <td>White</td>
                                    <td>100</td>
                                    <td>
                                        <span class="badge text-bg-success">Paid</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Leather Jacket</td>
                                    <td>L</td>
                                    <td>White</td>
                                    <td>100</td>
                                    <td>
                                        <span class="badge text-bg-primary">Shipped</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Leather Jacket</td>
                                    <td>XL</td>
                                    <td>White</td>
                                    <td>100</td>
                                    <td>
                                        <span class="badge text-bg-warning">Delivery</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Leather Jacket</td>
                                    <td>S</td>
                                    <td>White</td>
                                    <td>100</td>
                                    <td>
                                        <span class="badge text-bg-info">Delivered</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Leather Jacket</td>
                                    <td>M</td>
                                    <td>White</td>
                                    <td>100</td>
                                    <td>
                                        <span class="badge text-bg-secondary">Cancelled</span>
                                    </td>
                                </tr>
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