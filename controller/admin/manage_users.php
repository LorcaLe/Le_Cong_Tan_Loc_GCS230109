<?php
include '../../includes/auth.php';
session_start_if_not_started();
checkAuth();
if (!isAdmin()) {
    die('Access Denied. Admins only.');
}

include '../../includes/DatabaseConnection.php';
include '../../includes/DatabaseFunction.php';

try {
    // Logic Xóa User
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $userIdToDelete = $_POST['user_id'];
        
        // Cấm admin tự xóa mình
        if ($userIdToDelete == $_SESSION['user']['id']) {
            header('Location: manage_users.php?error=selfdelete');
            exit;
        }
        
        deleteUser($pdo, $userIdToDelete);
        header('Location: manage_users.php?status=deleted');
        exit;
    }

    // Lấy danh sách user
    $users = getAllUsers($pdo); // Dùng hàm mới
    $title = 'Manage Users';
    
    ob_start();
    include '../../templates/admin/admin_users.html.php';
    $output = ob_get_clean();

} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage();
}
include '../../templates/admin/admin_layout.html.php';
?>