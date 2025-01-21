<?php
// Start the session
session_start();

// Include the database connection
require_once "database.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Get the product ID from the URL
if (!isset($_GET['product_id']) || empty($_GET['product_id'])) {
    echo "Invalid product ID!";
    exit();
}
$product_id = intval($_GET['product_id']); // Sanitize input

// Insert the product into the cart table
try {
    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity, created_at) VALUES (:user_id, :product_id, :quantity, NOW())");
    $stmt->execute([
        ':user_id' => $user_id,
        ':product_id' => $product_id,
        ':quantity' => 1
    ]);

    // Redirect to addToCart.php after successful insertion
    header("Location: addToCart.php");
    exit();
} catch (PDOException $e) {
    echo "Error adding product to cart: " . $e->getMessage();
    exit();
}
