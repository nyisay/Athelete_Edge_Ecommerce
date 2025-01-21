<?php
require_once "database.php";
if (!isset($_SESSION)) {
    session_start();
}

try {
    $sql = "SELECT products.product_id, products.name, products.description, products.price, products.quantity, products.image, 
    categories.name AS category_name FROM products INNER JOIN categories ON products.category_id = categories.category_id";
    $stmt = $conn->query($sql);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>View Products</title>
</head>

<body class="bg-gray-100 flex">
    <!-- Sidebar -->
    <div class="bg-indigo-500 text-white w-64 p-6">
        <h2 class="text-2xl font-bold mb-6">Admin Dashboard</h2>
        <nav>
            <ul class="space-y-4">
                <li><a href="dashboard.php" class="block py-2 px-4 rounded hover:bg-indigo-600">Dashboard</a></li>
                <li><a href="viewproducts.php" class="block py-2 px-4 rounded bg-indigo-600">View Products</a></li>
                <li><a href="insertproduct.php" class="block py-2 px-4 rounded hover:bg-indigo-600">Add New Product</a></li>
                <li><a href="vieworder.php" class="block py-2 px-4 rounded hover:bg-indigo-600">View Orders</a></li>
                <li><a href="customers.php" class="block py-2 px-4 rounded hover:bg-indigo-600">Manage Customers</a></li>
                <li><a href="reports.php" class="block py-2 px-4 rounded hover:bg-indigo-600">Reports</a></li>
                <li><a href="logout.php" class="block py-2 px-4 rounded hover:bg-indigo-600">Logout</a></li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-6">
        <div class="bg-white shadow-md rounded-lg p-6 w-full">
            <h1 class="text-2xl font-bold mb-4 text-gray-800">Product List</h1>

            <?php if (isset($_SESSION['insertSuccess'])): ?>
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                    <?php
                    echo $_SESSION['insertSuccess'];
                    unset($_SESSION['insertSuccess']);
                    ?>
                </div>
            <?php endif; ?>

            <table class="min-w-full bg-white border border-gray-300 rounded-lg table-auto">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-3 px-4 border-b text-left">ID</th>
                        <th class="py-3 px-4 border-b text-left">Name</th>
                        <th class="py-3 px-4 border-b text-left">Description</th>
                        <th class="py-3 px-4 border-b text-center">Price ($)</th>
                        <th class="py-3 px-4 border-b text-center">Quantity</th>
                        <th class="py-3 px-4 border-b text-left">Category</th>
                        <th class="py-3 px-4 border-b text-center">Image</th>
                        <th class="py-3 px-4 border-b text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td class="py-3 px-4 border-b text-center"><?php echo htmlspecialchars($product['product_id']); ?></td>
                                <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($product['name']); ?></td>
                                <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($product['description']); ?></td>
                                <td class="py-3 px-4 border-b text-center"><?php echo htmlspecialchars($product['price']); ?></td>
                                <td class="py-3 px-4 border-b text-center"><?php echo htmlspecialchars($product['quantity']); ?></td>
                                <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($product['category_name']); ?></td>
                                <td class="py-3 px-4 border-b text-center">
                                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image" class="h-16 w-16 object-cover rounded">
                                </td>
                                <td class="py-3 px-4 border-b text-center space-y-2">
                                    <a href="updateproduct.php?product_id=<?= $product['product_id'] ?>" class="inline-block bg-indigo-500 text-white py-2 px-4 rounded-md shadow hover:bg-indigo-600 focus:outline-none">Update</a>
                                    <a href="delete.php?product_id=<?= $product['product_id'] ?>" class="inline-block bg-red-500 text-white py-2 px-4 rounded-md shadow hover:bg-red-600 focus:outline-none">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="py-3 px-4 text-center">No products found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>

