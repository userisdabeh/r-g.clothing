<?php
session_start();
include '../../config/dbconn.php';

// Initialize filter variables
$search_query = trim($_GET['search'] ?? '');
$category_filter = trim($_GET['category'] ?? 'all'); // Default to 'all'
$min_price = filter_var($_GET['min-price'] ?? '', FILTER_VALIDATE_FLOAT);
$max_price = filter_var($_GET['max-price'] ?? '', FILTER_VALIDATE_FLOAT);


$sql = "SELECT product_id, product_name, product_description, price, category FROM products WHERE 1=1";
$params = [];
$types = '';

// search filter
if (!empty($search_query)) {
    $sql .= " AND (product_name LIKE ? OR product_description LIKE ?)"; // Use product_description
    $params[] = '%' . $search_query . '%';
    $params[] = '%' . $search_query . '%';
    $types .= 'ss';
}

// category filter
if ($category_filter !== 'all' && !empty($category_filter)) {
    $sql .= " AND category = ?";
    $params[] = $category_filter;
    $types .= 's';
}

// price range filters
if ($min_price !== false && $min_price >= 0) {
    $sql .= " AND price >= ?";
    $params[] = $min_price;
    $types .= 'd'; 
}
if ($max_price !== false && $max_price >= 0) {
    $sql .= " AND price <= ?";
    $params[] = $max_price;
    $types .= 'd'; 
}

// Order by product name
$sql .= " ORDER BY product_name ASC";

$products = []; // Array to store fetched products

try {
    if ($dbconn === null) {
        throw new mysqli_sql_exception("Database connection is not established. Check dbconn.php.");
    }
    $stmt = $dbconn->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    $stmt->close();
} catch (mysqli_sql_exception $e) {
    error_log("Error fetching products: " . $e->getMessage());
    $products = [];
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
        <title>R+G Clothing | Shop</title>
    </head>
    <body>
        <?php include '../includes/catalog_header.php'; ?>
        <main class="main-wrapper">
            <h2 class="main-title">Shop</h2>
            <section class="shop-container">
                <section class="filter-container">
                    <div class="filter-header">
                        <i class="bi bi-funnel"></i>
                        <h3>Filters</h3>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get" class="filter-form">
                        <div class="filter-search">
                            <h5>Search Products</h5>
                            <input type="search" name="search" id="search" placeholder="Search for products" class="form-control" value="<?php echo htmlspecialchars($search_query); ?>">
                        </div>
                        <div class="filter-category">
                            <h5>Category</h5>
                            <div class="filter-categories">
                                <label class="category-item">
                                    <input type="radio" name="category" id="category-all" value="all" <?php echo ($category_filter === 'all') ? 'checked' : ''; ?>>
                                    All
                                </label>
                                <label class="category-item">
                                    <input type="radio" name="category" id="category-streetwear" value="Streetwear" <?php echo ($category_filter === 'Streetwear') ? 'checked' : ''; ?>>
                                    Streetwear
                                </label>
                                <label class="category-item">
                                    <input type="radio" name="category" id="category-hypebeast" value="Hypebeast" <?php echo ($category_filter === 'Hypebeast') ? 'checked' : ''; ?>>
                                    Hypebeast
                                </label>
                                <label class="category-item">
                                    <input type="radio" name="category" id="category-casual" value="Casual" <?php echo ($category_filter === 'Casual') ? 'checked' : ''; ?>>
                                    Casual
                                </label>
                                <label class="category-item">
                                    <input type="radio" name="category" id="category-athletic" value="Athletic" <?php echo ($category_filter === 'Athletic') ? 'checked' : ''; ?>>
                                    Athletic
                                </label>
                                <label class="category-item">
                                    <input type="radio" name="category" id="category-workwear" value="Workwear" <?php echo ($category_filter === 'Workwear') ? 'checked' : ''; ?>>
                                    Workwear
                                </label>
                            </div>
                        </div>
                        <div class="filter-price">
                            <h5>Price</h5>
                            <div class="filter-price-range">
                                <input type="number" name="min-price" id="min-price" placeholder="Min" class="form-control" min="0" value="<?php echo ($min_price !== false) ? htmlspecialchars($min_price) : ''; ?>">
                                <span>-</span>
                                <input type="number" name="max-price" id="max-price" placeholder="Max" class="form-control" min="0" value="<?php echo ($max_price !== false) ? htmlspecialchars($max_price) : ''; ?>">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                    </form>
                </section>
                <section class="product-cards">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="product-card">
                                <img src="https://placehold.co/400x300/E0E0E0/333333?text=No+Image" alt="<?php echo htmlspecialchars($product['product_name']); ?>" class="product-card-image">
                                <div class="product-card-details">
                                    <div class="product-card-content">
                                        <h5 class="product-card-title"><?php echo htmlspecialchars($product['product_name']); ?></h5>

                                        <p class="product-card-description"><?php echo htmlspecialchars($product['product_description']); ?></p>
                                        </p> -->
                                        <p class="product-card-price">₱<span class="product-card-value"><?php echo htmlspecialchars(number_format($product['price'] ?? 0, 2)); ?></span></p>
                                    </div>
                                    <a href="product.php?id=<?php echo htmlspecialchars($product['product_id']); ?>" class="btn btn-primary product-card-button">View Product</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center text-gray-600 w-full">No products found matching your criteria.</p>
                    <?php endif; ?>
                </section>
            </section>
        </main>
    </body>
</html>
