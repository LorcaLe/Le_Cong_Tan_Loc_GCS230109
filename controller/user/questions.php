<?php
include '../../includes/auth.php';
session_start_if_not_started();
try{
    include '../../includes/DatabaseConnection.php';
    include '../../includes/DatabaseFunction.php';
    include '../../includes/config.php';
    $questions = allQuestions($pdo);
    $title = 'Question List';
    $totalQuestion = totalQuestion($pdo);
    
    ob_start();
    include '../../templates/user/questions.html.php';
    $output = ob_get_clean();
}catch (PDOException $e){
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage();
}
include '../../templates/user/layout.html.php';
?>