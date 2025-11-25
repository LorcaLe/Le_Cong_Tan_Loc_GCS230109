<?php
include '../../includes/auth.php'; // Thêm vào
session_start_if_not_started(); // Thêm vào
checkAuth(); // Thêm vào
if (!isAdmin()) die('Access Denied'); // Thêm vào

include '../../includes/DatabaseConnection.php';
include '../../includes/DatabaseFunction.php'; // Thêm vào

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: inbox.php");
    exit;
}

// Dùng hàm mới
replyToContactMessage($pdo, $_POST['id'], $_POST['reply']);

header("Location: inbox.php");
exit;
?>