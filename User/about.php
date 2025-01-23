<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Athlete Edge</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[url('../images/Athle.png')] bg-cover bg-center bg-no-repeat backdrop-blur-sm shadow-lg">
    <!-- Header -->
    <?php include 'header.php'; ?>

    <!-- About Section -->
    <section class="py-16 bg-[url('/images/about-bg.jpg')] bg-cover bg-center">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl font-bold mb-4 text-gray-200 animate-fade-in-down">About Athlete Edge</h1>
            <p class="text-lg text-gray-300 mb-10">
                At Athlete Edge, we are passionate about empowering athletes and fitness enthusiasts 
                with top-quality sports gear, apparel, and equipment. Our mission is to inspire you 
                to push your limits and achieve your personal best.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Mission -->
                <div class="bg-gray-400 bg-opacity-80 shadow-lg rounded-lg p-6 hover:scale-105 transition-transform duration-300">
                    <div class="flex justify-center mb-4">
                        <img src="/images/mission1.png" alt="Mission" class="h-16 w-16">
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-700">Our Mission</h3>
                    <p class="text-gray-300">
                        To provide premium-quality products that enhance athletic performance and foster a love for fitness.
                    </p>
                </div>

                <!-- Vision -->
                <div class="bg-gray-400 bg-opacity-80 shadow-lg rounded-lg p-6 hover:scale-105 transition-transform duration-300">
                    <div class="flex justify-center mb-4">
                        <img src="/images/vision.png" alt="Vision" class="h-16 w-16">
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-700">Our Vision</h3>
                    <p class="text-gray-300">
                        To become a trusted global brand that inspires and equips athletes of all levels to succeed.
                    </p>
                </div>

                <!-- Values -->
                <div class="bg-gray-400 bg-opacity-80 shadow-lg rounded-lg p-6 hover:scale-105 transition-transform duration-300">
                    <div class="flex justify-center mb-4">
                        <img src="/images/value.png" alt="Values" class="h-16 w-16">
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-700">Our Values</h3>
                    <p class="text-gray-300">
                        Integrity, innovation, and excellence drive every decision we make, ensuring the best for our customers.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-16 bg-[url('/images/team-bg.jpg')] bg-cover bg-center bg-fixed">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-6 text-red-500 animate-fade-in-down">Meet Our Team</h2>
            <p class="text-lg text-gray-300 mb-10">
                Our dedicated team works tirelessly to bring you the best in sports and fitness. Meet the people behind Athlete Edge!
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-gray-400 bg-opacity-80 rounded-lg p-6 shadow-lg hover:scale-105 transition-transform duration-300">
                    <img src="/images/team member1.png" alt="Team Member 1" class="rounded-full h-32 w-32 mx-auto mb-4">
                    <h3 class="text-xl font-bold text-gray-700">John Doe</h3>
                    <p class="text-gray-300">Founder & CEO</p>
                </div>
                <div class="bg-gray-400 bg-opacity-80 rounded-lg p-6 shadow-lg hover:scale-105 transition-transform duration-300">
                    <img src="/images/team member2.png" alt="Team Member 2" class="rounded-full h-32 w-32 mx-auto mb-4">
                    <h3 class="text-xl font-bold text-gray-700">Jane Smith</h3>
                    <p class="text-gray-300">Head of Marketing</p>
                </div>
                <div class="bg-gray-400 bg-opacity-80 rounded-lg p-6 shadow-lg hover:scale-105 transition-transform duration-300">
                    <img src="/images/team member3.png" alt="Team Member 3" class="rounded-full h-32 w-32 mx-auto mb-4">
                    <h3 class="text-xl font-bold text-gray-700">Emily Johnson</h3>
                    <p class="text-gray-300">Product Designer</p>
                </div>
                <div class="bg-gray-400 bg-opacity-80 rounded-lg p-6 shadow-lg hover:scale-105 transition-transform duration-300">
                    <img src="/images/team member4.png" alt="Team Member 4" class="rounded-full h-32 w-32 mx-auto mb-4">
                    <h3 class="text-xl font-bold text-gray-700">Michael Lee</h3>
                    <p class="text-gray-300">Operations Manager</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-400 py-6">
        <div class="container mx-auto text-center">
            <p class="text-sm">&copy; 2025 Athlete Edge. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
