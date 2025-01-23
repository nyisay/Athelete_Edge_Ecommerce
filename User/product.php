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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
</head>

<?php include 'header.php'; ?>

<body class="bg-[url('../images/background.png')] bg-cover bg-center bg-no-repeat backdrop-blur-lg shadow-lg">

    <section id="products" class="py-16">
        <div class="container mx-auto">
            <h2 class="text-4xl font-extrabold text-center text-gray-800 mb-12">Products</h2>

            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Filter Form -->
                <div class="w-3/4 lg:w-1/6 p-6 rounded-lg shadow-md backdrop-blur-sm">
                    <form id="filter-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                        <h3 class="text-xl font-semibold mb-4">Filter Products</h3>

                        <!-- Category Filter -->
                        <div class="mb-6">
                            <h4 class="font-medium text-gray-700 mb-2">Category</h4>
                            <?php foreach ($categories as $category) { ?>
                                <div class="flex items-center mb-2">
                                    <input type="radio" name="category" value="<?php echo $category['name']; ?>" class="form-check-input" <?php echo ($category['name'] == $categoryFilter) ? 'checked' : ''; ?>>
                                    <label for="form-check-label" class="ml-2"><?php echo $category['name']; ?></label>
                                </div>
                            <?php } ?>
                        </div>

                        <!-- Price Range Filter -->
                        <div class="mb-6">
                            <h4 class="font-medium text-gray-700 mb-2">Price Range</h4>
                            <div class="flex gap-4">
                                <div>
                                    <input type="radio" id="price_0_50" name="price_range" value="0-50" <?php echo ($priceFilter == '0-50') ? 'checked' : ''; ?> class="form-check-input">
                                    <label for="price_0_50">$0 - $50</label>
                                </div>
                                <div>
                                    <input type="radio" id="price_51_100" name="price_range" value="51-100" <?php echo ($priceFilter == '51-100') ? 'checked' : ''; ?> class="form-check-input">
                                    <label for="price_51_100">$51 - $100</label>
                                </div>
                                <div>
                                    <input type="radio" id="price_101_200" name="price_range" value="101-200" <?php echo ($priceFilter == '101-200') ? 'checked' : ''; ?> class="form-check-input">
                                    <label for="price_101_200">$101 - $200</label>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Apply Button -->
                        <button type="submit" name="save" class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700 mb-4">Apply Filters</button>

                        <!-- Reset Button with JavaScript -->
                        <button type="button" id="reset-btn" class="w-full bg-gray-500 text-white py-2 rounded hover:bg-gray-600">Reset Filters</button>
                    </form>
                </div>

                <!-- Product Grid -->
                <div class="w-full lg:w-3/4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        <?php
                        if (isset($filteredProducts) && !empty($filteredProducts)) {
                            foreach ($filteredProducts as $product) { ?>
                                <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex flex-col h-full">
                                    <div class="relative">
                                        <img src="/images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="w-full h-80 object-cover rounded-t-lg">
                                    </div>
                                    <div class="p-6 flex-1">
                                        <h3 class="text-xl font-bold text-gray-700 mb-2 h-14 overflow-hidden">
                                            <?php echo $product['name']; ?>
                                        </h3>
                                        <div class="flex items-center justify-between">
                                            <span class="text-lg font-bold text-blue-600"><?php echo '$' . number_format($product['price'], 2); ?></span>
                                        </div>
                                    </div>
                                    <div class="px-6 pb-6 mt-auto">
                                        <a href="productdetail.php?product_id=<?php echo $product['product_id']; ?>" class="block bg-gray-500 text-white text-center py-1 px-4 rounded hover:bg-gray-600 transition-color mb-2">View Detail</a>
                                        <a href="addCart.php?product_id=<?php echo $product['product_id']; ?>" class="block bg-gray-500 text-white text-center py-1 px-4 rounded hover:bg-gray-600 transition-colors">Add to Cart</a>
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