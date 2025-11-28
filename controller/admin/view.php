<?php
include '../../includes/auth.php'; 
session_start_if_not_started(); 
checkAuth(); 
if (!isAdmin()) die('Access Denied');

include '../../includes/DatabaseConnection.php';
include '../../includes/DatabaseFunction.php'; 

// Validate and get message ID
if (!isset($_GET['id'])) {
    header('Location: inbox.php');
    exit;
}
$id = $_GET['id'];

// Fetch message details
$msg = getContactMessageById($pdo, $id); 
markMessageAsRead($pdo, $id); 

$title = "View Message";
ob_start();
include '../../templates/admin/admin_view.html.php';
$output = ob_get_clean();
include '../../templates/admin/admin_layout.html.php';
?>