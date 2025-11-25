<?php
session_start();
require_once '../../includes/DatabaseConnection.php';
require_once '../../includes/DatabaseFunction.php'; // Thêm vào
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['email']) || empty($_POST['password'])) {
        header('Location: ../../templates/auth/login.html.php?error=empty');
        exit;
    }

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $user = getUserByEmail($pdo, $email); // Dùng hàm mới

    if (!$user) {
        header('Location: ../../templates/auth/login.html.php?error=email');
        exit;
    }

    // BẮT BUỘC: Kiểm tra mật khẩu đã hash
    if (!password_verify($password, $user['password'])) {
        header('Location: ../../templates/auth/login.html.php?error=password');
        exit;
    }
    
    // ... (code set session của bạn) ...
    $_SESSION['user'] = [
        'id'    => $user['id'],
        'name'  => $user['name'],
        'email' => $user['email'],
        'role'  => $user['role']
    ];

    header('Location: ../../index.php');
    exit;
}
header('Location: ../../templates/auth/login.html.php');
exit;
?>