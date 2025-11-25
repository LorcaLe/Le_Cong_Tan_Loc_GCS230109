<?php
include '../../includes/auth.php';
session_start_if_not_started();
checkAuth();
if (!isAdmin()) die('Access Denied');

include '../../includes/DatabaseConnection.php';
include '../../includes/DatabaseFunction.php';

// Biến này dùng để quyết định xem đang ở chế độ "Thêm" hay "Sửa"
$moduleToEdit = null;

try {
    // --- 1. XỬ LÝ POST (THÊM / SỬA / XÓA) ---
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $action = $_POST['action'] ?? '';

        // XỬ LÝ XÓA
        if ($action === 'delete') {
            deleteModule($pdo, $_POST['module_id']);
            header('Location: manage_modules.php?status=deleted');
            exit;
        }

        // XỬ LÝ THÊM MỚI
        if ($action === 'add' && !empty($_POST['moduleName'])) {
            insertModule($pdo, $_POST['moduleName']);
            header('Location: manage_modules.php?status=added');
            exit;
        }

        // XỬ LÝ CẬP NHẬT (EDIT)
        if ($action === 'update' && !empty($_POST['moduleName'])) {
            updateModule($pdo, $_POST['id'], $_POST['moduleName']);
            header('Location: manage_modules.php?status=updated'); // Quay về trang gốc để thoát chế độ edit
            exit;
        }
    }

    // --- 2. XỬ LÝ GET (CHẾ ĐỘ EDIT) ---
    // Nếu trên URL có ?action=edit&id=... thì lấy dữ liệu module đó ra
    if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
        $moduleToEdit = getModule($pdo, $_GET['id']);
    }

    // --- 3. LẤY DANH SÁCH ĐỂ HIỂN THỊ ---
    $modules = allModules($pdo);
    $title = 'Manage Modules';

    ob_start();
    include '../../templates/admin/admin_modules.html.php';
    $output = ob_get_clean();

} catch (PDOException $e) {
    $title = 'Error';
    $output = 'Database error: ' . $e->getMessage();
}

include '../../templates/admin/admin_layout.html.php';
?>