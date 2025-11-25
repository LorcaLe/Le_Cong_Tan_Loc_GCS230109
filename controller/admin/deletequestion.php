<?php
include '../../includes/auth.php';
session_start_if_not_started();
checkAuth();
if (!isAdmin()) {
    die('Access Denied. Admins only.');
}

try {
    include '../../includes/DatabaseConnection.php';
    include '../../includes/DatabaseFunction.php';
    
    $question = getQuestionImg($pdo, $_POST['id']);

    if ($question && !empty($question['img'])) {
        $imagePath = '../../images/' . $question['img'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    deleteQuestion($pdo, $_POST['id']);

    header('location: questions.php');
    exit;
} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage();
    include '../../templates/admin/admin_layout.html.php';
}
?>
