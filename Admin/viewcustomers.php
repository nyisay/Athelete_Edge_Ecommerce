<?php
require_once "database.php"; // Ensure this file contains your database connection.

if (!isset($_SESSION)) {
    session_start();
}

try {
    // SQL query to fetch customer details
    $sql = "
        SELECT 
            user_id AS customer_id,
            name AS customer_name,
            email AS customer_email,
            phone AS customer_phone,
            address AS customer_address,
            role
        FROM users
        WHERE role = 'customer'
        ORDER BY name ASC
    ";
    $stmt = $conn->query($sql);
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>View Customers</title>
</head>

<body class="bg-gray-100">

    <div class="flex">
        <!-- Sidebar -->
        <div class="bg-gray-800 text-white w-64 p-6 sticky top-0 h-screen">
            <h2 class="text-2xl font-bold mb-6">Admin Dashboard</h2>
            <nav>
                <ul class="space-y-4">
                    <li><a href="dashboard.php" class="block py-2 px-4 rounded hover:bg-yellow-600">Dashboard</a></li>
                    <li><a href="viewproduct.php" class="block py-2 px-4 rounded bg-yellow-600">View Products</a></li>
                    <li><a href="insertproduct.php" class="block py-2 px-4 rounded hover:bg-yellow-600">Add New Product</a></li>
                    <li><a href="vieworder.php" class="block py-2 px-4 rounded hover:bg-yellow-600">View Orders</a></li>
                    <li><a href="viewcustomers.php" class="block py-2 px-4 rounded hover:bg-yellow-600">Manage Customers</a></li>
                    <li><a href="reports.php" class="block py-2 px-4 rounded hover:bg-yellow-600">Reports</a></li>
                    <li><a href="logout.php" class="block py-2 px-4 rounded hover:bg-yellow-600">Logout</a></li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="container mx-auto p-6 flex-1">
            <div class="flex items-center mb-4">
                <img src="/images//logoedit.png" alt="Logo" class="h-10 w-10 mr-2">
                <h1 class="text-2xl font-bold text-gray-800">All Customer</h1>
            </div>

            <!-- Show session message if exists -->
            <?php if (isset($_SESSION['status_message'])) : ?>
                <div class="bg-green-500 text-white p-4 rounded-md mb-4">
                    <?php
                    echo $_SESSION['status_message'];
                    unset($_SESSION['status_message']); // Clear the message after showing it
                    ?>
                </div>
            <?php endif; ?>

            <div class="bg-white shadow-md rounded-lg p-6">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg table-auto">
                    <thead>
                        <tr class="bg-gray-600 text-white">
                            <th class="py-3 px-4 border-b text-left">Customer ID</th>
                            <th class="py-3 px-4 border-b text-left">Name</th>
                            <th class="py-3 px-4 border-b text-left">Email</th>
                            <th class="py-3 px-4 border-b text-left">Phone</th>
                            <th class="py-3 px-4 border-b text-left">Address</th>
                            <th class="py-3 px-4 border-b text-left">Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($customers)) : ?>
                            <?php foreach ($customers as $customer) : ?>
                                <tr>
                                    <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($customer['customer_id']); ?></td>
                                    <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($customer['customer_name']); ?></td>
                                    <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($customer['customer_email']); ?></td>
                                    <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($customer['customer_phone']); ?></td>
                                    <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($customer['customer_address']); ?></td>
                                    <td class="py-3 px-4 border-b capitalize"><?php echo htmlspecialchars($customer['role']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="py-3 px-4 text-center">No customers found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>