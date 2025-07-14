<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="../../public/assets/logo-square.png" type="image/x-icon">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
        <link rel="stylesheet" href="../../public/css/global/base.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="../../public/css/global/catalog.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="../../public/css/global/dropdown.css?v=<?php echo time(); ?>">
        <script src="../../public/js/dropdown.js?v=<?php echo time(); ?>"></script>
        <title>R+G Clothing | Shop</title>
    </head>
    <body>
        <?php include '../includes/catalog_header.php'; ?>
        <main>
            <div class="filter-container">
                <div class="filter-header">
                    <i class="bi bi-funnel"></i>
                    <h3>Filters</h3>
                </div>
                <input type="search" name="search" id="search" placeholder="Search for products">
            </div>
        </main>
    </body>
</html>