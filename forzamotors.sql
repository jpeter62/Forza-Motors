-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 18, 2025 at 07:38 AM
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
-- Database: `forzamotors`
--

-- --------------------------------------------------------

--
-- Table structure for table `availability`
--

CREATE TABLE `availability` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `available_from` date NOT NULL,
  `available_to` date NOT NULL,
  `status` enum('available','booked') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `availability`
--

INSERT INTO `availability` (`id`, `car_id`, `location_id`, `available_from`, `available_to`, `status`) VALUES
(1, 1, 2, '2024-09-28', '2024-09-29', 'booked'),
(2, 2, 2, '2024-09-19', '2024-10-31', 'available'),
(3, 3, 3, '2025-05-21', '2025-05-28', 'booked'),
(4, 4, 1, '2024-09-19', '2024-10-31', 'booked'),
(5, 5, 2, '2024-09-19', '2024-10-31', 'available'),
(6, 5, 3, '2024-09-19', '2024-10-31', 'available'),
(7, 6, 2, '2024-09-28', '2024-09-29', 'booked'),
(8, 7, 3, '2024-09-29', '2024-09-30', 'booked'),
(9, 8, 3, '2024-09-28', '2024-09-28', 'booked'),
(10, 9, 1, '2024-09-28', '2024-09-29', 'booked'),
(11, 10, 2, '2024-09-19', '2024-10-31', 'available'),
(12, 3, 3, '2025-05-21', '2025-05-28', 'booked'),
(13, 9, 1, '2025-05-20', '2025-05-30', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `bid` int(11) NOT NULL,
  `cvv` int(3) NOT NULL,
  `cno` bigint(11) NOT NULL,
  `bfname` varchar(25) NOT NULL,
  `blname` varchar(20) NOT NULL,
  `bbal` int(10) NOT NULL,
  `cexp` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`bid`, `cvv`, `cno`, `bfname`, `blname`, `bbal`, `cexp`) VALUES
(1, 333, 12345678, 'Joyal', 'S', 99669921, '1222');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `pickup_date` date NOT NULL,
  `dropoff_date` date NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_contact` varchar(255) NOT NULL,
  `customer_email` varchar(50) DEFAULT NULL,
  `total_price` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `car_id`, `location_id`, `pickup_date`, `dropoff_date`, `customer_name`, `customer_contact`, `customer_email`, `total_price`, `userid`) VALUES
(44, 6, 1, '2024-09-28', '2024-09-29', 'mamooty ikka', '9562949318', 'bigb@gmail.com', 18405, 40),
(45, 9, 1, '2024-09-28', '2024-09-29', 'mamooty ikka', '9562949318', 'bigb@gmail.com', 12215, 40),
(47, 7, 2, '2024-09-29', '2024-09-30', 'mamooty ikka', '9562949318', 'bigb@gmail.com', 11240, 40),
(48, 3, 1, '2025-05-21', '2025-05-28', 'senjil jose', '6456893623', 'jossjksijs@gmail.com', 29785, 41),
(49, 3, 1, '2025-05-21', '2025-05-28', 'senjil jose', '6456893623', 'jossjksijs@gmail.com', 29785, 41),
(50, 3, 1, '2025-05-21', '2025-05-28', 'senjil jose', '6456893623', 'jossjksijs@gmail.com', 29785, 41);

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `transmission` varchar(50) NOT NULL,
  `year` year(4) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `name`, `image`, `transmission`, `year`, `price`) VALUES
(1, 'Toyota Corolla', 'car images/swift pic.png', 'Automatic', '2021', 2559),
(2, 'Kushaq', 'car images/Kushaq pic.png', 'Manual', '2020', 2566),
(3, 'Polo', 'car images/Polo pic.png', 'Automatic', '2019', 2155),
(4, 'Altroz', 'car images/altroz pic.png', 'Manual', '2022', 2079),
(5, 'Innova', 'car images/innova pic.png', 'Manual', '2020', 2929),
(6, 'Vento', 'car images/vento pic.png', 'Manual', '2019', 2405),
(7, 'Amaze', 'car images/amaze pic.png', 'Manual', '2018', 2240),
(8, 'Thar', 'car images/thar pic.png', 'Manual', '2024', 2988),
(9, 'Hector', 'car images/hector pic.png', 'Automatic', '2023', 2215),
(10, 'Wagon R', 'car images/wagonr pic.png', 'Automatic', '2022', 2114);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `car_model` varchar(50) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `car_model`, `rating`, `review`, `created_at`) VALUES
(1, 'lamal', 'lamin23@gmail.com', 'polo', 3, 'good', '2025-05-17 17:39:23'),
(2, 'lamal', 'lamin23@gmail.com', 'polo', 3, 'good', '2025-05-17 17:40:30');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `loc_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`loc_id`, `name`) VALUES
(1, 'Kuttikanam'),
(2, 'Peermade'),
(3, 'Elappara');

