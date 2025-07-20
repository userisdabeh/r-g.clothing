<?php
    // Just sample data
    // TODO: Replace with actual data from database
    $product = [
        'name' => 'Black Coat Leather',
        'price' => 2999,
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sit amet consequat sapien. Maecenas aliquam auctor aliquam. Aliquam commodo eget justo ut sagittis. Donec eros odio, porttitor ut nisi ac, ultricies pretium nibh. Integer vitae nisi nibh. Ut facilisis, libero sed congue ornare, erat diam congue eros, et molestie nibh libero eget sem. Integer rhoncus vestibulum felis. Proin porttitor sem in sem ultricies sollicitudin. Donec vestibulum euismod dui, sed fringilla nibh lobortis vitae. Mauris pellentesque purus ultrices aliquet lacinia. Ut maximus vel est nec efficitur.',
        'stock' => [
            'S' => [
                'white' => 10,
                'black' => 15,
            ],
            'M' => [
                'white' => 20,
                'black' => 25,
            ],
            'L' => [
                'white' => 30,
                'black' => 35,
            ],
            'XL' => [
                'white' => 40,
                'black' => 45,
            ]
        ],
        'colors' => [
            'White',
            'Black',
        ],
        'sizes' => [
            'S',
            'M',
            'L',
            'XL',
        ],
        'images' => [
            '../../public/assets/leather1.webp',
            '../../public/assets/leather2.webp',
            '../../public/assets/leather3.jpg',
        ],
        'reviews' => [
            'review1' => [
                'user' => 'Lebron James',
                'rating' => 5,
                'comment' => 'This is a great product! I love it!',
                'image' => '../../public/assets/lebron.webp'
            ],
            'review2' => [
                'user' => 'Kobe Bryant',
                'rating' => 4.5,
                'comment' => 'This is a good product! I like it!'
            ],
            'review3' => [
                'user' => 'Michael Jordan',
                'rating' => 1,
                'comment' => 'This is a bad product! I hate it!',
                'image' => '../../public/assets/michael.webp'
            ]
        ]
    ];
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
        <link rel="stylesheet" href="../../public/css/components/product.css?v=<?php echo time(); ?>">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous" defer></script>
        <script>window.stockData = <?php echo json_encode($product['stock']); ?></script>
        <script src="../../public/js/product.js?v=<?php echo time(); ?>" defer></script>
        <title>R+G Clothing | Shop</title>
    </head>
    <body>
        <?php include '../includes/catalog_header.php'; ?>
        <main class="main-wrapper">
            <div class="product-image">
                <div id="product-images" class="carousel slide" data-bs-ride="carousel">
                    <ol class="carousel-indicators">
                        <?php foreach ($product['images'] as $index => $image) : ?>
                            <li data-bs-target="#product-images" data-bs-slide-to="<?php echo $index; ?>" class="<?php echo $index === 0 ? 'active' : ''; ?>"></li>
                        <?php endforeach; ?>
                    </ol>
                    <div class="carousel-inner">
                        <?php foreach ($product['images'] as $index => $image) : ?>
                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                <img class="d-block w-100" src="<?php echo $image; ?>" alt="Product Image <?php echo $index + 1; ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a class="carousel-control-prev" href="#product-images" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#product-images" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </div>
            </div>
            <div class="product-details">
                <h1 class="product-details-name"><?php echo $product['name']; ?></h1>
                <div class="product-details-rating">
                    <?php
                        $rating = 0;
                        foreach ($product['reviews'] as $review) {
                            $rating += $review['rating'];
                        }
                        $rating = $rating / count($product['reviews']);
                        for($i = 0; $i < 5; $i++) {
                            if ($rating >= $i + 1) {
                                echo '<i class="bi bi-star-fill text-warning"></i>';
                            } else if ($rating >= $i + 0.5) {
                                echo '<i class="bi bi-star-half text-warning"></i>';
                            } else {
                                echo '<i class="bi bi-star text-warning"></i>';
                            }
                        }
                    ?>
                    <span class="product-details-rating-value">(<?php echo count($product['reviews']); ?> reviews)</span>
                </div>
                <h1 class="product-details-price">₱<span class="product-details-value"><?php echo number_format($product['price'], 2); ?></span></h1>
                <p class="product-details-description"><?php echo $product['description']; ?></p>
                <p class="stock-status">In Stock: <span class="stock-status-value"><?php echo $product['stock']['S']['white']; ?></span> remaining</p>
                <form action="" method="post" id="product-details-form" class="product-details-form">
                    <div class="product-details-size-selector">
                        <p class="product-details-size-selector-title">Size</p>
                        <select name="product-size" id="product-size" class="form-select">
                            <?php foreach ($product['sizes'] as $size) : ?>
                                <option value="<?php echo $size; ?>"><?php echo $size; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="product-details-color-selector">
                        <p class="product-details-color-selector-title">Color</p>
                        <select name="product-color" id="product-color" class="form-select">
                           <?php foreach ($product['colors'] as $color) : ?>
                                <option value="<?php echo $color; ?>"><?php echo $color; ?></option>
                           <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <button class="btn btn-secondary" type="button" id="button-minus">-</button>
                        <input type="number" name="product-quantity" id="product-quantity" class="form-control" value="1" min="1">
                        <button class="btn btn-secondary" type="button" id="button-plus">+</button>
                    </div>
                    <div class="product-details-actions">
                        <button type="submit" class="btn btn-primary" value="Cart">Add to Cart</button>
                        <button type="submit" class="btn btn-secondary" value="Buy">Buy Now</button>
                    </div>
                </form>
                <div class="product-details-reviews mt-5">
                    <h3 class="product-details-reviews-title">Reviews</h3>
                    <div class="product-details-reviews-list">
                        <?php foreach ($product['reviews'] as $review) : ?>
                            <div class="product-details-reviews-item">
                                <div class="product-details-reviews-item-header">
                                    <div class="reviews-stars">
                                        <?php for($i = 0; $i < 5; $i++) {
                                            if ($review['rating'] >= $i + 1) {
                                                echo '<i class="bi bi-star-fill text-warning"></i>';
                                            } else if ($review['rating'] >= $i + 0.5) {
                                                echo '<i class="bi bi-star-half text-warning"></i>';
                                            } else {
                                                echo '<i class="bi bi-star text-warning"></i>';
                                            }
                                        } ?>
                                    </div>
                                    <p class="product-details-reviews-item-user"><?php echo $review['user']; ?></p>
                                </div>
                                <?php if (isset($review['image'])) : ?>
                                    <img src="<?php echo $review['image']; ?>" alt="Review Image" class="product-details-reviews-item-image" onerror="this.src='../../public/assets/image-placeholder.svg'">
                                <?php endif; ?>
                                <p class="review-comment"><?php echo $review['comment']; ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>