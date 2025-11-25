<?php
// 1. Gọi Middleware (đi lùi 2 cấp)
include '../../includes/auth.php';
session_start_if_not_started();
checkAuth(); // Chỉ cần đăng nhập là được

// 2. Thiết lập tiêu đề
$title = 'Student Dashboard';

// 3. Gọi View (Template)
ob_start();
// Gọi file giao diện dashboard nằm trong templates/user/
include '../../templates/user/home.html.php';
$output = ob_get_clean();

// 4. Gọi Layout User
include '../../templates/user/layout.html.php';
?>