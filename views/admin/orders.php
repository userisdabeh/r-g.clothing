<?php
    session_start();
    $activePage = 'orders';

    include_once '../../config/dbconn.php';

    $user_id = $_SESSION['user_id'];
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit;
    }

    $getAllOrders = mysqli_query($dbconn, "CALL admin_view_orders()");
    $getAllOrdersResult = [];
    while ($row = mysqli_fetch_assoc($getAllOrders)) {
        $getAllOrdersResult[] = $row;
    }
    mysqli_free_result($getAllOrders);
    mysqli_next_result($dbconn);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="../../public/assets/logo-square.png" type="image/x-icon">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../public/css/global/base.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="../../public/css/global/employees.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="../../public/css/components/admin/orders.css?v=<?php echo time(); ?>">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous" defer></script>
        <title>R+G - Admin Dashboard</title>
    </head>
    <body>
        <?php include 'components/navigation.php'; ?>
        <main>
            <section class="main-header mb-4">
                <h3 class="main-header-title">Orders</h3>
            </section>
            <section class="table-container">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Total Amount</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($getAllOrdersResult as $order): ?>
                        <tr>
                            <td scope="row"><?php echo $order['order_id']; ?></td>
                            <td><?php echo $order['product_name']; ?></td>
                            <td>PHP <?php echo $order['price_at_purchase']; ?></td>
                            <td><?php echo $order['order_status']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </body>
</html>