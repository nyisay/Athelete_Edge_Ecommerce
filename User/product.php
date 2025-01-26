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

$categoryFilter = "";
$priceFilter = "";
$filteredProducts = $products; // Default to showing all products

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    // Category and Price filters
    $categoryFilter = isset($_POST['category']) ? $_POST['category'] : '';
    $priceFilter = isset($_POST['price_range']) ? $_POST['price_range'] : '';

    $query = "SELECT products.*, categories.name AS category_name 
              FROM products 
              JOIN categories ON categories.category_id = products.category_id 
              WHERE 1=1";

    // Apply category filter if selected
    if ($categoryFilter) {
        $query .= " AND categories.name = :category";
    }

    // Apply price range filter
    if ($priceFilter) {
        $priceRange = explode('-', $priceFilter);
        $query .= " AND products.price BETWEEN :min_price AND :max_price";
    }

    // Prepare and execute the query with filters
    $stmt = $conn->prepare($query);

    if ($categoryFilter) {
        $stmt->bindParam(':category', $categoryFilter);
    }

    if ($priceFilter) {
        $stmt->bindParam(':min_price', $priceRange[0]);
        $stmt->bindParam(':max_price', $priceRange[1]);
    }

    $stmt->execute();
    $filteredProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

try {
    $sql = "SELECT * FROM categories";
    $stmt = $conn->query($sql);
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<?php include 'header.php'; ?>

<body class="bg-gray-100 font-poppins">

    <section id="products" class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-extrabold text-center text-gray-800 mb-12">Our Products</h2>

            <div class="flex flex-col lg:flex-row gap-10">
                <!-- Filter Form -->
                <div class="w-full lg:w-1/4 bg-white p-6 rounded-lg shadow-lg">
                    <form id="filter-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                        <h3 class="text-2xl font-semibold text-gray-800 mb-6">Filter Products</h3>

                        <!-- Category Filter -->
                        <div class="mb-8">
                            <h4 class="font-semibold text-gray-600 mb-4">Category</h4>
                            <?php foreach ($categories as $category) { ?>
                                <div class="flex items-center mb-2">
                                    <input type="radio" name="category" value="<?php echo $category['name']; ?>" class="form-radio text-blue-600 focus:ring-0" <?php echo ($category['name'] == $categoryFilter) ? 'checked' : ''; ?>>
                                    <label class="ml-2 text-gray-700"><?php echo $category['name']; ?></label>
                                </div>
                            <?php } ?>
                        </div>

                        <!-- Price Range Filter -->
                        <div class="mb-8">
                            <h4 class="font-semibold text-gray-600 mb-4">Price Range</h4>
                            <div class="space-y-3">
                                <div>
                                    <input type="radio" id="price_0_50" name="price_range" value="0-50" <?php echo ($priceFilter == '0-50') ? 'checked' : ''; ?> class="form-radio text-blue-600 focus:ring-0">
                                    <label for="price_0_50" class="text-gray-700">$0 - $50</label>
                                </div>
                                <div>
                                    <input type="radio" id="price_51_100" name="price_range" value="51-100" <?php echo ($priceFilter == '51-100') ? 'checked' : ''; ?> class="form-radio text-blue-600 focus:ring-0">
                                    <label for="price_51_100" class="text-gray-700">$51 - $100</label>
                                </div>
                                <div>
                                    <input type="radio" id="price_101_200" name="price_range" value="101-200" <?php echo ($priceFilter == '101-200') ? 'checked' : ''; ?> class="form-radio text-blue-600 focus:ring-0">
                                    <label for="price_101_200" class="text-gray-700">$101 - $200</label>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <button type="submit" name="save" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">Apply Filters</button>
                        <button type="button" id="reset-btn" class="w-full bg-gray-500 text-white py-2 mt-4 rounded-lg hover:bg-gray-600 transition">Reset Filters</button>
                    </form>
                </div>

                <!-- Product Grid -->
                <div class="w-full lg:w-3/4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        <?php
                        if (isset($filteredProducts) && !empty($filteredProducts)) {
                            foreach ($filteredProducts as $product) { ?>
                                <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow">
                                    <div class="relative">
                                        <img src="/images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="w-full h-80 object-cover rounded-t-lg">
                                    </div>
                                    <div class="p-4">
                                        <h3 class="text-lg font-bold text-gray-800 mb-2 truncate">
                                            <?php echo $product['name']; ?>
                                        </h3>
                                        <p class="text-blue-600 font-semibold text-lg mb-4">
                                            <?php echo '$' . number_format($product['price'], 2); ?>
                                        </p>
                                        <div class="flex justify-around items-center">
                                            <a href="productdetail.php?product_id=<?php echo $product['product_id']; ?>"
                                                class="bg-gray-500 text-white px-4 py-2 rounded-3xl hover:bg-gray-600 transition">
                                                Details
                                            </a>
                                            <a href="addCart.php?product_id=<?php echo $product['product_id']; ?>"
                                                class="bg-red-500 text-white px-4 py-2 rounded-3xl hover:bg-red-600 transition">
                                                Add to Cart
                                            </a>
                                        </div>
                                    </div>
                                </div>
                        <?php }
                        } else {
                            echo "<p class='text-center text-gray-500'>No products found for your filter criteria.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('reset-btn').addEventListener('click', function() {
            // Reset the form
            document.getElementById('filter-form').reset();

            // Optionally, refresh the page to clear any PHP filter variables
            window.location.href = window.location.pathname;
        });
    </script>

</body>

</html>