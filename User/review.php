<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Reviews</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>


<body class="bg-gray-100 text-gray-800">

    <?php include 'header.php'; ?>
    <!-- Reviews Section -->
    <section class="py-16">
        <div class="container mx-auto px-6">
            <h1 class="text-4xl font-bold text-gray-800 mb-8 text-center">Product Reviews</h1>

            <!-- Review Form -->
            <div class="bg-white p-8 rounded-lg shadow-lg mb-12">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Leave a Review</h2>
                <form action="submit_review.php" method="POST" class="space-y-6">
                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Your Name</label>
                        <input type="text" id="name" name="name" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Rating Field -->
                    <div>
                        <label for="rating" class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                        <select id="rating" name="rating" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="" disabled selected>Choose a rating</option>
                            <option value="1">1 - Very Poor</option>
                            <option value="2">2 - Poor</option>
                            <option value="3">3 - Average</option>
                            <option value="4">4 - Good</option>
                            <option value="5">5 - Excellent</option>
                        </select>
                    </div>

                    <!-- Review Textarea -->
                    <div>
                        <label for="review" class="block text-sm font-medium text-gray-700 mb-2">Your Review</label>
                        <textarea id="review" name="review" rows="4" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition w-full">
                        Submit Review
                    </button>
                </form>
            </div>

            <!-- Display Reviews -->
            <div class="space-y-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Customer Reviews</h2>

                <!-- Individual Review -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-800">John Doe</h3>
                        <div class="flex space-x-1 text-yellow-400">
                            <!-- 5-star rating -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24">
                                <path
                                    d="M12 17.75l-5.447 3.607 2.07-6.374L2.545 9.8l6.657-.023L12 3.6l2.798 6.177 6.657.023-6.078 5.182 2.07 6.374z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24">
                                <path
                                    d="M12 17.75l-5.447 3.607 2.07-6.374L2.545 9.8l6.657-.023L12 3.6l2.798 6.177 6.657.023-6.078 5.182 2.07 6.374z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24">
                                <path
                                    d="M12 17.75l-5.447 3.607 2.07-6.374L2.545 9.8l6.657-.023L12 3.6l2.798 6.177 6.657.023-6.078 5.182 2.07 6.374z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24">
                                <path
                                    d="M12 17.75l-5.447 3.607 2.07-6.374L2.545 9.8l6.657-.023L12 3.6l2.798 6.177 6.657.023-6.078 5.182 2.07 6.374z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24">
                                <path
                                    d="M12 17.75l-5.447 3.607 2.07-6.374L2.545 9.8l6.657-.023L12 3.6l2.798 6.177 6.657.023-6.078 5.182 2.07 6.374z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-600">
                        This product is amazing! The quality is top-notch, and the service was excellent.
                    </p>
                </div>

                <!-- Another Review -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-800">Jane Smith</h3>
                        <div class="flex space-x-1 text-yellow-400">
                            <!-- 4-star rating -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24">
                                <path
                                    d="M12 17.75l-5.447 3.607 2.07-6.374L2.545 9.8l6.657-.023L12 3.6l2.798 6.177 6.657.023-6.078 5.182 2.07 6.374z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24">
                                <path
                                    d="M12 17.75l-5.447 3.607 2.07-6.374L2.545 9.8l6.657-.023L12 3.6l2.798 6.177 6.657.023-6.078 5.182 2.07 6.374z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24">
                                <path
                                    d="M12 17.75l-5.447 3.607 2.07-6.374L2.545 9.8l6.657-.023L12 3.6l2.798 6.177 6.657.023-6.078 5.182 2.07 6.374z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24">
                                <path
                                    d="M12 17.75l-5.447 3.607 2.07-6.374L2.545 9.8l6.657-.023L12 3.6l2.798 6.177 6.657.023-6.078 5.182 2.07 6.374z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-600">
                        Very good product. Could have been a bit cheaper, but overall, I am satisfied!
                    </p>
                </div>
            </div>
        </div>
    </section>

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