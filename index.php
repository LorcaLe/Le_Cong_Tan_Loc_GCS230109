<?php
// CWtest/index.php
session_start();

// 1. Chưa đăng nhập -> Chuyển vào Controller Login
if (!isset($_SESSION['user'])) {
    header("Location: controller/auth/login.php");
    exit;
}

// 2. Đã đăng nhập -> Kiểm tra quyền
$role = $_SESSION['user']['role'];

if ($role === 'admin') {
    // Chuyển vào Controller Admin
    header("Location: controller/admin/index.php");
} else {
    // Chuyển vào Controller User
    header("Location: controller/user/index.php");
}
exit;
?>