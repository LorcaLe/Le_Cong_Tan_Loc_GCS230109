<?php
$success = isset($_GET['success']);
$error = $_GET['error'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <?php include '../UI/bootstrap.php'; ?>
    <link rel="stylesheet" href="../UI/login_register.css">
</head>

<body class="d-flex justify-content-center align-items-center vh-100">

<div class="form-container">

    <h3>Create Account</h3>

    <?php if ($success): ?>
        <div class="alert alert-success">🎉 Registration successful! Redirecting...</div>
        <script>
            setTimeout(() => {
                window.location.href = "login.html.php";
            }, 2000);
        </script>
    <?php endif; ?>

    <?php if ($error === "empty"): ?>
        <div class="alert alert-danger">❌ Please fill in all fields.</div>
    <?php endif; ?>

    <?php if ($error === "email_taken"): ?>
        <div class="alert alert-danger">❌ Email already exists.</div>
    <?php endif; ?>

    <form action="../../controller/auth/register.php" method="POST">

        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button class="btn-main">Register</button>

    </form>

    <p class="text-small">
        Already have an account? <a href="../../controller/auth/login.php">Login</a>
    </p>

</div>

</body>
</html>
