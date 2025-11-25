<?php
include '../../includes/auth.php'; // Thêm vào
session_start_if_not_started(); // Thêm vào
checkAuth(); // Thêm vào
if (!isAdmin()) die('Access Denied'); // Thêm vào

include '../../includes/DatabaseConnection.php';
include '../../includes/DatabaseFunction.php'; // Thêm vào

if (!isset($_GET['id'])) {
    header('Location: inbox.php');
    exit;
}
$id = $_GET['id'];

$msg = getContactMessageById($pdo, $id); // Dùng hàm mới
markMessageAsRead($pdo, $id); // Dùng hàm mới

$title = "View Message";
ob_start();
include '../../templates/admin/admin_view.html.php';
$output = ob_get_clean();
include '../../templates/admin/admin_layout.html.php';
?>