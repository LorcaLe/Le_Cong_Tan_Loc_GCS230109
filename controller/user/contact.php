<?php
include '../../includes/auth.php'; 
session_start_if_not_started(); 
checkAuth(); 

require_once '../../includes/DatabaseConnection.php';
require_once '../../includes/DatabaseFunction.php'; 
$title = 'Contact Us';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    insertContactMessage(
        $pdo,
        $_SESSION['user']['id'],
        $_SESSION['user']['name'],
        $_SESSION['user']['email'],
        $_POST['subject'],
        $_POST['message']
    );
    echo "<div class='alert alert-success'>Message sent! You can check replies in 'My Inbox'.</div>";
}
ob_start();
include '../../templates/user/mailform.html.php';
$output = ob_get_clean();
include '../../templates/user/layout.html.php';
?>