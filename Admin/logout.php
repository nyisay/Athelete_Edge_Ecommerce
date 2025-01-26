<?php 
if (!isset($_SESSION)) {
    session_start();
}

// Check if the session key 'adminLoginSuccess' is set and true
if (isset($_SESSION['adminLoginSuccess']) && $_SESSION['adminLoginSuccess']) {
    session_destroy();
    header('Location: loginform.php');
    exit; 
} else {
    
    session_destroy();
    header('Location: loginform.php');
    exit;
}
?>
