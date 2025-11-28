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
    // Handle form submission
    if (isset($_POST['submit'])) {
        
        $questionId = $_POST['questionid'];
        $text = $_POST['text'];
        $moduleId = $_POST['moduleid'];
        
        // Verify ownership or admin rights
        $question = getQuestion($pdo, $questionId);
        if ($question['userid'] != $_SESSION['user']['id'] && !isAdmin()) {
            die('Access Denied.');
        }
        $imageFileName = null;

        // Handle image upload
        if (!empty($_FILES['image']['name'])) {
            // Delete old image if exists
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
        // Update question details
        updateQuestionDetails($pdo, $questionId, $text, $moduleId, $imageFileName);
        
        header('location: questions.php');
        exit;
    }

    else {
        if (!isset($_GET['id'])) {
             header('location: questions.php');
             exit;
        }
        // Verify ownership or admin rights
        $question = getQuestion($pdo, $_GET['id']);
        if ($question['userid'] != $_SESSION['user']['id'] && !isAdmin()) {
            die('Access Denied.');
        }
        
        $modules = allModules($pdo);
        
        $title = 'Edit Your Question';
        ob_start();
        include '../../templates/admin/admin_editquestion.html.php'; 
        $output = ob_get_clean();
    }
    
} catch(PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage();
}

include '../../templates/admin/admin_layout.html.php';
?>