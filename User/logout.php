<?php 
if(!isset($_SESSION)){
    session_start();
}

if($_SESSION['userLoginSuccess'] ){
    session_destroy();
    header('Location: home.php');
}else{
    session_destroy();
    header('Location: home.php');
}
?>