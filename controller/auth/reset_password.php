<?php
include '../../includes/auth.php';
session_start_if_not_started();
include '../../includes/DatabaseConnection.php';
include '../../includes/DatabaseFunction.php';

$token = $_GET['token'] ?? null;
if (empty($token)) {
    die('Invalid token.');
}

// Lấy user bằng token
$user = getUserByToken($pdo, $token);

if (!$user) {
    die('Token is invalid or has expired.');
}

// Xử lý khi user gửi form pass mới
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if ($password !== $password_confirm) {
        $error = "Passwords do not match.";
    } else {
        // Hash pass mới
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Cập nhật CSDL
        updatePassword($pdo, $user['id'], $hashedPassword);
        
        $success = "Password updated successfully! You can now <a href='login.php'>log in</a>.";
    }
}

$title = 'Reset Password';
ob_start();
include '../../templates/auth/reset_password.html.php';
$output = ob_get_clean();
include '../../templates/auth/layout_fake.html.php';
?>