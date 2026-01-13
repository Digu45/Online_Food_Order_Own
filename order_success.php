<?php
$method = $_GET['method'] ?? 'COD';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Placed</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial;
            background: #ecfdf5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .box {
            background: #fff;
            padding: 30px;
            border-radius: 14px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,.1);
        }
        .box h2 {
            color: #16a34a;
        }
        .box a {
            display: inline-block;
            margin-top: 15px;
            padding: 12px 20px;
            background: #2563eb;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>✅ Order Successful</h2>

    <?php if ($method === "COD") { ?>
        <p>Please pay at the counter.</p>
    <?php } else { ?>
        <p>Payment received successfully.</p>
    <?php } ?>

    <a href="home.php">Order More</a>
</div>

</body>
</html>
