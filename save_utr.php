<?php
include 'connection.php';

$order_id = $_POST['order_id'];
$utr      = $_POST['utr'];

mysqli_query($conn, "
UPDATE placeorder
SET transaction_id='$utr', payment_status='Pending'
WHERE order_group_id='$order_id'
");

header("Location: order_success.php?order_id=$order_id");
