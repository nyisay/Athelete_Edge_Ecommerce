<?php
require_once "database.php";

if (!isset($_SESSION)) {
    session_start();
}

try {
    // Fetch all categories
    $sql = "SELECT * FROM categories";
    $stmt = $conn->query($sql);
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching categories: " . $e->getMessage();
    exit;
}

if (isset($_POST['insert'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $category_id = $_POST['categories'];

    // Handle file upload
    $filename = $_FILES['image']['name'];
    $uploadPath = "../images/" . $filename;
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $uploadPath)) {
        echo "Error uploading the file.";
        exit;
    }

    $filename2 = $_FILES['second_image']['name'];
    $uploadPath2 = "../images/" . $filename;
    if (!move_uploaded_file($_FILES["second_image"]["tmp_name"], $uploadPath2)) {
        echo "Error uploading the file.";
        exit;
    }

    $filename2 = $_FILES['third_image']['name'];
    $uploadPath3 = "../images/" . $filename;
    if (!move_uploaded_file($_FILES["third_image"]["tmp_name"], $uploadPath3)) {
        echo "Error uploading the file.";
        exit;
    }

    $filename2 = $_FILES['fourth_image']['name'];
    $uploadPath4 = "../images/" . $filename;
    if (!move_uploaded_file($_FILES["fourth_image"]["tmp_name"], $uploadPath4)) {
        echo "Error uploading the file.";
        exit;
    }

    $filename2 = $_FILES['fifth_image']['name'];
    $uploadPath5 = "../images/" . $filename;
    if (!move_uploaded_file($_FILES["fifth_image"]["tmp_name"], $uploadPath5)) {
        echo "Error uploading the file.";
        exit;
    }

    try {
        // Insert product into the database
        $sql = "INSERT INTO products (name, description, price, quantity, category_id, image, second_image, third_image, fourth_image, fifth_image) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $status = $stmt->execute([$name, $description, $price, $quantity, $category_id, $uploadPath, $uploadPath2, $uploadPath3, $uploadPath4, $uploadPath5]);

        if ($status) {
            $_SESSION['insertSuccess'] = 'Product has been successfully added.';
            header("Location: viewproduct.php");
            exit; // Exit after redirection
        } else {
            echo "Failed to insert the product.";
        }
    } catch (PDOException $e) {
        echo "Error inserting product: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Insert Products</title>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-lg">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">Add New Product</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" 
              class="space-y-4" enctype="multipart/form-data">
            <!-- Product Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                <input type="text" id="name" name="name" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="4" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>

            <!-- Price -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Price ($)</label>
                <input type="number" id="price" name="price" step="0.01" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Quantity -->
            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                <input type="number" id="quantity" name="quantity" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Category -->
            <div>
                <label for="categories" class="block text-sm font-medium text-gray-700">Category</label>
                <select id="categories" name="categories" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="" selected disabled>Choose Category</option>
                    <?php
                    if (isset($categories)) {
                        foreach ($categories as $category) {
                            echo "<option value='{$category['category_id']}'>{$category['name']}</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <!-- Image -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Product Image</label>
                <input type="file" id="image" name="image" accept="image/*" required
                    class="mt-1 block w-full text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Product Image</label>
                <input type="file" id="second_image" name="second_image" accept="image/*" required
                    class="mt-1 block w-full text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Product Image</label>
                <input type="file" id="third_image" name="third_image" accept="image/*" required
                    class="mt-1 block w-full text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Product Image</label>
                <input type="file" id="fourth_image" name="fourth_image" accept="image/*" required
                    class="mt-1 block w-full text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Product Image</label>
                <input type="file" id="fifth_image" name="fifth_image" accept="image/*" required
                    class="mt-1 block w-full text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Submit Button -->
            <button type="submit" name="insert"
                class="w-full bg-indigo-500 text-white py-2 px-4 rounded-md shadow hover:bg-indigo-600">
                Add Product
            </button>
        </form>
    </div>
</body>
</html>



