<?php
session_start();
include("connection.php");

if (!isset($_SESSION['unique_device_id'])) {
    header("Location: cart.php");
    exit;
}

$device_id = $_SESSION['unique_device_id'];
$mobile    = $_SESSION['mobile'] ?? '';
$name      = $_SESSION['name'] ?? '';
$table_id  = $_SESSION['table_id'] ?? '';

// Fetch cart
$cart = mysqli_query($conn, "
    SELECT MenuID, Rate, Quantity, (Rate * Quantity) AS amount
    FROM menu_items
    WHERE DeviceID='$device_id'
");

if (mysqli_num_rows($cart) == 0) {
    die("Cart empty");
}

// Calculate totals
$itemTotal = 0;
$items = [];

while ($row = mysqli_fetch_assoc($cart)) {
    $itemTotal += $row['amount'];
    $items[] = $row;
}

$cgst = round($itemTotal * 0.025, 2);
$sgst = round($itemTotal * 0.025, 2);
$grand = round($itemTotal + $cgst + $sgst);

// INSERT ORDER (COD)
foreach ($items as $item) {
    mysqli_query($conn, "
        INSERT INTO placeorder (
            mobile_no,
            customer_name,
            product_id,
            qty,
            rate,
            amount,
            sub_total,
            total_tax_amt,
            grand_amt,
            table_id,
            payment_method,
            payment_status,
            status,
            status_id
        ) VALUES (
            '$mobile',
            '$name',
            '{$item['MenuID']}',
            '{$item['Quantity']}',
            '{$item['Rate']}',
            '{$item['amount']}',
            '$itemTotal',
            '".($cgst+$sgst)."',
            '$grand',
            '$table_id',
            'COD',
            NULL,
            'Pending',
            0
        )
    ");
}

// Clear cart
mysqli_query($conn, "DELETE FROM menu_items WHERE DeviceID='$device_id'");

header("Location: order_success.php?mode=COD");
exit;
