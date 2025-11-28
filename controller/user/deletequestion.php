<?php
include '../../includes/auth.php';
session_start_if_not_started();
checkAuth(); 

include '../../includes/DatabaseConnection.php';
include '../../includes/DatabaseFunction.php';

if (isset($_POST['question_id'])) {
    $questionId = $_POST['question_id'];

    try {

        $question = getQuestion($pdo, $questionId);

        // Check if the logged-in user is the owner of the question or an admin
        if ($question['userid'] != $_SESSION['user']['id'] && !isAdmin()) {
            die('Access Denied. You do not have permission.');
        }


        $questionImg = getQuestionImg($pdo, $questionId);

        // Delete associated image if it exists
        if ($questionImg && !empty($questionImg['img'])) {
            $imagePath = __DIR__ . '../../images/' . $questionImg['img'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        deleteQuestion($pdo, $questionId);

        header('Location: questions.php');
        exit;

    } catch (PDOException $e) {
        die('Database error: ' . $e->getMessage());
    }
} else {

    header('Location: index.php');
    exit;
}
?>