-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2023 at 01:20 PM
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
-- Database: `ets`
--

-- --------------------------------------------------------

--
-- Table structure for table `bar_graph`
--

CREATE TABLE `bar_graph` (
  `organization_bar_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `ongoing_event_name_id` int(11) NOT NULL,
  `event_name_id` int(11) NOT NULL,
  `bar_meter` decimal(5,2) NOT NULL,
  `isAnon` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bar_graph`
--

INSERT INTO `bar_graph` (`organization_bar_id`, `organization_id`, `ongoing_event_name_id`, `event_name_id`, `bar_meter`, `isAnon`) VALUES
(65, 1, 24, 6, 0.00, 0),
(66, 2, 24, 6, 0.00, 0),
(67, 3, 24, 6, 0.00, 0),
(68, 4, 24, 6, 0.00, 0),
(69, 5, 24, 6, 0.00, 0),
(70, 6, 24, 6, 0.00, 0),
(71, 7, 24, 6, 0.00, 0),
(72, 8, 24, 6, 0.00, 0),
(73, 1, 25, 7, 0.00, 1),
(74, 2, 25, 7, 0.00, 1),
(75, 3, 25, 7, 0.00, 1),
(76, 4, 25, 7, 0.00, 1),
(77, 5, 25, 7, 0.00, 1),
(78, 6, 25, 7, 0.00, 1),
(79, 7, 25, 7, 0.00, 1),
(80, 8, 25, 7, 0.00, 1),
(81, 1, 26, 8, 0.00, 1),
(82, 2, 26, 8, 0.00, 1),
(83, 3, 26, 8, 0.00, 1),
(84, 4, 26, 8, 0.00, 1),
(85, 5, 26, 8, 0.00, 1),
(86, 6, 26, 8, 0.00, 1),
(87, 7, 26, 8, 0.00, 1),
(88, 8, 26, 8, 0.00, 1),
(89, 1, 27, 9, 0.00, 1),
(90, 2, 27, 9, 0.00, 1),
(91, 3, 27, 9, 0.00, 1),
(92, 4, 27, 9, 0.00, 1),
(93, 5, 27, 9, 0.00, 1),
(94, 6, 27, 9, 0.00, 1),
(95, 7, 27, 9, 0.00, 1),
(96, 8, 27, 9, 0.00, 1),
(97, 1, 28, 10, 0.00, 1),
(98, 2, 28, 10, 0.00, 1),
(99, 3, 28, 10, 0.00, 1),
(100, 4, 28, 10, 0.00, 1),
(101, 5, 28, 10, 0.00, 1),
(102, 6, 28, 10, 0.00, 1),
(103, 7, 28, 10, 0.00, 1),
(104, 8, 28, 10, 0.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bracket_forms`
--

CREATE TABLE `bracket_forms` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `current_column` int(11) NOT NULL DEFAULT 1,
  `node_id_start` int(11) NOT NULL,
  `parent_id_start` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bracket_teams`
--

CREATE TABLE `bracket_teams` (
  `id` int(11) NOT NULL,
  `bracket_form_id` int(11) NOT NULL,
  `bracket_position` int(11) NOT NULL,
  `team_one_id` int(11) DEFAULT NULL,
  `team_two_id` int(11) DEFAULT NULL,
  `event_date_time` datetime DEFAULT NULL,
  `current_column` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category_name`
--

CREATE TABLE `category_name` (
  `category_name_id` int(11) NOT NULL,
  `event_name_id` int(11) NOT NULL,
  `event_type_id` int(11) NOT NULL,
  `category_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_name`
--

INSERT INTO `category_name` (`category_name_id`, `event_name_id`, `event_type_id`, `category_name`) VALUES
(35, 8, 1, 'SAMPLE CATEGORY'),
(36, 9, 1, 'ANOTHER SAMPLE CATEGORY'),
(37, 10, 1, 'EVENT NI KUYA WIL');

-- --------------------------------------------------------

--
-- Table structure for table `competition`
--

CREATE TABLE `competition` (
  `competition_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `schedule` datetime DEFAULT NULL,
  `schedule_end` datetime DEFAULT NULL,
  `is_archived` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `competition`
--

INSERT INTO `competition` (`competition_id`, `event_id`, `schedule`, `schedule_end`, `is_archived`) VALUES
(44, 53, NULL, NULL, 0),
(45, 54, NULL, NULL, 0),
(46, 55, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `criterion`
--

CREATE TABLE `criterion` (
  `criterion_id` int(11) NOT NULL,
  `category_name_id` int(11) NOT NULL,
  `criterion_name` varchar(50) NOT NULL,
  `criterion_percent` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `criterion_scoring`
--

CREATE TABLE `criterion_scoring` (
  `criterion_scoring_id` int(11) NOT NULL,
  `ongoing_criterion_id` int(11) NOT NULL,
  `participants_id` int(11) NOT NULL,
  `judge_id` int(11) NOT NULL,
  `criterion_temp_score` int(2) DEFAULT NULL,
  `criterion_final_score` decimal(4,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_name`
--

CREATE TABLE `event_name` (
  `event_name_id` int(11) NOT NULL,
  `event_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_name`
--

INSERT INTO `event_name` (`event_name_id`, `event_name`) VALUES
(6, 'Buwan ng Wika'),
(7, 'Sports Fest'),
(8, 'SAMPLE EVENT'),
(9, 'ANOTHER SAMPLE EVENT'),
(10, 'BIGYAN NG JAKET');

-- --------------------------------------------------------

--
-- Table structure for table `event_type`
--

CREATE TABLE `event_type` (
  `event_type_id` int(11) NOT NULL,
  `event_type` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_type`
--

INSERT INTO `event_type` (`event_type_id`, `event_type`) VALUES
(1, 'Tournament'),
(2, 'Competition'),
(3, 'Standard');

-- --------------------------------------------------------

--
-- Table structure for table `highlights`
--

CREATE TABLE `highlights` (
  `highlight_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `image_info` varchar(255) NOT NULL,
  `image_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `judges`
--

CREATE TABLE `judges` (
  `judge_id` int(11) NOT NULL,
  `competition_id` int(11) NOT NULL,
  `judge_name` varchar(150) NOT NULL,
  `judge_nickname` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `judges`
--

INSERT INTO `judges` (`judge_id`, `competition_id`, `judge_name`, `judge_nickname`) VALUES
(2, 44, 'Dominic Fernandez', 'Judge A'),
(3, 44, 'Owen Harvey Balocon', 'Judge B'),
(4, 44, 'Arwin Nucuum', 'Judge C'),
(5, 45, 'Josefina Colcol', 'Judge D'),
(6, 45, 'Kimberly Eco', 'Judge E'),
(7, 45, 'Cristopher Alpasa', 'Judge F');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `log_id` bigint(20) NOT NULL,
  `log_date` date NOT NULL,
  `log_time` time NOT NULL,
  `admin_id` int(11) NOT NULL,
  `activity_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`log_id`, `log_date`, `log_time`, `admin_id`, `activity_description`) VALUES
(1, '2023-06-26', '21:42:47', 1, 'Edited in Overall Results'),
(2, '2023-06-26', '21:42:49', 1, 'Edited in Overall Results'),
(3, '2023-06-28', '22:23:11', 1, 'Added in Events'),
(4, '2023-06-28', '22:23:23', 1, 'Added in Events'),
(5, '2023-06-28', '22:24:12', 1, 'Added in Events'),
(6, '2023-06-28', '22:26:22', 1, 'Added in Events'),
(7, '2023-06-28', '22:27:20', 1, 'Added in Events'),
(8, '2023-06-28', '22:31:29', 1, 'Added in Events'),
(9, '2023-06-28', '22:32:01', 1, 'Added in Events'),
(10, '2023-06-28', '22:32:41', 1, 'Added in Events'),
(11, '2023-06-28', '22:34:03', 1, 'Added in Events'),
(12, '2023-06-28', '22:38:34', 1, 'Added in Events'),
(13, '2023-06-28', '22:56:53', 1, 'Added in Events'),
(14, '2023-06-28', '22:58:10', 1, 'Added in Events'),
(15, '2023-06-28', '22:58:39', 1, 'Added in Events'),
(16, '2023-06-28', '23:41:01', 1, 'Added in Events'),
(17, '2023-06-28', '23:42:23', 1, 'Edited in Events'),
(18, '2023-06-28', '23:45:44', 1, 'Edited in Events'),
(19, '2023-06-28', '23:46:53', 1, 'Edited in Events'),
(20, '2023-06-28', '23:51:09', 1, 'Added in Events'),
(21, '2023-06-28', '23:51:54', 1, 'Added in Events'),
(22, '2023-06-28', '23:52:20', 1, 'Edited in Events'),
(23, '2023-06-28', '23:53:30', 1, 'Edited in Events'),
(24, '2023-06-28', '23:53:55', 1, 'Edited in Events'),
(25, '2023-06-28', '23:55:39', 1, 'Added in Events'),
(26, '2023-06-28', '23:56:05', 1, 'Edited in Events'),
(27, '2023-06-28', '23:56:30', 1, 'Edited in Events'),
(28, '2023-06-28', '23:59:52', 1, 'Added in Events'),
(29, '2023-06-29', '00:00:09', 1, 'Edited in Events'),
(30, '2023-06-29', '00:05:28', 1, 'Added in Events'),
(31, '2023-06-29', '00:05:44', 1, 'Edited in Events'),
(32, '2023-07-10', '10:24:28', 1, 'Added in Events'),
(33, '2023-07-10', '10:27:00', 1, 'Added in Events'),
(34, '2023-07-10', '11:01:06', 1, 'Added in Events'),
(35, '2023-07-10', '12:56:02', 1, 'Added in Events'),
(36, '2023-07-10', '13:18:24', 1, 'Added in Events'),
(37, '2023-07-10', '13:38:03', 1, 'Edited in Events'),
(38, '2023-07-10', '13:39:15', 1, 'Edited in Events'),
(39, '2023-07-10', '13:52:23', 1, 'Edited in Events'),
(40, '2023-07-10', '13:52:26', 1, 'Edited in Events'),
(41, '2023-07-10', '13:52:34', 1, 'Edited in Events'),
(42, '2023-07-10', '13:53:28', 1, 'Edited in Events'),
(43, '2023-07-10', '13:53:39', 1, 'Edited in Events'),
(44, '2023-07-10', '13:55:45', 1, 'Edited in Events'),
(45, '2023-07-10', '14:01:20', 1, 'Edited in Events'),
(46, '2023-07-10', '14:30:20', 1, 'Edited in Events'),
(47, '2023-07-10', '14:31:07', 1, 'Edited in Events'),
(48, '2023-07-10', '14:32:43', 1, 'Edited in Events'),
(49, '2023-07-10', '14:34:05', 1, 'Edited in Events'),
(50, '2023-07-10', '14:35:03', 1, 'Edited in Events'),
(51, '2023-07-10', '14:36:31', 1, 'Edited in Events'),
(52, '2023-07-10', '14:36:31', 1, 'Edited in Events'),
(53, '2023-07-10', '14:50:14', 1, 'Edited in Events'),
(54, '2023-07-10', '14:50:20', 1, 'Edited in Events'),
(55, '2023-07-10', '14:50:27', 1, 'Edited in Events'),
(56, '2023-07-10', '14:50:36', 1, 'Edited in Events'),
(57, '2023-07-10', '14:51:05', 1, 'Edited in Events'),
(58, '2023-07-10', '14:56:49', 1, 'Edited in Events'),
(59, '2023-07-10', '14:56:49', 1, 'Edited in Events'),
(60, '2023-07-10', '14:58:34', 1, 'Edited in Events'),
(61, '2023-07-10', '15:00:10', 1, 'Edited in Events'),
(62, '2023-07-10', '15:01:22', 1, 'Edited in Events'),
(63, '2023-07-10', '15:01:42', 1, 'Edited in Events'),
(64, '2023-07-10', '15:02:39', 1, 'Edited in Events'),
(65, '2023-07-10', '15:03:00', 1, 'Edited in Events'),
(66, '2023-07-10', '15:03:00', 1, 'Edited in Events'),
(67, '2023-07-10', '15:09:38', 1, 'Edited in Events'),
(68, '2023-07-10', '15:10:34', 1, 'Edited in Events'),
(69, '2023-07-10', '15:10:34', 1, 'Edited in Events'),
(70, '2023-07-10', '15:12:03', 1, 'Edited in Events'),
(71, '2023-07-10', '15:13:08', 1, 'Edited in Events'),
(72, '2023-07-10', '15:13:08', 1, 'Edited in Events'),
(73, '2023-07-10', '15:13:50', 1, 'Edited in Events'),
(74, '2023-07-10', '15:14:01', 1, 'Edited in Events'),
(75, '2023-07-10', '16:01:57', 1, 'Added in Events'),
(76, '2023-07-10', '16:04:58', 1, 'Added in Events'),
(77, '2023-07-10', '16:05:38', 1, 'Added in Events'),
(78, '2023-07-10', '16:11:55', 1, 'Added in Events'),
(79, '2023-07-10', '16:12:42', 1, 'Added in Events'),
(80, '2023-07-10', '16:13:19', 1, 'Added in Events'),
(81, '2023-07-10', '16:13:42', 1, 'Added in Events'),
(82, '2023-07-10', '16:15:45', 1, 'Added in Events'),
(83, '2023-07-10', '16:16:09', 1, 'Added in Events'),
(84, '2023-07-10', '16:18:34', 1, 'Added in Events'),
(85, '2023-07-10', '16:19:19', 1, 'Added in Events'),
(86, '2023-07-10', '16:22:46', 1, 'Added in Events'),
(87, '2023-07-10', '16:23:13', 1, 'Added in Events'),
(88, '2023-07-10', '16:23:55', 1, 'Added in Events'),
(89, '2023-07-10', '16:24:01', 1, 'Added in Events'),
(90, '2023-07-10', '16:24:24', 1, 'Added in Events'),
(91, '2023-07-10', '16:55:26', 1, 'Added in Events'),
(92, '2023-07-10', '16:55:55', 1, 'Added in Events'),
(93, '2023-07-10', '16:58:22', 1, 'Edited in Events'),
(94, '2023-07-10', '16:58:22', 1, 'Edited in Events'),
(95, '2023-07-10', '16:59:59', 1, 'Edited in Events'),
(96, '2023-07-10', '16:59:59', 1, 'Edited in Events'),
(97, '2023-07-10', '17:01:06', 1, 'Edited in Events'),
(98, '2023-07-10', '17:01:06', 1, 'Edited in Events'),
(99, '2023-07-10', '17:11:47', 1, 'Added in Events'),
(100, '2023-07-10', '17:59:49', 1, 'Added in Events'),
(101, '2023-07-10', '18:01:45', 1, 'Added in Events'),
(102, '2023-07-10', '18:01:58', 1, 'Edited in Events'),
(103, '2023-07-10', '18:06:54', 1, 'Added in Events'),
(104, '2023-07-10', '18:08:09', 1, 'Added in Events'),
(105, '2023-07-10', '18:08:31', 1, 'Added in Events'),
(106, '2023-07-10', '18:12:15', 1, 'Added in Events'),
(107, '2023-07-10', '18:13:55', 1, 'Added in Events'),
(108, '2023-07-13', '21:29:55', 2, 'Added \'HElol\' in event_name(event_name) (Events)'),
(109, '2023-07-14', '20:31:12', 2, 'Added \'3\', \'2\', \'AAAAA\' in category_name(event_name_id, (Events)'),
(110, '2023-07-14', '20:31:17', 2, 'Added \'3\', \'1\', \'BBBBB\' in category_name(event_name_id, (Events)'),
(111, '2023-07-14', '20:31:59', 2, 'Added \'22\', \'20\', \'3\', \'1\', \'BBBBB\', \'ASDSADASDSA\', \'2023-07-14\', \'20:31\' in ongoing_list_of_event (Events)'),
(112, '2023-07-14', '20:33:16', 2, 'Added \'21\', \'20\', \'3\', \'2\', \'AAAAA\', \'asdasdsadsa\', \'2023-07-14\', \'20:33\' in ongoing_list_of_event (Events)'),
(113, '2023-07-14', '20:39:30', 2, 'Added \'3\', \'2\', \'CCCCCC\' in category_name(event_name_id, (Events)'),
(114, '2023-07-14', '20:43:12', 2, 'Added \'23\', \'20\', \'3\', \'2\', \'CCCCCC\', \'asdasdsadas\', \'2023-07-14\', \'20:42\' in ongoing_list_of_event (Events)'),
(115, '2023-07-14', '21:09:59', 2, 'Added \'HAPPY HAPPY\' in event_name(event_name) (Events)'),
(116, '2023-07-14', '21:10:13', 2, 'Added \'4\', \'1\', \'HAHAHAAH\' in category_name(event_name_id, (Events)'),
(117, '2023-07-14', '21:10:39', 2, 'Added \'24\', \'21\', \'4\', \'1\', \'HAHAHAAH\', \'ASDASDAS\', \'2023-07-29\', \'21:10\' in ongoing_list_of_event (Events)'),
(118, '2023-07-14', '21:21:32', 2, 'Added \'23\', \'20\', \'3\', \'2\', \'CCCCCC\', \'ASDASDSAD\', \'2023-07-14\', \'21:21\' in ongoing_list_of_event (Events)'),
(119, '2023-07-15', '09:55:31', 2, 'Added \'20\', \'22\', \'1\', \'2\', \'asdasdasdas\', \'HAHAHA\', \'2023-07-15\', \'09:55\' in ongoing_list_of_event (Events)'),
(120, '2023-07-15', '09:56:00', 2, 'Added \'19\', \'22\', \'1\', \'2\', \'asdasdasdsa\', \'HAHAHAHA\', \'2023-07-16\', \'09:56\' in ongoing_list_of_event (Events)'),
(121, '2023-07-15', '10:24:24', 2, 'Added \'Example Event\' in event_name(event_name) (Events)'),
(122, '2023-07-15', '10:25:05', 2, 'Added \'5\', \'1\', \'Example Category\' in category_name(event_name_id, (Events)'),
(123, '2023-07-15', '10:25:35', 2, 'Added \'25\', \'23\', \'5\', \'1\', \'Example Category\', \'AHAHAHA\', \'2023-07-15\', \'10:26\' in ongoing_list_of_event (Events)'),
(124, '2023-07-15', '10:26:29', 2, 'Added \'21\', \'20\', \'3\', \'2\', \'AAAAA\', \'ASDSADSAD\', \'2023-07-15\', \'10:27\' in ongoing_list_of_event (Events)'),
(125, '2023-07-15', '10:28:45', 2, 'Added \'1\', \'2\', \'Poster Making\' in category_name(event_name_id, (Events)'),
(126, '2023-07-15', '10:31:28', 2, 'Added \'26\', \'22\', \'1\', \'2\', \'Poster Making\', \'ASDASDASD\', \'2023-07-15\', \'10:32\' in ongoing_list_of_event (Events)'),
(127, '2023-07-17', '07:00:01', 2, 'Added \'20\', \'3\', \'3\', \'asdasdsa\', \'2023-07-17\', \'06:00\' in ongoing_list_of_event (Events)'),
(128, '2023-07-17', '08:39:50', 2, 'Added \'4\', \'22\', \'1\', \'1\', \'Chess\', \'asdasdas\', \'2023-07-19\', \'08:39\' in ongoing_list_of_event (Events)'),
(129, '2023-07-17', '08:44:09', 2, 'Updated event_id = \'47\'; in ongoing_list_of_event (Events)'),
(130, '2023-07-17', '08:45:24', 2, 'Updated event_id = \'47\'; in ongoing_list_of_event (Events)'),
(131, '2023-07-17', '09:41:03', 2, 'Added \'19\', \'22\', \'1\', \'2\', \'asdasdasdsa\', \'ASDSADAA\', \'2023-07-17\', \'09:41\' in ongoing_list_of_event (Events)'),
(132, '2023-07-17', '09:41:25', 2, 'Added \'26\', \'22\', \'1\', \'2\', \'Poster Making\', \'HAHAA\', \'2023-07-20\', \'21:41\' in ongoing_list_of_event (Events)'),
(133, '2023-07-17', '14:26:27', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(134, '2023-07-17', '14:26:27', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(135, '2023-07-17', '14:35:34', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(136, '2023-07-17', '14:44:00', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(137, '2023-07-17', '14:45:26', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(138, '2023-07-17', '14:46:58', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(139, '2023-07-17', '14:49:53', 2, 'Updated event_id = \'40\'; in ongoing_list_of_event (Events)'),
(140, '2023-07-17', '14:50:30', 2, 'Updated event_id = \'40\'; in ongoing_list_of_event (Events)'),
(141, '2023-07-17', '14:51:56', 2, 'Updated event_id = \'40\'; in ongoing_list_of_event (Events)'),
(142, '2023-07-17', '14:51:56', 2, 'Updated event_id = \'40\'; in ongoing_list_of_event (Events)'),
(143, '2023-07-17', '14:55:07', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(144, '2023-07-17', '14:55:42', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(145, '2023-07-17', '14:56:11', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(146, '2023-07-17', '14:56:51', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(147, '2023-07-17', '14:57:53', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(148, '2023-07-17', '14:57:53', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(149, '2023-07-17', '15:00:09', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(150, '2023-07-17', '15:00:59', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(151, '2023-07-17', '15:03:29', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(152, '2023-07-17', '15:03:52', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(153, '2023-07-17', '15:04:52', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(154, '2023-07-17', '15:05:20', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(155, '2023-07-17', '15:06:29', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(156, '2023-07-17', '15:06:45', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(157, '2023-07-17', '15:06:45', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(158, '2023-07-17', '15:07:19', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(159, '2023-07-17', '15:10:25', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(160, '2023-07-17', '15:11:05', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(161, '2023-07-17', '15:11:58', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(162, '2023-07-17', '15:12:25', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(163, '2023-07-17', '15:13:29', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(164, '2023-07-17', '15:14:14', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(165, '2023-07-17', '15:14:14', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(166, '2023-07-17', '15:14:38', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(167, '2023-07-17', '15:21:19', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(168, '2023-07-17', '15:21:32', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(169, '2023-07-17', '15:21:50', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(170, '2023-07-17', '15:21:50', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(171, '2023-07-17', '15:22:02', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(172, '2023-07-17', '15:22:54', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(173, '2023-07-17', '15:23:17', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(174, '2023-07-17', '15:23:54', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(175, '2023-07-17', '15:27:53', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(176, '2023-07-17', '15:29:54', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(177, '2023-07-17', '15:29:54', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(178, '2023-07-17', '15:30:56', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(179, '2023-07-17', '15:31:02', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(180, '2023-07-17', '15:31:25', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(181, '2023-07-17', '15:32:54', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(182, '2023-07-17', '15:36:12', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(183, '2023-07-17', '15:37:11', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(184, '2023-07-17', '15:37:32', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(185, '2023-07-17', '15:40:10', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(186, '2023-07-17', '15:41:47', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(187, '2023-07-17', '15:41:59', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(188, '2023-07-17', '15:46:51', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(189, '2023-07-17', '15:49:40', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(190, '2023-07-17', '15:51:27', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(191, '2023-07-17', '15:51:34', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(192, '2023-07-17', '15:51:50', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(193, '2023-07-17', '15:54:15', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(194, '2023-07-17', '15:55:07', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(195, '2023-07-17', '15:55:25', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(196, '2023-07-17', '15:56:47', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(197, '2023-07-17', '15:56:51', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(198, '2023-07-17', '15:56:57', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(199, '2023-07-17', '15:57:50', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(200, '2023-07-17', '15:57:59', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(201, '2023-07-17', '15:58:04', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(202, '2023-07-17', '15:58:21', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(203, '2023-07-17', '18:18:07', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(204, '2023-07-17', '18:24:21', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(205, '2023-07-17', '18:24:23', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(206, '2023-07-17', '18:25:30', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(207, '2023-07-17', '18:27:23', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(208, '2023-07-17', '18:27:33', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(209, '2023-07-17', '18:30:09', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(210, '2023-07-17', '18:31:14', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(211, '2023-07-17', '18:32:02', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(212, '2023-07-17', '18:32:40', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(213, '2023-07-17', '18:33:04', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(214, '2023-07-17', '18:33:14', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(215, '2023-07-17', '18:33:20', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(216, '2023-07-17', '18:33:37', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(217, '2023-07-17', '18:33:37', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(218, '2023-07-17', '18:36:19', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(219, '2023-07-17', '18:37:10', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(220, '2023-07-17', '18:38:03', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(221, '2023-07-17', '18:38:40', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(222, '2023-07-17', '18:38:44', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(223, '2023-07-17', '18:40:58', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(224, '2023-07-17', '18:46:25', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(225, '2023-07-17', '18:52:58', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(226, '2023-07-17', '18:55:45', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(227, '2023-07-17', '18:57:01', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(228, '2023-07-17', '18:57:21', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(229, '2023-07-17', '18:57:51', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(230, '2023-07-17', '19:00:27', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(231, '2023-07-17', '19:00:48', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(232, '2023-07-17', '19:07:24', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(233, '2023-07-17', '19:09:23', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(234, '2023-07-17', '19:10:44', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(235, '2023-07-17', '19:10:58', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(236, '2023-07-17', '19:12:09', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(237, '2023-07-17', '19:13:39', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(238, '2023-07-17', '19:15:15', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(239, '2023-07-17', '19:15:29', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(240, '2023-07-17', '19:16:32', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(241, '2023-07-17', '19:17:30', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(242, '2023-07-17', '19:18:59', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(243, '2023-07-17', '19:19:01', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(244, '2023-07-17', '19:19:09', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(245, '2023-07-17', '19:19:33', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(246, '2023-07-17', '19:20:52', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(247, '2023-07-17', '19:21:16', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(248, '2023-07-17', '19:21:47', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(249, '2023-07-17', '19:25:08', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(250, '2023-07-17', '19:25:30', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(251, '2023-07-17', '19:25:48', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(252, '2023-07-17', '19:26:24', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(253, '2023-07-17', '19:26:45', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(254, '2023-07-17', '19:27:02', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(255, '2023-07-17', '19:29:56', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(256, '2023-07-17', '19:30:06', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(257, '2023-07-17', '19:30:14', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(258, '2023-07-17', '19:30:18', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(259, '2023-07-17', '19:30:36', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(260, '2023-07-17', '19:30:46', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(261, '2023-07-17', '19:30:46', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(262, '2023-07-17', '19:31:06', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(263, '2023-07-17', '19:31:06', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(264, '2023-07-17', '19:31:10', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(265, '2023-07-17', '19:32:11', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(266, '2023-07-17', '19:32:24', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(267, '2023-07-17', '19:32:24', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(268, '2023-07-17', '19:32:44', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(269, '2023-07-17', '19:32:49', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(270, '2023-07-17', '19:32:58', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(271, '2023-07-17', '19:33:01', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(272, '2023-07-17', '19:33:41', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(273, '2023-07-17', '19:34:19', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(274, '2023-07-17', '19:34:35', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(275, '2023-07-17', '19:34:46', 2, 'Updated event_id = \'41\'; in ongoing_list_of_event (Events)'),
(276, '2023-07-17', '19:46:48', 2, 'Updated event_id = \'43\'; in ongoing_list_of_event (Events)'),
(277, '2023-07-17', '19:47:57', 2, 'Updated event_id = \'43\'; in ongoing_list_of_event (Events)'),
(278, '2023-07-17', '19:48:03', 2, 'Updated event_id = \'43\'; in ongoing_list_of_event (Events)'),
(279, '2023-07-17', '20:02:47', 2, 'Updated event_id = \'40\'; in ongoing_list_of_event (Events)'),
(280, '2023-07-17', '20:02:54', 2, 'Updated event_id = \'40\'; in ongoing_list_of_event (Events)'),
(281, '2023-07-17', '20:10:07', 2, 'Updated event_id = \'47\'; in ongoing_list_of_event (Events)'),
(282, '2023-07-17', '22:21:50', 2, 'Updated event_id = \'43\'; in ongoing_list_of_event (Events)'),
(283, '2023-07-17', '22:23:11', 2, 'Updated event_id = \'44\'; in ongoing_list_of_event (Events)'),
(284, '2023-07-17', '22:23:17', 2, 'Updated event_id = \'45\'; in ongoing_list_of_event (Events)'),
(285, '2023-07-17', '22:45:01', 2, 'Updated event_id = \'\'; in ongoing_list_of_event (Events)'),
(286, '2023-07-17', '22:45:01', 2, 'Updated event_id = \'\'; in ongoing_list_of_event (Events)'),
(287, '2023-07-17', '22:45:01', 2, 'Updated event_id = \'\'; in ongoing_list_of_event (Events)'),
(288, '2023-07-17', '22:48:21', 2, 'Updated event_id = \'46\'; in ongoing_list_of_event (Events)'),
(289, '2023-07-17', '22:48:36', 2, 'Updated event_id = \'46\'; in ongoing_list_of_event (Events)'),
(290, '2023-07-17', '22:49:00', 2, 'Updated event_id = \'44\'; in ongoing_list_of_event (Events)'),
(291, '2023-07-17', '22:49:00', 2, 'Updated event_id = \'44\'; in ongoing_list_of_event (Events)'),
(292, '2023-07-17', '22:51:05', 2, 'Updated event_id = \'44\'; in ongoing_list_of_event (Events)'),
(293, '2023-07-17', '22:51:42', 2, 'Updated event_id = \'43\'; in ongoing_list_of_event (Events)'),
(294, '2023-07-17', '22:51:46', 2, 'Updated event_id = \'43\'; in ongoing_list_of_event (Events)'),
(295, '2023-07-17', '22:54:50', 2, 'Updated event_id = \'44\'; in ongoing_list_of_event (Events)'),
(296, '2023-07-17', '22:54:53', 2, 'Updated event_id = \'44\'; in ongoing_list_of_event (Events)'),
(297, '2023-07-17', '22:55:54', 2, 'Updated event_id = \'43\'; in ongoing_list_of_event (Events)'),
(298, '2023-07-17', '22:55:59', 2, 'Updated event_id = \'43\'; in ongoing_list_of_event (Events)'),
(299, '2023-07-17', '22:56:11', 2, 'Updated event_id = \'43\'; in ongoing_list_of_event (Events)'),
(300, '2023-07-17', '22:56:25', 2, 'Updated event_id = \'43\'; in ongoing_list_of_event (Events)'),
(301, '2023-07-17', '22:56:41', 2, 'Updated event_id = \'43\'; in ongoing_list_of_event (Events)'),
(302, '2023-07-17', '22:58:26', 2, 'Updated event_id = \'45\'; in ongoing_list_of_event (Events)'),
(303, '2023-07-17', '23:00:40', 2, 'Updated event_id = \'43\'; in ongoing_list_of_event (Events)'),
(304, '2023-07-17', '23:00:49', 2, 'Updated event_id = \'45\'; in ongoing_list_of_event (Events)'),
(305, '2023-07-17', '23:01:26', 2, 'Updated event_id = \'43\'; in ongoing_list_of_event (Events)'),
(306, '2023-07-17', '23:01:33', 2, 'Updated event_id = \'43\'; in ongoing_list_of_event (Events)'),
(307, '2023-07-17', '23:10:11', 2, 'Updated event_id = \'43\'; in ongoing_list_of_event (Events)'),
(308, '2023-07-17', '23:10:11', 2, 'Updated event_id = \'43\'; in ongoing_list_of_event (Events)'),
(309, '2023-07-17', '23:10:46', 2, 'Updated event_id = \'49\'; in ongoing_list_of_event (Events)'),
(310, '2023-07-17', '23:45:54', 2, 'Added \'Buwan ng Wika\' in event_name(event_name) (Events)'),
(311, '2023-07-17', '23:46:00', 2, 'Added \'Sports Fest\' in event_name(event_name) (Events)'),
(312, '2023-07-17', '23:46:27', 2, 'Added \'6\', \'1\', \'Chess\' in category_name(event_name_id, (Events)'),
(313, '2023-07-17', '23:46:44', 2, 'Added \'6\', \'2\', \'Poster Making Contest\' in category_name(event_name_id, (Events)'),
(314, '2023-07-17', '23:46:56', 2, 'Added \'6\', \'1\', \'Basketball\' in category_name(event_name_id, (Events)'),
(315, '2023-07-17', '23:47:22', 2, 'Added \'6\', \'2\', \'Drawing Contest\' in category_name(event_name_id, (Events)'),
(316, '2023-07-17', '23:47:49', 2, 'Added \'7\', \'1\', \'Basketball Boys\' in category_name(event_name_id, (Events)'),
(317, '2023-07-17', '23:48:00', 2, 'Added \'6\', \'1\', \'Basketball Girls\' in category_name(event_name_id, (Events)'),
(318, '2023-07-17', '23:48:41', 2, 'Added \'7\', \'2\', \'Draw the Mayor\' in category_name(event_name_id, (Events)'),
(319, '2023-07-17', '23:52:29', 2, 'Added \'30\', \'24\', \'6\', \'1\', \'Basketball\', \'Muling saksihan ang paglalaro nang Basketball ng mga estudyante ng PUP Santa Rosa!\', \'2023-07-22\', \'12:00\' in ongoing_list_of_event (Events)'),
(320, '2023-07-17', '23:53:17', 2, 'Added \'33\', \'24\', \'6\', \'1\', \'Basketball Girls\', \'Basketball ng mga kababaihan dito sa PUP!\', \'2023-07-23\', \'17:00\' in ongoing_list_of_event (Events)'),
(321, '2023-07-17', '23:54:17', 2, 'Added \'28\', \'24\', \'6\', \'1\', \'Chess\', \'Nagbabagang labanan ang mangyayari sa ating kompetisyon ng Chess.\', \'2023-07-25\', \'08:00\' in ongoing_list_of_event (Events)'),
(322, '2023-07-17', '23:55:37', 2, 'Added \'31\', \'24\', \'6\', \'2\', \'Drawing Contest\', \'Magsulat, gumuhit! Mga mahuhusay rito, sumali na kayo!\', \'2023-07-17\', \'12:00\' in ongoing_list_of_event (Events)'),
(323, '2023-07-17', '23:56:19', 2, 'Added \'29\', \'24\', \'6\', \'2\', \'Poster Making Contest\', \'Gusto mo bang magkakulay ang buhay mo? Kulayan na natin yan.\', \'2023-07-17\', \'12:00\' in ongoing_list_of_event (Events)'),
(324, '2023-07-17', '23:58:26', 2, 'Added \'34\', \'25\', \'7\', \'2\', \'Draw the Mayor\', \'Mayor mo? mayor ko din yan! Drawing na natin yan\', \'2023-08-01\', \'11:00\' in ongoing_list_of_event (Events)'),
(325, '2023-07-17', '23:59:08', 2, 'Added \'32\', \'25\', \'7\', \'1\', \'Basketball Boys\', \'Sheeshable\', \'2023-08-02\', \'08:00\' in ongoing_list_of_event (Events)'),
(326, '2023-07-18', '00:27:00', 2, 'Updated event_id = \'55\'; in ongoing_list_of_event (Events)'),
(327, '2023-07-18', '00:49:16', 2, 'Updated event_id = \'54\'; in ongoing_list_of_event (Events)'),
(328, '2023-07-18', '01:19:02', 2, 'Updated event_id = \'52\'; in ongoing_list_of_event (Events)'),
(329, '2023-07-18', '01:19:02', 2, 'Updated event_id = \'52\'; in tournament (Events)'),
(330, '2023-07-18', '01:21:26', 2, 'Updated event_id = \'50\'; in ongoing_list_of_event (Events)'),
(331, '2023-07-18', '01:21:26', 2, 'Updated event_id = \'50\'; in tournament (Events)'),
(332, '2023-07-18', '01:21:36', 2, 'Updated event_id = \'51\'; in ongoing_list_of_event (Events)'),
(333, '2023-07-18', '01:21:36', 2, 'Updated event_id = \'51\'; in tournament (Events)'),
(334, '2023-07-18', '01:21:57', 2, 'Updated event_id = \'56\'; in ongoing_list_of_event (Events)'),
(335, '2023-07-18', '01:21:57', 2, 'Updated event_id = \'56\'; in tournament (Events)'),
(336, '2023-07-18', '01:21:57', 2, 'Updated event_id = \'56\'; in ongoing_list_of_event (Events)'),
(337, '2023-07-19', '15:01:48', 1, 'Added \'SAMPLE EVENT\' in event_name(event_name) (Events)'),
(338, '2023-07-19', '15:01:58', 1, 'Added \'8\', \'1\', \'SAMPLE CATEGORY\' in category_name(event_name_id, (Events)'),
(339, '2023-07-19', '15:03:45', 1, 'Added \'35\', \'26\', \'8\', \'1\', \'SAMPLE CATEGORY\', \'SAMPLE DESC\', \'2023-07-19\', \'18:03\' in ongoing_list_of_event (Events)'),
(340, '2023-07-19', '15:12:10', 1, 'Added \'ANOTHER SAMPLE EVENT\' in event_name(event_name) (Events)'),
(341, '2023-07-19', '15:12:25', 1, 'Added \'9\', \'1\', \'ANOTHER SAMPLE CATEGORY\' in category_name(event_name_id, (Events)'),
(342, '2023-07-19', '15:13:01', 1, 'Added \'36\', \'27\', \'9\', \'1\', \'ANOTHER SAMPLE CATEGORY\', \'eweweesseseqwsdasda\', \'2023-07-19\', \'21:12\' in ongoing_list_of_event (Events)'),
(343, '2023-07-19', '15:14:07', 1, 'Updated event_id = \'58\'; in ongoing_list_of_event (Events)'),
(344, '2023-07-19', '15:14:07', 1, 'Updated event_id = \'58\'; in tournament (Events)'),
(345, '2023-07-19', '15:15:05', 1, 'Updated event_id = \'50\'; in ongoing_list_of_event (Events)'),
(346, '2023-07-19', '15:15:05', 1, 'Updated event_id = \'50\'; in tournament (Events)'),
(347, '2023-07-19', '15:19:00', 1, 'Updated event_id = \'58\'; in ongoing_list_of_event (Events)'),
(348, '2023-07-19', '15:25:12', 1, 'Added \'BIGYAN NG JAKET\' in event_name(event_name) (Events)'),
(349, '2023-07-19', '15:25:25', 1, 'Added \'10\', \'1\', \'EVENT NI KUYA WIL\' in category_name(event_name_id, (Events)'),
(350, '2023-07-19', '15:26:51', 1, 'Added \'37\', \'28\', \'10\', \'1\', \'EVENT NI KUYA WIL\', \'PAYB TAU SAN\', \'2023-07-20\', \'18:26\' in ongoing_list_of_event (Events)'),
(351, '2023-07-19', '15:28:21', 1, 'Updated event_id = \'59\'; in ongoing_list_of_event (Events)'),
(352, '2023-07-19', '15:28:21', 1, 'Updated event_id = \'59\'; in tournament (Events)'),
(353, '2023-07-19', '19:03:35', 1, 'Updated bar_graph.ongoing_event_name_id = ? in bar_graph (Overall Results)'),
(354, '2023-07-20', '01:30:40', 1, 'Added \'2023-07-24T00:00\', \'0\', \'wrccce\', \'crewqqwcerwceqr\', \'2023-07-20 01:30:40\', \'1\' in post (Announcements)');

-- --------------------------------------------------------

--
-- Table structure for table `number_of_wins`
--

CREATE TABLE `number_of_wins` (
  `number_of_wins_id` int(11) NOT NULL,
  `number_of_wins` varchar(20) NOT NULL,
  `number_of_wins_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `number_of_wins`
--

INSERT INTO `number_of_wins` (`number_of_wins_id`, `number_of_wins`, `number_of_wins_number`) VALUES
(1, 'Best of One', 1),
(2, 'Best of Three', 3),
(3, 'Best of Five', 5),
(4, 'Best of Seven', 7),
(5, 'Best of Nine', 9);

-- --------------------------------------------------------

--
-- Table structure for table `ongoing_criterion`
--

CREATE TABLE `ongoing_criterion` (
  `ongoing_criterion_id` int(11) NOT NULL,
  `criterion_id` int(11) NOT NULL,
  `category_name_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `criterion_name` varchar(50) NOT NULL,
  `criterion_percent` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ongoing_criterion`
--

INSERT INTO `ongoing_criterion` (`ongoing_criterion_id`, `criterion_id`, `category_name_id`, `event_id`, `criterion_name`, `criterion_percent`) VALUES
(85, 32, 31, 53, 'Clarity', 25),
(86, 33, 31, 53, 'Quality', 25),
(87, 34, 31, 53, 'Neatness', 50),
(88, 30, 29, 54, 'Creativity', 50),
(89, 31, 29, 54, 'Originality', 50),
(91, 35, 34, 55, 'Impression of Art', 100);

-- --------------------------------------------------------

--
-- Table structure for table `ongoing_event_name`
--

CREATE TABLE `ongoing_event_name` (
  `ongoing_event_name_id` int(11) NOT NULL,
  `event_name_id` int(11) NOT NULL,
  `event_name` varchar(25) NOT NULL,
  `year_created` year(4) NOT NULL,
  `is_done` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ongoing_event_name`
--

INSERT INTO `ongoing_event_name` (`ongoing_event_name_id`, `event_name_id`, `event_name`, `year_created`, `is_done`) VALUES
(24, 6, 'Buwan ng Wika', '2023', 1),
(25, 7, 'Sports Fest', '2023', 0),
(26, 8, 'SAMPLE EVENT', '2023', 0),
(27, 9, 'ANOTHER SAMPLE EVENT', '2023', 0),
(28, 10, 'BIGYAN NG JAKET', '2023', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ongoing_list_of_event`
--

CREATE TABLE `ongoing_list_of_event` (
  `event_id` int(11) NOT NULL,
  `ongoing_event_name_id` int(11) NOT NULL,
  `category_name_id` int(11) DEFAULT NULL,
  `event_name_id` int(11) NOT NULL,
  `event_type_id` int(11) NOT NULL,
  `category_name` varchar(25) DEFAULT NULL,
  `event_description` varchar(255) NOT NULL,
  `event_code` varchar(12) DEFAULT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `is_archived` tinyint(1) NOT NULL DEFAULT 0,
  `suggested_status` tinyint(1) NOT NULL DEFAULT 0,
  `overall_include` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ongoing_list_of_event`
--

INSERT INTO `ongoing_list_of_event` (`event_id`, `ongoing_event_name_id`, `category_name_id`, `event_name_id`, `event_type_id`, `category_name`, `event_description`, `event_code`, `event_date`, `event_time`, `is_archived`, `suggested_status`, `overall_include`, `is_deleted`) VALUES
(50, 24, 30, 6, 1, 'Basketball', 'Muling saksihan ang paglalaro nang Basketball ng mga estudyante ng PUP Santa Rosa!', NULL, '2023-07-22', '12:00:00', 0, 0, 1, 0),
(51, 24, 33, 6, 1, 'Basketball Girls', 'Basketball ng mga kababaihan dito sa PUP!', NULL, '2023-07-23', '17:00:00', 0, 0, 1, 0),
(52, 24, 28, 6, 1, 'Chess', 'Nagbabagang labanan ang mangyayari sa ating kompetisyon ng Chess.', NULL, '2023-07-25', '08:00:00', 0, 0, 1, 0),
(53, 24, 31, 6, 2, 'Drawing Contest', 'Magsulat, gumuhit! Mga mahuhusay rito, sumali na kayo!', 'g5uIqokZeOOK', '2023-07-17', '12:00:00', 0, 0, 1, 0),
(54, 24, 29, 6, 2, 'Poster Making Contest', 'Gusto mo bang magkakulay ang buhay mo? Kulayan na natin yan.', '1sqw4rNeDI4q', '2023-07-17', '12:00:00', 0, 0, 0, 0),
(55, 25, 34, 7, 2, 'Draw the Mayor', 'Mayor mo? mayor ko din yan! Drawing na natin yan', 'YYyvDu110fZC', '2023-08-01', '11:00:00', 0, 0, 0, 0),
(56, 25, 32, 7, 1, 'Basketball Boys', 'Sheeshable', NULL, '2023-08-02', '08:00:00', 0, 0, 1, 0),
(57, 26, 35, 8, 1, 'SAMPLE CATEGORY', 'SAMPLE DESC', NULL, '2023-07-19', '18:03:00', 0, 0, 0, 1),
(58, 27, 36, 9, 1, 'ANOTHER SAMPLE CATEGORY', 'eweweesseseqwsdasda', NULL, '2023-07-19', '21:12:00', 0, 0, 0, 1),
(59, 28, 37, 10, 1, 'EVENT NI KUYA WIL', 'PAYB TAU SAN', NULL, '2023-07-20', '18:26:00', 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ongoing_teams`
--

CREATE TABLE `ongoing_teams` (
  `id` int(11) NOT NULL,
  `team_name` varchar(255) DEFAULT NULL,
  `bracket_form_id` int(11) NOT NULL,
  `current_team_status` varchar(255) NOT NULL DEFAULT 'active',
  `current_overall_score` int(11) NOT NULL,
  `current_set_no` int(11) NOT NULL DEFAULT 1,
  `current_score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `organization_id` int(11) NOT NULL,
  `organization_name` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`organization_id`, `organization_name`) VALUES
(0, 'SC'),
(1, 'ACAP'),
(2, 'AECES'),
(3, 'ELITE'),
(4, 'GIVE'),
(5, 'JEHRA'),
(6, 'JMAP'),
(7, 'JPIA'),
(8, 'PIIE');

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `participants_id` int(11) NOT NULL,
  `competition_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `participant_name` varchar(50) NOT NULL,
  `participant_section` varchar(50) NOT NULL,
  `final_score` decimal(5,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`participants_id`, `competition_id`, `organization_id`, `participant_name`, `participant_section`, `final_score`) VALUES
(3, 44, 3, 'Vincent Cosio', '3-2', 77.00),
(4, 44, 4, 'Lance Lira', '2-2', 84.00),
(5, 44, 7, 'Charlene Castro', '4-1', 87.00),
(6, 44, 6, 'Jhimwell Robles', '1-2', 78.00),
(7, 44, 8, 'Renz Esona', '3-1', 80.00),
(8, 45, 1, 'Julianne Climaco', '3-2', 88.00),
(9, 45, 1, 'Raphael Barba', '3-2', 88.00),
(10, 45, 1, 'Kaye Dayo', '3-1', 88.00),
(11, 45, 1, 'Michael Calaguas', '4-2', 88.00),
(12, 45, 1, 'Rhenz Casunuran', '4-1', 88.00),
(13, 45, 2, 'Ephraim Gardoce', '1-1', 89.00),
(14, 45, 2, 'Camille Bermejo', '3-1', 89.00),
(15, 45, 2, 'Louisse Del Mundo', '4-1', 89.00),
(16, 45, 2, 'Junard Calma', '4-2', 89.00),
(17, 45, 2, 'Kathrina Hernandez', '4-2', 89.00),
(18, 45, 5, 'Lance Dalanon', '1-2', 89.50),
(19, 45, 5, 'Rhona Del Rosario', '2-2', 89.50),
(20, 45, 5, 'Sophia Acuzar', '2-1', 89.50),
(21, 45, 5, 'Zemory Casantusan', '4-1', 89.50),
(22, 45, 5, 'Kate INfante', '4-2', 89.50);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `post_calendar` datetime DEFAULT NULL,
  `post_title` varchar(60) NOT NULL,
  `post_description` text NOT NULL,
  `post_cover` text NOT NULL,
  `post_schedule` datetime NOT NULL,
  `post_draft` tinyint(4) NOT NULL DEFAULT 0,
  `post_calendar_type` varchar(8) NOT NULL DEFAULT 'Standard'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `organization_id`, `post_calendar`, `post_title`, `post_description`, `post_cover`, `post_schedule`, `post_draft`, `post_calendar_type`) VALUES
(85, 6, '0000-00-00 00:00:00', 'MARKETISTA SEM-ENDER 2023', '𝐈𝐭\'𝐬 𝐭𝐢𝐦𝐞 𝐭𝐨 𝐥𝐨𝐨𝐤 𝐛𝐚𝐜𝐤 𝐚𝐧𝐝 𝐛𝐞 𝐩𝐫𝐨𝐮𝐝!\r\n\r\nMonths away, and we are at the end of this fruitful academic year that tested our capabilities, integrity, and limits. Setbacks are inevitable, but the blood of a champion runs in our veins, Marketistas! We bounce back stronger and wiser. \r\n\r\nJoin us for this year’s 𝗠𝗮𝗿𝗸𝗲𝘁𝗶𝘀𝘁𝗮 𝗦𝗲𝗺-𝗘𝗻𝗱𝗲𝗿 𝟮𝟬𝟮3, 𝐓𝐫𝐚𝐧𝐬𝐟𝐨𝐫𝐦𝐚𝐭𝐢𝐨𝐧𝐚𝐥 𝐂𝐡𝐚𝐦𝐩𝐢𝐨𝐧𝐬: 𝐔𝐧𝐢𝐟𝐲𝐢𝐧𝐠 𝐃𝐢𝐯𝐞𝐫𝐬𝐢𝐭𝐲 𝐓𝐡𝐫𝐨𝐮𝐠𝐡 𝐂𝐚𝐦𝐚𝐫𝐚𝐝𝐞𝐫𝐢𝐞. A walkthrough of the splendid year of the marketing community.\r\n\r\n𝐏𝐚𝐜𝐤 𝐲𝐨𝐮𝐫 𝐭𝐡𝐢𝐧𝐠𝐬 𝐚𝐧𝐝 𝐜𝐞𝐥𝐞𝐛𝐫𝐚𝐭𝐞 𝐰𝐢𝐭𝐡 𝐮𝐬!\r\n\r\n#MarketistaSemEnder2023\r\n#JMAPUPSRC\r\n#JMAPBatchZeta\r\n#BreakBarriersandCreateMeaningfulConnections', 'cover-JMAP.png', '2023-07-08 01:32:36', 0, 'Standard'),
(86, 6, '0000-00-00 00:00:00', 'Larong Pinoy', '𝐋𝐞𝐭\'𝐬 𝐠𝐨 𝐛𝐚𝐜𝐤 𝐭𝐨 𝐨𝐮𝐫 𝐫𝐨𝐨𝐭𝐬, 𝐈𝐬𝐤𝐨 𝐚𝐧𝐝 𝐈𝐬𝐤𝐚!\r\nLet’s go out with a bang with 𝐋𝐚𝐫𝐨𝐧𝐠 𝐏𝐢𝐧𝐨𝐲, which will bring us back to our nostalgic childhood games that will definitely unlock fond memories as we create brand-new ones with our fellow Marketistas. \r\n\r\n𝗠𝘂𝘀𝘁𝗲𝗿 𝘆𝗼𝘂𝗿 𝘀𝗸𝗶𝗹𝗹𝘀 𝗮𝗻𝗱 𝗰𝗮𝗹𝗹 𝘆𝗼𝘂𝗿 𝗽𝗹𝗮𝘆𝗺𝗮𝘁𝗲𝘀!\r\n\r\n𝗟𝗮𝗿𝗼𝗻𝗴 𝗣𝗶𝗻𝗼𝘆\r\nhttps://l.messenger.com/l.php?u=https%3A%2F%2Fdocs.google.com%2F...%2F1Yk368pwBdx5FCSQ8sHki...%2Fedit&h=AT1btJTrzHodgpUFeqMY7SH5W0r9qQoVRVsXe3GqGpeeuyZ_YWnRHOOUzEbVpkHw5H8e0ScD-F40P_ul-NewVrcEe_49QGR_ruLQxOvGTYp0LpxHlLeDJWl1bmVY50fot4SCzA\r\n\r\n#MarketistaSemEnder2023\r\n#JMAPPUPSRC\r\n#JMAPBatchZeta\r\n#BreakBarriersCreateMeaningfulConnections', '86_COVER_64ac412a6470b.png', '2023-07-11 01:34:34', 0, 'Standard'),
(87, 6, '0000-00-00 00:00:00', 'EntrePinoy On-the-Go', '\"Do not look at yourself because you are too young or inexperienced in having a business.\" - Sir. Ramirez\r\n𝗥𝗘𝗔𝗗𝗬, 𝗦𝗘𝗧, 𝗦𝗧𝗔𝗥𝗧! ✨\r\nYesterday, the Junior Marketing Association of the Philippines (SRC) successfully participated in an event entitled 𝐄𝐧𝐭𝐫𝐞𝐏𝐢𝐧𝐨𝐲 𝐎𝐧-𝐭𝐡𝐞-𝐆𝐨: 𝐓𝐡𝐞 𝐔𝐥𝐭𝐢𝐦𝐚𝐭𝐞 𝐆𝐮𝐢𝐝𝐞 𝐚𝐧𝐝 𝐓𝐢𝐩𝐬 𝐭𝐨 𝐛𝐞 𝐚𝐧 𝐄𝐟𝐟𝐞𝐜𝐭𝐢𝐯𝐞 𝐒𝐭𝐚𝐫𝐭-𝐮𝐩 𝐄𝐧𝐭𝐫𝐞𝐩𝐫𝐞𝐧𝐞𝐮𝐫, which lasted from 9AM to 4PM at the PUPSRC Multi-Purpose Hall. This was attended by fourth-year marketing students who will soon use the knowledge imparted by guest speaker 𝐂𝐚𝐞𝐬𝐞𝐫 𝐀𝐩𝐨𝐥𝐢𝐧𝐚𝐫 𝐑𝐚𝐦𝐢𝐫𝐞𝐳 𝐉𝐫. 𝐏𝐡𝐃 as they embark on their own journeys.\r\nLet us all take in these wise words left by Mr. Ramirez and not let fear overpower our drive to try new ventures. Embrace the uncertainty, and do not be afraid to fail and try again.\r\nHave courage, Marketistas! Thank you, City Cooperative Development Office for conducting this seminar.💛\r\n#JMAPPUPSRC\r\n#JMAPBatchZeta\r\n#BreakBarriersCreateMeaningfulConnections', 'cover-JMAP.png', '2023-07-08 01:36:40', 0, 'Standard'),
(89, 3, '2023-07-01 00:00:00', 'Project T.A.L.E.N.T.', '𝗜𝗴𝗻𝗶𝘁𝗲 𝘆𝗼𝘂𝗿 𝘀𝗸𝗶𝗹𝗹𝘀 𝗮𝗻𝗱 𝘂𝗻𝗹𝗲𝗮𝘀𝗵 𝘆𝗼𝘂𝗿 𝗽𝗼𝘁𝗲𝗻𝘁𝗶𝗮𝗹 𝘄𝗶𝘁𝗵 \"𝗣𝗿𝗼𝗷𝗲𝗰𝘁 𝗧𝗔𝗟𝗘𝗡𝗧\"! 🚀\r\n\r\nWhether you\'re an aspiring designer, a meticulous tester, a creative graphic artist, or a budding web developer, Project TALENT has something in store for you. \r\n\r\n📅 Mark your calendars for July 1, 2023, from 8:00am to 6:00pm, as we embark on a transformative journey through four exciting topics: \r\n(1) Web Development\r\n(2) UI/UX\r\n(3) Graphics, and;\r\n(4) Quality Assurance\r\n\r\nDon\'t miss your chance to gain valuable insights into these cutting-edge fields. Each seminar is limited to only 60 slots, so make sure to secure your spot early! ⏰\r\n\r\nEmbrace the future of technology and embrace your true potential. Register for Project TALENT and unlock the doors to endless possibilities! 🎉\r\n\r\nPlease take note that this event will be available exclusively to ELITE members only. Registration will be open on June 26 (Monday). \r\n\r\nStay tuned for more details and exciting announcements in the coming days. See you there, ITellectuals! 🧡🖤', '89_COVER_64ac43e9673b2.jpg', '2023-06-19 01:46:17', 0, 'Standard'),
(92, 3, '0000-00-00 00:00:00', 'Congratulations to our current Vice President - External', 'Radiant, graceful, and crowned with victory. Congratulations to our current Vice President - External and the newly crowned Binibining Market Area 2023, Louisse Del Mundo! 💐\r\nYour ELITE Family is proud of you! 🧡🖤', '92_COVER_64ac451d67e26.jpg', '2023-07-11 01:51:25', 0, 'Standard'),
(93, 2, '2023-07-08 00:00:00', 'Unlocking Your Professional Potential', 'Heads up Future Engineers!\r\nWe are excited to invite you to the last seminar for this semester of BS ECE 4-1! Join us on July 08 at 9:30 am in the morning for a webinar via Google Meet. Our theme for this seminar is \"Unlocking Your Professional Potential: Mastering the Art of Resume Building and Interview Success,\" brought to you by Team July of PUP Santa Rosa BS ECE 4-1 class.\r\n\r\nWe are honored to have Ms. Ancelle Rose P. Alfonso as our confident speaker. Ms. Alfonso is a Human Resource Timekeeping specialist at Steelpro, Inc. and a Behavioral Therapist at The Bright Future Behavioral Center. Her expertise in both fields will provide valuable insights and practical tips to help you excel in resume writing and job interviews.\r\n\r\nThis webinar aims to equip you with the skills and knowledge needed to write a proper resume and present yourself confidently in a job interview. It is particularly relevant for third-year students who are preparing for their internships and want to enhance their skills to secure their dream jobs. Fourth-year students are also encouraged to attend as it is never too late to improve your presentation skills and increase your chances of success.\r\n\r\nTo join this informative session, simply fill out the registration form provided below, and the webinar link will be emailed to you.\r\n\r\nRegistration Link: https://forms.gle/z4FDRWbgNgCp6Mff9\r\n\r\nDon\'t miss out on this opportunity to enhance your professional development and take a step closer to achieving your career goals.\r\n\r\nWe are looking  forward to your active participation!', 'cover-AECES.png', '2023-07-07 01:54:30', 0, 'Standard'),
(94, 2, '2023-05-12 00:00:00', 'Bridging the Gap', '𝗕𝗿𝗶𝗱𝗴𝗶𝗻𝗴 𝘁𝗵𝗲 𝗚𝗮𝗽: 𝗘𝗺𝗽𝗼𝘄𝗲𝗿𝗶𝗻𝗴 𝘁𝗵𝗲 𝗩𝗶𝘁𝗮𝗹 𝗥𝗼𝗹𝗲 𝗼𝗳 𝗘𝗹𝗲𝗰𝘁𝗿𝗼𝗻𝗶𝗰𝘀 𝗘𝗻𝗴𝗶𝗻𝗲𝗲𝗿𝘀 𝗶𝗻 𝘁𝗵𝗲 𝗠𝗲𝗱𝗶𝗰𝗮𝗹 𝗙𝗶𝗲𝗹𝗱\r\n\r\nCalling all Electronics Engineering Students! Join us in our upcoming seminar as we delve into the crucial role of electronics engineers in advancing medical technology. Be part of the movement in \'Bridging the Gap\' and discover the opportunities for technological innovation in the field of medicine. Register now and empower yourself to make a difference!\r\n\r\nwith the topic of \"𝗕𝗿𝗶𝗱𝗴𝗶𝗻𝗴 𝘁𝗵𝗲 𝗚𝗮𝗽: 𝗘𝗺𝗽𝗼𝘄𝗲𝗿𝗶𝗻𝗴 𝘁𝗵𝗲 𝗩𝗶𝘁𝗮𝗹 𝗥𝗼𝗹𝗲 𝗼𝗳 𝗘𝗹𝗲𝗰𝘁𝗿𝗼𝗻𝗶𝗰𝘀 𝗘𝗻𝗴𝗶𝗻𝗲𝗲𝗿𝘀 𝗶𝗻 𝘁𝗵𝗲 𝗠𝗲𝗱𝗶𝗰𝗮𝗹 𝗙𝗶𝗲𝗹𝗱\"\r\n\r\nPlease be advised that the number of available slots for this event is 𝗹𝗶𝗺𝗶𝘁𝗲𝗱 𝘁𝗼 𝟳𝟱, 𝘄𝗶𝘁𝗵 𝘁𝗵𝗲 𝗲𝘅𝗰𝗹𝘂𝘀𝗶𝗼𝗻 𝗼𝗳 𝟰𝘁𝗵-𝘆𝗲𝗮𝗿 𝘀𝘁𝘂𝗱𝗲𝗻𝘁𝘀. We highly encourage interested participants to register at the earliest possible time.\r\n\r\n𝗪𝗵𝗲𝗻: May 12, 2023 | Friday\r\n𝗪𝗵𝗲𝗿𝗲: PUP - Sta. Rosa Campus (AVR)\r\n𝗧𝗶𝗺𝗲: 8:00 AM- 12:00 PM\r\n𝗦𝗽𝗲𝗮𝗸𝗲𝗿: Engr. Mark Dairen C. Camcaman\r\n\r\nhttps://bit.ly/Engr_in_Med', '94_COVER_64ac465fc85b3.png', '2023-05-10 01:56:47', 0, 'Standard'),
(95, 5, '2023-07-15 00:00:00', 'SOMETHING BIG IS COMING!', '📢 Save the Date! 🗓️\r\n\r\nJoin us, Humanistas, on July 15th as we dive into the world of innovation, technology, and transformative management strategies. Discover how the synergy of these elements can unlock limitless potential, driving both businesses and society forward.\r\n\r\nGet ready for a thought-provoking event that will empower you with the knowledge and insights needed to navigate the ever-evolving landscape. Together, we\'ll explore cutting-edge technologies, share best practices, and discuss effective strategies for success.\r\n\r\nDon\'t miss out on this opportunity to connect with industry leaders, entrepreneurs, and change-makers. Mark your calendars and join us on July 15th to unlock the power of technology and effective management for a brighter future! 🌐💼✨', '95_COVER_64ac470dc541b.png', '2023-07-01 01:59:41', 0, 'Standard'),
(96, 8, '0000-00-00 00:00:00', 'Unleash Your Colors: Embrace, Empower, and Celebrate Pride!', 'The Philippine Institute of Industrial Engineers is thrilled to join the worldwide celebration of 𝗣𝗿𝗶𝗱𝗲 𝗠𝗼𝗻𝘁𝗵, as advocates for diversity, inclusion, and equality, we stand tall and proud, ready to make a difference.\r\n\r\nThis 𝗣𝗿𝗶𝗱𝗲 𝗠𝗼𝗻𝘁𝗵, we invite you to join us in celebrating the power of unity, acceptance, and self-expression by supporting our very own PIIE members who will unleash their colors by embracing, empowering, and celebrating their true self. \r\n\r\n𝗛𝗮𝗽𝗽𝘆 𝗣𝗿𝗶𝗱𝗲 𝗠𝗼𝗻𝘁𝗵 from the Philippine Institute of Industrial Engineers! Let\'s make this a month of love, acceptance, and celebration that will reverberate throughout the year. 🤝🌟', '96_COVER_64ac47b7ba053.png', '2023-06-24 02:02:31', 0, 'Standard'),
(97, 7, '0000-00-00 00:00:00', 'Decoding the Ledger: Exercise Your Accounting Brain!', 'Attention 𝐉𝐏𝐈𝐀𝐍𝐬! Prepare to put your accounting skills to the test with our exciting new activity, 𝐃𝐞𝐜𝐨𝐝𝐢𝐧𝐠 𝐭𝐡𝐞 𝐋𝐞𝐝𝐠𝐞𝐫! \r\n\r\nGet ready to exercise your brain cells and refresh your knowledge in a fun and engaging way. We challenge you to provide your answers and guesses before we unveil the correct solutions. \r\n\r\nGet ready for more thrilling accounting adventures!\r\n\r\n𝗤𝘂𝗲𝘀𝘁𝗶𝗼𝗻: 𝗣𝗨𝗣 𝗦𝗥𝗖 𝗔𝗰𝗮𝗱𝗲𝗺𝗶𝗰 𝗖𝗼𝗺𝗺𝗶𝘁𝘁𝗲𝗲 𝟮𝟮𝟮𝟯\r\n𝗣𝗿𝗼𝗷𝗲𝗰𝘁 𝗯𝘆: 𝗣𝗨𝗣 𝗦𝗥𝗖 𝗠𝘂𝗹𝘁𝗶𝗺𝗲𝗱𝗶𝗮 𝗖𝗼𝗺𝗺𝗶𝘁𝘁𝗲𝗲 𝟮𝟮𝟮𝟯\r\n𝗟𝗮𝘆𝗼𝘂𝘁: 𝗠𝗮𝗿𝗶𝗲𝗹 𝗛𝗲𝗿𝗺𝗼𝘀𝗼 & 𝗝𝗮𝗻𝗲 𝗣𝗮𝗻𝗰𝗵𝗮', 'cover-JPIA.png', '2023-03-03 11:03:55', 0, 'Standard'),
(98, 7, '0000-00-00 00:00:00', 'Winners of REVAMP Academic Webinar Series Raffle Games', 'We are thrilled to announce the triumphant recipients of our raffle games during the REVAMP Academic Webinar Series: Bridging the Gaps towards Excellence! All the prizes have been successfully dispatched to the winners\' respective email addresses. If you have any concerns or inquiries regarding this matter, please don\'t hesitate to reach out to us via the 𝑷𝑼𝑷 𝑺𝑹𝑪 𝑱𝑷𝑰𝑨 𝑭𝒂𝒄𝒆𝒃𝒐𝒐𝒌 𝑷𝒂𝒈𝒆 or contact our 𝑽𝑷 𝒇𝒐𝒓 𝑨𝒄𝒂𝒅𝒆𝒎𝒊𝒄𝒔, 𝑱𝒂𝒏𝒆𝒍𝒍𝒂 𝑴𝒂𝒓𝒂𝒏̃𝒐.\r\n\r\nOnce again, we extend our warmest congratulations to all the winners!\r\n\r\nSponsors:\r\n🍄 𝗥𝗲𝗶𝗴𝗻𝗮 & 𝗥𝗼𝗴𝗴𝗶𝗲 𝗔𝗽𝗮𝗿𝘁𝗺𝗲𝗻𝘁\r\n🍰 𝗝𝗼𝘆\'𝘀 𝗣𝘂𝘁𝗼𝗰𝗮𝗸𝗲:\r\n🧶 𝗥𝗲𝗰𝗿𝗼𝗰𝗵𝗲𝘁\r\n🏢 𝗙𝗿𝗮𝗻𝗰𝗵𝗶𝘀𝗲𝗠𝗮𝗻𝗶𝗹𝗮.𝗰𝗼𝗺\r\n🎓 𝗖𝗣𝗔 𝗢𝗻𝗹𝗶𝗻𝗲 𝗥𝗲𝘃𝗶𝗲𝘄 𝗦𝗰𝗵𝗼𝗼𝗹\r\n🔧 𝗔𝘀𝗵 𝗧𝗲𝗰𝗵\r\n📜 𝗣𝗮𝗽𝗲𝗿𝗹𝗮𝗻𝗱\r\n🍰 𝗔𝗘\'𝘀 𝗦𝘄𝗲𝗲𝘁 𝗖𝗿𝗲𝗮𝘁𝗶𝗼𝗻𝘀\r\n❄️ 𝗜𝗰𝘆 𝗦𝗼𝗹𝗲𝘀\r\n\r\nLayout: Myk De Mesa', 'cover-JPIA.png', '2023-03-03 02:06:03', 0, 'Standard'),
(99, 0, '0000-00-00 00:00:00', '19th Cityhood Anniversary', 'By virtue of Presidential Proclamation no. 268, July 10, 2023, Monday, is hereby declared as a Special Non-Working Holiday in the City of Santa Rosa, Laguna. This is due to the celebration of its 19th Cityhood Anniversary\r\n\r\nPlease be guided accordingly. Thank you.', 'cover-SC.png', '2023-07-11 02:08:03', 0, 'Standard'),
(100, 0, '2023-07-24 00:00:00', 'wrccce', 'crewqqwcerwceqr', 'cover-SC.png', '2023-07-20 01:30:40', 1, 'Standard');

-- --------------------------------------------------------

--
-- Table structure for table `post_photo`
--

CREATE TABLE `post_photo` (
  `photo_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `file_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_photo`
--

INSERT INTO `post_photo` (`photo_id`, `post_id`, `file_name`) VALUES
(26, 85, '85_PHOTO_64ac40b4af822.png'),
(27, 87, '87_PHOTO_64ac41a80e710.jpg'),
(28, 87, '87_PHOTO_64ac41a80f1f2.jpg'),
(29, 87, '87_PHOTO_64ac41a80fa96.jpg'),
(30, 87, '87_PHOTO_64ac41a8102ff.jpg'),
(32, 89, '89_PHOTO_64ac43e967fda.jpg'),
(33, 89, '89_PHOTO_64ac43e968a6f.jpg'),
(34, 89, '89_PHOTO_64ac43e9693ea.jpg'),
(35, 89, '89_PHOTO_64ac43e969dbd.jpg'),
(36, 92, '92_PHOTO_64ac451d68731.jpg'),
(37, 94, '94_PHOTO_64ac465fc90c1.png'),
(38, 95, '95_PHOTO_64ac470dc60e9.png'),
(39, 96, '96_PHOTO_64ac47b7baa6e.png'),
(40, 96, '96_PHOTO_64ac47b7bb2f6.png'),
(41, 97, '97_PHOTO_64ac480b247eb.png'),
(42, 98, '98_PHOTO_64ac488b36afe.jpg'),
(43, 98, '98_PHOTO_64ac488b37376.jpg'),
(44, 98, '98_PHOTO_64ac488b37cc8.jpg'),
(45, 98, '98_PHOTO_64ac488b3862e.jpg'),
(46, 98, '98_PHOTO_64ac488b38df0.jpg'),
(47, 98, '98_PHOTO_64ac488b395c0.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `score_rule`
--

CREATE TABLE `score_rule` (
  `id` int(11) NOT NULL,
  `bracket_form_id` int(11) NOT NULL,
  `set_no` int(11) NOT NULL,
  `max_value` int(11) NOT NULL,
  `game_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tournament`
--

CREATE TABLE `tournament` (
  `tournament_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `number_of_wins_id` int(11) NOT NULL,
  `has_set_tournament` tinyint(1) NOT NULL DEFAULT 0,
  `bracket_form_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tournament`
--

INSERT INTO `tournament` (`tournament_id`, `event_id`, `number_of_wins_id`, `has_set_tournament`, `bracket_form_id`) VALUES
(12, 50, 4, 0, NULL),
(13, 51, 5, 0, NULL),
(14, 52, 3, 0, NULL),
(15, 56, 5, 0, NULL),
(16, 57, 1, 0, NULL),
(17, 58, 4, 0, NULL),
(18, 59, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tournament_score_archive`
--

CREATE TABLE `tournament_score_archive` (
  `id` int(11) NOT NULL,
  `team_name` varchar(255) DEFAULT NULL,
  `bracket_form_id` int(11) NOT NULL,
  `current_team_status` varchar(255) NOT NULL,
  `current_overall_score` int(11) NOT NULL,
  `current_set_no` int(11) NOT NULL,
  `current_score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `admin_id` int(11) NOT NULL,
  `user_username` varchar(20) NOT NULL,
  `user_password` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`admin_id`, `user_username`, `user_password`) VALUES
(1, 'admin', 'admin'),
(2, 'kennethpogi', 'password');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bar_graph`
--
ALTER TABLE `bar_graph`
  ADD PRIMARY KEY (`organization_bar_id`),
  ADD KEY `organization_id` (`organization_id`),
  ADD KEY `ongoing_event_name_id` (`ongoing_event_name_id`);

--
-- Indexes for table `bracket_forms`
--
ALTER TABLE `bracket_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bracket_teams`
--
ALTER TABLE `bracket_teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bracket_form_id` (`bracket_form_id`);

--
-- Indexes for table `category_name`
--
ALTER TABLE `category_name`
  ADD PRIMARY KEY (`category_name_id`),
  ADD KEY `event_name_id` (`event_name_id`),
  ADD KEY `event_type_id` (`event_type_id`);

--
-- Indexes for table `competition`
--
ALTER TABLE `competition`
  ADD PRIMARY KEY (`competition_id`),
  ADD UNIQUE KEY `event_id_2` (`event_id`),
  ADD UNIQUE KEY `event_id_3` (`event_id`),
  ADD UNIQUE KEY `event_id_4` (`event_id`),
  ADD UNIQUE KEY `event_id_5` (`event_id`),
  ADD UNIQUE KEY `event_id_6` (`event_id`),
  ADD UNIQUE KEY `event_id_7` (`event_id`),
  ADD UNIQUE KEY `event_id_8` (`event_id`),
  ADD UNIQUE KEY `event_id_9` (`event_id`),
  ADD UNIQUE KEY `event_id_10` (`event_id`),
  ADD UNIQUE KEY `event_id_11` (`event_id`),
  ADD UNIQUE KEY `event_id_12` (`event_id`),
  ADD UNIQUE KEY `event_id_13` (`event_id`),
  ADD UNIQUE KEY `event_id_14` (`event_id`),
  ADD UNIQUE KEY `event_id_15` (`event_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `criterion`
--
ALTER TABLE `criterion`
  ADD PRIMARY KEY (`criterion_id`),
  ADD KEY `category_name_id` (`category_name_id`);

--
-- Indexes for table `criterion_scoring`
--
ALTER TABLE `criterion_scoring`
  ADD PRIMARY KEY (`criterion_scoring_id`),
  ADD KEY `participants_id` (`participants_id`),
  ADD KEY `ongoing_criterion_id` (`ongoing_criterion_id`),
  ADD KEY `judge_id` (`judge_id`);

--
-- Indexes for table `event_name`
--
ALTER TABLE `event_name`
  ADD PRIMARY KEY (`event_name_id`);

--
-- Indexes for table `event_type`
--
ALTER TABLE `event_type`
  ADD PRIMARY KEY (`event_type_id`);

--
-- Indexes for table `highlights`
--
ALTER TABLE `highlights`
  ADD PRIMARY KEY (`highlight_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `judges`
--
ALTER TABLE `judges`
  ADD PRIMARY KEY (`judge_id`),
  ADD KEY `competition_id` (`competition_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `number_of_wins`
--
ALTER TABLE `number_of_wins`
  ADD PRIMARY KEY (`number_of_wins_id`);

--
-- Indexes for table `ongoing_criterion`
--
ALTER TABLE `ongoing_criterion`
  ADD PRIMARY KEY (`ongoing_criterion_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `ongoing_event_name`
--
ALTER TABLE `ongoing_event_name`
  ADD PRIMARY KEY (`ongoing_event_name_id`);

--
-- Indexes for table `ongoing_list_of_event`
--
ALTER TABLE `ongoing_list_of_event`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `event_type_id` (`event_type_id`),
  ADD KEY `ongoing_event_name_id` (`ongoing_event_name_id`);

--
-- Indexes for table `ongoing_teams`
--
ALTER TABLE `ongoing_teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bracket_form_id` (`bracket_form_id`);

--
-- Indexes for table `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`organization_id`);

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`participants_id`),
  ADD KEY `organization_id` (`organization_id`),
  ADD KEY `competition_id` (`competition_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `organization_id` (`organization_id`);

--
-- Indexes for table `post_photo`
--
ALTER TABLE `post_photo`
  ADD PRIMARY KEY (`photo_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `score_rule`
--
ALTER TABLE `score_rule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bracket_form_id` (`bracket_form_id`);

--
-- Indexes for table `tournament`
--
ALTER TABLE `tournament`
  ADD PRIMARY KEY (`tournament_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `number_of_wins_id` (`number_of_wins_id`),
  ADD KEY `bracket_form_id` (`bracket_form_id`);

--
-- Indexes for table `tournament_score_archive`
--
ALTER TABLE `tournament_score_archive`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bracket_form_id` (`bracket_form_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`admin_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bar_graph`
--
ALTER TABLE `bar_graph`
  MODIFY `organization_bar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `bracket_forms`
--
ALTER TABLE `bracket_forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bracket_teams`
--
ALTER TABLE `bracket_teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category_name`
--
ALTER TABLE `category_name`
  MODIFY `category_name_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `competition`
--
ALTER TABLE `competition`
  MODIFY `competition_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `criterion`
--
ALTER TABLE `criterion`
  MODIFY `criterion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `criterion_scoring`
--
ALTER TABLE `criterion_scoring`
  MODIFY `criterion_scoring_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `event_name`
--
ALTER TABLE `event_name`
  MODIFY `event_name_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `event_type`
--
ALTER TABLE `event_type`
  MODIFY `event_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `highlights`
--
ALTER TABLE `highlights`
  MODIFY `highlight_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `judges`
--
ALTER TABLE `judges`
  MODIFY `judge_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=355;

--
-- AUTO_INCREMENT for table `number_of_wins`
--
ALTER TABLE `number_of_wins`
  MODIFY `number_of_wins_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ongoing_criterion`
--
ALTER TABLE `ongoing_criterion`
  MODIFY `ongoing_criterion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `ongoing_event_name`
--
ALTER TABLE `ongoing_event_name`
  MODIFY `ongoing_event_name_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `ongoing_list_of_event`
--
ALTER TABLE `ongoing_list_of_event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `ongoing_teams`
--
ALTER TABLE `ongoing_teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `organization`
--
ALTER TABLE `organization`
  MODIFY `organization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `participants_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `post_photo`
--
ALTER TABLE `post_photo`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `score_rule`
--
ALTER TABLE `score_rule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tournament`
--
ALTER TABLE `tournament`
  MODIFY `tournament_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tournament_score_archive`
--
ALTER TABLE `tournament_score_archive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bar_graph`
--
ALTER TABLE `bar_graph`
  ADD CONSTRAINT `bar_graph_ibfk_1` FOREIGN KEY (`ongoing_event_name_id`) REFERENCES `ongoing_event_name` (`ongoing_event_name_id`),
  ADD CONSTRAINT `bar_graph_ibfk_2` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`organization_id`);

--
-- Constraints for table `bracket_teams`
--
ALTER TABLE `bracket_teams`
  ADD CONSTRAINT `bracket_teams_ibfk_1` FOREIGN KEY (`bracket_form_id`) REFERENCES `bracket_forms` (`id`);

--
-- Constraints for table `category_name`
--
ALTER TABLE `category_name`
  ADD CONSTRAINT `category_name_ibfk_1` FOREIGN KEY (`event_name_id`) REFERENCES `event_name` (`event_name_id`),
  ADD CONSTRAINT `category_name_ibfk_2` FOREIGN KEY (`event_type_id`) REFERENCES `event_type` (`event_type_id`);

--
-- Constraints for table `competition`
--
ALTER TABLE `competition`
  ADD CONSTRAINT `competition_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `ongoing_list_of_event` (`event_id`);

--
-- Constraints for table `criterion`
--
ALTER TABLE `criterion`
  ADD CONSTRAINT `criterion_ibfk_1` FOREIGN KEY (`category_name_id`) REFERENCES `category_name` (`category_name_id`);

--
-- Constraints for table `criterion_scoring`
--
ALTER TABLE `criterion_scoring`
  ADD CONSTRAINT `criterion_scoring_ibfk_1` FOREIGN KEY (`ongoing_criterion_id`) REFERENCES `ongoing_criterion` (`ongoing_criterion_id`),
  ADD CONSTRAINT `criterion_scoring_ibfk_2` FOREIGN KEY (`participants_id`) REFERENCES `participants` (`participants_id`),
  ADD CONSTRAINT `criterion_scoring_ibfk_3` FOREIGN KEY (`judge_id`) REFERENCES `judges` (`judge_id`);

--
-- Constraints for table `highlights`
--
ALTER TABLE `highlights`
  ADD CONSTRAINT `highlights_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `ongoing_list_of_event` (`event_id`);

--
-- Constraints for table `judges`
--
ALTER TABLE `judges`
  ADD CONSTRAINT `judges_ibfk_1` FOREIGN KEY (`competition_id`) REFERENCES `competition` (`competition_id`);

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `user` (`admin_id`);

--
-- Constraints for table `ongoing_criterion`
--
ALTER TABLE `ongoing_criterion`
  ADD CONSTRAINT `ongoing_criterion_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `ongoing_list_of_event` (`event_id`);

--
-- Constraints for table `ongoing_list_of_event`
--
ALTER TABLE `ongoing_list_of_event`
  ADD CONSTRAINT `ongoing_list_of_event_ibfk_1` FOREIGN KEY (`event_type_id`) REFERENCES `event_type` (`event_type_id`),
  ADD CONSTRAINT `ongoing_list_of_event_ibfk_2` FOREIGN KEY (`ongoing_event_name_id`) REFERENCES `ongoing_event_name` (`ongoing_event_name_id`);

--
-- Constraints for table `ongoing_teams`
--
ALTER TABLE `ongoing_teams`
  ADD CONSTRAINT `ongoing_teams_ibfk_1` FOREIGN KEY (`bracket_form_id`) REFERENCES `bracket_forms` (`id`);

--
-- Constraints for table `participants`
--
ALTER TABLE `participants`
  ADD CONSTRAINT `participants_ibfk_1` FOREIGN KEY (`competition_id`) REFERENCES `competition` (`competition_id`),
  ADD CONSTRAINT `participants_ibfk_2` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`organization_id`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`organization_id`);

--
-- Constraints for table `post_photo`
--
ALTER TABLE `post_photo`
  ADD CONSTRAINT `post_photo_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`);

--
-- Constraints for table `score_rule`
--
ALTER TABLE `score_rule`
  ADD CONSTRAINT `score_rule_ibfk_1` FOREIGN KEY (`bracket_form_id`) REFERENCES `bracket_forms` (`id`);

--
-- Constraints for table `tournament`
--
ALTER TABLE `tournament`
  ADD CONSTRAINT `tournament_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `ongoing_list_of_event` (`event_id`),
  ADD CONSTRAINT `tournament_ibfk_2` FOREIGN KEY (`number_of_wins_id`) REFERENCES `number_of_wins` (`number_of_wins_id`),
  ADD CONSTRAINT `tournament_ibfk_3` FOREIGN KEY (`bracket_form_id`) REFERENCES `bracket_forms` (`id`);

--
-- Constraints for table `tournament_score_archive`
--
ALTER TABLE `tournament_score_archive`
  ADD CONSTRAINT `tournament_score_archive_ibfk_1` FOREIGN KEY (`bracket_form_id`) REFERENCES `bracket_forms` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
