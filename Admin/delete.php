<?php
    require_once "database.php";
    if(!isset($_SESSION)){
        session_start(); // to create success if not exist
    }

    if(isset($_GET['product_id'])){
        $product_id = $_GET['product_id'];
        $sql = "DELETE from products where product_id = ?";
        $stmt = $conn -> prepare($sql);
        $status = $stmt->execute([$product_id]);// we need array in here
        if($status){
            $_SESSION['deleteSuccess'] = "Product with $product_id has been deleted.";
            header("Location: viewproduct.php");
        }
        else{
            $_SESSION['deleteError'] = "Failed to delete product with $product_id.";
        }
    }
?>
 
 