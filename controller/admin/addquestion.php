<?php
// THÊM BẢO VỆ ADMIN
include '../../includes/auth.php';
session_start_if_not_started();
checkAuth();
if (!isAdmin()) {
    die('Access Denied. Admins only.');
}

include '../../includes/DatabaseConnection.php';
include '../../includes/DatabaseFunction.php';

if (isset($_POST['text'])) {
    try {
        $imageFileName = null;

        if (!empty($_FILES['image']['name'])) {
            $uploadDir = __DIR__ . '/../images/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $imageFileName = time() . '_' . basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $imageFileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            } else {
                $imageFileName = null;
            }
        }
        
        // === SỬA LỖI Ở ĐÂY ===
        // Bỏ $_POST['userid'] và thay bằng ID của admin
        $adminUserId = $_SESSION['user']['id'];
        
        insertQuestion(
            $pdo, 
            $_POST['text'], 
            $_POST['moduleid'], 
            $adminUserId,  // Đã sửa
            $imageFileName
        );

        header('location: questions.php'); // Chuyển hướng về trang list của admin
        exit;
    } catch (PDOException $e) {
        $title = 'An error has occurred';
        $output = 'Database error: ' . $e->getMessage();
    }
} else {
    $title = 'Add a new Question';
    $modules = allModules($pdo);
    // $users = allUsers($pdo); // XÓA DÒNG NÀY, không cần nữa
    
    ob_start();
    include '../../templates/admin/admin_addquestion.html.php';
    $output = ob_get_clean();
}
include '../../templates/admin/admin_layout.html.php';
?>