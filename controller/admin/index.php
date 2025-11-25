<?php
// 1. Gọi Middleware (đi lùi 2 cấp ra includes)
include '../../includes/auth.php';
session_start_if_not_started();
checkAuth();

// 2. Bảo vệ: Chỉ Admin mới được vào
if (!isAdmin()) {
    die('Access Denied. Admins only.');
}

// 3. Thiết lập tiêu đề trang
$title = 'Admin Dashboard';

// 4. Gọi View (Template)
ob_start();
// Gọi file giao diện dashboard nằm trong templates/admin/
include '../../templates/admin/admin_home.html.php';
$output = ob_get_clean();

// 5. Gọi Layout Admin
include '../../templates/admin/admin_layout.html.php';
?>