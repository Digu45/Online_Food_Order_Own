<?php
session_start();
$payment_method = $_GET['payment_mode'] ?? 'COD';


// Session variables
$mobile     = $_SESSION['mobile'] ?? '';
$device_id  = $_SESSION['unique_device_id'] ?? '';
$table_id   = $_SESSION['table_id'] ?? '';
$cust_name  = $_SESSION['name'] ?? '';

include("connection.php");

$itemTotal = 0;

$sumRes = $conn->query("
    SELECT SUM(Amount) AS total 
    FROM menu_items 
    WHERE DeviceID='$device_id'
");
$row = $sumRes->fetch_assoc();
$itemTotal = $row['total'];

$cgstTotal = round($itemTotal * 0.025, 2);
$sgstTotal = round($itemTotal * 0.025, 2);
$totalTax  = $cgstTotal + $sgstTotal;
$roundedTotal = round($itemTotal + $totalTax);
$fractionalAmount = $roundedTotal - ($itemTotal + $totalTax);


if ($payment_method === 'COD') {
    $payment_status = 'Pending';
    $transaction_id = NULL;
} elseif ($payment_method === 'UPI') {
    $payment_status = 'Pending';
    $transaction_id = NULL;
} elseif ($payment_method === 'CARD') {
    $payment_status = 'Paid';
    $transaction_id = 'CARD' . time();
} else {
    $payment_method = 'COD';
    $payment_status = 'Pending';
    $transaction_id = NULL;
}


$totalTax = $cgstTotal + $sgstTotal;

// Fetch cart items
$sql = "SELECT MenuID, Rate, Quantity, Amount, Instructions 
        FROM menu_items WHERE DeviceID='$device_id'";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    echo json_encode(['error' => 'No items in cart.']);
    exit;
}

$order_group_id = 'ORD' . time() . rand(100,999);

$insert_success = true;

while ($row = $result->fetch_assoc()) {

    $menuID       = $row['MenuID'];
    $rate         = $row['Rate'];
    $qty          = $row['Quantity'];
    $amount       = $row['Amount'];
    $instructions = $conn->real_escape_string($row['Instructions']);

    $sql_insert = "INSERT INTO placeorder (
        mobile_no,
        customer_name,
        product_id,
        qty,
        rate,
        amount,
        sub_total,
        total_tax_amt,
        rounded_amt,
        grand_amt,
        table_id,
        Instructions,
        status_id,
        payment_method,
        payment_status,
        transaction_id,
        order_group_id
    ) VALUES (
        '$mobile',
        '$cust_name',
        '$menuID',
        '$qty',
        '$rate',
        '$amount',
        '$itemTotal',
        '$totalTax',
        '$fractionalAmount',
        '$roundedTotal',
        '$table_id',
        '$instructions',
        0,
        '$payment_method',
        '$payment_status',
        " . ($transaction_id ? "'$transaction_id'" : "NULL") . ",
        '$order_group_id'
    )";

    if (!$conn->query($sql_insert)) {
        $insert_success = false;
        echo json_encode(['error' => 'Insert failed: ' . $conn->error]);
        break;
    }
}

// Clear cart
if ($insert_success) {
    $sql_delete = "DELETE FROM menu_items WHERE DeviceID='$device_id'";
    if ($conn->query($sql_delete)) {
        echo json_encode([
            'result' => 'success',
            'payment_method' => $payment_method,
            'payment_status' => $payment_status,
            'order_group_id' => $order_group_id

        ]);
    } else {
        echo json_encode(['error' => 'Failed to clear cart']);
    }
}

$conn->close();
?>
