<?php
    // Sample data for cart items
    // TODO: Replace with actual data from database
    // Suggestion: Use GROUP BY to group the cart items and the quantity of each item in the cart, so the data looks like this:
    $items = [
        $item1 = [
            'product_name' => 'Leather Jacket',
            'product_image' => 'https://res.cloudinary.com/davgly7hd/image/upload/v1752311719/samples/woman-on-a-football-field.jpg',
            'product_price' => 2999,
            'size' => 'M',
            'color' => 'Black',
            'quantity' => 1
        ],
        $item2 = [
            'product_name' => 'Camper Hoodie',
            'product_image' => '../../public/assets/leather1.webp',
            'product_price' => 4999,
            'size' => 'M',
            'color' => 'Black',
            'quantity' => 3
        ]
    ];

    // Initialize variables for cart summary
    $total = 0;
    $shipping = 0;
    $discount = 0;

    foreach($items as $item) {
        $total += $item['quantity'] * $item['product_price'];
        $cutForShipping = $total * 0.005;
        $shipping += $cutForShipping;
    }
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
        <link rel="stylesheet" href="../../public/css/components/cart.css?v=<?php echo time(); ?>">
        <script src="../../public/js/cart.js?v=<?php echo time(); ?>" defer></script>
        <title>R+G Clothing | Cart</title>
    </head>
    <body>
        <?php include '../includes/catalog_header.php'; ?>
        <main class="main-wrapper">
            <h2 class="cart-title">Shopping Cart</h2>
            <section class="main-container">
                <div class="cart-items">
                    <?php foreach ($items as $index => $item) : ?>
                        <div class="cart-item">
                            <div class="cart-item-left">
                                <img src="<?php echo $item['product_image']; ?>" alt="Product Image" class="cart-item-image" onerror="this.src='../../public/assets/image-placeholder.svg'">
                                <div class="cart-item-details">
                                    <a href="product.php" class="link-hover-line cart-item-name"><?php echo $item['product_name']; ?></a>
                                    <p class="cart-item-size-color">
                                        <span class="cart-item-size">Size: <?php echo $item['size']; ?></span> | 
                                        <span class="cart-item-color">Color: <?php echo $item['color']; ?></span>
                                    </p>
                                    <p class="cart-item-quantity">Quantity: <?php echo $item['quantity']; ?></p>
                                    <h5 class="cart-item-price">₱<?php echo $item['product_price']; ?></h5>
                                </div>
                            </div>
                            <div class="cart-item-actions">
                                <button class="btn btn-danger remove-item" data-index="<?php echo $index; ?>">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="cart-summary">
                    <h3 class="cart-summary-title">Order Summary</h3>
                    <div class="price-breakdown">
                        <div class="breakdown-item">
                            <p class="price-label">Subtotal</p>
                            <p class="price-value">₱<?php echo number_format($total, 2)?></p>
                        </div>
                        <div class="breakdown-item">
                            <p class="price-label">Shipping</p>
                            <p class="price-value">₱<?php echo number_format(round($shipping), 2)?></p>
                        </div>
                        <div class="breakdown-item">
                            <p class="price-label">Discount</p>
                            <p class="price-value">₱<?php echo number_format($discount, 2)?></p>
                        </div>
                    </div>
                    <div class="total-price">
                        <p class="price-label">Total</p>
                        <p class="price-value">₱<?php echo number_format(round($total + $shipping), 2)?></p>
                    </div>
                    <div class="checkout-button mt-1">
                        <button class="btn btn-primary w-100">Proceed to Checkout</button>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>