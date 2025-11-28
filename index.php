<?php
session_start();

if (!isset($_SESSION['user'])) { // Not logged in
    header("Location: controller/auth/login.php");
    exit;
}

$role = $_SESSION['user']['role']; // 'admin' or 'user'

if ($role === 'admin') {
    header("Location: controller/admin/index.php");
} else {
    header("Location: controller/user/index.php");
}
exit;
?>