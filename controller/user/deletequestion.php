<?php
include '../../includes/auth.php';
session_start_if_not_started();
checkAuth(); // Bắt buộc đăng nhập

include '../../includes/DatabaseConnection.php';
include '../../includes/DatabaseFunction.php';

if (isset($_POST['question_id'])) {
    $questionId = $_POST['question_id'];

    try {
        // --- BẢO MẬT: KIỂM TRA QUYỀN SỞ HỮU ---
        $question = getQuestion($pdo, $questionId);

        // Logic MỚI: Nếu không phải chủ VÀ không phải Admin thì chặn
        if ($question['userid'] != $_SESSION['user']['id'] && !isAdmin()) {
            die('Access Denied. You do not have permission.');
        }

        // 1. Lấy thông tin ảnh để xóa file
        $questionImg = getQuestionImg($pdo, $questionId);

        // 2. Xóa ảnh khỏi thư mục (nếu có)
        if ($questionImg && !empty($questionImg['img'])) {
            $imagePath = __DIR__ . '../../images/' . $questionImg['img'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // 3. Xóa câu hỏi khỏi CSDL
        deleteQuestion($pdo, $questionId);

        // 4. Chuyển hướng
        header('Location: questions.php');
        exit;

    } catch (PDOException $e) {
        die('Database error: ' . $e->getMessage());
    }
} else {
    // Nếu không có POST id, đá về trang chủ
    header('Location: index.php');
    exit;
}
?>