<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once "database.php";
try {
    $sql = "SELECT * FROM products Limit 4";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['products'] = $products;
} catch (PDOException) {
    echo "Error: " . $e->getMessage();
}


// Get the user ID from the session
$user_id = $_SESSION['user_id'] ?? "";

$searchProduct = "";
$product_details = [];

// Check if the form is submitted via POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search']) && !empty($_POST['search'])) {
    $search = htmlspecialchars($_POST['search']);  // Sanitize user input

    try {
        // Perform the search query to find matching products
        $stmt = $conn->prepare("SELECT products.*, categories.name AS category_name 
                                FROM products 
                                JOIN categories ON categories.category_id = products.category_id 
                                WHERE products.name LIKE :search 
                                OR categories.name LIKE :search 
                                OR products.price LIKE :search");
        $stmt->execute([':search' => '%' . $search . '%']);
        $product_details = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if products were found
        if (count($product_details) === 0) {
            $searchProduct = "No products found matching your search criteria.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    $searchProduct = "Please enter a product name or category.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Fonts Link -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <!---------------------- Navbar ------------------------>
    <?php include'header.php'; ?>


    <!-- Video Banner -->
    <section class="relative">
        <video autoplay loop muted playsinline class="w-full h-[600px] object-cover">
            <source src="/images/For our beloved athletes.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="absolute inset-0 flex items-center justify-center">
            <!-- Shop Now Button -->
            <a href="#products"
                class="absolute bottom-4 right-64 bg-blue-500 text-white text-lg px-6 py-3 rounded shadow hover:bg-blue-600 transition">
                Shop Now
            </a>
        </div>
    </section>




    <!-- Services Section -->
    <section id="services" class="py-16">
        <div class="container mx-auto">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">Our Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-blue-500 text-4xl mb-4">📦</div>
                    <h3 class="text-xl font-semibold mb-2">Branded</h3>
                    <p class="text-gray-600">High-quality products, service tailored to your needs.</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-blue-500 text-4xl mb-4">⚡</div>
                    <h3 class="text-xl font-semibold mb-2">Time</h3>
                    <p class="text-gray-600">Fast and reliable solutions every time.</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-blue-500 text-4xl mb-4">🌍</div>
                    <h3 class="text-xl font-semibold mb-2">Global</h3>
                    <p class="text-gray-600">Globally trusted and respected by our clients.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="p-8 bg-gray-100">
        <!-- Trending Heading -->
        <h2 class="text-4xl font-bold text-center text-gray-900 mb-8 font-poppins">
            Trending
        </h2>

        <div class="flex justify-center gap-6">
            <!-- Video 1 -->
            <div class="relative w-full max-w-md overflow-hidden rounded-lg shadow-xl transform transition-transform duration-300 hover:scale-105">
                <video autoplay loop muted playsinline class="w-full h-[500px] object-cover rounded-lg">
                    <source src="/images/Jordan Heir Series PF 'Classic'.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <!-- Overlay Content -->
                <div class="absolute bottom-4 right-4 text-white p-4">
                    <h3 class="text-xl font-semibold mb-2">Jordan Heir Series PF</h3>
                    <button class="bg-red-500 text-white px-6 py-2 rounded-full hover:bg-red-600 transition duration-300">
                        Check
                    </button>
                </div>
            </div>

            <!-- Video 2 -->
            <div class="relative w-full max-w-md overflow-hidden rounded-lg shadow-xl transform transition-transform duration-300 hover:scale-105">
                <video autoplay loop muted playsinline class="w-full h-[500px] object-cover rounded-lg">
                    <source src="/images/Nike Dri-FIT Rise 365.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <!-- Overlay Content -->
                <div class="absolute bottom-4 right-4 text-white p-4">
                    <h3 class="text-xl font-semibold mb-2">Nike Dri-FIT Rise 365</h3>
                    <button class="bg-red-500 text-white px-6 py-2 rounded-full hover:bg-red-600 transition duration-300">
                        Check
                    </button>
                </div>
            </div>

            <!-- Video 3 -->
            <div class="relative w-full max-w-md overflow-hidden rounded-lg shadow-xl transform transition-transform duration-300 hover:scale-105">
                <video autoplay loop muted playsinline class="w-full h-[500px] object-cover rounded-lg">
                    <source src="/images/Zion 3 PF.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <!-- Overlay Content -->
                <div class="absolute bottom-4 right-4 text-white p-4">
                    <h3 class="text-xl font-semibold mb-2">Zion 3 PF</h3>
                    <button class="bg-red-500 text-white px-6 py-2 rounded-full hover:bg-red-600 transition duration-300">
                        Check
                    </button>
                </div>
            </div>
        </div>
    </section>


    <!-- Call to Action -->
    <section class="bg-gray-600 text-white py-16">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold mb-4">RACE THE NIGHT AWAY</h2>
            <p class="mb-6">Run until you see stars at the Ethelte EDGE After Dark Tour, a race powered by men.</p>
            <a href="#contact" class="bg-white text-blue-600 px-8 py-3 rounded shadow hover:bg-blue-100">
                Contact Us
            </a>
        </div>
    </section>

    <!-- Banner Section -->
    <section id="banners" class="py-16 bg-gray-100">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">Our Featured Banners</h2>
        <div class="grid grid-cols-2 grid-rows-2 gap-0">
            <!-- Top Left Banner -->
            <div class="bg-white shadow overflow-hidden">
                <img src="/images/Jordan Heir Series.jpeg" alt="Banner 1" class="w-full h-full object-cover">
            </div>
            <!-- Top Right Banner -->
            <div class="bg-white shadow overflow-hidden">
                <img src="/images/nike alphafly .avif" alt="Banner 2" class="w-full h-full object-cover">
            </div>
            <!-- Bottom Left Banner -->
            <div class="bg-white shadow overflow-hidden">
                <img src="/images/Converse x Swarovski Run Star Trainer.webp" alt="Banner 3" class="w-full h-full object-cover">
            </div>
            <!-- Bottom Right Banner -->
            <div class="bg-white shadow overflow-hidden">
                <img src="/images/PUMA Deviate Nitro 3.avif" alt="Banner 4" class="w-full h-full object-cover">
            </div>
        </div>
    </section>


    <!-- Products Section -->
    <section id="products" class="py-16 bg-gray-100">
        <div class="container mx-auto">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">Best Sellers</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php
                if (isset($products)) {
                    foreach ($products as $product) { ?>
                        <!-- Product Card -->
                        <div class="bg-white rounded-lg shadow p-6 text-center">
                            <img src="/images/<?php echo $product['image']; ?>" alt="Product 1" class="h-100 w-full object-cover rounded mb-4">
                            <h3 class="text-lg font-semibold mb-2"><?php echo $product['name']; ?></h3>
                            <p class="text-gray-600 mb-4"><?php echo $product['description']; ?></p>
                            <span class="text-blue-600 font-bold text-lg"><?php echo '$' . number_format($product['price'], 2); ?></span>
                            <div class="mt-4">
                                <?php
                                echo "
                                <a href='addCart.php?product_id=$product[product_id]' class='bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600'>
                                    Add to Cart
                                </a>
                                 <a href='productdetail.php?product_id=$product[product_id]' class='bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600'>
                                    Detail
                                </a>
                                "
                                ?>
                            </div>
                        </div>
                <?php }
                } ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-400 py-8">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Athlete EDGE. All Rights Reserved.</p>
            <p class="mt-2">Follow us on:
                <a href="#" class="text-blue-500 hover:text-white mx-1">Facebook</a> |
                <a href="#" class="text-blue-500 hover:text-white mx-1">Twitter</a> |
                <a href="#" class="text-blue-500 hover:text-white mx-1">Instagram</a>
            </p>
        </div>
    </footer>
</body>

</html>