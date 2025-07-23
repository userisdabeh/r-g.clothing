<?php
session_start();
include '../../config/dbconn.php';

$product = null; 
$product_id = $_GET['id'] ?? null; 

// Validate product ID
if ($product_id === null || !is_numeric($product_id)) {
    // If no ID or invalid ID, redirect or show an error
    header("Location: catalog.php"); 
    exit();
}

try {
    $sql = "SELECT product_id, product_name, product_description, price, stock, size, color, category FROM products WHERE product_id = ?";
    $stmt = $dbconn->prepare($sql);

    $stmt->bind_param("i", $product_id); 

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        header("Location: catalog.php?error=product_not_found"); 
        exit();
    }

    $stmt->close();

} catch (mysqli_sql_exception $e) {
    error_log("Error fetching product details: " . $e->getMessage());
    header("Location: catalog.php?error=db_error");
    exit();
}

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
        <link rel="stylesheet" href="../../public/css/global/catalog.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="../../public/css/components/product.css?v=<?php echo time(); ?>">
        <title>R+G Clothing | <?php echo htmlspecialchars($product['product_name'] ?? 'Product'); ?></title>
    </head>
    <body>
        <?php include '../includes/catalog_header.php'; ?>
        <main class="main-wrapper">
            <?php if ($product): ?>
                <div class="product-detail-container">
                    <section class="product-image-section">
                        <img src="https://placehold.co/600x400/E0E0E0/333333?text=Product+Image" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                    </section>
                    <section class="product-info-section">
                        <h1><?php echo htmlspecialchars($product['product_name']); ?></h1>
                        <p class="price">₱<?php echo htmlspecialchars(number_format($product['price'], 2)); ?></p>
                        <p class="description"><?php echo htmlspecialchars($product['product_description']); ?></p>

                        <div class="details">
                            <p><strong>Category:</strong> <?php echo htmlspecialchars($product['category']); ?></p>
                            <p><strong>Available Stock:</strong> <?php echo htmlspecialchars($product['stock']); ?></p>
                            <p><strong>Sizes:</strong> <?php echo htmlspecialchars($product['size']); ?></p>
                            <p><strong>Color:</strong> <?php echo htmlspecialchars($product['color']); ?></p>
                        </div>

                        <form action="cart.php" method="POST">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['product_id']); ?>">
                            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>">
                            <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($product['price']); ?>">
                            <input type="hidden" name="product_size" value="<?php echo htmlspecialchars($product['size']); ?>">
                            <input type="hidden" name="product_color" value="<?php echo htmlspecialchars($product['color']); ?>">
                            <input type="hidden" name="product_image" value="https://placehold.co/400x300/E0E0E0/333333?text=No+Image">

                            <div class="quantity-control">
                                <label for="quantity" class="font-medium text-gray-700">Quantity:</label>
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">-</button>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" max="<?php echo htmlspecialchars($product['stock']); ?>" class="form-control">
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">+</button>
                            </div>

                            <button type="submit" class="add-to-cart-btn" <?php echo ($product['stock'] <= 0) ? 'disabled' : ''; ?>>
                                <?php echo ($product['stock'] <= 0) ? 'Out of Stock' : 'Add to Cart'; ?>
                            </button>
                        </form>
                    </section>
                </div>
            <?php else: ?>
                <div class="text-center p-8">
                    <h2 class="text-2xl font-bold text-red-600">Product Not Found or Database Error</h2>
                    <p class="text-gray-700 mt-4">We could not retrieve the product details. Please try again or go back to the <a href="catalog.php" class="text-blue-500 hover:underline">shop page</a>.</p>
                </div>
            <?php endif; ?>
        </main>
    </body>
</html>
