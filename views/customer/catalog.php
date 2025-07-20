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
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" class="filter-form">
                        <div class="filter-search">
                            <h5>Search Products</h5>
                            <input type="search" name="search" id="search" placeholder="Search for products" class="form-control">
                        </div>
                        <div class="filter-category">
                            <h5>Category</h5>
                            <div class="filter-categories">
                                    <label class="category-item">
                                        <input type="radio" name="category" id="category-all" value="all">
                                        All
                                    </label>
                                <label class="category-item">
                                    <input type="radio" name="category" id="category-streetwear" value="streetwear">
                                    Streetwear
                                </label>
                                <label class="category-item">
                                    <input type="radio" name="category" id="category-hypebeast" value="hypebeast">
                                    Hypebeast
                                </label>
                                <label class="category-item">
                                    <input type="radio" name="category" id="category-casual" value="casual">
                                    Casual
                                </label>
                                <label class="category-item">
                                    <input type="radio" name="category" id="category-athletic" value="athletic">
                                    Athletic
                                </label>
                                <label class="category-item">
                                    <input type="radio" name="category" id="category-workwear" value="workwear">
                                    Workwear
                                </label>
                            </div>
                        </div>
                        <div class="filter-price">
                            <h5>Price</h5>
                            <div class="filter-price-range">
                                <input type="number" name="min-price" id="min-price" placeholder="Min" class="form-control" min="0">
                                <span>-</span>
                                <input type="number" name="max-price" id="max-price" placeholder="Max" class="form-control" min="0">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                    </form>
                </section>
                <section class="product-cards">
                    <div class="product-card">
                        <img src="https://res.cloudinary.com/davgly7hd/image/upload/v1752311719/samples/woman-on-a-football-field.jpg" alt="Product Image" class="product-card-image">
                        <div class="product-card-details">
                            <div class="product-card-content">
                                <h5 class="product-card-title">Product Name</h5>
                                <p class="product-card-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sit amet consequat sapien. Maecenas aliquam auctor aliquam. Aliquam commodo eget justo ut sagittis. Donec eros odio, porttitor ut nisi ac, ultricies pretium nibh. Integer vitae nisi nibh. Ut facilisis, libero sed congue ornare, erat diam congue eros, et molestie nibh libero eget sem. Integer rhoncus vestibulum felis. Proin porttitor sem in sem ultricies sollicitudin. Donec vestibulum euismod dui, sed fringilla nibh lobortis vitae. Mauris pellentesque purus ultrices aliquet lacinia. Ut maximus vel est nec efficitur.</p>
                                <p class="product-card-rating">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                    4.5
                                    <span>(100)</span>
                                </p>
                                <p class="product-card-price">₱<span class="product-card-value" id="product-card-value-1">1000</span></p>
                            </div>
                            <a href="product.php" class="btn btn-primary product-card-button">View Product</a>
                        </div>
                    </div>
                    <div class="product-card">
                        <img src="https://res.cloudinary.com/davgly7hd/image/upload/v1752311719/samples/woman-on-a-football-field.jpg" alt="Product Image" class="product-card-image">
                        <div class="product-card-details">
                            <div class="product-card-content">
                                <h5 class="product-card-title">Product Name</h5>
                                <p class="product-card-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sit amet consequat sapien. Maecenas aliquam auctor aliquam. Aliquam commodo eget justo ut sagittis. Donec eros odio, porttitor ut nisi ac, ultricies pretium nibh. Integer vitae nisi nibh. Ut facilisis, libero sed congue ornare, erat diam congue eros, et molestie nibh libero eget sem. Integer rhoncus vestibulum felis. Proin porttitor sem in sem ultricies sollicitudin. Donec vestibulum euismod dui, sed fringilla nibh lobortis vitae. Mauris pellentesque purus ultrices aliquet lacinia. Ut maximus vel est nec efficitur.</p>
                                <p class="product-card-rating">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                    4.5
                                    <span>(100)</span>
                                </p>
                                <p class="product-card-price">₱<span class="product-card-value">1000</span></p>
                            </div>
                            <a href="product.php" class="btn btn-primary product-card-button">View Product</a>
                        </div>
                    </div>
                    <div class="product-card">
                        <img src="https://res.cloudinary.com/davgly7hd/image/upload/v1752311719/samples/woman-on-a-football-field.jpg" alt="Product Image" class="product-card-image">
                        <div class="product-card-details">
                            <div class="product-card-content">
                                <h5 class="product-card-title">Product Name</h5>
                                <p class="product-card-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sit amet consequat sapien. Maecenas aliquam auctor aliquam. Aliquam commodo eget justo ut sagittis. Donec eros odio, porttitor ut nisi ac, ultricies pretium nibh. Integer vitae nisi nibh. Ut facilisis, libero sed congue ornare, erat diam congue eros, et molestie nibh libero eget sem. Integer rhoncus vestibulum felis. Proin porttitor sem in sem ultricies sollicitudin. Donec vestibulum euismod dui, sed fringilla nibh lobortis vitae. Mauris pellentesque purus ultrices aliquet lacinia. Ut maximus vel est nec efficitur.</p>
                                <p class="product-card-rating">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                    4.5
                                    <span>(100)</span>
                                </p>
                                <p class="product-card-price">₱<span class="product-card-value" id="product-card-value-2">1000</span></p>
                            </div>
                            <a href="product.php" class="btn btn-primary product-card-button">View Product</a>
                        </div>
                    </div>
                    <div class="product-card">
                        <img src="https://res.cloudinary.com/davgly7hd/image/upload/v1752311719/samples/woman-on-a-football-field.jpg" alt="Product Image" class="product-card-image">
                        <div class="product-card-details">
                            <div class="product-card-content">
                                <h5 class="product-card-title">Product Name</h5>
                                <p class="product-card-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sit amet consequat sapien. Maecenas aliquam auctor aliquam. Aliquam commodo eget justo ut sagittis. Donec eros odio, porttitor ut nisi ac, ultricies pretium nibh. Integer vitae nisi nibh. Ut facilisis, libero sed congue ornare, erat diam congue eros, et molestie nibh libero eget sem. Integer rhoncus vestibulum felis. Proin porttitor sem in sem ultricies sollicitudin. Donec vestibulum euismod dui, sed fringilla nibh lobortis vitae. Mauris pellentesque purus ultrices aliquet lacinia. Ut maximus vel est nec efficitur.</p>
                                <p class="product-card-rating">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                    4.5
                                    <span>(100)</span>
                                </p>
                                <p class="product-card-price">₱<span class="product-card-value" id="product-card-value-3">1000</span></p>
                            </div>
                            <a href="product.php" class="btn btn-primary product-card-button">View Product</a>
                        </div>
                    </div>
                    <div class="product-card">
                        <img src="https://res.cloudinary.com/davgly7hd/image/upload/v1752311719/samples/woman-on-a-football-field.jpg" alt="Product Image" class="product-card-image">
                        <div class="product-card-details">
                            <div class="product-card-content">
                                <h5 class="product-card-title">Product Name</h5>
                                <p class="product-card-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sit amet consequat sapien. Maecenas aliquam auctor aliquam. Aliquam commodo eget justo ut sagittis. Donec eros odio, porttitor ut nisi ac, ultricies pretium nibh. Integer vitae nisi nibh. Ut facilisis, libero sed congue ornare, erat diam congue eros, et molestie nibh libero eget sem. Integer rhoncus vestibulum felis. Proin porttitor sem in sem ultricies sollicitudin. Donec vestibulum euismod dui, sed fringilla nibh lobortis vitae. Mauris pellentesque purus ultrices aliquet lacinia. Ut maximus vel est nec efficitur.</p>
                                <p class="product-card-rating">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                    4.5
                                    <span>(100)</span>
                                </p>
                                <p class="product-card-price">₱<span class="product-card-value" id="product-card-value-4">1000</span></p>
                            </div>
                            <a href="product.php" class="btn btn-primary product-card-button">View Product</a>
                        </div>
                    </div>
                </section>
            </section>
        </main>
    </body>
</html>