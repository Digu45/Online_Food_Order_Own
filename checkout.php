<?php
session_start();
include 'connection.php';

/* Device check */
if (!isset($_SESSION['unique_device_id'])) {
    header("Location: cart.php");
    exit;
}
$device_id = $_SESSION['unique_device_id'];

/* Fetch cart items */
$sql = "
    SELECT 
        MenuID,
        MenuName,
        MenuImageUrl,
        Rate,
        Quantity,
        (Rate * Quantity) AS amount
    FROM menu_items
    WHERE DeviceID = '$device_id'
";
$result = mysqli_query($conn, $sql);

$item_total = 0;
$items = [];

while ($row = mysqli_fetch_assoc($result)) {
    $item_total += $row['amount'];
    $items[] = $row;
}

/* Tax */
$cgst = round($item_total * 0.025, 2);
$sgst = round($item_total * 0.025, 2);
$total = $item_total + $cgst + $sgst;
$rounded_total = round($total);
$round_off = number_format($rounded_total - $total, 2);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Checkout</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            overflow-x: hidden;
        }


        .checkout-header {
            width: 100vw;
            /* FULL SCREEN */
            max-width: 100vw;
            background: rgb(138, 147, 144);
            color: #fff;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-sizing: border-box;
        }

        .checkout-header .logo {
            height: 42px;
            /* bigger */
            border-radius: 6px;
        }

        /* CONTAINER */
        .checkout-container {
            max-width: 520px;
            margin: auto;
            padding: 12px;
            padding-bottom: 90px;
            /* space for sticky button */
        }

        /* CARD */
        .checkout-card {
            background: #fff;
            border-radius: 14px;
            margin-bottom: 14px;
            padding: 14px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        }

        .section-title {
            font-weight: 600;
            margin-bottom: 12px;
            font-size: 15px;
        }

        /* ORDER ITEM */
        .order-item {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
        }

        .food-img {
            width: 62px;
            height: 62px;
            border-radius: 10px;
            object-fit: cover;
        }

        .item-info {
            flex: 1;
            padding-left: 10px;
        }

        .item-info h6 {
            margin: 0;
            font-size: 14px;
            font-weight: 500;
        }

        .item-info small {
            color: #777;
        }

        .item-price {
            font-weight: 600;
            font-size: 14px;
        }

        /* BILL */
        .bill-row,
        .bill-total {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
            font-size: 14px;
        }

        .bill-total {
            font-weight: 600;
            font-size: 16px;
        }

        /* CONTAINER – INLINE ROW */
        .payment-options {
            display: flex;
            gap: 12px;
            justify-content: space-between;
        }

        /* EACH PAYMENT BOX */
        .payment-option {
            flex: 1;
            display: flex;
            flex-direction: column;
            /* icon above text */
            align-items: center;
            gap: 8px;
            border: 1px solid #e0e0e0;
            padding: 14px 10px;
            border-radius: 16px;
            cursor: pointer;
            transition: 0.2s;
            background: #fff;
            text-align: center;
        }

        .payment-option:hover {
            background: #f9f9f9;
        }

        /* HIDE DEFAULT RADIO */
        .payment-option input {
            display: none;
        }

        /* CIRCULAR ICON */
        .payment-option img {
            width: 56px;
            height: 56px;
            object-fit: contain;
            border-radius: 50%;
            background: #f3f5f9;
            padding: 10px;
        }

        /* TEXT */
        .payment-option span {
            font-size: 15px;
            font-weight: 600;
            color: #333;
        }

        /* SELECTED STATE */
        .payment-option input:checked+img {
            outline: 2px solid rgb(121, 162, 227);
        }


        /* PAY BUTTON (STICKY LIKE REAL APPS) */
        .pay-btn {
            position: fixed;
            bottom: 12px;
            left: 50%;
            transform: translateX(-50%);
            width: calc(100% - 24px);
            max-width: 520px;

            background: rgb(121, 162, 227);
            color: #fff;
            border: none;
            padding: 16px;
            font-size: 17px;
            font-weight: 600;
            border-radius: 14px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        /* MOBILE ONLY TUNING */
        @media (max-width: 480px) {

            .checkout-header span {
                font-size: 14px;
                font-weight: 600;
            }

            .food-img {
                width: 68px;
                height: 68px;
            }

            .item-info h6 {
                font-size: 15px;
            }
        }

        @media (max-width: 480px) {
            .checkout-header {
                min-height: 45px;
            }
        }



        @media (max-width: 480px) {
            .payment-option img {
                width: 40px;
                height: 40px;
            }

            .payment-option span {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="checkout-header">
        <img src="images/digus_restaurant.jpeg" class="logo">
        <span>CHECKOUT</span>
    </div>

    <div class="container checkout-container">

        <!-- ORDER SUMMARY -->
        <div class="card checkout-card">
            <h5 class="section-title">Your Order</h5>

            <?php foreach ($items as $row) { ?>
                <div class="order-item">
                    <img src="<?= !empty($row['MenuImageUrl']) ? htmlspecialchars($row['MenuImageUrl']) : 'images/food-default.jpg' ?>" class="food-img" alt="Menu Image">
                    <div class="item-info">
                        <h6><?= $row['MenuName'] ?></h6>
                        <small>Qty: <?= $row['Quantity'] ?></small>
                    </div>

                    <div class="item-price">
                        ₹<?= $row['amount'] ?>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- BILL SUMMARY -->
        <div class="card checkout-card">
            <h5 class="section-title">Bill Details</h5>

            <div class="bill-row">
                <span>Item Total</span>
                <span>₹<?= $item_total ?></span>
            </div>
            <div class="bill-row">
                <span>CGST (2.5%)</span>
                <span>₹<?= $cgst ?></span>
            </div>
            <div class="bill-row">
                <span>SGST (2.5%)</span>
                <span>₹<?= $sgst ?></span>
            </div>
            <div class="bill-row">
                <span>Round Off</span>
                <span>₹<?= $round_off ?></span>
            </div>

            <hr>

            <div class="bill-total">
                <span>Total Payable</span>
                <span>₹<?= $rounded_total ?></span>
            </div>
        </div>

      <!-- PAYMENT -->
<div class="card checkout-card">
    <h5 class="section-title">Payment Method</h5>

    <div class="payment-options">
        <label class="payment-option">
            <input type="radio" name="payment_mode" value="UPI">
            <img src="images/UPI.png">
            <span>UPI</span>
        </label>

        <label class="payment-option">
            <input type="radio" name="payment_mode" value="CARD">
            <img src="images/Card.png">
            <span>Card</span>
        </label>

        <label class="payment-option">
            <input type="radio" name="payment_mode" value="COD">
            <img src="images/Cash.png">
            <span>Cash</span>
        </label>
    </div>

    <p id="paymentError" style="color:red; display:none; margin-top:8px;">
        Please select a payment method
    </p>
</div>
<button class="pay-btn" id="payNowBtn">
    Pay ₹<?= $rounded_total ?>
</button>

<button class="pay-btn" id="codBtn" style="display:none; background:#16a34a;">
    Place Order (Cash)
</button>



    </div>

</body>

</html>
<script>
const payBtn = document.getElementById('payNowBtn');
const codBtn = document.getElementById('codBtn');
const errorMsg = document.getElementById('paymentError');
const radios = document.querySelectorAll('input[name="payment_mode"]');

// hide buttons initially
payBtn.style.display = "none";
codBtn.style.display = "none";

// handle payment mode selection
radios.forEach(radio => {
    radio.addEventListener("change", function () {
        errorMsg.style.display = "none";

        if (this.value === "COD") {
            payBtn.style.display = "none";
            codBtn.style.display = "block";
        } else {
            codBtn.style.display = "none";
            payBtn.style.display = "block";
            payBtn.innerText = "Pay ₹<?= $rounded_total ?>";
        }
    });
});

// UPI / CARD → GO TO placeorder.php
payBtn.onclick = () => {
    const selected = document.querySelector('input[name="payment_mode"]:checked');

    if (!selected) {
        errorMsg.style.display = "block";
        return;
    }

    // redirect with payment mode
    window.location.href = "place_order.php?payment_mode=" + selected.value;
};

// CASH → GO TO placeorder.php
codBtn.onclick = () => {
    window.location.href = "place_order.php?payment_mode=COD";
};
</script>
