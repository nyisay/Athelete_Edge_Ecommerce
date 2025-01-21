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
            order_items.product_id,
            products.name AS product_name,
            products.price AS product_price,
            order_items.quantity
        FROM orders
        INNER JOIN users ON orders.user_id = users.user_id
        INNER JOIN payment_method ON orders.payment_method_id = payment_method.payment_method_id
        INNER JOIN order_items ON orders.order_id = order_items.order_id
        INNER JOIN products ON order_items.product_id = products.product_id
        ORDER BY orders.order_date DESC
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
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">All Orders</h1>

        <div class="bg-white shadow-md rounded-lg p-6 w-full">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg table-auto">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-3 px-4 border-b text-left">Order ID</th>
                        <th class="py-3 px-4 border-b text-left">Customer</th>
                        <th class="py-3 px-4 border-b text-left">Email</th>
                        <th class="py-3 px-4 border-b text-left">Order Date</th>
                        <th class="py-3 px-4 border-b text-left">Status</th>
                        <th class="py-3 px-4 border-b text-left">Payment Method</th>
                        <th class="py-3 px-4 border-b text-left">Product</th>
                        <th class="py-3 px-4 border-b text-left">Price</th>
                        <th class="py-3 px-4 border-b text-left">Quantity</th>
                        <th class="py-3 px-4 border-b text-left">Total</th>
                        <th class="py-3 px-4 border-b text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($order['order_id']); ?></td>
                                <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($order['customer_email']); ?></td>
                                <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($order['order_date']); ?></td>
                                <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($order['status']); ?></td>
                                <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($order['payment_name']); ?></td>
                                <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($order['product_name']); ?></td>
                                <td class="py-3 px-4 border-b">$<?php echo htmlspecialchars($order['product_price']); ?></td>
                                <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($order['quantity']); ?></td>
                                <td class="py-3 px-4 border-b">$<?php echo htmlspecialchars($order['product_price'] * $order['quantity']); ?></td>
                                <td class="py-3 px-4 border-b text-center">
                                    <form action="update_status.php" method="POST">
                                        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                        <button type="submit" name="approve_order" class="bg-green-500 text-white py-2 px-4 rounded-md shadow hover:bg-green-600 focus:outline-none">Approve</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="11" class="py-3 px-4 text-center">No orders found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>
    </div>
</body>

</html>