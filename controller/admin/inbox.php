<?php
include '../../includes/auth.php'; // Thêm vào
session_start_if_not_started(); // Thêm vào
checkAuth(); // Thêm vào
if (!isAdmin()) die('Access Denied'); // Thêm vào

include '../../includes/DatabaseConnection.php';
include '../../includes/DatabaseFunction.php'; // Thêm vào

$messages = getAllContactMessages($pdo); // Dùng hàm mới
$title = "Contact Inbox";

ob_start();
include '../../templates/admin/admin_inbox.html.php';
$output = ob_get_clean();
include '../../templates/admin/admin_layout.html.php';
?>