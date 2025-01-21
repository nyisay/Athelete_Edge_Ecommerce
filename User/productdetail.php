<?php
// Start session
session_start();

// Include database connection
require_once "database.php";


// // Get user_id from session
$user_id = $_SESSION['user_id'] ?? "";

// // Validate and get product_id from GET parameters
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

if ($product_id > 0) {
    try {
        // Fetch product details for the session
        $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = :product_id");
        $stmt->execute([':product_id' => $product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            $_SESSION['product'] = $product;
        }
    } catch (PDOException $e) {
        echo "Error adding to cart: " . $e->getMessage();
        exit();
    }
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
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .active-img {
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body class="bg-[url('../images/background.png')] bg-cover bg-center bg-no-repeat">

    <!-- Navbar -->
    <header class="bg-white/30 backdrop-blur-lg shadow-lg">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="home.php" class="flex items-center">
                <img src="/images/logoedit.png" alt="Logo" class="h-12 w-12 mr-3">
                <span class="text-xl font-bold text-gray-700">Athlete Edge</span>
            </a>

            <nav class="flex space-x-6 items-center">
                <a href="home.php" class="text-gray-800 hover:text-red-600 transition">Home</a>
                <a href="about.php" class="text-gray-800 hover:text-red-600 transition">About</a>
                <a href="features.php" class="text-gray-800 hover:text-red-600 transition">Features</a>
                <a href="categories.php" class="text-gray-800 hover:text-red-600 transition">Categories</a>

                <form action="search_results.php" method="POST" class="flex items-center space-x-2">
                    <input type="text" name="search" placeholder="Search products..." class="px-4 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-red-600 transition">
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                        Search
                    </button>
                </form>
            </nav>

            <a href="addtocart.php" class="bg-transparent text-gray-800 px-4 py-2 rounded hover:bg-gray-200 transition">
                Cart
            </a>

            <div class="flex space-x-4 items-center">
                <a href="loginform.php" class="bg-transparent text-gray-800 px-4 py-2 rounded hover:bg-gray-200 transition">
                    Login
                </a>
                <a href="signup.php" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                    Sign Up
                </a>
            </div>
        </div>
    </header>


    <!-- Product Detail Section -->
    <section class="py-16 rounded-lg shadow-lg backdrop-blur-md mx-4 md:mx-auto max-w-6xl">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Product Image -->
                <div>
                    <!-- Main Image -->
                    <img id="mainImage" src="<?php echo $product['image']; ?>" alt="Product Name" class="rounded-lg shadow-lg mb-6">

                    <!-- Additional Images -->
                    <div class="flex space-x-4">
                        <img src="<?php echo $product['second_image']; ?>" alt="Side View" class="w-20 h-20 object-cover rounded shadow cursor-pointer hover:ring-2 hover:ring-blue-600 active-img" onclick="changeMainImage(this)">
                        <img src="<?php echo $product['third_image']; ?>" alt="Back View" class="w-20 h-20 object-cover rounded shadow cursor-pointer hover:ring-2 hover:ring-blue-600" onclick="changeMainImage(this)">
                        <img src="<?php echo $product['fourth_image']; ?>" alt="Zoom View" class="w-20 h-20 object-cover rounded shadow cursor-pointer hover:ring-2 hover:ring-blue-600" onclick="changeMainImage(this)">
                        <img src="<?php echo $product['fifth_image']; ?>" alt="Angle View" class="w-20 h-20 object-cover rounded shadow cursor-pointer hover:ring-2 hover:ring-blue-600" onclick="changeMainImage(this)">
                    </div>
                </div>

                <!-- Product Details -->
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-4"> <?php echo $product['name']; ?></h1>
                    <p class="text-gray-600 mb-6">
                        <?php echo $product['description']; ?>
                    </p>
                    <div class="mb-6">
                        <span class="text-xl font-bold text-blue-600"> <?php echo $product['price']; ?></span>
                        <span class="text-sm text-gray-400 line-through ml-4">$59.99</span>
                    </div>

                    <!-- Ratings -->
                    <div class="flex items-center mb-6">
                        <span class="flex text-yellow-400 space-x-1">
                            <!-- Stars -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                                <path d="M12 17.75l-5.447 3.607 2.07-6.374L2.545 9.8l6.657-.023L12 3.6l2.798 6.177 6.657.023-6.078 5.182 2.07 6.374z" />
                            </svg>
                            <!-- Repeat for stars -->
                        </span>
                        <span class="text-sm text-gray-500 ml-3">(25 Reviews)</span>
                    </div>

                    <!-- Available Colors -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-800 mb-2">Available Colors:</h3>
                        <div class="flex space-x-4">
                            <span class="w-8 h-8 rounded-full bg-red-500 shadow cursor-pointer hover:ring-2 hover:ring-gray-400"></span>
                            <span class="w-8 h-8 rounded-full bg-blue-500 shadow cursor-pointer hover:ring-2 hover:ring-gray-400"></span>
                            <span class="w-8 h-8 rounded-full bg-green-500 shadow cursor-pointer hover:ring-2 hover:ring-gray-400"></span>
                            <span class="w-8 h-8 rounded-full bg-gray-500 shadow cursor-pointer hover:ring-2 hover:ring-gray-400"></span>
                        </div>
                    </div>

                    <?php
                    if ($user_id) {
                    ?>
                        <!-- Add to Cart Button -->
                        <div class="flex items-center space-x-4">
                            <a href="addtocart.php?product_id=<?php echo $product['product_id']; ?>" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Add to Cart
                            </a>
                        </div>
                    <?php
                    }
                    ?>

                    <button class="bg-gray-100 text-gray-600 px-6 py-2 rounded hover:bg-gray-200 transition">
                        Favourite
                    </button>
                </div>

                <!-- Additional Info -->
                <ul class="mt-6 space-y-2">
                    <li class="text-gray-600">✔ Free Shipping</li>
                    <li class="text-gray-600">✔ 30-day Return Policy</li>
                    <li class="text-gray-600">✔ Secure Payment</li>
                </ul>
            </div>
        </div>
        </div>
    </section>

    <script>
        function changeMainImage(clickedImage) {
            // Get the main image
            const mainImage = document.getElementById('mainImage');

            // Update the source of the main image
            mainImage.src = clickedImage.src;

            // Remove active class from all images
            document.querySelectorAll('.flex img').forEach(img => {
                img.classList.remove('active-img');
            });

            // Add active class to clicked image
            clickedImage.classList.add('active-img');
        }
    </script>
</body>

</html>