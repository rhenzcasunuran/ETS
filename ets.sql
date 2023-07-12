-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2023 at 07:28 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

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
  `isAnon` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bar_graph`
--

INSERT INTO `bar_graph` (`organization_bar_id`, `organization_id`, `ongoing_event_name_id`, `event_name_id`, `bar_meter`, `isAnon`) VALUES
(9, 1, 15, 1, '90.00', 0),
(10, 2, 15, 1, '80.00', 0),
(11, 3, 15, 1, '70.00', 0),
(12, 4, 15, 1, '60.00', 0),
(13, 5, 15, 1, '50.00', 0),
(14, 6, 15, 1, '40.00', 0),
(15, 7, 15, 1, '30.00', 0),
(16, 8, 15, 1, '20.00', 0);

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
(1, 1, 1, 'Basketball1'),
(2, 1, 2, 'Essay Writing'),
(3, 1, 2, 'Poster Making'),
(4, 1, 2, 'Spoken Poetry'),
(22, 2, 2, 'Tug o War');

--
-- Triggers `category_name`
--
DELIMITER $$
CREATE TRIGGER `add_competition` AFTER INSERT ON `category_name` FOR EACH ROW BEGIN
    -- Check if the inserted row has event_type_id equal to '2'
    IF NEW.`event_type_id` = 2 THEN
        -- Insert a new row into `competitions_table` using the inserted `category_name_id`
        INSERT INTO `competition` (`category_name_id`) VALUES (NEW.`category_name_id`);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `competition`
--

CREATE TABLE `competition` (
  `competition_id` int(11) NOT NULL,
  `category_name_id` int(11) NOT NULL,
  `schedule` datetime DEFAULT NULL,
  `schedule_end` datetime DEFAULT NULL,
  `is_archived` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `competition`
--

INSERT INTO `competition` (`competition_id`, `category_name_id`, `schedule`, `schedule_end`, `is_archived`) VALUES
(1, 2, '2023-07-11 17:00:00', '2023-07-13 01:00:00', 0),
(2, 3, '2023-07-11 17:00:00', '2023-07-13 01:00:00', 0),
(3, 4, NULL, NULL, 1),
(38, 22, NULL, NULL, 0);

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

--
-- Dumping data for table `criterion`
--

INSERT INTO `criterion` (`criterion_id`, `category_name_id`, `criterion_name`, `criterion_percent`) VALUES
(1, 2, 'Creativity', 50),
(2, 2, 'Originality', 25),
(3, 2, 'Insight', 25),
(4, 3, 'Artistry', 25),
(5, 3, 'Colors', 25),
(6, 3, 'Technique', 50),
(7, 4, 'Delivery', 25),
(8, 4, 'Emotion', 25),
(9, 4, 'Content', 50);

-- --------------------------------------------------------

--
-- Table structure for table `criterion_scoring`
--

CREATE TABLE `criterion_scoring` (
  `criterion_scoring_id` int(11) NOT NULL,
  `ongoing_criterion_id` int(11) NOT NULL,
  `category_name_id` int(11) DEFAULT NULL,
  `participants_id` int(11) NOT NULL,
  `criterion_temp_score` decimal(3,2) DEFAULT NULL,
  `criterion_final_score` decimal(3,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `criterion_scoring`
--

INSERT INTO `criterion_scoring` (`criterion_scoring_id`, `ongoing_criterion_id`, `category_name_id`, `participants_id`, `criterion_temp_score`, `criterion_final_score`) VALUES
(1, 1, 2, 1, 9.99, 9.99),
(2, 2, 2, 1, 9.99, 9.99),
(3, 3, 2, 1, 9.99, 9.99),
(4, 1, 2, 2, 9.00, 9.00),
(5, 2, 2, 2, 9.00, 9.00),
(6, 3, 2, 2, 9.00, 9.00),
(7, 1, 2, 3, 8.00, 8.00),
(8, 2, 2, 3, 8.00, 8.00),
(9, 3, 2, 3, 8.00, 8.00),
(10, 1, 2, 4, 7.00, 7.00),
(11, 2, 2, 4, 7.00, 7.00),
(12, 3, 2, 4, 7.00, 7.00),
(13, 4, 3, 5, 9.00, 9.00),
(14, 5, 3, 5, 9.00, 9.00),
(15, 6, 3, 5, 9.00, 9.00),
(16, 4, 3, 6, 9.99, 9.99),
(17, 5, 3, 6, 9.99, 9.99),
(18, 6, 3, 6, 9.99, 9.99),
(19, 4, 3, 7, 8.00, 8.00),
(20, 5, 3, 7, 8.00, 8.00),
(21, 6, 3, 7, 8.00, 8.00),
(22, 4, 3, 8, 7.00, 7.00),
(23, 5, 3, 8, 7.00, 7.00),
(24, 6, 3, 8, 7.00, 0.00),
(25, 7, 4, 9, 5.00, 5.00),
(26, 8, 4, 9, 5.00, 5.00),
(27, 9, 4, 9, 5.00, 5.00),
(28, 7, 4, 10, 6.00, 6.00),
(29, 8, 4, 10, 6.00, 6.00),
(30, 9, 4, 10, 6.00, 6.00),
(31, 7, 4, 11, 7.00, 7.00),
(32, 8, 4, 11, 7.00, 7.00),
(33, 9, 4, 11, 7.00, 7.00),
(34, 7, 4, 12, 8.00, 8.00),
(35, 8, 4, 12, 8.00, 8.00),
(36, 9, 4, 12, 8.00, 8.00);

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
(1, 'Buwan ng Wika'),
(2, 'Foundation');


-- --------------------------------------------------------

--
-- Table structure for table `event_type`
--

CREATE TABLE `event_type` (
  `event_type_id` int(11) NOT NULL,
  `event_type` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `highlights`
--

INSERT INTO `highlights` (`highlight_id`, `event_id`, `filename`, `status`, `image_info`, `image_description`) VALUES
(31, 2, 'Database-Schema.jpg', 0, 'sad', 'sad');

-- --------------------------------------------------------

--
-- Table structure for table `judges`
--

CREATE TABLE `judges` (
  `judge_id` int(11) NOT NULL,
  `competition_id` int(11) NOT NULL,
  `judge_name` varchar(150) NOT NULL,
  `judge_nickname` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(107, '2023-07-10', '18:13:55', 1, 'Added in Events');

-- --------------------------------------------------------

--
-- Table structure for table `number_of_wins`
--

CREATE TABLE `number_of_wins` (
  `number_of_wins_id` int(11) NOT NULL,
  `number_of_wins` varchar(20) NOT NULL,
  `number_of_wins_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `number_of_wins`
