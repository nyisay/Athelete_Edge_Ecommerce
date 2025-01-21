<header class="bg-white/30 backdrop-blur-lg shadow-lg">
    <div class="container mx-auto px-4 py-4 flex flex-row justify-between">
        <a href="home.php" class=" items-center">
            <img src="/images/logoedit.png" alt="Logo" class="h-12 w-12 mr-3">
            <span class="text-xl font-bold text-gray-700">Athlete Edge</span>
        </a>

        <nav class="flex flex-row space-x-6 items-center">
            <a href="home.php" class="text-gray-800 hover:text-red-600 transition">Home</a>
            <a href="about.php" class="text-gray-800 hover:text-red-600 transition">About</a>
            <a href="features.php" class="text-gray-800 hover:text-red-600 transition">Features</a>
            <a href="categories.php" class="text-gray-800 hover:text-red-600 transition">Categories</a>

            <form action="search_results.php" method="POST" class="flex items-center space-x-2">
                <input type="text" name="search" placeholder="Search products..." class="px-4 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-red-600 transition">
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                    Search
                </button>
            </form>
        </nav>
        <?php
        if ($user_id) { ?>

            <a href='addtocart.php' class='text-gray-600 hover:text-gray-900 transition duration-300'>
                <i class='fas fa-shopping-cart text-lg'></i>
            </a>

            <a href='logout.php' class='bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition'>
                Logout
            </a>


        <?php } ?>




        <?php
        if (!$user_id) {
            echo "
                    <div class='flex space-x-4 items-center'>
                        <a href='loginform.php' class='bg-transparent text-gray-800 px-4 py-2 rounded hover:bg-gray-200 transition'>
                            Login
                        </a>
                        <a href='signup.php' class='bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition'>
                            Sign Up
                        </a>
                    </div>
                ";
        }
        ?>

    </div>
</header>