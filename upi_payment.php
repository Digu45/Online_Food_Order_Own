<?php
include 'connection.php';

$order_id = $_GET['order_id'] ?? '';
if ($order_id == '') {
    die("Invalid Order");
}
?>

<h3>Pay using UPI</h3>

<img src="images/OR.jpeg" width="250"><br><br>

<form method="POST" action="save_utr.php">
    <input type="hidden" name="order_id" value="<?= $order_id ?>">
    <input type="text" name="utr" placeholder="Enter UPI Transaction ID" required>
    <br><br>
    <button type="submit">Confirm Payment</button>
</form>
