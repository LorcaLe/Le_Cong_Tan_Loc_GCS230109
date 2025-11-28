<?php
include '../../includes/auth.php';
session_start_if_not_started();
checkAuth(); 

include '../../includes/DatabaseConnection.php';
include '../../includes/DatabaseFunction.php';

// Handle form submission
if (isset($_POST['text'])) {
    try {
        $imageFileName = null;
        // Handle image upload if provided
        if (!empty($_FILES['image']['name'])) {
            $uploadDir = __DIR__ . '../../../images/';  // Ensure correct path
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);     // Create directory if not exists
            $imageFileName = time() . '_' . basename($_FILES['image']['name']); // Unique file name
            $targetPath = $uploadDir . $imageFileName;  // Full path for upload
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {   // Move uploaded file
                $imageFileName = null;
            }
        }
        
        insertQuestion(
            $pdo, 
            $_POST['text'], 
            $_POST['moduleid'], 
            $_SESSION['user']['id'], 
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
    
    ob_start();

    include '../../templates/user/addquestion.html.php'; 
    $output = ob_get_clean();
}
include '../../templates/user/layout.html.php';
?>