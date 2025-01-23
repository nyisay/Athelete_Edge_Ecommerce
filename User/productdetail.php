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
<?php include 'header.php'; ?>

<body class="bg-gray-100 text-gray-800">

    <!-- Product Detail Section -->
    <section class="py-16 rounded-lg mx-4 md:mx-auto max-w-6xl bg-white shadow-lg">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Product Image -->
                <div>
                    <!-- Main Image -->
                    <div class="relative">
                        <img id="mainImage" src="<?php echo $product['image']; ?>" alt="Product Name"
                            class="rounded-lg shadow-lg mb-6 w-full object-cover">
                        <span
                            class="absolute top-4 left-4 bg-blue-600 text-white text-xs font-semibold px-2 py-1 rounded">
                            New
                        </span>
                    </div>

                    <!-- Additional Images -->
                    <div class="flex space-x-4">
                        <img src="<?php echo $product['second_image']; ?>" alt="Side View"
                            class="w-20 h-20 object-cover rounded shadow cursor-pointer hover:ring-2 hover:ring-blue-600 active-img"
                            onclick="changeMainImage(this)">
                        <img src="<?php echo $product['third_image']; ?>" alt="Back View"
                            class="w-20 h-20 object-cover rounded shadow cursor-pointer hover:ring-2 hover:ring-blue-600"
                            onclick="changeMainImage(this)">
                        <img src="<?php echo $product['fourth_image']; ?>" alt="Zoom View"
                            class="w-20 h-20 object-cover rounded shadow cursor-pointer hover:ring-2 hover:ring-blue-600"
                            onclick="changeMainImage(this)">
                        <img src="<?php echo $product['fifth_image']; ?>" alt="Angle View"
                            class="w-20 h-20 object-cover rounded shadow cursor-pointer hover:ring-2 hover:ring-blue-600"
                            onclick="changeMainImage(this)">
                    </div>
                </div>

                <!-- Product Details -->
                <div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-4"><?php echo $product['name']; ?></h1>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        <?php echo $product['description']; ?>
                    </p>

                    <div class="mb-6 flex items-center space-x-4">
                        <span class="text-3xl font-semibold text-blue-600"><?php echo $product['price']; ?></span>
                        <span class="text-sm text-gray-400 line-through">$59.99</span>
                    </div>

                    <!-- Ratings -->
                    <div class="flex items-center mb-6">
                        <span class="flex text-yellow-400 space-x-1">
                            <!-- Stars -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                                <path
                                    d="M12 17.75l-5.447 3.607 2.07-6.374L2.545 9.8l6.657-.023L12 3.6l2.798 6.177 6.657.023-6.078 5.182 2.07 6.374z" />
                            </svg>
                        </span>
                        <span class="text-sm text-gray-500 ml-3">(25 Reviews)</span>
                    </div>

                    <!-- Available Colors -->
                    <!-- <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-800 mb-2">Available Colors:</h3>
                        <div class="flex space-x-4">
                            <span class="w-8 h-8 rounded-full bg-red-500 shadow cursor-pointer hover:ring-2 hover:ring-gray-400"></span>
                            <span class="w-8 h-8 rounded-full bg-blue-500 shadow cursor-pointer hover:ring-2 hover:ring-gray-400"></span>
                            <span class="w-8 h-8 rounded-full bg-green-500 shadow cursor-pointer hover:ring-2 hover:ring-gray-400"></span>
                            <span class="w-8 h-8 rounded-full bg-gray-500 shadow cursor-pointer hover:ring-2 hover:ring-gray-400"></span>
                        </div>
                    </div> -->

                    <?php if ($user_id) { ?>
                        <!-- Add to Cart Button -->
                        <div class="flex items-center space-x-4 mb-4">
                            <a href="addtocart.php?product_id=<?php echo $product['product_id']; ?>"
                                class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 transition shadow-lg">
                                Add to Cart
                            </a>
                            <button
                                class="bg-gray-100 text-gray-600 px-6 py-3 rounded hover:bg-gray-200 transition shadow-lg">
                                Favourite
                            </button>
                        </div>
                    <?php } ?>

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
            const mainImage = document.getElementById('mainImage');
            mainImage.src = clickedImage.src;
            document.querySelectorAll('.flex img').forEach(img => {
                img.classList.remove('active-img');
            });
            clickedImage.classList.add('active-img');
        }
    </script>
</body>


</html>