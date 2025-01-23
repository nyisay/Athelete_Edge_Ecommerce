<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Reviews</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">
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
</body>

</html>
