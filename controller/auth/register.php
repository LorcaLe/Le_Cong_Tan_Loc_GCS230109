<?php
session_start();
require_once '../../includes/DatabaseConnection.php';
require_once '../../includes/DatabaseFunction.php'; 

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Basic validation
    if (empty($name) || empty($email) || empty($password)) {
        header('Location: ../../templates/auth/register.html.php?error=empty');
        exit;
    }
    
    // Check if email already exists
    if (checkEmailExists($pdo, $email)) { 
        header('Location: ../../templates/auth/register.html.php?error=email_taken');
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    createUser($pdo, $name, $email, $hashedPassword); 

    header('Location: ../../templates/auth/register.html.php?success=1');
    exit;
}
header('Location: ../../templates/auth/register.html.php');
exit;
?>