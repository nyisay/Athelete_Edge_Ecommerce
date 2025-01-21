<?php
require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['approve_order'])) {
    $orderId = $_POST['order_id'];

    try {
        // Update order status to 'approved'
        $sql = "UPDATE orders SET status = 'approved' WHERE id = :order_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['status_message'] = "Order ID $orderId has been approved successfully!";
        } else {
            $_SESSION['status_message'] = "Failed to approve Order ID $orderId.";
        }
    } catch (PDOException $e) {
        $_SESSION['status_message'] = "Error: " . $e->getMessage();
    }

    // Redirect back to the orders page
    header("Location: vieworder.php");
    exit;
}
?>
