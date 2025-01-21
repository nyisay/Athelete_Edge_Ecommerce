<?php
require_once "database.php";

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    try {
        $sql = "SELECT * FROM products WHERE product_id = :product_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['product_id' => $product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    if (isset($_POST['update'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $category_id = $_POST['categories'];
        $filename = $_FILES['image']['name'];
        $filename2 = $_FILES['second_image']['name'];
        $filename3 = $_FILES['third_image']['name'];
        $filename4 = $_FILES['fourth_image']['name'];
        $filename5 = $_FILES['fifth_image']['name'];

        $uploadPath = $filename ? "../images/" . $filename : $product['image'];
        echo $uploadPath;
        if ($filename) {
            move_uploaded_file($_FILES["image"]["tmp_name"], $uploadPath);
        }

        $uploadPath2 = $filename2 ? "../images/" . $filename2 : $product['second_image'];
        echo $uploadPath2;
        if ($filename) {
            move_uploaded_file($_FILES["second_image"]["tmp_name"], $uploadPath2);
        }

        $uploadPath3 = $filename3 ? "../images/" . $filename3 : $product['third_image'];
        echo $uploadPath3;
        if ($filename) {
            move_uploaded_file($_FILES["third_image"]["tmp_name"], $uploadPath3);
        }

        $uploadPath4 = $filename4 ? "../images/" . $filename4 : $product['fourth_image'];
        echo $uploadPath4;
        if ($filename) {
            move_uploaded_file($_FILES["fourth_image"]["tmp_name"], $uploadPath4);
        }

        $uploadPath5 = $filename5 ? "../images/" . $filename5 : $product['fifth_image'];
        echo $uploadPath5;
        if ($filename) {
            move_uploaded_file($_FILES["fifth_image"]["tmp_name"], $uploadPath5);
        }

        try {
            $sql = "UPDATE products
                    SET name = :name, description = :description, price = :price, quantity = :quantity, 
                        category_id = :category_id, image = :image, second_image = :second_image, 
                        third_image = :third_image, fourth_image = :fourth_image, fifth_image = :fifth_image
                     WHERE product_id = :product_id";
            $stmt2 = $conn->prepare($sql);
            $status2 = $stmt2->execute([
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'quantity' => $quantity,
                'category_id' => $category_id,
                'image' => $uploadPath,
                'second_image' => $uploadPath2,
                'third_image' => $uploadPath3,
                'fourth_image' => $uploadPath4,
                'fifth_image' => $uploadPath5,
                'product_id' => $product['product_id']
            ]);

            if ($status2) {
                $_SESSION['updateSuccess'] = 'Product has been successfully updated.';
                header("Location: viewproduct.php");
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
} else {
    echo "Product ID is missing.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Update Product</title>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-lg">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">Update Product</h1>
        <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>?product_id=<?= $product_id ?>" class="space-y-4" enctype="multipart/form-data">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                <input type="text" id="name" name="name" value="<?= $product['name'] ?>" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="4" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm"><?= $product['description'] ?></textarea>
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Price ($)</label>
                <input type="number" id="price" name="price" step="0.01" value="<?= $product['price'] ?>" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                <input type="number" id="quantity" name="quantity" value="<?= $product['quantity'] ?>" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label for="categories" class="block text-sm font-medium text-gray-700">Category</label>
                <select id="categories" name="categories" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                    <option value="" disabled>Select Category</option>
                    <?php
                    try {
                        $sql = "SELECT * FROM categories";
                        $stmt = $conn->query($sql);
                        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($categories as $category) {
                            $selected = $category['category_id'] === $product['category_id'] ? 'selected' : '';
                            echo "<option value=" . $category['category_id'] . " $selected>{$category['name']}</option>";
                        }
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                    ?>
                </select>
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Product Image</label>
                <input type="file" id="image" name="image" accept="image/*"
                    class="mt-1 block w-full text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm">
                <p class="mt-2 text-sm text-gray-600">Current Image: <?= basename($product['image']) ?></p>
            </div>
            <div>
                <label for="second_image" class="block text-sm font-medium text-gray-700">Product Image</label>
                <input type="file" id="second_image" name="second_image" accept="image/*"
                    class="mt-1 block w-full text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm">
                <p class="mt-2 text-sm text-gray-600">Current Image: <?= basename($product['second_image']) ?></p>
            </div>
            <div>
                <label for="third_image" class="block text-sm font-medium text-gray-700">Product Image</label>
                <input type="file" id="third_image" name="third_image" accept="image/*"
                    class="mt-1 block w-full text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm">
                <p class="mt-2 text-sm text-gray-600">Current Image: <?= basename($product['third_image']) ?></p>
            </div>
            <div>
                <label for="fourth_image" class="block text-sm font-medium text-gray-700">Product Image</label>
                <input type="file" id="fourth_image" name="fourth_image" accept="image/*"
                    class="mt-1 block w-full text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm">
                <p class="mt-2 text-sm text-gray-600">Current Image: <?= basename($product['fourth_image']) ?></p>
            </div>
            <div>
                <label for="fifth_image" class="block text-sm font-medium text-gray-700">Product Image</label>
                <input type="file" id="fifth_image" name="fifth_image" accept="image/*"
                    class="mt-1 block w-full text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm">
                <p class="mt-2 text-sm text-gray-600">Current Image: <?= basename($product['fifth_image']) ?></p>
            </div>

            <button type="submit" name="update"
                class="w-full bg-indigo-500 text-white py-2 px-4 rounded-md shadow hover:bg-indigo-600">
                Update Product
            </button>
        </form>
    </div>
</body>

</html>