<?php
if (!isset($_SESSION)) {
    session_start();
}
// Get the user ID from the session
$user_id = $_SESSION['user_id'] ?? "";
?>


<header class="bg-white/30 backdrop-blur-lg shadow-lg">
    <div class="container mx-auto px-4 py-4 flex flex-row justify-between items-center z-0">
        <!-- Logo -->
        <a href="home.php" class="flex items-center">
            <img src="/images/logoedit.png" alt="Logo" class="h-12 w-12 mr-3">
        </a>

        <!-- Navigation Links -->
        <nav class="flex flex-row space-x-6 items-center">
            <a href="home.php" class="text-gray-800 hover:text-red-600 transition">Home</a>
            <a href="about.php" class="text-gray-800 hover:text-red-600 transition">About</a>
            <a href="product.php" class="text-gray-800 hover:text-red-600 transition">Products</a>
            <a href="review.php" class="text-gray-800 hover:text-red-600 transition">Review</a>

            <!-- Search Bar -->
            <form action="search_results.php" method="POST" class="flex items-center space-x-2">
                <div class="relative flex items-center">
                    <!-- Search Icon -->
                    <i class="fa-solid fa-magnifying-glass absolute left-3 text-gray-400"></i>
                    <!-- Search Input -->
                    <input
                        type="text"
                        name="search"
                        placeholder="Search products..."
                        class="pl-10 px-4 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-red-600 transition">
                </div>
                <!-- Submit Button -->
                <button
                    type="submit"
                    class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                    Search
                </button>
            </form>

        </nav>

        <!-- User Actions -->
        <div class="flex space-x-4 items-center">
            <?php if ($user_id) { ?>
                <!-- Cart Icon -->
                <a href="addtocart.php" class="text-gray-600 hover:text-gray-900 transition duration-300">
                    <i class="fa-brands fa-opencart text-x text-red-500"></i>
                </a>
                <!-- Logout Button -->
                <a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                    Logout
                </a>
            <?php } else { ?>
                <!-- Login and Sign Up Buttons -->
                <a href="loginform.php" class="bg-transparent text-gray-800 px-4 py-2 rounded hover:bg-gray-200 transition">
                    Login
                </a>
                <a href="signup.php" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                    Sign Up
                </a>
            <?php } ?>
        </div>
    </div>
</header>