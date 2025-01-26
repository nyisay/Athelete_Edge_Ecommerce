<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .widget {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .chart-container {
            height: 300px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        ul li {
            font-size: 16px;
            color: #555;
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <h1>E-Commerce Dashboard</h1>

    <div class="dashboard">
        <!-- Revenue Widget -->
        <div class="widget">
            <h2>Total Revenue</h2>
            <p class="text-2xl font-bold text-green-600">$<span id="totalRevenue">0</span></p>
        </div>

        <!-- Orders Line Chart -->
        <div class="widget chart-container">
            <h2>Orders Trend</h2>
            <canvas id="ordersTrendChart"></canvas>
        </div>

        <!-- Payment Methods Pie Chart -->
        <div class="widget chart-container">
            <h2>Payment Methods</h2>
            <canvas id="paymentMethodsChart"></canvas>
        </div>

        <!-- Top Products -->
        <div class="widget">
            <h2>Top Products</h2>
            <ul id="topProductsList"></ul>
        </div>
    </div>

    <script>
        // Example data (replace with data from your PHP backend)
        const totalRevenue = 12000.50; // Replace with actual revenue
        const ordersTrendData = [
            { date: "2023-01", total_orders: 30 },
            { date: "2023-02", total_orders: 45 },
            { date: "2023-03", total_orders: 50 },
        ];
        const paymentMethodsData = [
            { payment_method: "Credit Card", total_orders: 120 },
            { payment_method: "PayPal", total_orders: 80 },
            { payment_method: "Bank Transfer", total_orders: 40 },
        ];
        const topProducts = [
            { name: "Running Shoes", total_sold: 120 },
            { name: "Fitness Tracker", total_sold: 95 },
            { name: "Yoga Mat", total_sold: 85 },
        ];

        // Update total revenue
        document.getElementById("totalRevenue").textContent = totalRevenue.toFixed(2);

        // Orders Trend Chart
        const ordersLabels = ordersTrendData.map(item => item.date);
        const ordersValues = ordersTrendData.map(item => item.total_orders);
        new Chart(document.getElementById("ordersTrendChart"), {
            type: "line",
            data: {
                labels: ordersLabels,
                datasets: [{
                    label: "Orders",
                    data: ordersValues,
                    borderColor: "#007bff",
                    backgroundColor: "rgba(0, 123, 255, 0.2)",
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true },
                    x: { title: { display: true, text: "Month" } },
                }
            }
        });

        // Payment Methods Pie Chart
        const paymentLabels = paymentMethodsData.map(item => item.payment_method);
        const paymentValues = paymentMethodsData.map(item => item.total_orders);
        new Chart(document.getElementById("paymentMethodsChart"), {
            type: "pie",
            data: {
                labels: paymentLabels,
                datasets: [{
                    data: paymentValues,
                    backgroundColor: ["#28a745", "#ffc107", "#17a2b8"]
                }]
            },
            options: {
                responsive: true,
            }
        });

        // Top Products List
        const topProductsList = document.getElementById("topProductsList");
        topProducts.forEach(product => {
            const li = document.createElement("li");
            li.textContent = `${product.name}: ${product.total_sold} sold`;
            topProductsList.appendChild(li);
        });
    </script>
</body>

</html>
