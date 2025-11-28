<?php
include '../../includes/auth.php';
session_start_if_not_started();
include '../../includes/DatabaseConnection.php';
include '../../includes/DatabaseFunction.php';

$message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $user = getUserByEmail($pdo, $email);

    // If user exists, create reset token and display reset link
    if ($user) {
        // Generate a secure token
        $token = bin2hex(random_bytes(32));
        
        // Store the token in the database
        setResetToken($pdo, $email, $token);

        // Create reset link (in a real app, this would be emailed)
        $resetLink = "http://localhost/Coursework/controller/auth/reset_password.php?token=" . $token;
        
        // Display success message with reset link
        $message_type = 'success';
        $message = "Found account. In a real app, an email would be sent.<br>"
                 . "For this project, please use this link: <br>"
                 . "<a href='$resetLink'>$resetLink</a>";
                 
    } else {
        $message_type = 'danger';
        $message = "No account found with that email address.";
    }
}

$title = 'Forgot Password';
ob_start();
include '../../templates/auth/forgot_password.html.php';
$output = ob_get_clean();
include '../../templates/auth/layout_fake.html.php'; 
?>