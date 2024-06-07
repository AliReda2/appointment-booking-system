-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2024 at 04:03 AM
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
-- Database: `medleb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$nWEjfiXhVXwysX4OkX8WmOCiKi1c7D9GYu/Imm.NV3JGtbOCcbhv.');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int(11) NOT NULL,
  `d_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `day` date NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`id`, `d_id`, `p_id`, `day`, `time`) VALUES
(58, 6, 19, '2024-05-28', '07:00:00'),
(59, 7, 20, '2024-05-28', '08:00:00'),
(60, 7, 20, '2024-05-30', '08:00:00'),
(61, 7, 20, '2024-05-29', '08:00:00'),
(62, 6, 20, '2024-10-28', '07:00:00'),
(63, 7, 23, '2024-06-01', '09:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `assistant`
--

CREATE TABLE `assistant` (
  `id` int(11) NOT NULL,
  `d_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` int(11) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assistant`
--

INSERT INTO `assistant` (`id`, `d_id`, `name`, `email`, `phone`, `password`) VALUES
(5, 6, 'assistant', 'assistant@gmail.com', 70031455, '$2y$10$R3M7D3jCufzEuCuku3wvQOf52aK/wui4L.CWhwaC9xsny27KmjP4S'),
(6, 6, 'Ali Reda', 'alireda203@gmail.com', 70031455, '$2y$10$3gVrdgL8Nq0URqldHak3k.ztnnGG5M43KrgHNkI054KKSAxjNXix.');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` int(20) NOT NULL,
  `spec` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `start_time` time DEFAULT '08:00:00',
  `end_time` time DEFAULT '14:00:00',
  `interval_minutes` int(11) DEFAULT 15
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`id`, `name`, `email`, `phone`, `spec`, `password`, `start_time`, `end_time`, `interval_minutes`) VALUES
(6, 'Doc4', 'doc4@gmail.com', 70073455, 'Brain', '$2y$10$A.aHjZgeldlkeOKATy9Uauq36TodowYwkHaH0by4qV9LHFHYaX6Xi', '07:00:00', '15:00:00', 30),
(7, 'doc2', 'doc2@gmail.com', 81073501, 'bones', '$2y$10$lbg3orzq6G4xqazn2/Zu/eTpOMd17cFnkvB3L511yHPTJJAviNy5W', '08:00:00', '14:00:00', 15),
(9, 'Ali Osseili', 'ali@g', 76313174, 'broken  heart / nese2e', '$2y$10$IeqlDMer0alsI1DqB7FMEemcsXfam7XhMoTQUB5xgmcbu1UYsrz.C', '08:00:00', '14:00:00', 15);

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `id` int(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `phone` int(50) NOT NULL,
  `d_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`id`, `name`, `email`, `password`, `dob`, `phone`, `d_id`) VALUES
(13, 'mahdi', 'patient3@gmail.com', '$2y$10$iVrWYqe8ijNCemyxNOvL0ubOJ/BSH0PCTQ5ldN7yrKh2pCdBeu2Dq', '2005-07-09', 70031478, NULL),
(14, 'medo', 'patient2@gmail.com', '$2y$10$Y.v8PXkeXNGEixUTpZUCn.15sqP6ai4GJjG.3I8NS9feUUua3YquK', '2000-02-27', 81714062, NULL),
(15, 'hadi', 'patient5@gmail.com', '$2y$10$1PtzSjkGEGj6Ub2XrFSB3.CcdXOoXuJGPoZabGGcN3cNWKrE6oEWC', '2004-08-07', 12345678, NULL),
(16, 'Ali Reda', 'ali3@gmail.com', '$2y$10$OPRWRUAkwsazZ2YM.7BPqeV8xL7uKsBiqbmRi4sfAi6FOWYOH3VTm', '2010-01-01', 70031455, NULL),
(17, 'pal', 'patient6@gmail.com', '$2y$10$wPlRMMph6y1LJS3qylW97OFew17344ueMb/TLrz4Hg1wCrfXzYsrC', '2006-12-31', 65876344, 6),
(18, 'mhmd', 'patient7@gmail.com', '$2y$10$XIsx2J5Ngl1OTUYll/7EOeBEV2M/YTwHYvJRe4Qy0O4qij5YFfaUy', '2013-01-01', 70876567, NULL),
(19, 'Ali Reda', 'alireda2003@gmail.com', '$2y$10$OeDCRrQDVeFlGbQzUG./keHFgCeIalzVgpQjUrFXzF2hABT7HZ2W.', '2010-12-18', 70031455, 6),
(20, 'patient', 'patient@gmail.com', '$2y$10$VKBWJ1OuDnrvonhG9syDEeJ15.6T.5hWUGYvLgqzUjOsi9o66waD6', '2006-12-31', 70031455, NULL),
(23, 'Ali', 'ali@gmail', '$2y$10$diB7480v7uDADtT.mX3AF.jvPakHM3ubQrLAAbtDHqeqP.x3pM4Aq', '2004-03-01', 76313174, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `records`
--

CREATE TABLE `records` (
  `id` int(11) NOT NULL,
  `file` varchar(50) NOT NULL,
  `prescription` varchar(50) NOT NULL,
  `p_id` int(50) DEFAULT NULL,
  `d_id` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `records`
--

INSERT INTO `records` (`id`, `file`, `prescription`, `p_id`, `d_id`) VALUES
(10, '61269-luffy.jpg', 'hhhh', 19, 6),
(11, '79208-luffy.jpg', 'gggg', 20, 6),
(12, '78239-luffy.jpg', 'ggg', 17, 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `p_id` (`p_id`),
  ADD KEY `d_id` (`d_id`) USING BTREE;

--
-- Indexes for table `assistant`
--
ALTER TABLE `assistant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `d_id` (`d_id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `records`
--
ALTER TABLE `records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `p_id` (`p_id`,`d_id`),
  ADD KEY `d_id` (`d_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `assistant`
--
ALTER TABLE `assistant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `records`
--
ALTER TABLE `records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`d_id`) REFERENCES `doctor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appointment_ibfk_3` FOREIGN KEY (`p_id`) REFERENCES `patient` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `assistant`
--
ALTER TABLE `assistant`
  ADD CONSTRAINT `assistant_ibfk_1` FOREIGN KEY (`d_id`) REFERENCES `doctor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `records`
--
ALTER TABLE `records`
  ADD CONSTRAINT `records_ibfk_2` FOREIGN KEY (`p_id`) REFERENCES `patient` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `records_ibfk_3` FOREIGN KEY (`d_id`) REFERENCES `doctor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
