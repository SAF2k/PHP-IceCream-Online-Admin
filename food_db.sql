-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2023 at 08:11 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `password`) VALUES
(1, 'admin', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(10) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `pid`, `name`, `price`, `quantity`, `image`) VALUES
(46, 9, 57, 'cone', 213.00, 1, 'product-1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `c_name` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `c_name`) VALUES
(6, 'cake'),
(14, 'scope'),
(15, 'cone');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(1, 1, 'Saf', 'jewoh26598@aaorsi.com', '2', 'sdadasdsa'),
(2, 0, 'admin', 'jewoh26598@aaorsi.com', '3213312', 'sdasdasd');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `placed_on` date NOT NULL DEFAULT current_timestamp(),
  `placed_time` time NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `placed_time`, `payment_status`) VALUES
(1, 1, 'Saf', '222121221', 'jayixas978@pyadu.com', 'paytm', '12, 21, 21, 21, 21, 21, 21 - 21', 'Gopala krishna Murthi Swamy Iyer Achary (24 x 2) - ', 48.00, '2023-06-14', '04:36:19', 'completed'),
(2, 1, 'Saf', '222121221', 'jayixas978@pyadu.com', 'paytm', '12, 21, 21, 21, 21, 21, 21 - 21', 'Iyer (26 x 4) - Gopala krishna Murthi Swamy Iyer Achary (24 x 5) - scope (200 x 7) - ', 1624.00, '2023-06-14', '04:36:19', 'completed'),
(3, 1, 'Saf', '222121221', 'jayixas978@pyadu.com', 'paypal', '12, 21, 21, 21, 21, 21, 21 - 21', 'scope (200 x 1) - ', 200.00, '2023-06-14', '04:36:19', 'completed'),
(4, 1, 'Saf', '222121221', 'jayixas978@pyadu.com', 'credit card', '12, 21, 21, 21, 21, 21, 21 - 21', 'Gopala krishna Murthi Swamy Iyer Achary (24 x 2) - Iyer (26 x 1) - ', 74.00, '2023-06-14', '04:36:19', 'completed'),
(5, 1, 'Saf', '222121221', 'jayixas978@pyadu.com', 'paytm', '12, 21, 21, 21, 21, 21, 21 - 21', 'dsad (321 x 1) - ', 321.00, '2023-06-15', '04:36:19', 'completed'),
(6, 1, 'Saf', '222121221', 'jayixas978@pyadu.com', 'credit card', '12, 21, 21, 21, 21, 21, 21 - 21', 'noob (2001 x 1) - kuch thoo ha (122 x 1) - ', 2123.00, '2023-06-15', '04:36:19', 'completed'),
(7, 1, 'Saf', '222121221', 'jayixas978@pyadu.com', 'paytm', '12, 21, 21, 21, 21, 21, 21 - 21', 'Bike Guy (700 x 1) - ', 700.00, '2023-06-15', '04:36:19', 'completed'),
(8, 2, 'Saf', '231', 'safwathkhan2@gmail.com', 'credit card', '1, 1, 1, 1, 1, 1, 1 - 1', 'Bike Guy (700 x 1) - ', 700.00, '2023-06-15', '04:36:19', 'completed'),
(9, 3, 'admin', '21', 'safwathkhan222222@gmail.com', 'paytm', '1, 1, 1, 1, 1, 1, 1 - 1', 'Bike Guy (700 x 1) - ', 700.00, '2023-06-16', '04:36:54', 'completed'),
(10, 3, 'admin', '21', 'safwathkhan222222@gmail.com', 'paypal', '1, 1, 1, 1, 1, 1, 1 - 1', 'Bike Guy (700 x 1) - dsad (321 x 1) - kuch thoo  (122 x 1) - xzdsa (231 x 1) - zxczcz (122 x 1) - ', 1496.00, '2023-06-09', '04:42:12', 'completed'),
(11, 3, 'admin', '21', 'safwathkhan222222@gmail.com', 'paytm', '1, 1, 1, 1, 1, 1, 1 - 1', 'Bike Guy (700 x 1) - dsad (321 x 1) - kuch thoo  (122 x 1) - dsadasd (1234 x 1) - who r u (231 x 1) - zxczcz (122 x 1) - Cold Coffee (2000 x 1) - ', 4730.00, '2023-06-06', '07:16:38', 'completed'),
(12, 3, 'admin', '21', 'safwathkhan222222@gmail.com', 'cash on delivery', '1, 1, 1, 1, 1, 1, 1 - 1', 'Bike Guy (700 x 1) - ', 700.00, '2023-06-16', '08:53:59', 'completed'),
(13, 3, 'admin', '21', 'safwathkhan222222@gmail.com', 'credit card', '1, 1, 1, 1, 1, 1, 1 - 1', 'kuch thoo  (122 x 1) - ', 122.00, '2023-06-09', '08:54:29', 'completed'),
(14, 3, 'admin', '21', 'safwathkhan222222@gmail.com', 'paytm', '1, 1, 1, 1, 1, 1, 1 - 1', 'zxczcz (122 x 1) - ', 122.00, '2023-06-16', '08:55:02', 'completed'),
(15, 5, 'ADMIN', '9999999999', 'admin@gmail.com', 'paytm', '1, 1, 1, 1, 1, 1, 1 - 1', 'Bike Guy (700 x 1) - ', 700.00, '2023-06-17', '01:38:54', 'completed'),
(16, 1, 'Saf', '222121221', 'jayixas978@pyadu.com', 'credit card', '12, 21, 21, 21, 21, 21, 21 - 21', 'cat (122 x 1) - ', 122.00, '2023-06-17', '13:44:09', 'completed'),
(17, 1, 'Saf', '222121221', 'jayixas978@pyadu.com', 'paytm', '12, 21, 21, 21, 21, 21, 21 - 21', 'pinky (10 x 1) - ', 10.00, '2023-06-17', '17:38:21', 'completed'),
(18, 1, 'Saf', '222121221', 'jayixas978@pyadu.com', 'credit card', '12, 21, 21, 21, 21, 21, 21 - 21', 'veg Puff (2313123 x 1) - Long Bread (213 x 1) - Breads (321 x 1) - White Flakes (432 x 1) - Cup Cake (431 x 1) - Sweet puff (321 x 1) - Sweet Bread (5431 x 1) - Donutes (231 x 1) - Cup cake 2 (321 x 1) - ', 2320824.00, '2023-06-18', '14:17:53', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `image`) VALUES
(57, 'cone', 'cake', 213.00, 'product-1.jpg'),
(58, 'Saf', 'scope', 6786.00, 'product-1.jpg'),
(59, 'ewr', 'cone', 122.42, 'product-1.jpg'),
(60, 'sdafasdas', 'cake', 2313.00, 'product-1.jpg'),
(61, 'gdfg', 'scope', 122.00, 'product-1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `uid` int(100) NOT NULL,
  `name` varchar(191) NOT NULL,
  `review` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `password` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `code` varchar(100) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `image` varchar(100) NOT NULL,
  `role` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `number`, `password`, `address`, `code`, `created_at`, `image`, `role`) VALUES
(1, 'Saf', 'jayixas978@pyadu.com', '222121221', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '12, 21, 21, 21, 21, 21, 21 - 21', '', '2023-06-16', '', 'user'),
(3, 'admin', 'safwathkhan222222@gmail.com', '21', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '1, 1, 1, 1, 1, 1, 1 - 1', '', '2023-06-16', 'face1.jpg', 'user'),
(5, 'ADMIN', 'admin@gmail.com', '9999999999', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '1, 1, 1, 1, 1, 1, 1 - 1', '', '2023-06-16', '', 'admin'),
(9, 'saaf', 'safwathkhan2@gmail.com', '1', '356a192b7913b04c54574d18c28d46e6395428ab', '', '', '2023-06-20', '', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
