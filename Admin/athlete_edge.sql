-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2025 at 12:18 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `athlete_edge`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `product_id`, `quantity`, `created_at`) VALUES
(54, 7, 14, 1, '2025-01-26'),
(55, 7, 20, 1, '2025-01-26'),
(59, 11, 25, 1, '2025-01-26'),
(63, 11, 20, 1, '2025-01-26');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `description`) VALUES
(1, 'Apparel', 'Clothing and accessories for sports and fitness'),
(2, 'Footwear', 'Shoes and related products for sports and fitness'),
(3, 'Accessories', 'Gear and equipment for various sports and fitness activities');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `payment_method_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `status` enum('pending','approved','cancelled') DEFAULT 'pending',
  `total_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `payment_method_id`, `user_id`, `order_date`, `status`, `total_amount`) VALUES
(1, 1, 7, '2025-01-21 05:53:45', 'approved', 170.00),
(2, 1, 7, '2025-01-21 05:54:15', 'cancelled', 170.00),
(3, 4, 7, '2025-01-21 05:59:50', 'approved', 120.00),
(4, 4, 7, '2025-01-21 06:05:47', 'cancelled', 364.00),
(5, 3, 7, '2025-01-22 03:40:24', 'approved', 159.00),
(6, 2, 8, '2025-01-22 03:44:12', 'cancelled', 339.00),
(7, 4, 10, '2025-01-25 15:20:08', 'pending', 248.00),
(8, 1, 11, '2025-01-26 05:05:03', 'pending', 438.00),
(9, 4, 10, '2025-01-26 11:21:37', 'pending', 389.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 6, 1, 170),
(2, 2, 6, 1, 170),
(3, 3, 5, 1, 120),
(4, 4, 6, 1, 170),
(5, 4, 7, 1, 34),
(6, 4, 8, 1, 160),
(7, 5, 10, 1, 125),
(8, 5, 12, 1, 34),
(9, 6, 11, 1, 160),
(10, 6, 12, 1, 34),
(11, 6, 13, 1, 145),
(12, 7, 17, 1, 40),
(13, 7, 16, 1, 69),
(14, 7, 15, 1, 139),
(15, 8, 11, 1, 160),
(16, 8, 14, 1, 99),
(17, 8, 15, 1, 139),
(18, 8, 17, 1, 40),
(19, 9, 26, 1, 229),
(20, 9, 18, 1, 130),
(21, 9, 22, 1, 30);

-- --------------------------------------------------------

--
-- Table structure for table `payment_method`
--

