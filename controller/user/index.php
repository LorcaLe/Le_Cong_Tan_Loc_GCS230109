<?php

include '../../includes/auth.php';
session_start_if_not_started();
checkAuth(); 


$title = 'Student Dashboard';


ob_start();
include '../../templates/user/home.html.php';
$output = ob_get_clean();

include '../../templates/user/layout.html.php';
?>