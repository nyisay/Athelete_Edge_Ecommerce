<?php
session_start(); // Starting session at the beginning
require_once "database.php";

try {
    // Fetch all products from the products table
    $sql = "SELECT * FROM products";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['products'] = $products;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$searchProduct = "";
$product_details = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    if (!empty($_POST['search'])) {
        $search = htmlspecialchars($_POST['search']);  // Sanitize user input

        // Fix the SQL to join products with categories by category_id and get the category name
        $stmt = $conn->prepare("SELECT products.*, categories.name AS category_name FROM products JOIN categories ON categories.category_id = products.category_id   WHERE products.name LIKE :search OR categories.name LIKE :search OR products.price LIKE :search");
        $stmt->execute([':search' => '%' . $search . '%']);
        $product_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $searchProduct = "Please enter a product name or category.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
</head>

<body class="bg-[url('../images/background.png')] bg-cover bg-center bg-no-repeat backdrop-blur-lg shadow-lg">
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
            </nav>

            <form action="search_results.php" method="POST" class="flex items-center space-x-2">
                <input type="text" name="query" placeholder="Search products..." class="px-4 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-red-600 transition">
                <button  type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                    Search
                </button>
            </form>

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

    <!-- <form method="POST" class="px-4 py-4">
        <input type="text" name="search" placeholder="Enter product name, category or price" required class="px-4 py-2 border border-gray-300 rounded">
        <button type="submit" name="save" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">Search</button>
    </form>

    <?php
    if (isset($searchProduct)) {
        echo "<p>$searchProduct</p>";
    }
    ?> -->

    <section id="products" class="py-16">
        <div class="container mx-auto">
            <h2 class="text-4xl font-extrabold text-center text-gray-800 mb-12">Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
                <?php
                if (isset($products)) {
                    foreach ($products as $product) { ?>
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
                                <a href="productdetail.php" class="block bg-gray-500 text-white text-center py-1 px-4 rounded hover:bg-gray-600 transition-colors">View Detail</a>
                            </div>
                        </div>
                <?php }
                } ?>
            </div>
        </div>
    </section>
</body>
</html>