CREATE TABLE `payment_method` (
  `payment_method_id` int(11) NOT NULL,
  `payment_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_method`
--

INSERT INTO `payment_method` (`payment_method_id`, `payment_name`) VALUES
(1, 'Credit Card'),
(2, 'Debit Card'),
(3, 'Cash On Delivery'),
(4, 'K pay');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `second_image` varchar(255) NOT NULL,
  `third_image` varchar(255) NOT NULL,
  `fourth_image` varchar(255) NOT NULL,
  `fifth_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `quantity`, `category_id`, `image`, `second_image`, `third_image`, `fourth_image`, `fifth_image`) VALUES
(10, 'Gazelle Bold x Liberty London Shoes', 'These iconic Gazelle shoes get a creative Liberty London makeover. These sneakers are refreshed with a vibrantly printed textile and suede upper, putting everyday street style into a floral state of mind.', 125.00, 100, 2, '../images/Gazelle Bold x Liberty London Shoes.png', '../images/Gazelle Bold x Liberty London Shoes up.png', '../images/Gazelle Bold x Liberty London Shoes behind.png', '../images/Gazelle Bold x Liberty London Shoes side.png', '../images/Gazelle Bold x Liberty London Shoes detail.png'),
(11, 'Adidas by Stella McCartney Terrex Gloves', 'These adidas by Stella McCartney gloves are made with PrimaLoft® insulation that\'s extra warm. ', 160.00, 100, 3, '../images/adidas by Stella McCartney Terrex Gloves.avif', '../images/close up glove.avif', '../images/detail gloves.avif', '../images/standing gloves.avif', '../images/from away.avif'),
(12, 'Bottle by Adidas Steel Metal Bottle 1L', ' The double-wall design keeps hot liquids hot and cold liquids cold for hours. The BPA-free design holds a fluid liter to keep you well hydrated.', 34.00, 200, 3, '../images/Steel matel bottle 1L.avif', '../images/top bottleavif.avif', '../images/detail.avif', '../images/bottle brand detail.avif', '../images/logo bottle.avif'),
(13, 'Nike Tech', 'Crafted with stretchy, breathable material, the Nike Tech Woven Jacket offers you ease of movement and adjustable details.', 145.00, 150, 1, '../images/Nike Tech.png', '../images/zip.png', '../images/string.png', '../images/from back.png', '../images/detail.png'),
(14, 'Nike Aura', 'A 24-litre capacity makes this bag ideal for carrying nearly everything you need for your day. A front zip pocket is perfect for smaller essentials while an interior slip pocket fits most laptops.', 99.00, 250, 3, '../images/Nike Aura.png', '../images/inside detail back pack (b).png', '../images/back pack quality.png', '../images/from left side back pack.png', '../images/back pack zip (b).png'),
(15, 'Anthony Edwards 1 Low Trainers Kids', 'These juniors\' signature trainers from adidas Basketball and Anthony Edwards are built for certified bucket getters. The combined BOOST and Lightstrike midsole is ultra-lightweight and adds outstanding energy return to your most explosive moves. ', 139.00, 100, 2, '../images/Anthony Edwards 1 Low Trainers Kids.png', '../images/Anthony Edwards 1 Low Trainers Kids 2 pair.png', '../images/Anthont Edwards 1 Low Traniners Kids Sole.png', '../images/Anthony Edwards 1 Low Trainers Kids string.png', '../images/Anthony Edwards 1 Low Trainers Kids two pair opposite.png'),
(16, 'Adidas Crazy Lite Jersey', ' This sleek sleeveless top is designed for non-stop motion, with lightweight, flexible fabric the moves with you for unrestricted range. ', 69.00, 150, 1, '../images/adidas Crazy Lite Jersey.png', '../images/adidas Crazy Lite Jersey from back.png', '../images/adidas Crazy Lite Jersey shirt detail.png', '../images/adidas Crazy Lite Jersey with basketball.png', '../images/adidas Crazy Lite Jersey logo.png'),
(17, 'Jordan Men\'s Flight Zip Wallet', 'Made of durable nylon satin, this wallet is an everyday essential. It has a zip around closure and opens to reveal the main compartment, a slip pocket on the back wall and a zippered pocket on the front wall so you can help secure your cards, IDs, or any other small, flat items. ', 40.00, 100, 3, '../images/Jordan men\'s flight zip wallet.png', '../images/Jordan men\'s flight zip wallet back side.png', '../images/Jordan men\'s flight zip wallet packing.png', '../images/Jordan Men\'s Flight Zip Wallet blue.png', '../images/Jordan Men\'s Flight Zip Wallet black.png'),
(18, 'Team Wheel Bag XL', 'This extra-large adidas bag makes it easier to haul your equipment to training, tournaments or away games. You can carry it by the top handles, or roll it like luggage. It comes with a tag on the side where you can write your name and number.', 130.00, 300, 3, '../images/Team Wheel Bag XL.png', '../images/Team Wheel Bag XL back.png', '../images/Team Wheel Bag XL 3D.png', '../images/Team Wheel Bag XL inside.png', '../images/Team Wheel Bag XL zip.png'),
(19, 'Nike Pegasus 41', 'Responsive cushioning in the Pegasus provides an energized ride for everyday road running. Experience lighter-weight energy return with dual Air Zoom units and a ReactX foam midsole.', 140.00, 120, 2, '../images/Nike Pegasus 41.png', '../images/Nike Pegasus 41 above.png', '../images/Nike Pegasus 41 back.png', '../images/Nike Pegasus 41 detail.png', '../images/Nike Pegasus 41 detail back.png'),
(20, 'Copa Pure 3 Elite Firm Ground Cleats ', 'Play the beautiful game your way in adidas Copa Pure 3 Elite cleats designed for comfort and connection. The form-fitting combination of an adidas PRIMEKNIT tongue, padded heel and OrthoLite® sockliner keeps you locked in. ', 250.00, 100, 2, '../images/Copa Pure 3 Elite Firm Ground Cleats main.png', '../images/Copa Pure 3 Elite Firm Ground Cleats.png', '../images/Copa Pure 3 Elite Firm Ground Cleats front.png', '../images/Copa Pure 3 Elite Firm Ground Cleats box.png', '../images/Copa Pure 3 Elite Firm Ground Cleats back.png'),
(21, 'Nike Shox TL', 'The Nike Shox TL takes mechanical cushioning to the next level. A recrafted version of the 2003 icon, it features breathable mesh in the upper and full-length Nike Shox technology for optimal impact absorption and a bold look on the streets.', 170.00, 220, 2, '../images/Nike Shox TL.jpg', '../images/side.png', '../images/top.jpg', '../images/back.png', '../images/bottom.png'),
(22, 'Hydrophobic Tour Golf Hat', 'Made with a series of recycled materials, and at least 40% recycled content, this product represents just one of our solutions to help end plastic waste.', 30.00, 300, 1, '../images/Hydrophobic Tour Golf Hat.png', '../images/Hydrophobic Tour Golf Hat logo.png', '../images/Hydrophobic Tour Golf Hat from back.png', '../images/Hydrophobic Tour Golf Hat back 2.png', '../images/Hydrophobic Tour Hat black.png'),
(23, 'Z.N.E. Full-Zip Hooded Track Jacket', 'Zip up and find your focus in this adidas track jacket. The cozy three-layer doubleknit fabric helps lock in warmth, while a full-coverage hood makes it easy to block out the world when you need some \"me time.\"', 110.00, 50, 1, '../images/Z.N.E. Full-Zip Hooded Track Jacket.png', '../images/Z.N.E. Full-Zip Hooded Track Jacket walking.png', '../images/Z.N.E. Full-Zip Hooded Track Jacket only jacket.png', '../images/Z.N.E. Full-Zip Hooded Track Jacket hoodie.png', '../images/Z.N.E. Full-Zip Hooded Track Jacket zip.png'),
(24, 'Jordan Heir Series PF', ' A drop-in midsole helps give you extra mobility, while a built-in cage provides a fit that contours to your foot for added support as you move from side to side. ', 175.00, 150, 2, '../images/Jordan Heir Series PF.png', '../images/Jordan Heir Series PF sole.png', '../images/Jordan Heir Series PF pair.png', '../images/Jordan Heir Series PF logo.png', '../images/Jordan Heir Series PF detail.png'),
(25, 'Nike Dri-FIT Rise 365', 'The Nike Dri-FIT 365 Top is made using runner-informed data for cooling in areas where you need it. It has the same soft feel you\'ve come to expect, with design details that nod to the iconic Nike chevron. ', 65.00, 200, 1, '../images/Nike Dri-FIT Rise 365.png', '../images/Nike Dri-FIT Rise 365 back.png', '../images/Nike Dri-FIT Rise 365 quality.png', '../images/Nike Dri-FIT Rise 365 dark.png', '../images/Nike Dri-FIT Rise 365 dark back.png'),
(26, 'Jordan Zion 3 PF', 'Zion\'s third signature shoe celebrates the dedication he puts in to crafting his singular game. Packed with court-ready tech, it\'s designed for ballers who are masters of both land and air. ', 229.00, 150, 2, '../images/Zion 3 PF.png', '../images/Zion 3 PF sole.png', '../images/Zion 3 PF pair.png', '../images/Zion 3 PF detail.png', '../images/Zion 3 PF detail2.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `profile_image` varchar(255) NOT NULL,
  `role` enum('customer','admin') DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `phone`, `address`, `profile_image`, `role`) VALUES
(1, 'Admin User', 'admin@example.com', 'adminpass', '1234567890', '123 Admin Street', '', 'admin'),
(3, 'nyisay', 'nyisay105@gmail.com', '$2y$10$8UZE1xvepKu.3X1Y5V/8MecslHn6o0p3cpGG0xnHmMoqw9HQRNDFu', NULL, NULL, '', 'customer'),
(4, 'root', 'nyisay1205@gmail.com', '$2y$10$pHdOwgrbaYBUrrg2rVl2Yecw/nx3Da2u7hBxQMFOEF7EZuN9XY.py', NULL, NULL, '', 'customer'),
(7, 'titties lover', 'boswar@gmail.com', '$2y$10$WGISKVSKlE1qSf/BtpgtIeTZAqLII8KFuuOc7RJq5zDRSQm.Q3UZC', NULL, NULL, '', 'customer'),
(8, 'root', 'mamalover@gmail.com', '$2y$10$Ci1GlzNTceWqyZ7ADMjtJeAE4Lei2Fj9c7AVTSKKV/yoZXWdUrH6e', NULL, NULL, '', 'customer'),
(9, 'root', 'nsmh@gmail.com', '$2y$10$IGtP2429OcbPj7OjhuzQBOoT5PquUleHr5iiIsoKvVukzuT8gJ4/O', NULL, NULL, '', 'admin'),
(10, 'root', 'john@gmail.com', '$2y$10$Vb5pLKdGsGLalu90ZAKa9uNnUuGJQMCtn17cLdPs/3YuO9A0cFy9W', NULL, NULL, '', 'customer'),
(11, 'root', 'Zwethuta@gmail.com', '$2y$10$HfBLZeA4EGqoQ6BkciodB.lLgDo29.Eakk3PaJW0iha3l8izjq566', NULL, NULL, '', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`payment_method_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `payment_method_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
