<?php 
unset($_SESSION['user']);
header("Location: /Coursework/templates/auth/login.html.php");
exit;
?>