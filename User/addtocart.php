<?php
// Start session
session_start();
require_once "database.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$user_id = $_SESSION['user_id'] ?? null;

// Fetch products in the cart for the logged-in user
try {
    $sql = "
        SELECT products.*, cart.created_at, cart.quantity 
        FROM cart
        JOIN products ON cart.product_id = products.product_id
        WHERE cart.user_id = :user_id
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $cart_products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Store cart products in session if found
    if ($cart_products) {
        $_SESSION['cart_products'] = $cart_products;
    }
} catch (PDOException $e) {
    echo "Error fetching cart products: " . $e->getMessage();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove']) && isset($_POST['product_id'])) {
    $product_id = htmlspecialchars($_POST['product_id']); // Sanitize input

    try {
        $sql = "DELETE FROM cart WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Optionally, redirect to refresh the page and update cart items
            header("Location: " . htmlspecialchars($_SERVER['PHP_SELF']));
            exit();
        } else {
            echo "Failed to remove the product from the cart.";
        }
    } catch (PDOException $e) {
        echo "Error removing product from cart: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .active-img {
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<?php include 'header.php'; ?>

<body class="bg-[url('../images/background.png')] bg-cover bg-center bg-no-repeat">

    

    <!-- Cart Section -->
    <section class="py-16 rounded-lg shadow-lg backdrop-blur-md mx-4 md:mx-auto max-w-6xl">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Your Shopping Cart</h2>
            <div class="space-y-6">
                <?php if (!empty($cart_products)) : ?>
                    <?php
                    $total = 0;
                    foreach ($cart_products as $product) :
                        $subtotal = $product['price'] * $product['quantity'];
                        $total += $subtotal;
                    ?>
                        <!-- Cart Item -->
                        <div class="flex items-center space-x-6 border-b pb-6">
                            <img src="/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="w-32 h-32 object-cover rounded-lg">
                            <div>
                                <h3 class="text-xl font-medium text-gray-800"><?php echo htmlspecialchars($product['name']); ?></h3>
                                <div class="flex items-center space-x-4 mt-2">
                                    <!-- Quantity Controls -->
                                    <div class="flex items-center space-x-2">
                                        <button class="bg-gray-200 text-gray-600 px-4 py-2 rounded hover:bg-gray-300 transition" onclick="decreaseQuantity('<?php echo $product['product_id']; ?>')">-</button>
                                        <span id="quantity<?php echo $product['product_id']; ?>" class="text-lg font-bold"><?php echo $product['quantity']; ?></span>
                                        <button class="bg-gray-200 text-gray-600 px-4 py-2 rounded hover:bg-gray-300 transition" onclick="increaseQuantity('<?php echo $product['product_id']; ?>')">+</button>
                                    </div>
                                    <span class="text-lg font-bold text-blue-600">$<?php echo number_format($subtotal, 2); ?></span>
                                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                        <button type="submit" name="remove" class="bg-gray-200 text-gray-600 px-4 py-2 rounded hover:bg-gray-300 transition">
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <!-- Cart Summary -->
                    <div class="flex justify-between items-center mt-6">
                        <span class="text-2xl font-bold text-gray-800">Total: $<?php echo number_format($total, 2); ?></span>
                        <div class="flex space-x-4">
                            <a href="checkout.php" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 transition">
                                Proceed to Checkout
                            </a>
                            <a href="product.php" class="bg-gray-100 text-gray-600 px-6 py-2 rounded hover:bg-gray-200 transition">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                <?php else : ?>
                    <p class="text-xl text-gray-600">Your cart is empty. <a href="product.php" class="text-red-600 underline">Start shopping now!</a></p>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <script>
        function increaseQuantity(quantityId) {
            const quantityElement = document.getElementById(quantityId);
            let quantity = parseInt(quantityElement.innerText);
            quantity += 1;
            quantityElement.innerText = quantity;
            updatePrice(quantityId, quantity);
        }

        function decreaseQuantity(quantityId) {
            const quantityElement = document.getElementById(quantityId);
            let quantity = parseInt(quantityElement.innerText);
            if (quantity > 1) {
                quantity -= 1;
                quantityElement.innerText = quantity;
                updatePrice(quantityId, quantity);
            }
        }

        function updatePrice(quantityId, quantity) {
            let priceElement;
            if (quantityId === 'quantity1') {
                priceElement = document.getElementById('price1');
            } else if (quantityId === 'quantity2') {
                priceElement = document.getElementById('price2');
            }

            const unitPrice = 49.99; // Unit price of the product
            const totalPrice = (unitPrice * quantity).toFixed(2);
            priceElement.innerText = `$${totalPrice}`;
            updateTotal();
        }

        function updateTotal() {
            const quantity1 = parseInt(document.getElementById('quantity1').innerText);
            const quantity2 = parseInt(document.getElementById('quantity2').innerText);
            const totalPrice = (49.99 * quantity1 + 49.99 * quantity2).toFixed(2);
            document.querySelector('.text-2xl').innerText = `Total: $${totalPrice}`;
        }
    </script>
</body>


</html>