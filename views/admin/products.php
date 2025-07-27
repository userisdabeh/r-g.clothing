<?php
    $activePage = 'products';
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
        <link rel="stylesheet" href="../../public/css/components/admin/dashboard.css?v=<?php echo time(); ?>">
        <title>R+G - Admin Dashboard</title>
    </head>
    <body>
        <?php include 'components/navigation.php'; ?>
        <main>
            <div class="main-header">
                <h3 class="main-header-title">Products</h3>
                <div class="main-header-actions">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        <i class="bi bi-plus-circle"></i>
                        Add Product
            </div>
        </main>
    </body>
</html>