--

INSERT INTO `number_of_wins` (`number_of_wins_id`, `number_of_wins`, `number_of_wins_number`) VALUES
(1, 'Best of One (1)', 1),
(2, 'Best of Two (2)', 2),
(3, 'Best of Three (3)', 3),
(4, 'Best of Four (4)', 4),
(5, 'Best of Five (5)', 5),
(6, 'Best of Six (6)', 6),
(7, 'Best of Seven (7)', 7),
(8, 'Best of Eight (8)', 8),
(9, 'Best of Nine (9)', 9);

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
(1, 1, 2, 1, 'Creativity', 100),
(2, 2, 2, 1, 'Originality', 100),
(3, 3, 2, 1, 'Insight', 100),
(4, 4, 3, 1, 'Artistry', 100),
(5, 5, 3, 1, 'Colors', 100),
(6, 6, 3, 1, 'Technique', 100),
(7, 7, 4, 1, 'Delivery', 100),
(8, 8, 4, 1, 'Emotion', 100),
(9, 9, 4, 1, 'Content', 100);

-- --------------------------------------------------------

--
-- Table structure for table `ongoing_event_name`
--

CREATE TABLE `ongoing_event_name` (
  `ongoing_event_name_id` int(11) NOT NULL,
  `event_name_id` int(11) NOT NULL,
  `event_name` varchar(25) NOT NULL,
  `is_done` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ongoing_event_name`
--

INSERT INTO `ongoing_event_name` (`ongoing_event_name_id`, `event_name_id`, `event_name`, `is_done`) VALUES
(15, 1, 'Buwan ng Wika', 1),
(16, 1, 'Buwan ng Wika', 1);

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
  `overall_include` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ongoing_list_of_event`
--

INSERT INTO `ongoing_list_of_event` (`event_id`, `ongoing_event_name_id`, `category_name_id`, `event_name_id`, `event_type_id`, `category_name`, `event_description`, `event_code`, `event_date`, `event_time`, `is_archived`, `suggested_status`, `overall_include`) VALUES
(1, 1, 2, 1, 1, 'Essay Writing', 'Nag susulat ng essay tungkol sa langaw na nakadapo sa tae na biglang lumipad papalapit sa sayo ng mabilisan.', NULL, '2023-07-11', '10:56:38', 0, 0, 0),
(2, 1, 3, 2, 1, 'Poster Making', 'Idrawing ang kababalaghang nakita mo noong may narinig kang ungol sa loob ng stall sa CR ng SM.', NULL, '2023-07-11', '10:56:38', 0, 0, 0),
(3, 1, 4, 3, 1, 'Spoken Poetry', 'Ikwento ang iyong natatagong pagtingin sa isang tao na pilit mong itinatanggi sa iyong sarili na wala kang nararamdam pero sa tagal mong niloloko ang sarili mo, may dumating na iba sa tabi nya at ang kaya mo nalang gawin ay tumawa.', NULL, '2023-07-11', '10:56:38', 0, 0, 0),
(30, 15, 12, 1, 2, 'xcvxcvcx', 'ASDDD', 'PY05hjSEqMZV', '2023-07-10', '05:59:00', 1, 0, 0),
(32, 16, 4, 1, 1, 'Chess', 'asdsadsad', 'sJC3vUIYN0os', '2023-07-10', '09:00:00', 1, 0, 0),
(33, 16, 12, 1, 2, 'xcvxcvcx', 'asdasdsad', '1B03FqynWsY4', '2023-07-10', '18:06:00', 1, 0, 0),
(34, 16, 19, 1, 2, 'asdasdasdsa', 'asdasdsa', 'GsQhN7Ym6FgE', '2023-07-10', '18:08:00', 1, 0, 0),
(35, 16, 20, 1, 2, 'asdasdasdas', 'twetqera', 'uEFvc1NLhdGf', '2023-07-10', '18:12:00', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `organization_id` int(11) NOT NULL,
  `organization_name` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `participant_section` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`participants_id`, `competition_id`, `organization_id`, `participant_name`, `participant_section`) VALUES
(1, 1, 1, 'Robbie 1 Boco', 'BS 1'),
(2, 1, 2, 'Robbie 2 Boco', 'BS 2'),
(3, 1, 3, 'Robbie 3 Boco', 'BS 3'),
(4, 1, 4, 'Robbie 4 Boco', 'BS 4'),
(5, 2, 5, 'Robbie 5 Boco', 'BS 5'),
(6, 2, 6, 'Robbie 6 Boco', 'BS 6'),
(7, 2, 7, 'Robbie 7 Boco', 'BS 7'),
(8, 2, 8, 'Robbie 8 Boco', 'BS 8'),
(9, 3, 3, 'Robbie 9 Boco', 'BS 9'),
(10, 3, 2, 'Robbie 10 Boco', 'BS 10'),
(11, 3, 7, 'Robbie 11 Boco', 'BS 11'),
(12, 3, 4, 'Robbie 12 Boco', 'BS 12');

-- --------------------------------------------------------

--
-- Table structure for table `participants_score`
--

CREATE TABLE `participants_score` (
  `participant_score_id` int(11) NOT NULL,
  `criterion_scoring_id` int(11) NOT NULL,
  `final_score` decimal(3,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `post_calendar` varchar(15) DEFAULT NULL,
  `post_title` varchar(60) NOT NULL,
  `post_description` text NOT NULL,
  `post_cover` text NOT NULL,
  `post_schedule` datetime NOT NULL,
  `post_draft` tinyint(4) NOT NULL DEFAULT 0,
  `post_calendar_type` varchar(8) NOT NULL DEFAULT 'Standard'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `organization_id`, `post_calendar`, `post_title`, `post_description`, `post_cover`, `post_schedule`, `post_draft`, `post_calendar_type`) VALUES
(85, 6, '', 'MARKETISTA SEM-ENDER 2023', '𝐈𝐭\'𝐬 𝐭𝐢𝐦𝐞 𝐭𝐨 𝐥𝐨𝐨𝐤 𝐛𝐚𝐜𝐤 𝐚𝐧𝐝 𝐛𝐞 𝐩𝐫𝐨𝐮𝐝!\r\n\r\nMonths away, and we are at the end of this fruitful academic year that tested our capabilities, integrity, and limits. Setbacks are inevitable, but the blood of a champion runs in our veins, Marketistas! We bounce back stronger and wiser. \r\n\r\nJoin us for this year’s 𝗠𝗮𝗿𝗸𝗲𝘁𝗶𝘀𝘁𝗮 𝗦𝗲𝗺-𝗘𝗻𝗱𝗲𝗿 𝟮𝟬𝟮3, 𝐓𝐫𝐚𝐧𝐬𝐟𝐨𝐫𝐦𝐚𝐭𝐢𝐨𝐧𝐚𝐥 𝐂𝐡𝐚𝐦𝐩𝐢𝐨𝐧𝐬: 𝐔𝐧𝐢𝐟𝐲𝐢𝐧𝐠 𝐃𝐢𝐯𝐞𝐫𝐬𝐢𝐭𝐲 𝐓𝐡𝐫𝐨𝐮𝐠𝐡 𝐂𝐚𝐦𝐚𝐫𝐚𝐝𝐞𝐫𝐢𝐞. A walkthrough of the splendid year of the marketing community.\r\n\r\n𝐏𝐚𝐜𝐤 𝐲𝐨𝐮𝐫 𝐭𝐡𝐢𝐧𝐠𝐬 𝐚𝐧𝐝 𝐜𝐞𝐥𝐞𝐛𝐫𝐚𝐭𝐞 𝐰𝐢𝐭𝐡 𝐮𝐬!\r\n\r\n#MarketistaSemEnder2023\r\n#JMAPUPSRC\r\n#JMAPBatchZeta\r\n#BreakBarriersandCreateMeaningfulConnections', 'cover-JMAP.png', '2023-07-08 01:32:36', 0, 'Standard'),
(86, 6, '', 'Larong Pinoy', '𝐋𝐞𝐭\'𝐬 𝐠𝐨 𝐛𝐚𝐜𝐤 𝐭𝐨 𝐨𝐮𝐫 𝐫𝐨𝐨𝐭𝐬, 𝐈𝐬𝐤𝐨 𝐚𝐧𝐝 𝐈𝐬𝐤𝐚!\r\nLet’s go out with a bang with 𝐋𝐚𝐫𝐨𝐧𝐠 𝐏𝐢𝐧𝐨𝐲, which will bring us back to our nostalgic childhood games that will definitely unlock fond memories as we create brand-new ones with our fellow Marketistas. \r\n\r\n𝗠𝘂𝘀𝘁𝗲𝗿 𝘆𝗼𝘂𝗿 𝘀𝗸𝗶𝗹𝗹𝘀 𝗮𝗻𝗱 𝗰𝗮𝗹𝗹 𝘆𝗼𝘂𝗿 𝗽𝗹𝗮𝘆𝗺𝗮𝘁𝗲𝘀!\r\n\r\n𝗟𝗮𝗿𝗼𝗻𝗴 𝗣𝗶𝗻𝗼𝘆\r\nhttps://l.messenger.com/l.php?u=https%3A%2F%2Fdocs.google.com%2F...%2F1Yk368pwBdx5FCSQ8sHki...%2Fedit&h=AT1btJTrzHodgpUFeqMY7SH5W0r9qQoVRVsXe3GqGpeeuyZ_YWnRHOOUzEbVpkHw5H8e0ScD-F40P_ul-NewVrcEe_49QGR_ruLQxOvGTYp0LpxHlLeDJWl1bmVY50fot4SCzA\r\n\r\n#MarketistaSemEnder2023\r\n#JMAPPUPSRC\r\n#JMAPBatchZeta\r\n#BreakBarriersCreateMeaningfulConnections', '86_COVER_64ac412a6470b.png', '2023-07-11 01:34:34', 0, 'Standard'),
(87, 6, '', 'EntrePinoy On-the-Go', '\"Do not look at yourself because you are too young or inexperienced in having a business.\" - Sir. Ramirez\r\n𝗥𝗘𝗔𝗗𝗬, 𝗦𝗘𝗧, 𝗦𝗧𝗔𝗥𝗧! ✨\r\nYesterday, the Junior Marketing Association of the Philippines (SRC) successfully participated in an event entitled 𝐄𝐧𝐭𝐫𝐞𝐏𝐢𝐧𝐨𝐲 𝐎𝐧-𝐭𝐡𝐞-𝐆𝐨: 𝐓𝐡𝐞 𝐔𝐥𝐭𝐢𝐦𝐚𝐭𝐞 𝐆𝐮𝐢𝐝𝐞 𝐚𝐧𝐝 𝐓𝐢𝐩𝐬 𝐭𝐨 𝐛𝐞 𝐚𝐧 𝐄𝐟𝐟𝐞𝐜𝐭𝐢𝐯𝐞 𝐒𝐭𝐚𝐫𝐭-𝐮𝐩 𝐄𝐧𝐭𝐫𝐞𝐩𝐫𝐞𝐧𝐞𝐮𝐫, which lasted from 9AM to 4PM at the PUPSRC Multi-Purpose Hall. This was attended by fourth-year marketing students who will soon use the knowledge imparted by guest speaker 𝐂𝐚𝐞𝐬𝐞𝐫 𝐀𝐩𝐨𝐥𝐢𝐧𝐚𝐫 𝐑𝐚𝐦𝐢𝐫𝐞𝐳 𝐉𝐫. 𝐏𝐡𝐃 as they embark on their own journeys.\r\nLet us all take in these wise words left by Mr. Ramirez and not let fear overpower our drive to try new ventures. Embrace the uncertainty, and do not be afraid to fail and try again.\r\nHave courage, Marketistas! Thank you, City Cooperative Development Office for conducting this seminar.💛\r\n#JMAPPUPSRC\r\n#JMAPBatchZeta\r\n#BreakBarriersCreateMeaningfulConnections', 'cover-JMAP.png', '2023-07-08 01:36:40', 0, 'Standard'),
(89, 3, '2023-07-01', 'Project T.A.L.E.N.T.', '𝗜𝗴𝗻𝗶𝘁𝗲 𝘆𝗼𝘂𝗿 𝘀𝗸𝗶𝗹𝗹𝘀 𝗮𝗻𝗱 𝘂𝗻𝗹𝗲𝗮𝘀𝗵 𝘆𝗼𝘂𝗿 𝗽𝗼𝘁𝗲𝗻𝘁𝗶𝗮𝗹 𝘄𝗶𝘁𝗵 \"𝗣𝗿𝗼𝗷𝗲𝗰𝘁 𝗧𝗔𝗟𝗘𝗡𝗧\"! 🚀\r\n\r\nWhether you\'re an aspiring designer, a meticulous tester, a creative graphic artist, or a budding web developer, Project TALENT has something in store for you. \r\n\r\n📅 Mark your calendars for July 1, 2023, from 8:00am to 6:00pm, as we embark on a transformative journey through four exciting topics: \r\n(1) Web Development\r\n(2) UI/UX\r\n(3) Graphics, and;\r\n(4) Quality Assurance\r\n\r\nDon\'t miss your chance to gain valuable insights into these cutting-edge fields. Each seminar is limited to only 60 slots, so make sure to secure your spot early! ⏰\r\n\r\nEmbrace the future of technology and embrace your true potential. Register for Project TALENT and unlock the doors to endless possibilities! 🎉\r\n\r\nPlease take note that this event will be available exclusively to ELITE members only. Registration will be open on June 26 (Monday). \r\n\r\nStay tuned for more details and exciting announcements in the coming days. See you there, ITellectuals! 🧡🖤', '89_COVER_64ac43e9673b2.jpg', '2023-06-19 01:46:17', 0, 'Standard'),
(92, 3, '', 'Congratulations to our current Vice President - External', 'Radiant, graceful, and crowned with victory. Congratulations to our current Vice President - External and the newly crowned Binibining Market Area 2023, Louisse Del Mundo! 💐\r\nYour ELITE Family is proud of you! 🧡🖤', '92_COVER_64ac451d67e26.jpg', '2023-07-11 01:51:25', 0, 'Standard'),
(93, 2, '2023-07-08', 'Unlocking Your Professional Potential', 'Heads up Future Engineers!\r\nWe are excited to invite you to the last seminar for this semester of BS ECE 4-1! Join us on July 08 at 9:30 am in the morning for a webinar via Google Meet. Our theme for this seminar is \"Unlocking Your Professional Potential: Mastering the Art of Resume Building and Interview Success,\" brought to you by Team July of PUP Santa Rosa BS ECE 4-1 class.\r\n\r\nWe are honored to have Ms. Ancelle Rose P. Alfonso as our confident speaker. Ms. Alfonso is a Human Resource Timekeeping specialist at Steelpro, Inc. and a Behavioral Therapist at The Bright Future Behavioral Center. Her expertise in both fields will provide valuable insights and practical tips to help you excel in resume writing and job interviews.\r\n\r\nThis webinar aims to equip you with the skills and knowledge needed to write a proper resume and present yourself confidently in a job interview. It is particularly relevant for third-year students who are preparing for their internships and want to enhance their skills to secure their dream jobs. Fourth-year students are also encouraged to attend as it is never too late to improve your presentation skills and increase your chances of success.\r\n\r\nTo join this informative session, simply fill out the registration form provided below, and the webinar link will be emailed to you.\r\n\r\nRegistration Link: https://forms.gle/z4FDRWbgNgCp6Mff9\r\n\r\nDon\'t miss out on this opportunity to enhance your professional development and take a step closer to achieving your career goals.\r\n\r\nWe are looking  forward to your active participation!', 'cover-AECES.png', '2023-07-07 01:54:30', 0, 'Standard'),
(94, 2, '2023-05-12', 'Bridging the Gap', '𝗕𝗿𝗶𝗱𝗴𝗶𝗻𝗴 𝘁𝗵𝗲 𝗚𝗮𝗽: 𝗘𝗺𝗽𝗼𝘄𝗲𝗿𝗶𝗻𝗴 𝘁𝗵𝗲 𝗩𝗶𝘁𝗮𝗹 𝗥𝗼𝗹𝗲 𝗼𝗳 𝗘𝗹𝗲𝗰𝘁𝗿𝗼𝗻𝗶𝗰𝘀 𝗘𝗻𝗴𝗶𝗻𝗲𝗲𝗿𝘀 𝗶𝗻 𝘁𝗵𝗲 𝗠𝗲𝗱𝗶𝗰𝗮𝗹 𝗙𝗶𝗲𝗹𝗱\r\n\r\nCalling all Electronics Engineering Students! Join us in our upcoming seminar as we delve into the crucial role of electronics engineers in advancing medical technology. Be part of the movement in \'Bridging the Gap\' and discover the opportunities for technological innovation in the field of medicine. Register now and empower yourself to make a difference!\r\n\r\nwith the topic of \"𝗕𝗿𝗶𝗱𝗴𝗶𝗻𝗴 𝘁𝗵𝗲 𝗚𝗮𝗽: 𝗘𝗺𝗽𝗼𝘄𝗲𝗿𝗶𝗻𝗴 𝘁𝗵𝗲 𝗩𝗶𝘁𝗮𝗹 𝗥𝗼𝗹𝗲 𝗼𝗳 𝗘𝗹𝗲𝗰𝘁𝗿𝗼𝗻𝗶𝗰𝘀 𝗘𝗻𝗴𝗶𝗻𝗲𝗲𝗿𝘀 𝗶𝗻 𝘁𝗵𝗲 𝗠𝗲𝗱𝗶𝗰𝗮𝗹 𝗙𝗶𝗲𝗹𝗱\"\r\n\r\nPlease be advised that the number of available slots for this event is 𝗹𝗶𝗺𝗶𝘁𝗲𝗱 𝘁𝗼 𝟳𝟱, 𝘄𝗶𝘁𝗵 𝘁𝗵𝗲 𝗲𝘅𝗰𝗹𝘂𝘀𝗶𝗼𝗻 𝗼𝗳 𝟰𝘁𝗵-𝘆𝗲𝗮𝗿 𝘀𝘁𝘂𝗱𝗲𝗻𝘁𝘀. We highly encourage interested participants to register at the earliest possible time.\r\n\r\n𝗪𝗵𝗲𝗻: May 12, 2023 | Friday\r\n𝗪𝗵𝗲𝗿𝗲: PUP - Sta. Rosa Campus (AVR)\r\n𝗧𝗶𝗺𝗲: 8:00 AM- 12:00 PM\r\n𝗦𝗽𝗲𝗮𝗸𝗲𝗿: Engr. Mark Dairen C. Camcaman\r\n\r\nhttps://bit.ly/Engr_in_Med', '94_COVER_64ac465fc85b3.png', '2023-05-10 01:56:47', 0, 'Standard'),
(95, 5, '2023-07-15', 'SOMETHING BIG IS COMING!', '📢 Save the Date! 🗓️\r\n\r\nJoin us, Humanistas, on July 15th as we dive into the world of innovation, technology, and transformative management strategies. Discover how the synergy of these elements can unlock limitless potential, driving both businesses and society forward.\r\n\r\nGet ready for a thought-provoking event that will empower you with the knowledge and insights needed to navigate the ever-evolving landscape. Together, we\'ll explore cutting-edge technologies, share best practices, and discuss effective strategies for success.\r\n\r\nDon\'t miss out on this opportunity to connect with industry leaders, entrepreneurs, and change-makers. Mark your calendars and join us on July 15th to unlock the power of technology and effective management for a brighter future! 🌐💼✨', '95_COVER_64ac470dc541b.png', '2023-07-01 01:59:41', 0, 'Standard'),
(96, 8, '', 'Unleash Your Colors: Embrace, Empower, and Celebrate Pride!', 'The Philippine Institute of Industrial Engineers is thrilled to join the worldwide celebration of 𝗣𝗿𝗶𝗱𝗲 𝗠𝗼𝗻𝘁𝗵, as advocates for diversity, inclusion, and equality, we stand tall and proud, ready to make a difference.\r\n\r\nThis 𝗣𝗿𝗶𝗱𝗲 𝗠𝗼𝗻𝘁𝗵, we invite you to join us in celebrating the power of unity, acceptance, and self-expression by supporting our very own PIIE members who will unleash their colors by embracing, empowering, and celebrating their true self. \r\n\r\n𝗛𝗮𝗽𝗽𝘆 𝗣𝗿𝗶𝗱𝗲 𝗠𝗼𝗻𝘁𝗵 from the Philippine Institute of Industrial Engineers! Let\'s make this a month of love, acceptance, and celebration that will reverberate throughout the year. 🤝🌟', '96_COVER_64ac47b7ba053.png', '2023-06-24 02:02:31', 0, 'Standard'),
(97, 7, '', 'Decoding the Ledger: Exercise Your Accounting Brain!', 'Attention 𝐉𝐏𝐈𝐀𝐍𝐬! Prepare to put your accounting skills to the test with our exciting new activity, 𝐃𝐞𝐜𝐨𝐝𝐢𝐧𝐠 𝐭𝐡𝐞 𝐋𝐞𝐝𝐠𝐞𝐫! \r\n\r\nGet ready to exercise your brain cells and refresh your knowledge in a fun and engaging way. We challenge you to provide your answers and guesses before we unveil the correct solutions. \r\n\r\nGet ready for more thrilling accounting adventures!\r\n\r\n𝗤𝘂𝗲𝘀𝘁𝗶𝗼𝗻: 𝗣𝗨𝗣 𝗦𝗥𝗖 𝗔𝗰𝗮𝗱𝗲𝗺𝗶𝗰 𝗖𝗼𝗺𝗺𝗶𝘁𝘁𝗲𝗲 𝟮𝟮𝟮𝟯\r\n𝗣𝗿𝗼𝗷𝗲𝗰𝘁 𝗯𝘆: 𝗣𝗨𝗣 𝗦𝗥𝗖 𝗠𝘂𝗹𝘁𝗶𝗺𝗲𝗱𝗶𝗮 𝗖𝗼𝗺𝗺𝗶𝘁𝘁𝗲𝗲 𝟮𝟮𝟮𝟯\r\n𝗟𝗮𝘆𝗼𝘂𝘁: 𝗠𝗮𝗿𝗶𝗲𝗹 𝗛𝗲𝗿𝗺𝗼𝘀𝗼 & 𝗝𝗮𝗻𝗲 𝗣𝗮𝗻𝗰𝗵𝗮', 'cover-JPIA.png', '2023-03-03 11:03:55', 0, 'Standard'),
(98, 7, '', 'Winners of REVAMP Academic Webinar Series Raffle Games', 'We are thrilled to announce the triumphant recipients of our raffle games during the REVAMP Academic Webinar Series: Bridging the Gaps towards Excellence! All the prizes have been successfully dispatched to the winners\' respective email addresses. If you have any concerns or inquiries regarding this matter, please don\'t hesitate to reach out to us via the 𝑷𝑼𝑷 𝑺𝑹𝑪 𝑱𝑷𝑰𝑨 𝑭𝒂𝒄𝒆𝒃𝒐𝒐𝒌 𝑷𝒂𝒈𝒆 or contact our 𝑽𝑷 𝒇𝒐𝒓 𝑨𝒄𝒂𝒅𝒆𝒎𝒊𝒄𝒔, 𝑱𝒂𝒏𝒆𝒍𝒍𝒂 𝑴𝒂𝒓𝒂𝒏̃𝒐.\r\n\r\nOnce again, we extend our warmest congratulations to all the winners!\r\n\r\nSponsors:\r\n🍄 𝗥𝗲𝗶𝗴𝗻𝗮 & 𝗥𝗼𝗴𝗴𝗶𝗲 𝗔𝗽𝗮𝗿𝘁𝗺𝗲𝗻𝘁\r\n🍰 𝗝𝗼𝘆\'𝘀 𝗣𝘂𝘁𝗼𝗰𝗮𝗸𝗲:\r\n🧶 𝗥𝗲𝗰𝗿𝗼𝗰𝗵𝗲𝘁\r\n🏢 𝗙𝗿𝗮𝗻𝗰𝗵𝗶𝘀𝗲𝗠𝗮𝗻𝗶𝗹𝗮.𝗰𝗼𝗺\r\n🎓 𝗖𝗣𝗔 𝗢𝗻𝗹𝗶𝗻𝗲 𝗥𝗲𝘃𝗶𝗲𝘄 𝗦𝗰𝗵𝗼𝗼𝗹\r\n🔧 𝗔𝘀𝗵 𝗧𝗲𝗰𝗵\r\n📜 𝗣𝗮𝗽𝗲𝗿𝗹𝗮𝗻𝗱\r\n🍰 𝗔𝗘\'𝘀 𝗦𝘄𝗲𝗲𝘁 𝗖𝗿𝗲𝗮𝘁𝗶𝗼𝗻𝘀\r\n❄️ 𝗜𝗰𝘆 𝗦𝗼𝗹𝗲𝘀\r\n\r\nLayout: Myk De Mesa', 'cover-JPIA.png', '2023-03-03 02:06:03', 0, 'Standard'),
(99, 0, '', '19th Cityhood Anniversariy', 'By virtue of Presidential Proclamation no. 268, July 10, 2023, Monday, is hereby declared as a Special Non-Working Holiday in the City of Santa Rosa, Laguna. This is due to the celebration of its 19th Cityhood Anniversary\r\n\r\nPlease be guided accordingly. Thank you.', 'cover-SC.png', '2023-07-11 02:08:03', 0, 'Standard');

-- --------------------------------------------------------

--
-- Table structure for table `post_photo`
--

CREATE TABLE `post_photo` (
  `photo_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `file_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Table structure for table `tournament`
--

CREATE TABLE `tournament` (
  `tournament_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `number_of_wins_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tournament`
--

INSERT INTO `tournament` (`tournament_id`, `event_id`, `number_of_wins_id`) VALUES
(7, 32, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tou_bracket`
--

CREATE TABLE `tou_bracket` (
  `bracket_id` int(11) NOT NULL,
  `tournament_id` int(11) NOT NULL,
  `team1_id` int(11) DEFAULT NULL,
  `team2_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tou_team`
--

CREATE TABLE `tou_team` (
  `team_score_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `team_score` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tou_team_stat`
--

CREATE TABLE `tou_team_stat` (
  `team_id` int(11) NOT NULL,
  `tournament_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `winning` tinyint(1) NOT NULL,
  `losing` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tou_team_stat`
--

INSERT INTO `tou_team_stat` (`team_id`, `tournament_id`, `organization_id`, `winning`, `losing`) VALUES
(25, 7, 1, 0, 0),
(26, 7, 2, 0, 0),
(27, 7, 3, 0, 0),
(28, 7, 4, 0, 0),
(29, 7, 5, 0, 0),
(30, 7, 6, 0, 0),
(31, 7, 7, 0, 0),
(32, 7, 8, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `admin_id` int(11) NOT NULL,
  `user_username` varchar(20) NOT NULL,
  `user_password` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`admin_id`, `user_username`, `user_password`) VALUES
(1, 'admin', 'admin');

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
  ADD KEY `category_name_id` (`category_name_id`);

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
  ADD KEY `category_name_id` (`category_name_id`);

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
  ADD KEY `event_id` (`event_id`),
  ADD KEY `criterion_id` (`criterion_id`),
  ADD KEY `category_name_id` (`category_name_id`);

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
-- Indexes for table `participants_score`
--
ALTER TABLE `participants_score`
  ADD PRIMARY KEY (`participant_score_id`),
  ADD KEY `criterion_scoring_id` (`criterion_scoring_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `organization_id` (`organization_id`);

--
-- Indexes for table `tournament`
--
ALTER TABLE `tournament`
  ADD PRIMARY KEY (`tournament_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `tou_bracket`
--
ALTER TABLE `tou_bracket`
  ADD PRIMARY KEY (`bracket_id`),
  ADD KEY `team1_id` (`team1_id`),
  ADD KEY `team2_id` (`team2_id`),
  ADD KEY `tournament_id` (`tournament_id`);

--
-- Indexes for table `tou_team`
--
ALTER TABLE `tou_team`
  ADD PRIMARY KEY (`team_score_id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `tou_team_stat`
--
ALTER TABLE `tou_team_stat`
  ADD PRIMARY KEY (`team_id`),
  ADD KEY `organization_id` (`organization_id`),
  ADD KEY `tournament_id` (`tournament_id`);

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
  MODIFY `organization_bar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `category_name`
--
ALTER TABLE `category_name`
  MODIFY `category_name_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `competition`
--
ALTER TABLE `competition`
  MODIFY `competition_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `criterion`
--
ALTER TABLE `criterion`
  MODIFY `criterion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `criterion_scoring`
--
ALTER TABLE `criterion_scoring`
  MODIFY `criterion_scoring_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_name`
--
ALTER TABLE `event_name`
  MODIFY `event_name_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `judge_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `number_of_wins`
--
ALTER TABLE `number_of_wins`
  MODIFY `number_of_wins_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ongoing_criterion`
--
ALTER TABLE `ongoing_criterion`
  MODIFY `ongoing_criterion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `ongoing_event_name`
--
ALTER TABLE `ongoing_event_name`
  MODIFY `ongoing_event_name_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `ongoing_list_of_event`
--
ALTER TABLE `ongoing_list_of_event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `organization`
--
ALTER TABLE `organization`
  MODIFY `organization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `participants_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `participants_score`
--
ALTER TABLE `participants_score`
  MODIFY `participant_score_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tournament`
--
ALTER TABLE `tournament`
  MODIFY `tournament_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tou_team`
--
ALTER TABLE `tou_team`
  MODIFY `team_score_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tou_team_stat`
--
ALTER TABLE `tou_team_stat`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bar_graph`
--
ALTER TABLE `bar_graph`
  ADD CONSTRAINT `bar_graph_ibfk_1` FOREIGN KEY (`ongoing_event_name_id`) REFERENCES `ongoing_event_name` (`ongoing_event_name_id`);

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
  ADD CONSTRAINT `competition_ibfk_1` FOREIGN KEY (`category_name_id`) REFERENCES `category_name` (`category_name_id`);

--
-- Constraints for table `criterion`
--
ALTER TABLE `criterion`
  ADD CONSTRAINT `criterion_ibfk_1` FOREIGN KEY (`category_name_id`) REFERENCES `category_name` (`category_name_id`);

--
-- Constraints for table `criterion_scoring`
--
ALTER TABLE `criterion_scoring`
  ADD CONSTRAINT `criterion_scoring_ibfk_1` FOREIGN KEY (`participants_id`) REFERENCES `participants` (`participants_id`),
  ADD CONSTRAINT `criterion_scoring_ibfk_2` FOREIGN KEY (`ongoing_criterion_id`) REFERENCES `ongoing_criterion` (`ongoing_criterion_id`),
  ADD CONSTRAINT `criterion_scoring_ibfk_3` FOREIGN KEY (`category_name_id`) REFERENCES `category_name` (`category_name_id`);

--
-- Constraints for table `ongoing_criterion`
--
ALTER TABLE `ongoing_criterion`
  ADD CONSTRAINT `ongoing_criterion_ibfk_1` FOREIGN KEY (`criterion_id`) REFERENCES `criterion` (`criterion_id`),
  ADD CONSTRAINT `ongoing_criterion_ibfk_2` FOREIGN KEY (`category_name_id`) REFERENCES `category_name` (`category_name_id`),
  ADD CONSTRAINT `ongoing_criterion_ibfk_3` FOREIGN KEY (`event_id`) REFERENCES `event_name` (`event_name_id`);

--
-- Constraints for table `participants`
--
ALTER TABLE `participants`
  ADD CONSTRAINT `participants_ibfk_1` FOREIGN KEY (`competition_id`) REFERENCES `competition` (`competition_id`),
  ADD CONSTRAINT `participants_ibfk_2` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`organization_id`);

--
-- Constraints for table `participants_score`
--
ALTER TABLE `participants_score`
  ADD CONSTRAINT `participants_score_ibfk_1` FOREIGN KEY (`criterion_scoring_id`) REFERENCES `criterion_scoring` (`criterion_scoring_id`);
COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
