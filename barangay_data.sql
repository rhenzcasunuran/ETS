-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2023 at 04:08 PM
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
-- Database: `barangay_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `forgot_password_users`
--

CREATE TABLE `forgot_password_users` (
  `reset_id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `otp` int(6) NOT NULL,
  `expiration_time` datetime NOT NULL,
  `is_used` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personnel_users`
--

CREATE TABLE `personnel_users` (
  `personnel_id` bigint(11) NOT NULL,
  `personnel_username` varchar(255) NOT NULL,
  `personnel_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resident_address_book`
--

CREATE TABLE `resident_address_book` (
  `address_entry_id` bigint(20) NOT NULL,
  `resident_id` bigint(20) NOT NULL,
  `street_building_house` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `city_municipality` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `zipcode` int(4) NOT NULL,
  `phone_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resident_address_contact`
--

CREATE TABLE `resident_address_contact` (
  `resident_address_id` bigint(20) NOT NULL,
  `resident_id` bigint(20) NOT NULL,
  `street_building_house` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `zipcode` int(4) NOT NULL,
  `phone_number` int(11) NOT NULL,
  `email_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resident_id_verification`
--

CREATE TABLE `resident_id_verification` (
  `resident_verification_id` bigint(20) NOT NULL,
  `resident_id` bigint(20) NOT NULL,
  `valid_id_type` varchar(255) NOT NULL,
  `valid_id_number` varchar(255) NOT NULL,
  `id_issued_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resident_personal_details`
--

CREATE TABLE `resident_personal_details` (
  `resident_detail_id` bigint(20) NOT NULL,
  `resident_id` bigint(20) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `suffix` varchar(255) NOT NULL DEFAULT 'N/A',
  `birth_date` date NOT NULL,
  `birth_place` varchar(255) NOT NULL,
  `sex` varchar(6) NOT NULL,
  `civil_status` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resident_users`
--

CREATE TABLE `resident_users` (
  `resident_id` bigint(20) NOT NULL,
  `resident_username` varchar(255) NOT NULL,
  `resident_password` varchar(255) NOT NULL,
  `is_account_activated` tinyint(1) NOT NULL DEFAULT 0,
  `account_creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_session` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `forgot_password_users`
--
ALTER TABLE `forgot_password_users`
  ADD PRIMARY KEY (`reset_id`);

--
-- Indexes for table `personnel_users`
--
ALTER TABLE `personnel_users`
  ADD PRIMARY KEY (`personnel_id`);

--
-- Indexes for table `resident_address_book`
--
ALTER TABLE `resident_address_book`
  ADD PRIMARY KEY (`address_entry_id`);

--
-- Indexes for table `resident_address_contact`
--
ALTER TABLE `resident_address_contact`
  ADD PRIMARY KEY (`resident_address_id`);

--
-- Indexes for table `resident_id_verification`
--
ALTER TABLE `resident_id_verification`
  ADD PRIMARY KEY (`resident_verification_id`);

--
-- Indexes for table `resident_personal_details`
--
ALTER TABLE `resident_personal_details`
  ADD PRIMARY KEY (`resident_detail_id`);

--
-- Indexes for table `resident_users`
--
ALTER TABLE `resident_users`
  ADD PRIMARY KEY (`resident_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `forgot_password_users`
--
ALTER TABLE `forgot_password_users`
  MODIFY `reset_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personnel_users`
--
ALTER TABLE `personnel_users`
  MODIFY `personnel_id` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resident_address_book`
--
ALTER TABLE `resident_address_book`
  MODIFY `address_entry_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resident_address_contact`
--
ALTER TABLE `resident_address_contact`
  MODIFY `resident_address_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resident_id_verification`
--
ALTER TABLE `resident_id_verification`
  MODIFY `resident_verification_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resident_personal_details`
--
ALTER TABLE `resident_personal_details`
  MODIFY `resident_detail_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resident_users`
--
ALTER TABLE `resident_users`
  MODIFY `resident_id` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
