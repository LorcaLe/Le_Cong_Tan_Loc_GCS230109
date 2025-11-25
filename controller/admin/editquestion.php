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
    // PHẦN 1: XỬ LÝ FORM KHI USER ẤN "SAVE" (POST Request)
    if (isset($_POST['submit'])) {
        
        $questionId = $_POST['questionid'];
        $text = $_POST['text'];
        $moduleId = $_POST['moduleid'];
        
        // --- KIỂM TRA QUYỀN SỞ HỮU ---
        $question = getQuestion($pdo, $questionId);
        if ($question['userid'] != $_SESSION['user']['id'] && !isAdmin()) {
            die('Access Denied.');
        }
        $imageFileName = null; // Mặc định là không có ảnh mới

        // --- XỬ LÝ UPLOAD ẢNH MỚI (NẾU CÓ) ---
        if (!empty($_FILES['image']['name'])) {
            // 1. Xóa ảnh cũ (nếu có)
            if (!empty($question['img'])) {
                $oldImagePath = __DIR__ . '../../../images/' . $question['img'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // 2. Tải ảnh mới lên
            $uploadDir = __DIR__ . '../../../images/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            
            $imageFileName = time() . '_' . basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $imageFileName;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $imageFileName = null; // Upload thất bại
            }
        }
        
        // Dùng hàm update MỚI
        updateQuestionDetails($pdo, $questionId, $text, $moduleId, $imageFileName);
        
        header('location: questions.php');
        exit;
    }
    
    // PHẦN 2: HIỂN THỊ FORM (GET Request)
    else {
        if (!isset($_GET['id'])) {
             header('location: questions.php');
             exit;
        }
        
        $question = getQuestion($pdo, $_GET['id']);
        if ($question['userid'] != $_SESSION['user']['id'] && !isAdmin()) {
            die('Access Denied.');
        }
        
        // Lấy danh sách module để hiển thị dropdown
        $modules = allModules($pdo);
        
        $title = 'Edit Your Question';
        ob_start();
        include '../../templates/admin/admin_editquestion.html.php'; // Dùng template đã được nâng cấp
        $output = ob_get_clean();
    }
    
} catch(PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage();
}

include '../../templates/admin/admin_layout.html.php'; // Dùng layout user
?>