<?php
    session_start();
    include_once '../../config/dbconn.php';

    $user_id = $_SESSION['user_id'];

    if (!$user_id) {
        header("Location: ../login.php");
        exit;
    }

    $rating = $_POST['rating-value'];
    $order_item_id = $_POST['order_item_id'];


    try {
        $updateRating = $dbconn->prepare("UPDATE order_items SET product_rating = ? WHERE order_item_id = ?");
        $updateRating->bind_param("ii", $rating, $order_item_id);
        $updateRating->execute();
        $updateRating->close();

        header("Location: order_details.php?order_item_id=" . $order_item_id);
        exit;
    } catch (Exception $e) {
        header("Location: order_details.php?order_item_id=" . $order_item_id . "&error=true");
        exit;
    }

?>