<?php
    session_start();
    include_once '../../config/dbconn.php';

    $user_id = $_SESSION['user_id'];

    if (!$user_id) {
        header("Location: ../login.php");
        exit;
    }

    $getOrders = $dbconn->prepare("SELECT * FROM orders WHERE user_id = ?");
    $getOrders->bind_param("i", $user_id);
    $getOrders->execute();
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
    <title>R+G Clothing | Orders</title>
</head>
<body>
    <?php include '../includes/catalog_header.php'; ?>
    <main>
        <div class="main-header">
            <h3 class="main-header-title">Orders</h3>
        </div>
    </main>
</body>
</html>