<?php
include 'connection.php';

if (isset($_GET['OrderId'])) {
    $orderId = $_GET['OrderId'];
    $sql = "UPDATE place_order SET status = 'confirmed' WHERE OrderId = '$orderId'";
    mysqli_query($conn, $sql);
    echo "Order confirmed!";
} else {
    echo "No order ID given.";
}
?>
