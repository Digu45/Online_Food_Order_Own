<?php
session_start();
include("connection.php");

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $res = mysqli_query($conn, $sql);

    if (!$res) {
        die("SQL Error: " . mysqli_error($conn));
    }

    $admin = mysqli_fetch_assoc($res);

    if ($admin) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_name'] = $admin['username'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    body {
        margin: 0;
        min-height: 100vh;
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(120deg, #0f2027, #203a43, #2c5364);
    }

    .login-wrapper {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    /* BRAND (DESKTOP ONLY) */
    .brand-panel {
        flex: 1;
        color: #fff;
        padding: 60px;
        display: none;
    }

    .brand-panel img {
        width: 140px;
        margin-bottom: 25px;
    }

    .brand-panel h1 {
        font-size: 42px;
        font-weight: 700;
    }

    /* LOGIN PANEL */
    .login-panel {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .login-card {
        width: 100%;
        max-width: 420px;
        padding: 30px;
        border-radius: 18px;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(18px);
        box-shadow: 0 25px 45px rgba(0,0,0,0.35);
        color: #fff;
        animation: fadeUp 0.8s ease;
    }

    /* MOBILE HEADER */
    .mobile-logo {
        display: block;
        text-align: center;
        margin-bottom: 20px;
    }

    .mobile-logo img {
        width: 90px;
        margin-bottom: 10px;
    }

    .mobile-logo h5 {
        font-weight: 600;
        margin-bottom: 0;
    }

    .login-card h3 {
        font-weight: 700;
        margin-bottom: 5px;
    }

    .login-card small {
        opacity: 0.8;
    }

    .form-control {
        background: rgba(255,255,255,0.2);
        border: none;
        height: 52px;
        color: #fff;
        border-radius: 14px;
        font-size: 16px;
    }

    .form-control::placeholder {
        color: rgba(255,255,255,0.7);
    }

    .btn-login {
        height: 52px;
        border-radius: 14px;
        font-weight: 600;
        font-size: 16px;
        background: linear-gradient(135deg, #00c6ff, #0072ff);
        border: none;
    }

    .alert {
        border-radius: 14px;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* DESKTOP VIEW */
    @media (min-width: 992px) {
        .login-wrapper {
            flex-direction: row;
        }

        .brand-panel {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .mobile-logo {
            display: none;
        }

        .login-panel {
            padding: 40px;
        }
    }
</style>

</head>

<body>
<div class="login-wrapper">

    <!-- LEFT BRAND (DESKTOP) -->
    <div class="brand-panel">
        <img src="digus_restaurant.jpeg" alt="Logo">
        <h1>Restaurant Admin</h1>
        <p>
            Manage orders, menus & users  
            with a modern admin experience.
        </p>
    </div>

    <!-- LOGIN -->
    <div class="login-panel">
        <div class="login-card">

            <!-- MOBILE HEADER -->
            <div class="mobile-logo">
                <img src="digus_restaurant.jpeg" alt="Logo">
                <h5>Restaurant Admin</h5>
            </div>

            <center><h3>Welcome Back 👋</h3>
            <small>Sign in to continue</small></center>

            <?php if(isset($error)) { ?>
                <div class="alert alert-danger mt-3 py-2">
                    <i class="bi bi-exclamation-circle"></i> <?= $error ?>
                </div>
            <?php } ?>

            <form method="POST" class="mt-3">
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>

                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <button type="submit" name="login" class="btn btn-login w-100">
                    Login
                </button>
            </form>

        </div>
    </div>

</div>

</body>
</html>
