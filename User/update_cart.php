<?php
session_start();
require 'database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['user_id'], $data['product_id'], $data['quantity'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
    exit;
}

$user_id = (int)$data['user_id'];
$product_id = (int)$data['product_id'];
$quantity = (int)$data['quantity'];

try {
    $stmt = $conn->prepare("UPDATE Cart SET quantity = :quantity WHERE product_id = :product_id AND user_id = :user_id");
    $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Cart updated successfully!']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
