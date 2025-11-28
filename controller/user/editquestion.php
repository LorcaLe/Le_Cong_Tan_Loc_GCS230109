<?php
include '../../includes/auth.php';
session_start_if_not_started();
checkAuth();

include '../../includes/DatabaseConnection.php';
include '../../includes/DatabaseFunction.php';

try {

    if (isset($_POST['submit'])) {
        
        $questionId = $_POST['questionid'];
        $text = $_POST['text'];
        $moduleId = $_POST['moduleid'];

        $question = getQuestion($pdo, $questionId); 
        if ($question['userid'] != $_SESSION['user']['id'] && !isAdmin()) {     // Check if user owns the question or is admin
            die('Access Denied.'); // Unauthorized access
        }

        $imageFileName = null; 


        if (!empty($_FILES['image']['name'])) {
            // Remove old image if exists
            if (!empty($question['img'])) {
                $oldImagePath = __DIR__ . '../../../images/' . $question['img'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Upload new image
            $uploadDir = __DIR__ . '../../../images/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            
            $imageFileName = time() . '_' . basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $imageFileName;
        
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $imageFileName = null; 
            }
        }
        

        updateQuestionDetails($pdo, $questionId, $text, $moduleId, $imageFileName);
        
        header('location: questions.php');
        exit;
    }
    

    else {
        if (!isset($_GET['id'])) {
             header('location: questions.php');
             exit;
        }

        $question = getQuestion($pdo, $_GET['id']);
        if ($question['userid'] != $_SESSION['user']['id'] && !isAdmin()) {
            die('Access Denied.');
        }
        

        $modules = allModules($pdo);
        
        $title = 'Edit Your Question';
        ob_start();
        include '../../templates/user/editquestion.html.php'; 
        $output = ob_get_clean();
    }
    
} catch(PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage();    // Display error message
}

include '../../templates/user/layout.html.php';
?>