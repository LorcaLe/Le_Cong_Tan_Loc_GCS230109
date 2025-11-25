<?php
include '../../includes/auth.php';
session_start_if_not_started();
checkAuth(); // Bắt buộc user đăng nhập

include '../../includes/DatabaseConnection.php';
include '../../includes/DatabaseFunction.php';

if (isset($_POST['text'])) {
    try {
        $imageFileName = null;
        if (!empty($_FILES['image']['name'])) {
            // ... (code upload ảnh của bạn) ...
            $uploadDir = __DIR__ . '../../../images/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $imageFileName = time() . '_' . basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $imageFileName;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $imageFileName = null;
            }
        }
        
        // Dùng hàm mới, lấy userid từ SESSION
        insertQuestion(
            $pdo, 
            $_POST['text'], 
            $_POST['moduleid'], 
            $_SESSION['user']['id'], // Tự động lấy user, không cho chọn
            $imageFileName
        );

        header('location: ../../controller/user/questions.php');
        exit;
    } catch (PDOException $e) {
        $title = 'An error has occurred';
        $output = 'Database error: ' . $e->getMessage();
    }
} else {
    $title = 'Add a new Question';
    $modules = allModules($pdo);
    // $users = allUsers($pdo); // BỎ DÒNG NÀY, user không được chọn user
    
    ob_start();
    // Chúng ta có thể dùng lại template addquestion.html.php
    // Nhưng hãy chắc chắn bạn đã xóa dropdown chọn User khỏi file đó
    include '../../templates/user/addquestion.html.php'; 
    $output = ob_get_clean();
}
include '../../templates/user/layout.html.php';
?>