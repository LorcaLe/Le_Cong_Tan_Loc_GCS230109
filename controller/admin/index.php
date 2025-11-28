<?php
include '../../includes/auth.php';
session_start_if_not_started();
checkAuth();

// Ensure only admins can access
if (!isAdmin()) {
    die('Access Denied. Admins only.');
}

$title = 'Admin Dashboard';

ob_start();
include '../../templates/admin/admin_home.html.php';
$output = ob_get_clean();
include '../../templates/admin/admin_layout.html.php';
?>