<?php
// Start session
session_start();

// Include database connection
require 'database.php'; // Replace with your database connection file

// Check if the user is logged in and get user_id
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}
$user_id = $_SESSION['user_id'];

try {
    // Query to fetch cart items for the logged-in user
    $sql = "SELECT cart.product_id, products.name, products.price, products.image, cart.quantity 
            FROM cart 
            JOIN products ON cart.product_id = products.product_id 
            WHERE cart.user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching cart items: " . $e->getMessage();
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
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

            <!-- Login and Sign-Up Buttons -->
            <div class="flex space-x-4 items-center">
                <a href="login.php" class="bg-transparent text-gray-800 px-4 py-2 rounded hover:bg-gray-200 transition">
                    Login
                </a>
                <a href="signup.php" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                    Sign Up
                </a>
            </div>
        </div>
    </header>

    <!-- Checkout Container -->
    <div class="bg-white/50 backdrop-blur-md shadow-lg max-w-4xl mx-auto mt-12 p-8 rounded-lg">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">Checkout</h1>

        <div class="flex flex-col md:flex-row gap-6">
            <!-- Order Summary Section -->
            <div class="flex-1 bg-gray-100 rounded-lg p-6">
                <h2 class="text-xl font-medium text-gray-800 mb-4">Order Summary</h2>
                <div class="space-y-4">
                    <?php if (count($cart_items) > 0): ?>
                        <?php foreach ($cart_items as $item): ?>
                            <div class="flex items-center gap-4">
                                <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="w-16 h-16 object-cover rounded-md">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800"><?php echo htmlspecialchars($item['name']); ?></h3>
                                    <p class="text-gray-600">Quantity: <?php echo htmlspecialchars($item['quantity']); ?></p>
                                </div>
                                <p class="font-bold text-gray-800">$<?php echo number_format($item['price'], 2); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-gray-600">Your cart is empty.</p>
                    <?php endif; ?>
                </div>
                <!-- Total -->
                <div class="mt-6 border-t pt-4">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-medium text-gray-800">Total:</span>
                        <span class="text-lg font-bold text-gray-800">
                            $<?php echo number_format(array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart_items)), 2); ?>
                        </span>
                    </div>
                </div>
            </div>  


            <!-- Payment Details Section -->
            <div class="flex-1 bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-medium text-gray-800 mb-4">Payment Details</h2>
                <form action="process_payment.php" method="POST" class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-gray-700 font-medium mb-1">Full Name</label>
                        <input type="text" id="name" name="name" class="w-full p-3 border rounded-md" required>
                    </div>
                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-gray-700 font-medium mb-1">Address</label>
                        <input type="text" id="address" name="address" class="w-full p-3 border rounded-md" required>
                    </div>
                    <!-- Card Details -->
                    <div>
                        <label for="cardNumber" class="block text-gray-700 font-medium mb-1">Card Number</label>
                        <input type="text" id="cardNumber" name="cardNumber" class="w-full p-3 border rounded-md" required>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex-1">
                            <label for="expiryDate" class="block text-gray-700 font-medium mb-1">Expiry Date</label>
                            <input type="text" id="expiryDate" name="expiryDate" class="w-full p-3 border rounded-md" placeholder="MM/YY" required>
                        </div>
                        <div class="w-1/3">
                            <label for="cvv" class="block text-gray-700 font-medium mb-1">CVV</label>
                            <input type="text" id="cvv" name="cvv" class="w-full p-3 border rounded-md" required>
                        </div>
                    </div>
                    <!-- Submit -->
                    <button type="submit" class="w-full bg-red-600 text-white py-3 rounded-lg font-semibold hover:bg-red-700 transition">
                        Complete Payment
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>