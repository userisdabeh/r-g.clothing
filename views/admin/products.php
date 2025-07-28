<?php
    session_start();
    $activePage = 'products';

    include_once '../../config/dbconn.php';

    $user_id = $_SESSION['user_id'];
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $productName = mysqli_real_escape_string($dbconn, $_POST['productName']);
        $productDescription = mysqli_real_escape_string($dbconn, $_POST['productDescription']);
        $productCategory = mysqli_real_escape_string($dbconn, $_POST['productCategory']);
        $productSize = mysqli_real_escape_string($dbconn, $_POST['productSize']);
        $productColor = mysqli_real_escape_string($dbconn, $_POST['productColor']);
        $productPrice = mysqli_real_escape_string($dbconn, $_POST['productPrice']);
        $productStock = mysqli_real_escape_string($dbconn, $_POST['productStock']);

        if ($productName === '' || $productDescription === '' || $productCategory === '' || $productSize === '' || $productPrice === '' || $productStock === '' || $productColor === '') {
            $message = "Please fill in all fields";
        } else {
            $addProduct = mysqli_query($dbconn, "CALL create_product('$productName', '$productDescription', '$productPrice', '$productStock', '$productSize', '$productColor', '$productCategory', 1)");
        }
    }

    $getAllProducts = mysqli_query($dbconn, "CALL get_all_products()");
    $getAllProductsResult = [];
    while ($row = mysqli_fetch_assoc($getAllProducts)) {
        $getAllProductsResult[] = $row;
    }
    mysqli_free_result($getAllProducts);
    mysqli_next_result($dbconn);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../../public/assets/logo-square.png">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
        <link rel="stylesheet" href="../../public/css/global/base.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="../../public/css/global/employees.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="../../public/css/components/admin/products.css?v=<?php echo time(); ?>">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous" defer></script>
        <title>R+G - Admin Dashboard</title>
    </head>
    <body>
        <?php include 'components/navigation.php'; ?>
        <main>
            <section class="main-header mb-4">
                <h3 class="main-header-title">Products</h3>
                <div class="main-header-actions">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        <i class="bi bi-plus-circle"></i>
                        Add Product
                    </button>
                </div>
            </section>
            <section class="table-container">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Category</th>
                            <th scope="col">Size</th>
                            <th scope="col">Price</th>
                            <th scope="col">Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($getAllProductsResult as $product): ?>
                        <tr>
                            <td scope="row"><?php echo $product['product_id']; ?></td>
                            <td><?php echo $product['product_name']; ?></td>
                            <td><?php echo $product['product_description']; ?></td>
                            <td><?php echo $product['category']; ?></td>
                            <td><?php echo $product['size']; ?></td>
                            <td>PHP <?php echo $product['price']; ?></td>
                            <td><?php echo $product['stock']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </main>
        <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title fs-5" id="addProductModalLabel">Add Product</h4>
                    </div>
                    <div class="modal-body">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="addProductForm">
                            <div class="mb-3">
                                <label for="productName" class="form-label">Product Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="productName" name="productName" required>
                            </div>
                            <div class="mb-3">
                                <label for="productDescription" class="form-label">Product Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="productDescription" name="productDescription" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="productCategory" class="form-label">Product Category <span class="text-danger">*</span></label>
                                <select class="form-select" id="productCategory" name="productCategory" required>
                                    <option value="" disabled selected>Select Category</option>
                                    <option value="Streetwear">Streetwear</option>
                                    <option value="Hypebeast">Hypebeast</option>
                                    <option value="Casual">Casual</option>
                                    <option value="Athletic">Athletic</option>
                                    <option value="Workwear">Workwear</option>
                                </select>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="productSize" class="form-label">Product Size <span class="text-danger">*</span></label>
                                    <select class="form-select" id="productSize" name="productSize" required>
                                        <option value="" disabled selected>Select Size</option>
                                        <option value="S">S</option>
                                        <option value="M">M</option>
                                        <option value="L">L</option>
                                        <option value="XL">XL</option>
                                        <option value="XXL">XXL</option>
                                    </select>
                                </div>    
                                <div class="col">
                                    <label for="productColor" class="form-label">Product Color <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="productColor" name="productColor" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="productPrice" class="form-label">Product Price <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="productPrice" name="productPrice" required>
                            </div>
                            <div class="mb-3">
                                <label for="productStock" class="form-label">Product Stock <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="productStock" name="productStock" required>
                            </div>                            
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" form="addProductForm">Add Product</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>