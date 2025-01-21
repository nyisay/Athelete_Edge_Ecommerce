<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-4xl bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Order Details</h1>

        <!-- Customer Details -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Customer Information</h2>
            <form class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <input type="text" placeholder="Full Name" class="border rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="email" placeholder="Email Address" class="border rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="tel" placeholder="Phone Number" class="border rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="text" placeholder="Shipping Address" class="border rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </form>
        </div>

        <form action="ordercomplete.php" method="POST" >
        <!-- Order Summary -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Order Summary</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border-b">Product</th>
                            <th class="px-4 py-2 border-b">Quantity</th>
                            <th class="px-4 py-2 border-b">Price</th>
                            <th class="px-4 py-2 border-b">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example row -->
                        <tr>
                            <td class="px-4 py-2 border-b">Running Shoes</td>
                            <td class="px-4 py-2 border-b">1</td>
                            <td class="px-4 py-2 border-b">$120</td>
                            <td class="px-4 py-2 border-b">$120</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 border-b">Yoga Mat</td>
                            <td class="px-4 py-2 border-b">2</td>
                            <td class="px-4 py-2 border-b">$30</td>
                            <td class="px-4 py-2 border-b">$60</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Total Amount -->
        <div class="flex justify-between items-center mb-6">
            <span class="text-lg font-medium">Total Amount:</span>
            <span class="text-xl font-bold text-green-600">$180</span>
        </div>

        <!-- Submit Button -->
        <div class="text-right">
           
                <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">Place Order</button>
            
        </div>
        </form>
    </div>
</body>

</html>