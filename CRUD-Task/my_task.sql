-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2025 at 06:40 PM
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
-- Database: `my_task`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT 'Temporary Id',
  `uid` char(10) NOT NULL COMMENT 'User Id',
  `name` varchar(20) NOT NULL COMMENT 'Full name',
  `number` varchar(10) NOT NULL COMMENT 'Number',
  `email` varchar(30) NOT NULL COMMENT 'Email',
  `role` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = Admin,\r\n2 = User',
  `photo` varchar(100) NOT NULL COMMENT 'Photo',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = active,\r\n2 = blocked',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Created at',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Updated at'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uid`, `name`, `number`, `email`, `role`, `photo`, `status`, `created_at`, `updated_at`) VALUES
(5, '6861773129', 'niharika', '8767676876', 'ritik@gmail.com', 1, 'pngwing.com (1).png', 1, '2025-03-10 19:36:34', '2025-03-10 19:36:34'),
(8, '7880244428', 'Ritik kumar', '1234567889', 'rk5771829@gmail.com', 2, '1_wbDheJeATl_PQhPvD_ACmQ.png', 2, '2025-03-11 17:29:37', '2025-03-11 17:29:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Temporary Id', AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
