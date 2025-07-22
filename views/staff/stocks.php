<?php
    $activePage = 'stocks';
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
        <link rel="stylesheet" href="../../public/css/components/staff/stocks.css?v=<?php echo time(); ?>">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous" defer></script>
        <script src="../../public/js/stocks.js?v=<?php echo time(); ?>" defer></script>
    </head>
    <body>
        <?php include 'components/navigation.php'; ?>
        <main>
            <div class="main-header">
                <h3 class="main-header-title">Stock Management</h3>
                <div class="main-header-actions">
                    <form action="" method="get">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="search" name="search" id="search" class="form-control" placeholder="Search for a product">
                        </div>
                    </form>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateStockModal">
                        <i class="bi bi-plus-circle"></i>
                        Update Stock
                    </button>
                </div>
            </div>
            <div class="main-content">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Size</th>
                            <th scope="col">Color</th>
                            <th scope="col">Stock Level</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <!-- Dynamically added from Database. Each Product Name should be unique and not repeated.
                        Variables:
                        1. data-bs-product-name (value should be the product name)
                        2. data-bs-product-size (value should be the product size)
                        3. data-bs-product-color (value should be the product color)
                        4. data-bs-product-stock (value should be the product stock)
                        5. data-bs-target (important so modal will toggle)
                        6. data-bs-toggle (important so modal will toggle) -->
                    <tbody>
                        <tr class="align-middle">
                            <td scope="row" class="fw-semibold">1</td>
                            <td>Leather Jacket</td>
                            <td>S</td>
                            <td>White</td>
                            <td>1,000</td>
                            <td>
                                <button class="btn btn-primary button-data" data-bs-toggle="modal" data-bs-target="#updateStockModal" data-bs-product-id="1" data-bs-product-name="Leather Jacket" data-bs-product-size="S" data-bs-product-color="White" data-bs-product-stock="1000">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            </td>
                        </tr>
                        <tr class="align-middle">
                            <td scope="row" class="fw-semibold">2</td>
                            <td>Leather Jacket</td>
                            <td>M</td>
                            <td>Black</td>
                            <td>1,890</td>
                            <td>
                                <button class="btn btn-primary button-data" data-bs-toggle="modal" data-bs-target="#updateStockModal" data-bs-product-id="2" data-bs-product-name="Leather Jacket" data-bs-product-size="M" data-bs-product-color="Black" data-bs-product-stock="1890">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
        <div class="modal fade" id="updateStockModal" tabindex="-1" aria-labelledby="updateStockModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title fs-5" id="updateStockModalLabel">Update Stock</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" id="updateStockForm">
                            <div class="mb-3">
                                <label for="productID" class="form-label">Product ID <span class="text-danger">*</span></label>
                                <select class="form-select" id="productID" name="productID" required>
                                    <option value="" disabled selected>Select Product</option>
                                    <!-- Dynamically added from the data in the table -->
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="productQuantity" class="form-label">Product Quantity <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="productQuantity" name="productQuantity" placeholder="Enter Quantity" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" form="updateStockForm">Update Stock</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>