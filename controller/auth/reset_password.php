<?php
include '../../includes/auth.php';
session_start_if_not_started();
include '../../includes/DatabaseConnection.php';
include '../../includes/DatabaseFunction.php';

// Get token from URL
$token = $_GET['token'] ?? null;
if (empty($token)) {
    die('Invalid token.');
}

// Fetch user by token
$user = getUserByToken($pdo, $token);

// If no user found, token is invalid or expired
if (!$user) {
    die('Token is invalid or has expired.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    
    // Basic validation
    if ($password !== $password_confirm) {
        $error = "Passwords do not match.";
    } else {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
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