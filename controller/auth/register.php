<?php
session_start();
require_once '../includes/DatabaseConnection.php';
require_once '../includes/DatabaseFunction.php'; // Thêm vào

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($name) || empty($email) || empty($password)) {
        header('Location: register.html.php?error=empty');
        exit;
    }
    
    if (checkEmailExists($pdo, $email)) { // Dùng hàm mới
        header('Location: register.html.php?error=email_taken');
        exit;
    }

    // BẮT BUỘC: Hash mật khẩu
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Dùng hàm mới
    createUser($pdo, $name, $email, $hashedPassword); 

    header('Location: register.html.php?success=1');
    exit;
}
header('Location: register.html.php');
exit;
?>