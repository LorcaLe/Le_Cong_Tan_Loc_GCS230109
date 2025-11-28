<?php
session_start();
require_once '../../includes/DatabaseConnection.php';
require_once '../../includes/DatabaseFunction.php'; 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['email']) || empty($_POST['password'])) {
        header('Location: ../../templates/auth/login.html.php?error=empty');
        exit;
    }

    // Sanitize inputs
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $user = getUserByEmail($pdo, $email); 

    // Check if user exists
    if (!$user) {
        header('Location: ../../templates/auth/login.html.php?error=email');
        exit;
    }

    // Verify password
    if (!password_verify($password, $user['password'])) {
        header('Location: ../../templates/auth/login.html.php?error=password');
        exit;
    }
    
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