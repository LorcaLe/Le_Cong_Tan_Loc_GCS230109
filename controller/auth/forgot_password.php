<?php
include '../../includes/auth.php';
session_start_if_not_started();
include '../../includes/DatabaseConnection.php';
include '../../includes/DatabaseFunction.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $user = getUserByEmail($pdo, $email);

    if ($user) {
        // Tạo token
        $token = bin2hex(random_bytes(32));
        
        // $expires = date('Y-m-d H:i:s', strtotime('+1 hour')); // <-- XÓA DÒNG NÀY
        
        // Lưu token vào CSDL (gọi hàm đã được đơn giản hóa)
        setResetToken($pdo, $email, $token); // <-- ĐÃ SỬA

        // Mô phỏng việc gửi email
        $resetLink = "http://localhost/Coursework/controller/auth/reset_password.php?token=" . $token;
        
        $message_type = 'success';
        $message = "Found account. In a real app, an email would be sent.<br>"
                 . "For this project, please use this link: <br>"
                 . "<a href='$resetLink'>$resetLink</a>";
                 
    } else {
        $message_type = 'danger';
        $message = "No account found with that email address.";
    }
}

$title = 'Forgot Password';
ob_start();
include '../../templates/auth/forgot_password.html.php';
$output = ob_get_clean();
include '../../templates/auth/layout_fake.html.php'; // Dùng layout user
?>