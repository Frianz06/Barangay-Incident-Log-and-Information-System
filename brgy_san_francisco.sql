-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2024 at 03:27 PM
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
-- Database: `brgy_san_francisco`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_table`
--

CREATE TABLE `admin_table` (
  `admin_ID#` int(100) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `brgy_role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='This table is only used for brgy officials of san francisco';

--
-- Dumping data for table `admin_table`
--

INSERT INTO `admin_table` (`admin_ID#`, `admin_name`, `admin_email`, `admin_password`, `brgy_role`) VALUES
(1, 'Ychicko Frian', 'ychickolegaspi@gmail.com', '$2y$10$CglCh6HHrgBP9fQ3tRgfD.tZLIdRJ0YGbHY8nV855QmRMzfy2iQSa', 'Barangay Captain');

-- --------------------------------------------------------

--
-- Table structure for table `archive_table`
--

CREATE TABLE `archive_table` (
  `archive_ID` int(11) NOT NULL,
  `incident_ID` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `incident_location` varchar(300) NOT NULL,
  `incident_type` varchar(255) NOT NULL,
  `incident_description` varchar(500) NOT NULL,
  `incident_date` date NOT NULL,
  `incident_time` time(6) NOT NULL,
  `report_timestamp` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `archive_description` varchar(500) NOT NULL,
  `archive_time` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incident_table`
--

CREATE TABLE `incident_table` (
  `incident_ID` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `status` varchar(100) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `incident_location` varchar(300) NOT NULL,
  `incident_type` varchar(255) NOT NULL,
  `incident_description` varchar(500) NOT NULL,
  `incident_date` date NOT NULL,
  `incident_time` time(6) NOT NULL,
  `report_timestamp` timestamp(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resolve_table`
--

CREATE TABLE `resolve_table` (
  `resolve_ID` int(11) NOT NULL,
  `incident_ID` int(11) NOT NULL,
  `resolved_by_admin` varchar(255) NOT NULL,
  `incident_description` varchar(500) NOT NULL,
  `resolution_description` varchar(1000) NOT NULL,
  `date_of_resolution` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `user_ID` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `home_address` varchar(255) DEFAULT NULL,
  `user_role` varchar(20) NOT NULL DEFAULT 'user',
  `account_status` varchar(10) DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`user_ID`, `user_name`, `gender`, `user_email`, `user_password`, `home_address`, `user_role`, `account_status`, `created_at`, `updated_at`) VALUES
(1, 'Ychicko', 'Male', 'ychickolegaspi@gmail.com', '$2y$10$GQrnM75h8P2qPpgDUJHa3OaUajVEQmdaSGJ7yEyk7unnqjmHLO5Wm', 'Blk 40 Lot 14 Valenza Street', 'user', 'active', '2024-12-10 14:23:08', '2024-12-10 14:23:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_table`
--
ALTER TABLE `admin_table`
  ADD PRIMARY KEY (`admin_ID#`);

--
-- Indexes for table `archive_table`
--
ALTER TABLE `archive_table`
  ADD PRIMARY KEY (`archive_ID`),
  ADD UNIQUE KEY `incident_ID` (`incident_ID`);

--
-- Indexes for table `incident_table`
--
ALTER TABLE `incident_table`
  ADD PRIMARY KEY (`incident_ID`);

--
-- Indexes for table `resolve_table`
--
ALTER TABLE `resolve_table`
  ADD PRIMARY KEY (`resolve_ID`),
  ADD UNIQUE KEY `incident_ID` (`incident_ID`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_ID`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_table`
--
ALTER TABLE `admin_table`
  MODIFY `admin_ID#` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `archive_table`
--
ALTER TABLE `archive_table`
  MODIFY `archive_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incident_table`
--
ALTER TABLE `incident_table`
  MODIFY `incident_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resolve_table`
--
ALTER TABLE `resolve_table`
  MODIFY `resolve_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
