<?php
include '../../includes/auth.php';
session_start_if_not_started();
checkAuth(); // Bắt buộc đăng nhập

include '../../includes/DatabaseConnection.php';
include '../../includes/DatabaseFunction.php';

try {
    // Dùng hàm mới, chỉ lấy tin nhắn của user đang đăng nhập
    $messages = getMessagesByUserId($pdo, $_SESSION['user']['id']);
    $title = 'My Inbox';
    
    ob_start();
    include '../../templates/user/user_inbox.html.php'; // Dùng template mới
    $output = ob_get_clean();

} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage();
}
include '../../templates/user/layout.html.php';
?>