<?php
// Start session
session_start();

// Include database connection
require 'database.php'; // Replace with your database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}
$user_id = $_SESSION['user_id'];

try {
    // Fetch the latest order for the logged-in user
    $order_sql = "SELECT * FROM orders 
                  WHERE user_id = :user_id 
                  ORDER BY order_id DESC 
                  LIMIT 1";
    $order_stmt = $conn->prepare($order_sql);
    $order_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $order_stmt->execute();
    $latest_order = $order_stmt->fetch(PDO::FETCH_ASSOC);

    if ($latest_order) {
        $order_id = $latest_order['order_id'];

        // Fetch order items for the latest order
        $order_items_sql = "SELECT order_items.*, products.name AS product_name, products.image 
                            FROM order_items 
                            JOIN products ON order_items.product_id = products.product_id 
                            WHERE order_items.order_id = :order_id";
        $order_items_stmt = $conn->prepare($order_items_sql);
        $order_items_stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $order_items_stmt->execute();
        $order_items = $order_items_stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $latest_order = null;
        $order_items = [];
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Complete</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[url('../images/background.png')] bg-cover bg-center bg-no-repeat">

    <!-- Navbar -->
    <header class="bg-white/30 backdrop-blur-lg shadow-lg">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <!-- Logo -->
            <a href="home.php" class="flex items-center">
                <img src="/images/logoedit.png" alt="Logo" class="h-12 w-12 mr-3">
                <span class="text-xl font-bold text-gray-700">Athlete Edge</span>
            </a>
            <!-- Navigation Links -->
            <nav class="flex space-x-6 items-center">
                <a href="home.php" class="text-gray-800 hover:text-red-600 transition">Home</a>
                <a href="about.php" class="text-gray-800 hover:text-red-600 transition">About</a>
                <a href="features.php" class="text-gray-800 hover:text-red-600 transition">Features</a>
                <a href="categories.php" class="text-gray-800 hover:text-red-600 transition">Categories</a>
            </nav>
        </div>
    </header>

    <!-- Order Completion Container -->
    <div class="bg-white/50 backdrop-blur-md shadow-lg max-w-4xl mx-auto mt-12 p-8 rounded-lg">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">Order Complete</h1>

        <?php if ($latest_order): ?>
            <!-- Order Details -->
            <div class="bg-gray-100 rounded-lg p-6 mb-6">
                <h2 class="text-xl font-medium text-gray-800 mb-4">Order Details</h2>
                <p><strong>Order ID:</strong> <?php echo htmlspecialchars($latest_order['order_id']); ?></p>
                <p><strong>Order Date:</strong> <?php echo htmlspecialchars($latest_order['order_date']); ?></p>
                <p><strong>Status:</strong> <?php echo htmlspecialchars($latest_order['status']); ?></p>
                <p><strong>Total Amount:</strong> $<?php echo number_format($latest_order['total_amount'], 2); ?></p>
            </div>

            <!-- Order Items -->
            <div class="bg-gray-100 rounded-lg p-6">
                <h2 class="text-xl font-medium text-gray-800 mb-4">Order Items</h2>
                <?php if (count($order_items) > 0): ?>
                    <div class="space-y-4">
                        <?php foreach ($order_items as $item): ?>
                            <div class="flex items-center gap-4">
                                <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" class="w-16 h-16 object-cover rounded-md">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800"><?php echo htmlspecialchars($item['product_name']); ?></h3>
                                    <p class="text-gray-600">Quantity: <?php echo htmlspecialchars($item['quantity']); ?></p>
                                    <p class="text-gray-600">Price per item: $<?php echo number_format($item['price'], 2); ?></p>
                                </div>
                                <p class="font-bold text-gray-800">Subtotal: $<?php echo number_format($item['quantity'] * $item['price'], 2); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-600">No items found for this order.</p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-800 font-medium">No recent order found.</p>
        <?php endif; ?>
        <div class="flex justify-center items-center mt-6">
            <a href="home.php" class="w-full border-2   border-blue-400 px-2 py-6 rounded-xl text-center text-blue-400 hover:text-white hover:bg-blue-400">Go back home</a> 
        </div>
    </div>
</body>

</html>
