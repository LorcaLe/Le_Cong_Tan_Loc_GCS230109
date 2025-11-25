<?php
include '../../includes/auth.php';
session_start_if_not_started();
checkAuth(); // User phải đăng nhập

include '../../includes/DatabaseConnection.php';
include '../../includes/DatabaseFunction.php';

$message = '';

if (isset($_POST['name'])) {
    $id = $_SESSION['user']['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    
    // Nếu user nhập pass mới thì hash, không thì để null
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    updateUserProfile($pdo, $id, $name, $email, $password);
    
    // Cập nhật lại session để hiển thị tên mới ngay lập tức
    $_SESSION['user']['name'] = $name;
    $_SESSION['user']['email'] = $email;
    
    $message = "Profile updated successfully!";
    $user = getUser($pdo, $id); 
} else {
    // Lấy thông tin hiện tại của user
    $user = getUser($pdo, $_SESSION['user']['id']);
}

$title = 'Edit My Profile';
ob_start();
include '../../templates/user/edit_profile.html.php';
$output = ob_get_clean();
include '../../templates/user/layout.html.php';
?>