-- --------------------------------------------------------

--
-- Table structure for table `users_data`
--

CREATE TABLE `users_data` (
  `userid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phoneno` varchar(15) DEFAULT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `confirm_password` varchar(50) CHARACTER SET armscii8 COLLATE armscii8_general_ci NOT NULL,
  `role` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_data`
--

INSERT INTO `users_data` (`userid`, `username`, `password`, `email`, `phoneno`, `firstname`, `lastname`, `created_at`, `confirm_password`, `role`) VALUES
(1, 'sachin009', '$2y$10$VuCW0pIFp4dpYfp/ZPKulu8WYfEfrBRUiFCmQZGw7g0bxgc6o4zPm', 'eargtg@gmail.com', '2147483647', 'sachin', 'mamu', '2024-06-13 05:43:36', '', 1),
(2, 'kuttan@banglore', '$2y$10$cNLBC76//swDaNj.zt2FZuLLpexw4cr.T3qy/Y850fBEDqkeLvBwG', 'kutu0@gmail.com', '2147483647', 'kuttan', 'panikar', '2024-06-13 05:47:51', 'password', 1),
(3, 'bobby@123', '$2y$10$SZ07v4lkSz45oz8WX0l99eR/lP0Ix2UeupW/F9W7GpnFWqglSN30K', 'boby9@gmail.com', '999999', 'boby', 'lucifer', '2024-06-13 05:51:04', '123', 1),
(5, 'charls', '$2y$10$COEdqhMBrBsRsOLzHSe.OuUS9KFlwOdRZHt4qsz3jZG6kHBERNGnC', 'charls@gmail.com', '988664434', 'charls', 'sabu', '2024-06-24 16:34:32', '123', 1),
(6, 'abu', '$2y$10$7ZWICIW9WIchmQyI.qpgEeI3lTHqSUKZHhtbIsFOQMhvH5LzJUno.', 'abu@gmail.com', '867349', 'abu', 'salim', '2024-06-24 17:55:43', 'salim', 1),
(10, 'josk', '$2y$10$Jiqe5AQSaoT2KtvfPWF64OyBcd0IDj1XIjIwsmBwxv3yyyCn7Ld4i', 'JOS23@gmail.com', '2147483647', 'JOS', 'KUTTY', '2024-06-24 18:21:30', 'pp', 2),
(12, 'huhu', '$2y$10$paKFA4/.6ZsEgOPRLHaD7.vHPE6DOsiJPD5B639vl96oPFTpmfCeW', 'abym23@gmail.com', '2147483647', 'AbyM', 'MAN', '2024-07-04 07:32:47', 'aa', 1),
(15, 'huu123', '$2y$10$5wM0Hv43jOr4ZArnyreiLuPWc6/w0XRRMSGO3mbJJF7nZ1Qvt/SBW', 'hello@gmail.com', '2147483647', 'huhu', 'chruu', '2024-07-04 08:05:29', '', 1),
(19, 'kokoppp', '$2y$10$pdfzkL31kWxcUbX9Salz3eHBy88ZZ4a5Ru.vEVj.zqHjlcZBNw8he', 'kokok23@gmail.com', '2147483647', 'koko', 'k', '2024-07-04 15:20:55', 'rajeevp', 1),
(25, 'anusha21', '$2y$10$23fiauJtVtb24URJA/vNtOyH6S01MwDdzAT8chSvRCAgr/jKQdOE6', 'a@gmail.com', '988664434', 'anusha', 'ms', '2024-07-11 04:50:43', '123234', 2),
(26, 'rtyy', '$2y$10$CwZ8JaGbWBacxKRDkCQy/.X1S/3dfOnf2gcI9XOQUNLJppmB3.FPi', 'dj@gmail.com', '2147483647', 'dona', 'joseph', '2024-07-11 05:01:16', '123456', 2),
(27, 'jp', '$2y$10$OORzB/9aqn17/MUdJ4dcBeNPc9N.1Xh1jzO9rfwU9fLRlgkBGBvGS', 'jp@gmail.com', '987654321', 'jerome', 'peter', '2024-07-19 09:40:25', '098098', 2),
(31, 'dona', '$2y$10$oWAUvqB1IBzE6CrSjKb91ucHUIPPvcDHBVFSbg5ZXOUB87TcQpSre', 'dd@gmail.com', '2147483647', 'donamol', 'joseph', '2024-07-22 08:12:51', '', 2),
(34, 'jpoppy', '$2y$10$AJu9M7b3OHFfsOv4Dv3dPuV72s6w9DMjyVlLv1HR0NN5IHSb6GYk2', 'joppappy@34gmail.com', '2147483647', 'jopappy', 'vellam', '2024-07-24 05:36:41', '', 2),
(37, 'nj@123', '$2y$10$vP95sa/Ejiyks6/x.pvYYuFsIs28rirF1C0n0zbid0GUg0juAU2um', 'nj@gmail.com', '2147483647', 'neeraj', 'chopra', '2024-08-15 09:42:34', '', 2),
(38, 'sj123', '$2y$10$Fg.OcUBeeZKOnggzR6rEkenMtKS8M.I06PQhxHpKm6RK9/944CTnS', 'sj@gmail.com', '2147483647', 'suraj', 'kozhikode', '2024-08-15 09:54:00', '', 2),
(40, 'ikka@12334', '$2y$10$6tOPsIbtD9rhPORZ9qiiAuS8.BZyrDf4tPWVR8aknySFkYRUAv2Au', 'bigb@gmail.com', '9562949318', 'mamooty', 'ikka', '2024-08-15 10:04:37', 'bazooka', 2),
(41, 'jose', '$2y$10$9afCd6aCVSKR1ABvTGVV.OL3FamAkQUElJ.tV4xZAe8Ha1URTaZqq', 'jossjksijs@gmail.com', '6456893623', 'senjil', 'jose', '2024-09-28 12:50:50', '22ubc256', 2),
(42, 'Lamal', '$2y$10$9HEOr5glz1l6z/6pHmfSpeWNZnle6asa6xQFa3BLC7elTSJXYquWe', 'lamin23@gmail.com', '9012354687', 'LAMINE', 'yamal', '2025-05-17 17:22:17', 'Lamal_17', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `availability`
--
ALTER TABLE `availability`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `location_id` (`location_id`);

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`bid`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `location_id` (`location_id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`loc_id`);

--
-- Indexes for table `users_data`
--
ALTER TABLE `users_data`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `firstname` (`firstname`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `availability`
--
ALTER TABLE `availability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `loc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users_data`
--
ALTER TABLE `users_data`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `availability`
--
ALTER TABLE `availability`
  ADD CONSTRAINT `availability_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `availability_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `locations` (`loc_id`) ON DELETE CASCADE;

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `locations` (`loc_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
