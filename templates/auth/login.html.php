<?php
$error = $_GET['error'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <?php include '../../includes/config.php'; ?>
    <?php include '../UI/bootstrap.php'; ?>
    <link rel="stylesheet" href="../UI/login_register.css">
</head>

<body class="d-flex justify-content-center align-items-center vh-100">

<div class="form-container">

    <h3 class="text-center mb-3">Login</h3>

    <!-- Hiển thị thông báo lỗi -->
    <?php if ($error === "empty"): ?>
        <div class="alert alert-danger text-center">❌ Please enter complete information.</div>
    <?php endif; ?>

    <?php if ($error === "email"): ?>
        <div class="alert alert-danger text-center">❌ Email does not exist.</div>
    <?php endif; ?>

    <?php if ($error === "password"): ?>
        <div class="alert alert-danger text-center">❌ Wrong password.</div>
    <?php endif; ?>

    <form action="../../controller/auth/login.php" method="POST">

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button class="btn-main w-100 mt-2">Login</button>
    </form>

    <p class="text-small text-muted text-center mt-3">
        Don't have an account? <a href="../../controller/auth/register.html.php">Register here</a>
        <br>
        <a href="../../controller/auth/forgot_password.php">Forgot your password?</a> 
    </p>

</div>

</body>
</html>
