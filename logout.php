<?php
require_once 'config/config.php';

// Log the logout event
if (Auth::isLoggedIn()) {
    Auth::logSecurityEvent('user_logout', [
        'user_id' => Auth::getUserId(),
        'user_email' => $_SESSION['user_email'] ?? 'unknown'
    ]);
    
    // Logout user
    Auth::logout();
}

// Redirect to login page
header('Location: login.php?message=logged_out');
exit();
?>