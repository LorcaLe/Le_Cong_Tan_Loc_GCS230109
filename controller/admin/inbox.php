<?php
include '../../includes/auth.php'; 
session_start_if_not_started(); 
checkAuth();
if (!isAdmin()) die('Access Denied'); 

include '../../includes/DatabaseConnection.php';
include '../../includes/DatabaseFunction.php'; 

// Fetch all contact messages
$messages = getAllContactMessages($pdo); 
$title = "Contact Inbox";

ob_start();
include '../../templates/admin/admin_inbox.html.php';
$output = ob_get_clean();
include '../../templates/admin/admin_layout.html.php';
?>