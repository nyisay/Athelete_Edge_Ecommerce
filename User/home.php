<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once "database.php";
try {
    $sql = "SELECT * FROM products Limit 4";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['products'] = $products;
} catch (PDOException) {
    echo "Error: " . $e->getMessage();
}


// Get the user ID from the session
$user_id = $_SESSION['user_id'] ?? "";

$searchProduct = "";
$product_details = [];

// Check if the form is submitted via POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search']) && !empty($_POST['search'])) {
    $search = htmlspecialchars($_POST['search']);  // Sanitize user input

    try {
        // Perform the search query to find matching products
        $stmt = $conn->prepare("SELECT products.*, categories.name AS category_name 
                                FROM products 
                                JOIN categories ON categories.category_id = products.category_id 
                                WHERE products.name LIKE :search 
                                OR categories.name LIKE :search 
                                OR products.price LIKE :search");
        $stmt->execute([':search' => '%' . $search . '%']);
        $product_details = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if products were found
        if (count($product_details) === 0) {
            $searchProduct = "No products found matching your search criteria.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    $searchProduct = "Please enter a product name or category.";
}


$message = '';
if (isset($_SESSION['userLoginSuccess'])) {
    $message = $_SESSION['userLoginSuccess'];
    unset($_SESSION['userLoginSuccess']);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Fonts Link -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <style>
        .alert-box {
            position: fixed;
            top: 20px;
            left: 45%;
            transform: translateX(-50%);
            background-color: #4caf50;
            color: white;
            padding: 16px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            opacity: 0;
            transform: translateY(-20px);
            animation: fadeInOut 3s ease forwards;
            z-index: 1000;
        }

        @keyframes fadeInOut {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            10% {
                opacity: 1;
                transform: translateY(0);
            }

            90% {
                opacity: 1;
                transform: translateY(0);
            }

            100% {
                opacity: 0;
                transform: translateY(-20px);
            }
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Animated Alert -->
    <?php if (!empty($message)) { ?>
        <div class="alert-box z-10">
            <?php echo $message; ?>
        </div>
    <?php } ?>

    <!---------------------- Navbar ------------------------>
    <?php include 'header.php'; ?>


    <!-- Video Banner -->
    <section class="relative">
        <video autoplay loop muted playsinline class="w-full h-[560px] object-cover">
            <source src="/images/For our beloved athletes.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="absolute inset-0 flex items-center justify-center">
            <!-- Shop Now Button -->
            <a href="product.php"
                class="absolute bottom-4 right-64 bg-blue-500 text-white text-lg px-6 py-3 rounded shadow hover:bg-blue-600 transition">
                Shop Now
            </a>
        </div>
    </section>




    <!-- Services Section -->
    <section id="services" class="py-16">
        <div class="container mx-auto">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">Our Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-blue-500 text-4xl mb-4">📦</div>
                    <h3 class="text-xl font-semibold mb-2">Branded</h3>
                    <p class="text-gray-600">High-quality products, service tailored to your needs.</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-blue-500 text-4xl mb-4">⚡</div>
                    <h3 class="text-xl font-semibold mb-2">Time</h3>
                    <p class="text-gray-600">Fast and reliable solutions every time.</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-blue-500 text-4xl mb-4">🌍</div>
                    <h3 class="text-xl font-semibold mb-2">Global</h3>
                    <p class="text-gray-600">Globally trusted and respected by our clients.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="p-8 bg-gray-100">
        <!-- Trending Heading -->
        <h2 class="text-4xl font-bold text-center text-gray-900 mb-8 font-poppins">
            Trending
        </h2>

        <div class="flex justify-center gap-6">
            <!-- Video 1 -->
            <div class="relative w-full max-w-md overflow-hidden rounded-lg shadow-xl transform transition-transform duration-300 hover:scale-105">
                <video autoplay loop muted playsinline class="w-full h-[500px] object-cover rounded-lg">
                    <source src="/images/Jordan Heir Series PF 'Classic'.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <!-- Overlay Content -->
                <div class="absolute bottom-4 right-4 text-gray-700 p-4">
                    <h3 class="text-xl font-semibold mb-2">Jordan Heir Series PF</h3>
                    <button class="bg-red-500 text-white px-6 py-2 rounded-full hover:bg-red-600 transition duration-300">
                        Check
                    </button>
                </div>
            </div>

            <!-- Video 2 -->
            <div class="relative w-full max-w-md overflow-hidden rounded-lg shadow-xl transform transition-transform duration-300 hover:scale-105">
                <video autoplay loop muted playsinline class="w-full h-[500px] object-cover rounded-lg">
                    <source src="/images/Nike Dri-FIT Rise 365.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <!-- Overlay Content -->
                <div class="absolute bottom-4 right-4 text-gray-700 p-4">
                    <h3 class="text-xl font-semibold mb-2">Nike Dri-FIT Rise 365</h3>
                    <button class="bg-red-500 text-white px-6 py-2 rounded-full hover:bg-red-600 transition duration-300">
                        Check
                    </button>
                </div>
            </div>

            <!-- Video 3 -->
            <div class="relative w-full max-w-md overflow-hidden rounded-lg shadow-xl transform transition-transform duration-300 hover:scale-105">
                <video autoplay loop muted playsinline class="w-full h-[500px] object-cover rounded-lg">
                    <source src="/images/Zion 3 PF.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <!-- Overlay Content -->
                <div class="absolute bottom-4 right-4 text-gray-s p-4">
                    <h3 class="text-xl font-semibold mb-2">Zion 3 PF</h3>
                    <button class="bg-red-500 text-white px-6 py-2 rounded-full hover:bg-red-600 transition duration-300">
                        Check
                    </button>
                </div>
            </div>
        </div>
    </section>


    <!-- Call to Action -->
    <section class="bg-gray-600 text-white py-16">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold mb-4">RACE THE NIGHT AWAY</h2>
            <p class="mb-6">Run until you see stars at the Ethelte EDGE After Dark Tour, a race powered by men.</p>
            <a href="#contact" class="bg-white text-blue-600 px-8 py-3 rounded shadow hover:bg-blue-100">
                Contact Us
            </a>
        </div>
    </section>

    <!-- Banner Section -->
    <section id="banners" class="py-16 bg-gray-100">
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-16">Our Featured Banners</h2>
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Top Left Banner -->
            <div class="bg-white shadow-lg overflow-hidden rounded-lg transform hover:scale-105 transition-transform duration-500 ease-in-out">
                <img src="/images/Jordan Heir Series.jpeg" alt="Banner 1" class="w-full h-96 object-cover object-center transition-all duration-500 ease-in-out hover:opacity-80">
            </div>
            <!-- Top Right Banner -->
            <div class="bg-white shadow-lg overflow-hidden rounded-lg transform hover:scale-105 transition-transform duration-500 ease-in-out">
                <img src="/images/nike alphafly .avif" alt="Banner 2" class="w-full h-96 object-cover object-center transition-all duration-500 ease-in-out hover:opacity-80">
            </div>
            <!-- Bottom Left Banner -->
            <div class="bg-white shadow-lg overflow-hidden rounded-lg transform hover:scale-105 transition-transform duration-500 ease-in-out">
                <img src="/images/Converse x Swarovski Run Star Trainer.webp" alt="Banner 3" class="w-full h-96 object-cover object-center transition-all duration-500 ease-in-out hover:opacity-80">
            </div>
            <!-- Bottom Right Banner -->
            <div class="bg-white shadow-lg overflow-hidden rounded-lg transform hover:scale-105 transition-transform duration-500 ease-in-out">
                <img src="/images/PUMA Deviate Nitro 3.avif" alt="Banner 4" class="w-full h-96 object-cover object-center transition-all duration-500 ease-in-out hover:opacity-80">
            </div>
        </div>
    </section>




    <!-- Products Section -->
    <section id="products" class="py-16 bg-gray-100">
        <div class="container mx-auto">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">Best Sellers</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php
                if (isset($products)) {
                    foreach ($products as $product) { ?>
                        <!-- Product Card -->
                        <div class="bg-white rounded-lg shadow-lg flex flex-col">
                            <!-- Image Container -->
                            <div class="w-full h-100 overflow-hidden rounded-lg flex items-center justify-center bg-gray-100">
                                <img src="/images/<?php echo $product['image']; ?>"
                                    alt="<?php echo $product['name']; ?>"
                                    class="h-full w-auto object-contain">
                            </div>
                            <!-- Product Content -->
                            <div class="flex flex-col flex-grow p-6 text-center">
                                <h3 class="text-lg font-semibold text-gray-800 mb-2"><?php echo $product['name']; ?></h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?php echo $product['description']; ?></p>
                                <span class="text-blue-600 font-bold text-xl mb-4"><?php echo '$' . number_format($product['price'], 2); ?></span>
                                <div class="mt-auto flex justify-center space-x-4">
                                    <?php if ($user_id) { ?>
                                        <a href="addCart.php?product_id=<?php echo $product['product_id']; ?>"
                                            class="bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600 transition">
                                            Add to Cart
                                        </a>
                                    <?php } else { ?>
                                        <a href="loginform.php"
                                            class="bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600 transition">
                                            Add to Cart
                                        </a>
                                    <?php } ?>
                                    <a href="productdetail.php?product_id=<?php echo $product['product_id']; ?>"
                                        class="bg-gray-500 text-white px-4 py-2 rounded-full hover:bg-gray-600 transition">
                                        Details
                                    </a>
                                </div>
                            </div>
                        </div>
                <?php }
                } ?>
            </div>
        </div>
    </section>



    <!-- Footer -->


    <footer class="bg-white dark:bg-gray-300">
        <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
            <div class="md:flex md:justify-between">
                <div class="mb-6 md:mb-0">
                    <a href="home.php" class="flex items-center">
                        <img src="/images/logoedit.png" class="h-8 me-3" alt="FlowBite Logo" />
                        <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-gray-700">Athlete EDGE</span>
                    </a>
                </div>
                <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
                    <div>
                        <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-gray-700">Pages</h2>
                        <ul class="text-gray-500 dark:text-gray-700 font-medium">
                            <li class="mb-4">
                                <a href="home.php" class="hover:underline">Home</a>
                            </li>
                            <li class="mb-4">
                                <a href="product.php" class="hover:underline">Products</a>
                            </li>
                            <li class="mb-4">
                                <a href="review.php" class="hover:underline">Review</a>
                            </li>
                            <li>
                                <a href="about.php" class="hover:underline">About</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-gray-700">Follow us</h2>
                        <ul class="text-gray-500 dark:text-gray-700 font-medium">
                            <li class="mb-4">
                                <a href="https://www.facebook.com" class="hover:underline ">Facebook</a>
                            </li>
                            <li class="mb-4">
                                <a href="https://discord.com/" class="hover:underline ">Discord</a>
                            </li>
                            <li class="mb-4">
                                <a href="https://x.com/?mx=2" class="hover:underline ">X</a>
                            </li>
                            <li class="mb-4">
                                <a href="https://github.com/" class="hover:underline ">GitHub</a>
                            </li>
                            <li>
                                <a href="https://dribbble.com/" class="hover:underline">Dribbble</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-gray-700">Legal</h2>
                        <ul class="text-gray-500 dark:text-gray-700 font-medium">
                            <li class="mb-4">
                                <a href="#" class="hover:underline">Privacy Policy</a>
                            </li>
                            <li>
                                <a href="#" class="hover:underline">Terms &amp; Conditions</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
            <div class="sm:flex sm:items-center sm:justify-between">
                <span class="text-sm text-gray-900 sm:text-center dark:text-gray-300">© 2023 <a href="https://flowbite.com/" class="hover:underline">Flowbite™</a>. All Rights Reserved.
                </span>
                <div class="flex mt-4 sm:justify-center sm:mt-0">
                    <a href="https://www.facebook.com" class="text-gray-800 hover:text-gray-700 dark:hover:text-gray-600">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 8 19">
                            <path fill-rule="evenodd" d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z" clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Facebook page</span>
                    </a>
                    <a href="https://discord.com/" class="text-gray-800 hover:text-gray-700 dark:hover:text-gray-600 ms-5">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 21 16">
                            <path d="M16.942 1.556a16.3 16.3 0 0 0-4.126-1.3 12.04 12.04 0 0 0-.529 1.1 15.175 15.175 0 0 0-4.573 0 11.585 11.585 0 0 0-.535-1.1 16.274 16.274 0 0 0-4.129 1.3A17.392 17.392 0 0 0 .182 13.218a15.785 15.785 0 0 0 4.963 2.521c.41-.564.773-1.16 1.084-1.785a10.63 10.63 0 0 1-1.706-.83c.143-.106.283-.217.418-.33a11.664 11.664 0 0 0 10.118 0c.137.113.277.224.418.33-.544.328-1.116.606-1.71.832a12.52 12.52 0 0 0 1.084 1.785 16.46 16.46 0 0 0 5.064-2.595 17.286 17.286 0 0 0-2.973-11.59ZM6.678 10.813a1.941 1.941 0 0 1-1.8-2.045 1.93 1.93 0 0 1 1.8-2.047 1.919 1.919 0 0 1 1.8 2.047 1.93 1.93 0 0 1-1.8 2.045Zm6.644 0a1.94 1.94 0 0 1-1.8-2.045 1.93 1.93 0 0 1 1.8-2.047 1.918 1.918 0 0 1 1.8 2.047 1.93 1.93 0 0 1-1.8 2.045Z" />
                        </svg>
                        <span class="sr-only">Discord community</span>
                    </a>
                    <a href="https://x.com/?mx=2" class="text-gray-800 hover:text-gray-700 dark:hover:text-gray-600 ms-5">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 17">
                            <path fill-rule="evenodd" d="M20 1.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.344 8.344 0 0 1-2.605.98A4.13 4.13 0 0 0 13.85 0a4.068 4.068 0 0 0-4.1 4.038 4 4 0 0 0 .105.919A11.705 11.705 0 0 1 1.4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 4.1 9.635a4.19 4.19 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 0 14.184 11.732 11.732 0 0 0 6.291 16 11.502 11.502 0 0 0 17.964 4.5c0-.177 0-.35-.012-.523A8.143 8.143 0 0 0 20 1.892Z" clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">X</span>
                    </a>
                    <a href="https://github.com/" class="text-gray-800 hover:text-gray-700 dark:hover:text-gray-600 ms-5">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 .333A9.911 9.911 0 0 0 6.866 19.65c.5.092.678-.215.678-.477 0-.237-.01-1.017-.014-1.845-2.757.6-3.338-1.169-3.338-1.169a2.627 2.627 0 0 0-1.1-1.451c-.9-.615.07-.6.07-.6a2.084 2.084 0 0 1 1.518 1.021 2.11 2.11 0 0 0 2.884.823c.044-.503.268-.973.63-1.325-2.2-.25-4.516-1.1-4.516-4.9A3.832 3.832 0 0 1 4.7 7.068a3.56 3.56 0 0 1 .095-2.623s.832-.266 2.726 1.016a9.409 9.409 0 0 1 4.962 0c1.89-1.282 2.717-1.016 2.717-1.016.366.83.402 1.768.1 2.623a3.827 3.827 0 0 1 1.02 2.659c0 3.807-2.319 4.644-4.525 4.889a2.366 2.366 0 0 1 .673 1.834c0 1.326-.012 2.394-.012 2.72 0 .263.18.572.681.475A9.911 9.911 0 0 0 10 .333Z" clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">GitHub account</span>
                    </a>
                    <a href="https://dribbble.com/" class="text-gray-800 hover:text-gray-700 dark:hover:text-gray-600 ms-5">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 0a10 10 0 1 0 10 10A10.009 10.009 0 0 0 10 0Zm6.613 4.614a8.523 8.523 0 0 1 1.93 5.32 20.094 20.094 0 0 0-5.949-.274c-.059-.149-.122-.292-.184-.441a23.879 23.879 0 0 0-.566-1.239 11.41 11.41 0 0 0 4.769-3.366ZM8 1.707a8.821 8.821 0 0 1 2-.238 8.5 8.5 0 0 1 5.664 2.152 9.608 9.608 0 0 1-4.476 3.087A45.758 45.758 0 0 0 8 1.707ZM1.642 8.262a8.57 8.57 0 0 1 4.73-5.981A53.998 53.998 0 0 1 9.54 7.222a32.078 32.078 0 0 1-7.9 1.04h.002Zm2.01 7.46a8.526 8.526 0 0 1-2.01-4.516 24.836 24.836 0 0 0 6.812-1.074c.178.34.356.686.538 1.025a23.99 23.99 0 0 1 .548 1.222 12.155 12.155 0 0 0-5.888 3.344ZM9.99 19.305a8.82 8.82 0 0 1-4.794-1.35 10.65 10.65 0 0 1 5.796-3.2 23.618 23.618 0 0 1 1.074 2.433 10.279 10.279 0 0 1-2.076 2.1ZM10 18.5Zm.01-.166a.016.016 0 0 1 0 .002v-.002Z" clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Dribbble account</span>
                    </a>
                </div>
            </div>

        </div>
    </footer>

</body>

</html>