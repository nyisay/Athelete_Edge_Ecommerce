<?php
// Include database connection
include('database.php');

// Fetch total products
$query_products = "SELECT COUNT(*) AS total_products FROM products";
$result_products = mysqli_query($conn, $query_products);
$row_products = mysqli_fetch_assoc($result_products);
$total_products = $row_products['total_products'];

// Fetch total orders
$query_orders = "SELECT COUNT(*) AS total_orders FROM orders";
$result_orders = mysqli_query($conn, $query_orders);
$row_orders = mysqli_fetch_assoc($result_orders);
$total_orders = $row_orders['total_orders'];

// Fetch total customers
$query_customers = "SELECT COUNT(*) AS total_customers FROM users WHERE role='customer'";
$result_customers = mysqli_query($conn, $query_customers);
$row_customers = mysqli_fetch_assoc($result_customers);
$total_customers = $row_customers['total_customers'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Admin Dashboard</title>
</head>
<body class="bg-gray-100 min-h-screen">

    <div class="flex">
        <!-- Sidebar -->
        <div class="bg-indigo-500 text-white w-64 p-6">
            <h2 class="text-2xl font-bold mb-6">Admin Dashboard</h2>
            <nav>
                <ul class="space-y-4">
                    <li><a href="admin_dashboard.php" class="block py-2 px-4 rounded bg-indigo-600">Dashboard</a></li>
                    <li><a href="viewproducts.php" class="block py-2 px-4 rounded hover:bg-indigo-600">View Products</a></li>
                    <li><a href="insertproduct.php" class="block py-2 px-4 rounded hover:bg-indigo-600">Add New Product</a></li>
                    <li><a href="vieworder.php" class="block py-2 px-4 rounded hover:bg-indigo-600">View Orders</a></li>
                    <li><a href="viewcustomers.php" class="block py-2 px-4 rounded hover:bg-indigo-600">Manage Customers</a></li>
                    <li><a href="reports.php" class="block py-2 px-4 rounded hover:bg-indigo-600">Reports</a></li>
                    <li><a href="logout.php" class="block py-2 px-4 rounded hover:bg-indigo-600">Logout</a></li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="container mx-auto p-6 flex-1">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Total Products -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800">Total Products</h3>
                    <p class="text-3xl font-bold text-indigo-600"><?php echo $total_products; ?></p>
                </div>

                <!-- Total Orders -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800">Total Orders</h3>
                    <p class="text-3xl font-bold text-indigo-600"><?php echo $total_orders; ?></p>
                </div>

                <!-- Total Customers -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800">Total Customers</h3>
                    <p class="text-3xl font-bold text-indigo-600"><?php echo $total_customers; ?></p>
                </div>
            </div>

            <!-- Additional Info Section -->
            <div class="mt-8">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">Recent Orders</h3>
                <!-- Fetch and display recent orders -->
                <?php
                $query_recent_orders = "SELECT * FROM orders ORDER BY order_date DESC LIMIT 5";
                $result_recent_orders = mysqli_query($conn, $query_recent_orders);
                while ($order = mysqli_fetch_assoc($result_recent_orders)) {
                    echo "<div class='bg-white p-4 mb-4 rounded-lg shadow-md'>";
                    echo "<p class='text-gray-700'><strong>Order ID:</strong> " . $order['id'] . "</p>";
                    echo "<p class='text-gray-700'><strong>User ID:</strong> " . $order['user_id'] . "</p>";
                    echo "<p class='text-gray-700'><strong>Status:</strong> " . ucfirst($order['status']) . "</p>";
                    echo "<p class='text-gray-700'><strong>Total Amount:</strong> $" . number_format($order['total_amount'], 2) . "</p>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>

</body>
</html>
