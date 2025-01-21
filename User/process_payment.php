<?php
// Start session
session_start();

// Include database connection
require_once "database.php";


// // Get user_id from session
$user_id = $_SESSION['user_id'] ?? "";


try {
    // Fetch product details for the session
    $stmt = $conn->prepare("INSERT into orders WHERE product_id = :product_id");
    $stmt->execute([':product_id' => $product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $_SESSION['product'] = $product;
    }
} catch (PDOException $e) {
    echo "Error adding to cart: " . $e->getMessage();
    exit();
}

// Initialize variables for search
$searchProduct = "";
$product_details = [];

// Handle search form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search']) && !empty($_POST['search'])) {
    $search = htmlspecialchars($_POST['search']);  // Sanitize user input

    try {
        // Perform search query to find matching products
        $stmt = $conn->prepare("
            SELECT products.*, categories.name AS category_name
            FROM products
            JOIN categories ON categories.category_id = products.category_id
            WHERE products.name LIKE :search 
               OR categories.name LIKE :search 
               OR products.price LIKE :search
        ");
        $stmt->execute([':search' => '%' . $search . '%']);
        $product_details = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if products were found
        if (empty($product_details)) {
            $searchProduct = "No products found matching your search criteria.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchProduct = "Please enter a product name or category.";
}
