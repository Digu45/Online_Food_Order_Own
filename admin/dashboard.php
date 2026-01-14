<?php
session_start();
include("connection.php");

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit;
}

// Fetch total orders
$totalOrdersRes = mysqli_query($conn, "SELECT COUNT(*) AS total FROM placeorder");
$totalOrdersRow = mysqli_fetch_assoc($totalOrdersRes);
$totalOrders = $totalOrdersRow['total'];

// Fetch total users
$totalUsersRes = mysqli_query($conn, "SELECT COUNT(*) AS total FROM placeorder");
$totalUsersRow = mysqli_fetch_assoc($totalUsersRes);
$totalUsers = $totalUsersRow['total'];

// Fetch last 5 orders
$lastOrders = mysqli_query($conn, "
    SELECT 
        placeorder.*,
        menu_master.MenuName
    FROM placeorder
    INNER JOIN menu_master 
        ON placeorder.product_id = menu_master.MenuId
    ORDER BY placeorder.OrderId DESC
    LIMIT 5
");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #f6f7fb;
            font-family: 'Poppins', sans-serif;
            margin: 0;
        }

        /* NAVBAR */
        .navbar-brand img {
            max-width: 35px;
            height: auto;
        }

        /* STAT CARDS */
        .stat-card {
            background: #fff;
            color: #333;
            padding: 15px;
            text-align: center;
            margin-bottom: 10px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        }
        .stat-card h3 {
            font-size: 1.8rem;
            margin-bottom: 5px;
            word-wrap: break-word;
        }
        .stat-card p {
            color: #666;
            margin: 0;
            font-size: 0.9rem;
        }

        /* QUICK ACTION CARDS */
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: 0.3s;
            text-align: center;
            margin-bottom: 10px;
        }
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        }
        .card h6 {
            font-size: 16px;
        }
        .card p {
            font-size: 13px;
        }

        /* TABLE */
        .table img {
            border-radius: 8px;
        }
        .table th, .table td {
            font-size: 14px;
            word-break: break-word;
        }
        .table-responsive {
            overflow-x: auto;
        }

        /* CONTAINER */
        .container-fluid {
            padding: 10px 10px;
        }

        /* MOBILE STYLING */
        @media (max-width: 992px) {
            .stat-card h3 { font-size: 1.5rem; }
            .stat-card p { font-size: 0.85rem; }
            .card h6 { font-size: 14px; }
            .card p { font-size: 12px; }
            .table th, .table td { font-size: 12px; padding: 6px 4px; }
        }

        @media (max-width: 768px) {
            .stat-card h3 { font-size: 1.3rem; }
            .stat-card p { font-size: 0.8rem; }
            .card h6 { font-size: 13px; }
            .card p { font-size: 11px; }
            .table th, .table td { font-size: 11px; padding: 5px 3px; }
        }

        @media (max-width: 480px) {
            .stat-card h3 { font-size: 1.1rem; }
            .stat-card p { font-size: 0.75rem; }
            .card h6 { font-size: 12px; }
            .card p { font-size: 10px; }
            .table th, .table td { font-size: 10px; padding: 4px 2px; }
            .navbar-brand {
                font-size: 12px;
                display: flex;
                align-items: center;
                gap: 5px;
            }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="digus_restaurant.jpeg" alt="Logo" class="me-2">
            Digus Restaurant Admin
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav text-center">
                <li class="nav-item"><a href="menu_items.php" class="nav-link">Menu Items</a></li>
                <li class="nav-item"><a href="orders.php" class="nav-link">Orders</a></li>
                <li class="nav-item"><a href="users.php" class="nav-link">Users</a></li>
                <li class="nav-item">
        <a href="#" class="nav-link" onclick="confirmLogout()">Logout</a>
    </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid min-vh-100 d-flex flex-column py-3">
    <!-- Welcome -->
    <div class="mb-3">
        <h1 class="h5 mb-1">Welcome, <?php echo $_SESSION['admin_name']; ?>!</h1>
        <p class="text-muted small">Here is your restaurant dashboard overview</p>
    </div>

    <!-- Stats -->
    <div class="row g-2 mb-3">
        <div class="col-12 col-sm-4">
            <div class="stat-card">
                <h3><?php echo $totalOrders; ?></h3>
                <p>Total Orders</p>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="stat-card">
                <h3><?php echo $totalUsers; ?></h3>
                <p>Total Users</p>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="stat-card">
                <h3>💰</h3>
                <p>Revenue</p>
            </div>
        </div>
    </div>

    <!-- Quick Action Cards -->
    <div class="row g-2 mb-3">
        <div class="col-12 col-sm-4">
            <div class="card py-2">
                <h6>Add/Edit Menu Items</h6>
                <p class="mb-1">Manage menu items easily</p>
                <a href="menu_items.php" class="btn btn-sm btn-primary">Manage</a>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="card py-2">
                <h6>Orders</h6>
                <p class="mb-1">View customer orders</p>
                <a href="orders.php" class="btn btn-sm btn-primary">View Orders</a>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="card py-2">
                <h6>Users</h6>
                <p class="mb-1">View registered users</p>
                <a href="users.php" class="btn btn-sm btn-primary">View Users</a>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="flex-grow-1">
        <h6 class="mb-2">Recent Orders</h6>
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Mobile</th>
                        <th>Menu</th>
                        <th>Total</th>
                        <th>Table No</th>
                        <th>Status</th>
                        <th>Payment Mode</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($lastOrders)) { ?>
                        <tr>
                            <td><?php echo $row['OrderId']; ?></td>
                            <td><?php echo $row['customer_name']; ?></td>
                            <td><?php echo $row['mobile_no']; ?></td>
                            <td><?php echo $row['MenuName']; ?></td>
                            <td><?php echo $row['amount']; ?></td>
                            <td><?php echo $row['table']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td><?php echo $row['payment_method']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<script>
function confirmLogout() {
    if (confirm("Are you sure you want to logout?")) {
        window.location.href = "logout.php";
    }
}
</script>
