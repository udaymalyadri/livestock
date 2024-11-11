-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2024 at 01:02 PM
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
-- Database: `livestock`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `product_type` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `product_type`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Milk', 'Dairy Product', '../uploads/milk2.jpg', '2024-10-19 03:45:34', '2024-10-26 05:21:12'),
(3, 'Cow', 'Cattle', '../uploads/cow_3.jpg', '2024-10-19 03:45:34', '2024-10-26 05:20:46'),
(4, 'Goat', 'Cattle', '../uploads/goat_2.jpg', '2024-10-19 03:45:34', '2024-10-19 07:13:28'),
(5, 'Buffalo', 'Cattle', '../uploads/buffalo_3.jpg', '2024-10-19 07:13:11', '2024-10-25 18:01:08'),
(7, 'horse', 'Cattle', 'horse_2.jpg', '2024-10-25 18:07:05', '2024-10-25 18:07:05');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_type` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `doctor_report` varchar(255) DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `product_type`, `category`, `price`, `stock`, `seller_id`, `doctor_report`, `product_image`, `created_at`, `updated_at`) VALUES
(2, 'egg', 'Dairy Product', 'Eggs', 29.99, 44, 1, NULL, 'uploads/butter.jpg', '2024-10-19 08:30:17', '2024-10-19 08:30:17'),
(5, 'jersey', 'Cattle', 'Cow', 100000.00, 0, 1, 'uploads/hexaware_15.pdf', 'uploads/cow_3.jpg', '2024-10-25 18:11:14', '2024-10-25 18:11:14');

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `seller_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('seller') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sellers`
--

INSERT INTO `sellers` (`seller_id`, `name`, `contact`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'meena', '7897897897', 'meena@gmail.com', '$2y$10$nlVr5pvTQwYCDoUkZTVdu.pzwMw3LkOCfREiS9n.szANFBK6yZHwe', 'seller', '2024-10-18 09:57:09'),
(2, 'kiran', '9381743745', 'kiran@gmail.com', '$2y$10$fyqIWlp.Xt.mIQZr92MUie7JfAv8GHIcRdlkJ9guPcnNJBv/eYS8q', 'seller', '2024-10-22 06:46:45'),
(3, 'jeni', '9876543210', 'jeni@gmail.com', '$2y$10$2T3p5R81YvXwRjzTeUyateVGYU4vewfKyxHysUZ/BstF9nt61y4Zu', 'seller', '2024-10-25 05:35:54'),
(5, 'laddu', '9492335004', 'laddu@gmail.com', '$2y$10$L7nOUTNkBpFh..Uh2SJcmuW2D39sHE67zA5POW80AXb8Pfoko/D16', 'seller', '2024-10-27 06:33:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `contact`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'ashu', '9381743745', 'ashu@gmail.com', '1234', 'user\r\n', '2024-10-18 09:52:25'),
(2, 'admin', '09381743745', 'admin@gmail.com', 'admin', 'admin', '2024-10-18 10:07:09'),
(11, 'Aakash', '7897897897', 'ak@gmail.com', '123', 'user', '2024-10-25 10:01:25'),
(13, 'uday', '7897897897', 'uday@gmail.com', '123', 'user', '2024-10-25 17:53:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`seller_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sellers`
--
ALTER TABLE `sellers`
  MODIFY `seller_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`seller_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
