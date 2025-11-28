<?php
include '../../includes/auth.php'; 
session_start_if_not_started(); 
checkAuth();
if (!isAdmin()) die('Access Denied'); 

include '../../includes/DatabaseConnection.php';
include '../../includes/DatabaseFunction.php'; 

// Validate request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: inbox.php");
    exit;
}

// Validate required fields
replyToContactMessage($pdo, $_POST['id'], $_POST['reply']);

header("Location: inbox.php");
exit;
?>