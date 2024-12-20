-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2024 at 10:42 PM
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
-- Database: `tek_trravels`
--

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `country_code` varchar(100) DEFAULT NULL,
  `mobile` varchar(255) NOT NULL,
  `otp` varchar(100) DEFAULT NULL,
  `otp_expiry` timestamp NULL DEFAULT current_timestamp(),
  `address` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `vehicletype` varchar(255) DEFAULT NULL,
  `vehiclenumber` varchar(255) DEFAULT NULL,
  `image_id` varchar(255) DEFAULT NULL,
  `walletamount` varchar(255) DEFAULT NULL,
  `driverstatus` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `adminstatus` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `is_vehicle_added` varchar(255) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `fcm_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `firstname`, `email`, `email_verified_at`, `password`, `lastname`, `country_code`, `mobile`, `otp`, `otp_expiry`, `address`, `country`, `latitude`, `longitude`, `vehicletype`, `vehiclenumber`, `image_id`, `walletamount`, `driverstatus`, `status`, `adminstatus`, `remember_token`, `is_vehicle_added`, `created_at`, `updated_at`, `fcm_token`) VALUES
(1, 'Vishal', 'vishalm123556dfgv68525498745@yopmail.com', NULL, '$2y$10$8hx585v1KAJ6oikYv1NZu.pBYOvSuOJlupPf4wt4g/4tSqaBkDNJu', 'm', '+91', '9658965635', NULL, NULL, NULL, NULL, '22.719568', '75.857728', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2024-09-21 17:44:37', '2024-09-21 17:45:10', 'dfgjdfffdg456tg457b676v6785n456uv45373865g'),
(2, 'Vishal', 'vishalm1235556dfgv68525498745@yopmail.com', NULL, '$2y$10$xQJtBG5biXwXdEvYNu.1kuEB3sAKtJ8k48uPKkyY9exqCy8.shCPq', 'm', '+91', '9658965634', NULL, NULL, NULL, NULL, '22.719568', '75.857728', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2024-09-21 17:58:41', '2024-09-21 17:59:17', 'vmv');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `file_name`, `file_path`, `created_at`, `updated_at`) VALUES
(1, 'vRytePvaMp.png', '/uploads/vRytePvaMp.png', '2024-09-22 20:32:35', '2024-09-22 20:32:35'),
(2, 'SpsSGKqe7t.png', '/uploads/SpsSGKqe7t.png', '2024-09-22 20:34:08', '2024-09-22 20:34:08');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(2, 'App\\Models\\User', 1, 'auth_token', '3f55d8a7b5aa93b0527585d8ad9079af56039204de78b386893370c69511bc8a', '[\"*\"]', '2024-09-21 17:44:32', NULL, '2024-09-21 17:43:36', '2024-09-21 17:44:32'),
(3, 'App\\Models\\Driver', 1, 'driver_token', 'ea923100e37b5e5e869f3a9b048d0a0ecb55060b27e757366116dcfe3ad0257d', '[\"*\"]', '2024-09-21 17:45:10', NULL, '2024-09-21 17:44:50', '2024-09-21 17:45:10'),
(4, 'App\\Models\\Driver', 2, 'driver_token', '0ae6170ef321797e219e33cb63fa6c7ece0cfb4ec9a6632c0ea74a75e08e6098', '[\"*\"]', NULL, NULL, '2024-09-21 17:59:17', '2024-09-21 17:59:17'),
(5, 'App\\Models\\User', 3, 'auth_token', '9dfbe8a4230b6149f02b9bcefb6f3a5a8110769dd6a0a49ce6849793f9b78882', '[\"*\"]', NULL, NULL, '2024-09-21 18:02:07', '2024-09-21 18:02:07'),
(6, 'App\\Models\\User', 2, 'auth_token', 'c2958d6641de460150b921c5787f2e7469e2089bc332cf6cb477cce728e9426f', '[\"*\"]', '2024-09-21 18:07:31', NULL, '2024-09-21 18:07:20', '2024-09-21 18:07:31'),
(9, 'App\\Models\\Vendor', 1, 'vendor_token', '471bc23eeb6b6debbe71c11ef60f60818d449c10ff08dc5c6354c1fc6ecc35c0', '[\"*\"]', '2024-09-22 20:37:26', NULL, '2024-09-22 19:57:17', '2024-09-22 20:37:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `country_code` varchar(100) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `otp` varchar(100) DEFAULT NULL,
  `otp_expiry` timestamp NULL DEFAULT current_timestamp(),
  `country` varchar(255) DEFAULT NULL,
  `age` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `user_code` varchar(255) DEFAULT NULL,
  `vehical_no` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `fcm_token` longtext DEFAULT NULL,
  `customer_id` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `email`, `lastname`, `country_code`, `mobile`, `otp`, `otp_expiry`, `country`, `age`, `city`, `latitude`, `longitude`, `user_code`, `vehical_no`, `email_verified_at`, `password`, `image_id`, `remember_token`, `fcm_token`, `customer_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Vishal', 'vish@yopmail.com', 'Mukati', '+91', '8966833570', NULL, NULL, NULL, NULL, NULL, '22.7149569', '75.857727', NULL, NULL, NULL, '$2y$10$yvEtxQPrHYlh.1zRXHEFJ.fG8bkG2uiDjZhE.jLiZ2KFMkDnuHJCK', NULL, NULL, 'gijsegkurghblkjsrgbgbgbe', NULL, 0, '2024-09-21 17:43:15', '2024-09-21 17:44:12'),
(2, 'vish', 'vish12345612@yopmail.com', 'mkt', '+91', '8966833512', '3524', '2024-09-21 18:10:20', NULL, NULL, NULL, '22.719568', '75.857727', NULL, NULL, NULL, '$2y$10$4kndvwiVxQjUvR2695BjEOS/NlCRlGftapSwBScS5lJC9twGfXFDC', NULL, NULL, 'gijsegkurghblkjsrgbgbgbe', NULL, 0, '2024-09-21 18:00:20', '2024-09-21 18:07:31'),
(3, 'vish', 'vish12345455612@yopmail.com', 'mkt', '+91', '8966833562', NULL, NULL, NULL, NULL, NULL, '22.719568', '75.857727', NULL, NULL, NULL, '$2y$10$PAGhZ9I1.Uk6fYqcZQyesOLcnJN5vT1G9JQBJRsKwYGylRR9v5Yge', NULL, NULL, 'erkgrbgikr', NULL, 0, '2024-09-21 18:01:11', '2024-09-21 18:02:07');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `country_code` varchar(100) DEFAULT NULL,
  `mobile` varchar(255) NOT NULL,
  `otp` varchar(100) DEFAULT NULL,
  `otp_expiry` timestamp NULL DEFAULT current_timestamp(),
  `address` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `image_id` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `fcm_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `firstname`, `email`, `email_verified_at`, `password`, `lastname`, `country_code`, `mobile`, `otp`, `otp_expiry`, `address`, `latitude`, `longitude`, `image_id`, `status`, `remember_token`, `created_at`, `updated_at`, `fcm_token`) VALUES
(1, 'Vishal', 'vishalm@yopmail.com', NULL, '$2y$10$ArlK8i5U3Ow3S46v1DO/m.KgM7J73JE6yOTVU6IyivIJMOI1iM0H6', 'Mukati', '91', '8966833570', NULL, NULL, NULL, '23.840799', '78.733597', '2', NULL, NULL, '2024-09-22 19:54:27', '2024-09-22 20:37:26', 'dfgjdfffdg456tg457b676v6785n456uv45373865g');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `drivers_email_unique` (`email`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `drivers_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
