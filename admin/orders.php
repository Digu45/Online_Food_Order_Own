<?php
session_start();
include("connection.php");

/* Admin login check */
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit;
}

/* Update order status */
if (isset($_POST['update_status'])) {

    $order_id   = (int)$_POST['order_id'];
    $new_status = trim($_POST['status']);

    $status_map = [
        'Pending'   => 0,
        'Preparing' => 1,
        'Completed' => 2,
        'Cancelled' => 3
    ];

    $status_id = $status_map[$new_status];

    mysqli_query($conn, "
        UPDATE placeorder 
        SET 
            `status` = '$new_status',
            status_id = '$status_id'
        WHERE OrderId = '$order_id'
    ");

    header("Location: orders.php");
    exit;
}


/* Fetch orders */

$orders = mysqli_query($conn, "
    SELECT 
        placeorder.*,
        menu_master.MenuName
    FROM placeorder
    INNER JOIN menu_master 
        ON placeorder.product_id = menu_master.MenuId
    ORDER BY placeorder.OrderId DESC

");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Orders</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        .back-btn {
    position: absolute;
    top: 15px;
    left: 15px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    font-size: 14px;
    border-radius: 8px;

    color: #ffffff;                 /* White text */
    background: rgba(255,255,255,0.08); /* Slight transparent bg */
    border: 1px solid rgba(255,255,255,0.25);
}

.back-btn:hover {
    background: rgba(255,255,255,0.18);
    color: #ffffff;
}

@media (max-width: 576px) {
    .back-btn {
        top: 10px;
        left: 10px;
        padding: 5px 10px;
        font-size: 13px;
    }
}


        body {
            margin: 0;
            background: #f4f6fb;
        }

        .header {
            background: #111827;
            color: #fff;
            padding: 15px;
            font-size: 20px;
            text-align: center;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 10px;
        }

        /* ===== MOBILE CARD ===== */
        .order-card {
            background: #fff;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .order-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .order-row span {
            font-weight: 600;
            color: #374151;
        }

        /* STATUS */
        .status {
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 13px;
            font-weight: 600;
        }

        .Pending {
            background: #fff3cd;
            color: #856404;
        }

        .Preparing {
            background: #cce5ff;
            color: #004085;
        }

        .Completed {
            background: #d4edda;
            color: #155724;
        }

        .Cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        /* FORM */
        select {
            width: 100%;
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin-top: 8px;
        }

        button {
            width: 100%;
            margin-top: 8px;
            padding: 8px;
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
        }

        /* ===== DESKTOP TABLE ===== */
        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        th,
        td {
            padding: 12px;
            text-align: center;
            font-size: 14px;
        }

        th {
            background: #111827;
            color: #fff;
        }

        tr:nth-child(even) {
            background: #f9fafb;
        }

        /* RESPONSIVE */
        @media(max-width:768px) {
            .table-wrapper {
                display: none;
            }
        }

        @media(min-width:769px) {
            .order-card {
                display: none;
            }
        }
    </style>
</head>

<body>
<a href="dashboard.php" class="btn btn-outline-dark back-btn">
    ← Back
</a>

    <div class="header">Admin Orders Panel</div>

    <div class="container">

        <!-- ===== MOBILE VIEW ===== -->
        <?php mysqli_data_seek($orders, 0);
        while ($row = mysqli_fetch_assoc($orders)) { ?>
            <div class="order-card">
                <div class="order-row"><span>Order ID</span><?= $row['OrderId'] ?></div>
                <div class="order-row"><span>Name</span><?= $row['customer_name'] ?></div>
                <div class="order-row"><span>Mobile</span><?= $row['mobile_no'] ?></div>
                <div class="order-row"><span>Menu</span><?= $row['MenuName'] ?></div>
                <div class="order-row"><span>Total</span>₹<?= $row['amount'] ?></div>
                <div class="order-row"><span>Table</span>₹<?= $row['table'] ?></div>
                <div class="order-row"><span>Payment Status</span>₹<?= $row['payment_status'] ?></div>

            
                <div class="order-row">
                    <span>Status</span>
                    <span class="status <?= $row['status'] ?>"><?= $row['status'] ?></span>
                </div>

                <form method="post">
                    <input type="hidden" name="order_id" value="<?= $row['OrderId'] ?>">
                    <select name="status">
                        <option value="Pending" <?= ($row['status'] == "Pending") ? 'selected' : '' ?>>Pending</option>
                        <option value="Preparing" <?= ($row['status'] == "Preparing") ? 'selected' : '' ?>>Preparing</option>
                        <option value="Completed" <?= ($row['status'] == "Completed") ? 'selected' : '' ?>>Completed</option>
                        <option value="Cancelled" <?= ($row['status'] == "Cancelled") ? 'selected' : '' ?>>Cancelled</option>
                    </select>

                    <button name="update_status">Update Status</button>
                </form>
            </div>
        <?php } ?>

        <!-- ===== DESKTOP VIEW ===== -->
        <div class="table-wrapper">
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Menu</th>
                    <th>Total</th>
                    <th>Table</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>

                <?php mysqli_data_seek($orders, 0);
                while ($row = mysqli_fetch_assoc($orders)) { ?>
                    <tr>
                        <td><?= $row['OrderId'] ?></td>
                        <td><?= $row['customer_name'] ?></td>
                        <td><?= $row['mobile_no'] ?></td>
                        <td><?= $row['MenuName'] ?></td>
                        <td>₹<?= $row['amount'] ?></td>
                        <td><?= $row['table'] ?></td>
                        <td><?= $row['payment_status'] ?></td>
                        <td><span class="status <?= $row['status'] ?>"><?= $row['status'] ?></span></td>
                        <td>
                        <form method="post">
                                <input type="hidden" name="order_id" value="<?= $row['OrderId'] ?>">
                                <select name="status">
                                    <option value="Pending" <?= ($row['status'] == "Pending") ? 'selected' : '' ?>>Pending</option>
                                    <option value="Preparing" <?= ($row['status'] == "Preparing") ? 'selected' : '' ?>>Preparing</option>
                                    <option value="Completed" <?= ($row['status'] == "Completed") ? 'selected' : '' ?>>Completed</option>
                                    <option value="Cancelled" <?= ($row['status'] == "Cancelled") ? 'selected' : '' ?>>Cancelled</option>
                                </select>

                                <button name="update_status">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>

    </div>
</body>

</html>