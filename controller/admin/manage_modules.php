<?php
include '../../includes/auth.php';
session_start_if_not_started();
checkAuth();
if (!isAdmin()) die('Access Denied');

include '../../includes/DatabaseConnection.php';
include '../../includes/DatabaseFunction.php';


$moduleToEdit = null;

try {
    // Handle form submissions
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $action = $_POST['action'] ?? '';
        
        if ($action === 'delete') {
            deleteModule($pdo, $_POST['module_id']);
            header('Location: manage_modules.php?status=deleted');
            exit;
        }


        if ($action === 'add' && !empty($_POST['moduleName'])) {
            insertModule($pdo, $_POST['moduleName']);
            header('Location: manage_modules.php?status=added');
            exit;
        }


        if ($action === 'update' && !empty($_POST['moduleName'])) {
            updateModule($pdo, $_POST['id'], $_POST['moduleName']);
            header('Location: manage_modules.php?status=updated');
            exit;
        }
    }

    // Handle edit request
    if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
        $moduleToEdit = getModule($pdo, $_GET['id']);
    }

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