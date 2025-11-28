<?php

function session_start_if_not_started() { 
    if (session_status() === PHP_SESSION_NONE) { // Check if session is not started
        session_start();
    }
}

function checkAuth() {
    if (!isset($_SESSION['user'])) {    // User not logged in
        header("Location: /Coursework/templates/auth/login.html.php");
        exit;
    }
}

function isAdmin() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}

function isUser() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'user';
}
?>
