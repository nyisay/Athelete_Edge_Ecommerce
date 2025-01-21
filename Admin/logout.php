<?php 
if(!isset($_SESSION)){
    session_start();
}

if($_SESSION['adminLoginSuccess']){
    session_destroy();
}
?>