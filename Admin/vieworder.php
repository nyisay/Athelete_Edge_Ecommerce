    <?php
    require_once "database.php";
    if (!isset($_SESSION)) {
        session_start();
    }

    try {
        // SQL to fetch all orders with related details
        $sql = "
                    SELECT 
                orders.order_id AS order_id, 
                users.name AS customer_name, 
                users.email AS customer_email,
                orders.order_date,
                orders.status,
                orders.total_amount,
                payment_method.payment_name,
                GROUP_CONCAT(
                    CONCAT(products.name, ' (', order_items.quantity, ' x $', products.price, ')')
                    SEPARATOR ', '
                ) AS product_details
            FROM orders
            INNER JOIN users ON orders.user_id = users.user_id
            INNER JOIN payment_method ON orders.payment_method_id = payment_method.payment_method_id
            INNER JOIN order_items ON orders.order_id = order_items.order_id
            INNER JOIN products ON order_items.product_id = products.product_id
            GROUP BY orders.order_id
            ORDER BY orders.order_date DESC;
        ";
        $stmt = $conn->query($sql);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>View All Orders</title>
</head>

<body class="bg-gray-100">
    <div class="flex flex-col md:flex-row">
        <!-- Sidebar -->
        <div class="bg-gray-800 text-white w-full md:w-64 p-6 md:h-screen">
            <h2 class="text-2xl font-bold mb-6">Admin Dashboard</h2>
            <nav>
                <ul class="space-y-4">
                    <li><a href="dashboard.php" class="block py-2 px-4 rounded hover:bg-yellow-600">Dashboard</a></li>
                    <li><a href="viewproduct.php" class="block py-2 px-4 rounded hover:bg-yellow-600">View Products</a></li>
                    <li><a href="insertproduct.php" class="block py-2 px-4 rounded hover:bg-yellow-600">Add New Product</a></li>
                    <li><a href="vieworder.php" class="block py-2 px-4 rounded bg-yellow-600">View Orders</a></li>
                    <li><a href="viewcustomers.php" class="block py-2 px-4 rounded hover:bg-yellow-600">Manage Customers</a></li>
                    <li><a href="reports.php" class="block py-2 px-4 rounded hover:bg-yellow-600">Reports</a></li>
                    <li><a href="logout.php" class="block py-2 px-4 rounded hover:bg-yellow-600">Logout</a></li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <h1 class="text-2xl font-bold mb-4 text-gray-800">All Orders</h1>

            <!-- Display session message -->
            <?php if (isset($_SESSION['status_message'])) : ?>
                <div class="bg-green-500 text-white p-4 rounded-md mb-4">
                    <?php
                    echo $_SESSION['status_message'];
                    unset($_SESSION['status_message']); // Clear the session message after displaying
                    ?>
                </div>
            <?php endif; ?>

            <div class="bg-white shadow-md rounded-lg p-6 w-full">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg table-auto">
                    <thead>
                        <tr class="bg-gray-600 text-white">
                            <th class="py-3 px-4 border-b text-left">Order ID</th>
                            <th class="py-3 px-4 border-b text-left">Customer</th>
                            <th class="py-3 px-4 border-b text-left">Email</th>
                            <th class="py-3 px-4 border-b text-left">Order Date</th>
                            <th class="py-3 px-4 border-b text-left">Payment Method</th>
                            <th class="py-3 px-4 border-b text-left">Product</th>
                            <th class="py-3 px-4 border-b text-left">Total</th>
                            <th class="py-3 px-4 border-b text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($orders)) : ?>
                            <?php foreach ($orders as $order) : ?>
                                <tr>
                                    <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($order['order_id']); ?></td>
                                    <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                    <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($order['customer_email']); ?></td>
                                    <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($order['order_date']); ?></td>
                                    <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($order['payment_name']); ?></td>
                                    <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($order['product_details']); ?></td>
                                    <td class="py-3 px-4 border-b">$<?php echo htmlspecialchars($order['total_amount']); ?></td>
                                    <td class="py-3 px-4 border-b text-center">
                                        <?php if ($order['status'] == 'cancelled') : ?>
                                            <p class="text-red-600 font-semibold">Cancelled</p>
                                        <?php elseif ($order['status'] == 'approved') : ?>
                                            <p class="text-green-600 font-semibold">Approved</p>
                                        <?php else : ?>
                                            <div class="flex justify-center space-x-4">
                                                <form action="update_status.php" method="POST">
                                                    <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                                    <button type="submit" name="approve_order" class="bg-green-500 text-white py-2 px-4 rounded-md shadow hover:bg-green-600 focus:outline-none">Approve</button>
                                                </form>
                                                <form action="update_status.php" method="POST">
                                                    <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                                    <button type="submit" name="cancel_order" class="bg-red-500 text-white py-2 px-4 rounded-md shadow hover:bg-red-600 focus:outline-none">Cancel</button>
                                                </form>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="8" class="py-3 px-4 text-center">No orders found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
