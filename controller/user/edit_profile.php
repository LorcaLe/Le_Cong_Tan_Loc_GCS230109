<?php
include '../../includes/auth.php';
session_start_if_not_started();
checkAuth(); 

include '../../includes/DatabaseConnection.php';
include '../../includes/DatabaseFunction.php';

$message = '';  // To hold success message

if (isset($_POST['name'])) {
    $id = $_SESSION['user']['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    
    // Only hash and update password if a new one is provided
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;    

    updateUserProfile($pdo, $id, $name, $email, $password);
    

    $_SESSION['user']['name'] = $name;
    $_SESSION['user']['email'] = $email;
    
    $message = "Profile updated successfully!";
    $user = getUser($pdo, $id); 
} else {
    $user = getUser($pdo, $_SESSION['user']['id']);
}

$title = 'Edit My Profile';
ob_start();
include '../../templates/user/edit_profile.html.php';
$output = ob_get_clean();
include '../../templates/user/layout.html.php';
?>