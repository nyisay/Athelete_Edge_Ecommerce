<?php
session_start();
require_once "database.php";

// Initialize variables for search and product details
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
    <title>Search Results</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
</head>

<body class="bg-[url('../images/background.png')] bg-cover bg-center bg-no-repeat backdrop-blur-lg shadow-lg">

    <!-- Navigation Bar -->
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

    <!-- Search Results Section -->
    <div class="container mx-auto px-4 py-16">
        <?php
        if (isset($searchProduct)) {
            echo "<p class='text-red-600 font-bold'>$searchProduct</p>";
        }

        if (isset($product_details) && count($product_details) > 0) {
            echo "<h2 class='text-4xl font-extrabold text-center text-gray-800 mb-12'>Search Results</h2>";
        ?>
            <section id="products" class="py-16">
                <div class="container mx-auto">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
                        <?php
                        foreach ($product_details as $product) { ?>
                            <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                                <div class="relative">
                                    <img src="/images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="h-48 w-full object-cover rounded-t-lg">
                                </div>
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-gray-700 mb-2"><?php echo $product['name']; ?></h3>
                                    <p class="text-sm text-gray-500 mb-4"><?php echo $product['description']; ?></p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-lg font-bold text-blue-600"><?php echo '$' . number_format($product['price'], 2); ?></span>
                                    </div>
                                </div>
                                <div class="px-16 pb-6">
                                    <a href="productdetail.php?id=<?php echo $product['product_id']; ?>" class="block bg-gray-500 text-white text-center py-1 px-4 rounded hover:bg-gray-600 transition-colors">View Detail</a>
                                </div>
                            </div>
                        <?php }
                        ?>
                    </div>
                </div>
            </section>

        <?php } else {
            echo "<p class='text-gray-600'>No products found matching your search criteria.</p>";
        }
        ?>
    </div>

</body>

</html>
