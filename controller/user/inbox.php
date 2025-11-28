<?php
include '../../includes/auth.php';
session_start_if_not_started();
checkAuth(); 

include '../../includes/DatabaseConnection.php';
include '../../includes/DatabaseFunction.php';

try {

    $messages = getMessagesByUserId($pdo, $_SESSION['user']['id']); // Get messages for the logged-in user
    $title = 'My Inbox';
    
    ob_start();
    include '../../templates/user/user_inbox.html.php'; 
    $output = ob_get_clean();

} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage(); // Display error message
}
include '../../templates/user/layout.html.php';
?>