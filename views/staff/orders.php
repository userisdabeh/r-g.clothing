<?php
    session_start();
    $activePage = 'orders';

    include_once '../../config/dbconn.php';

    $user_id = $_SESSION['user_id'];
    $search = isset($_GET['search']) ? mysqli_real_escape_string($dbconn, $_GET['search']) : '';

    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $orderID = mysqli_real_escape_string($dbconn, $_POST['orderID']);
        $orderStatus = mysqli_real_escape_string($dbconn, $_POST['orderStatus']);

        if ($orderID === '' || $orderStatus === '') {
            $message = "Please fill in all fields";
        } else {
            $updateOrder = mysqli_query($dbconn, "CALL update_order_status('$orderID', '$orderStatus')");
            if ($updateOrder) {
                $message = "Order status updated successfully";
            } else {
                $message = "Failed to update order status";
            }
        }

        header("Location: orders.php");
        exit;
    }

    if ($search !== '') {
        $getAllOrders = mysqli_query($dbconn, "CALL get_orders_by_search('$search')");
    } else {
        $getAllOrders = mysqli_query($dbconn, "CALL get_orders_list()");
    }
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
        <title>R+G Clothing - Staff Dashboard</title>
        <link rel="shortcut icon" href="../../public/assets/logo-square.png" type="image/x-icon">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../public/css/global/base.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="../../public/css/global/employees.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="../../public/css/components/staff/orders.css?v=<?php echo time(); ?>">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous" defer></script>
        <script src="../../public/js/orders.js?v=<?php echo time(); ?>" defer></script>
    </head>
    <body>
        <?php include 'components/navigation.php'; ?>
        <main>
            <div class="main-header">
                <h3 class="main-header-title">Order Management</h3>
                <div class="main-header-actions">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="search" name="search" id="search" class="form-control" placeholder="Search for an order">
                        </div>
                    </form>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateOrderModal">
                        <i class="bi bi-plus-circle"></i>
                        Update Order
                    </button>
                </div>
            </div>
            <div class="main-content">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 5%;">ID</th>
                            <th scope="col" style="width: 60%;">List of Items</th>
                            <th scope="col" style="width: 10%;">Status</th>
                            <th scope="col" style="width: 15%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($getAllOrdersResult as $order): ?>
                        <tr class="align-middle">
                            <td scope="row" class="fw-semibold"><?php echo $order['order_id']; ?></td>
                            <td><?php echo $order['items_summary']; ?></td>
                            <td><?php echo $order['order_status']; ?></td>
                            <td>
                                <button class="btn btn-primary button-data" data-bs-toggle="modal" data-bs-target="#updateOrderModal" data-bs-order-id="<?php echo $order['order_id']; ?>" data-bs-order-status="<?php echo $order['order_status']; ?>" data-bs-order-items="<?php echo $order['items_summary']; ?>">Update Status</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
        <div class="modal fade" id="updateOrderModal" tabindex="-1" aria-labelledby="updateOrderModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title fs-5">Update Order Status</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="updateOrderForm">
                            <div class="mb-3">
                                <label for="orderID" class="form-label">Order ID <span class="text-danger">*</span></label>
                                <select class="form-select" id="orderID" name="orderID" required>
                                    <option value="" disabled selected>Select Order</option>
                                    <!-- Dynamically added from the data in the table -->
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="orderStatus" class="form-label">Order Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="orderStatus" name="orderStatus" required>
                                    <option value="" disabled selected>Select Status</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Paid">Paid</option>
                                    <option value="Shipped">Shipped</option>
                                    <option value="Delivery">Delivery</option>
                                    <option value="Delivered">Delivered</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="updateOrderButton" form="updateOrderForm">Update Status</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>