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

$total = 0; // Initialize total variable

try {
    // Fetch cart items for the logged-in user
    $sql = "SELECT cart.product_id, products.name, products.price, products.image, cart.quantity 
            FROM cart 
            JOIN products ON cart.product_id = products.product_id 
            WHERE cart.user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculate the total before form submission
    foreach ($cart_items as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // Fetch payment methods
    $payment_sql = "SELECT payment_method_id, payment_name FROM payment_method";
    $payment_stmt = $conn->prepare($payment_sql);
    $payment_stmt->execute();
    $payment_methods = $payment_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

// Handle the payment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payment'])) {
    $status = "pending";
    $order_date = date('Y-m-d H:i:s');
    $payment_method_id = $_POST['payment_method'];

    // Calculate total by multiplying price and quantity
    $total = 0; // Reset total before recalculating it
    foreach ($cart_items as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    try {
        // Insert the order into the database
        $order_sql = "INSERT INTO orders (user_id, order_date, status, total_amount, payment_method_id) 
                      VALUES (:user_id, :order_date, :status, :total_amount, :payment_method_id)";
        $order_stmt = $conn->prepare($order_sql);
        $order_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $order_stmt->bindParam(':order_date', $order_date);
        $order_stmt->bindParam(':status', $status);
        $order_stmt->bindParam(':total_amount', $total);
        $order_stmt->bindParam(':payment_method_id', $payment_method_id, PDO::PARAM_INT);
        $order_stmt->execute();

        $order_id = $conn->lastInsertId();

        // Insert each cart item into `order_items`
        $sql_items = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                      VALUES (:order_id, :product_id, :quantity, :price)";
        $stmt_items = $conn->prepare($sql_items);

        foreach ($cart_items as $item) {
            $stmt_items->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $stmt_items->bindParam(':product_id', $item['product_id'], PDO::PARAM_INT);
            $stmt_items->bindParam(':quantity', $item['quantity'], PDO::PARAM_INT);
            $stmt_items->bindParam(':price', $item['price']);
            $stmt_items->execute();
        }

        // Clear the user's cart after order completion
        $sql_clear_cart = "DELETE FROM cart WHERE user_id = :user_id";
        $stmt_clear_cart = $conn->prepare($sql_clear_cart);
        $stmt_clear_cart->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt_clear_cart->execute();

        // Redirect to confirmation page or clear cart, if needed
        header('Location: ordercomplete.php');
        exit();
    } catch (PDOException $e) {
        echo "Error placing order: " . $e->getMessage();
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .payment-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .payment-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .payment-card.selected {
            border-color: #ef4444;
            /* Tailwind Red-600 */
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.3);
            transform: scale(1.05);
        }
    </style>
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
                                <p class="font-bold text-gray-800">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
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
                            $<?php echo number_format($total, 2); ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Payment Details Section -->
            <div class="flex-1 bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-medium text-gray-800 mb-4">Payment Details</h2>
                <form action="" method="POST" class="space-y-4">
                    <!-- Payment Methods -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Choose a Payment Method</label>
                        <div class="grid grid-cols-2 gap-4" id="payment-methods">
                            <?php
                            $payment_icons = [
                                'Credit Card' => '/images/creditcard.png',
                                'Debit Card' => '/images/debit card.png',
                                'Cash On Delivery' => '/images/cod.png',
                                'K pay' => '/images/Kpay.png',
                            ];
                            ?>
                            <?php foreach ($payment_methods as $method): ?>
                                <?php
                                $icon = $payment_icons[$method['payment_name']] ?? '/images/icons/default.png';
                                ?>
                                <label class="payment-card flex items-center gap-3 p-4 border rounded-lg cursor-pointer">
                                    <input
                                        type="radio"
                                        name="payment_method"
                                        value="<?php echo htmlspecialchars($method['payment_method_id']); ?>"
                                        class="hidden">
                                    <img src="<?php echo htmlspecialchars($icon); ?>"
                                        alt="<?php echo htmlspecialchars($method['payment_name']); ?>"
                                        class="w-10 h-10">
                                    <span class="text-gray-800 font-medium"><?php echo htmlspecialchars($method['payment_name']); ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <button type="submit" name="payment" class="w-full bg-red-600 text-white py-3 rounded-lg font-semibold hover:bg-red-700 transition">
                        Complete Payment
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const paymentCards = document.querySelectorAll('.payment-card');
            paymentCards.forEach(card => {
                card.addEventListener('click', () => {
                    paymentCards.forEach(c => c.classList.remove('selected'));
                    card.classList.add('selected');
                    card.querySelector('input[type="radio"]').checked = true;
                });
            });
        });
    </script>
</body>

</html>
