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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category_name`
--

INSERT INTO `category_name` (`category_name_id`, `event_name_id`, `event_type_id`, `category_name`) VALUES
(4, 1, 1, 'Chess'),
(12, 1, 2, 'xcvxcvcx'),
(19, 1, 2, 'asdasdasdsa'),
(20, 1, 2, 'asdasdasdas');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `competition`
--

INSERT INTO `competition` (`competition_id`, `event_id`, `schedule`, `schedule_end`, `is_archived`) VALUES
(31, 30, NULL, NULL, 0),
(32, 33, NULL, NULL, 0),
(33, 34, NULL, NULL, 0),
(34, 35, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `criterion`
--

CREATE TABLE `criterion` (
  `criterion_id` int(11) NOT NULL,
  `category_name_id` int(11) NOT NULL,
  `criterion_name` varchar(50) NOT NULL,
  `criterion_percent` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `criterion`
--

INSERT INTO `criterion` (`criterion_id`, `category_name_id`, `criterion_name`, `criterion_percent`) VALUES
(14, 12, 'zxczx', 100),
(22, 19, 'asdasda', 100),
(23, 20, 'asdasdas', 100);

-- --------------------------------------------------------

--
-- Table structure for table `criterion_scoring`
--

CREATE TABLE `criterion_scoring` (
  `criterion_scoring_id` int(11) NOT NULL,
  `ongoing_criterion_id` int(11) NOT NULL,
  `participants_id` int(11) NOT NULL,
  `criterion_temp_score` decimal(3,2) DEFAULT NULL,
  `criterion_final_score` decimal(3,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `event_name`
--

CREATE TABLE `event_name` (
  `event_name_id` int(11) NOT NULL,
  `event_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `event_name`
--

INSERT INTO `event_name` (`event_name_id`, `event_name`) VALUES
(1, 'Buwan ng Wika'),
(2, 'Sample');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ongoing_criterion`
--

INSERT INTO `ongoing_criterion` (`ongoing_criterion_id`, `criterion_id`, `category_name_id`, `event_id`, `criterion_name`, `criterion_percent`) VALUES
(67, 14, 12, 30, 'zxczx', 100),
(68, 14, 12, 33, 'zxczx', 100),
(69, 22, 19, 34, 'asdasda', 100),
(70, 23, 20, 35, 'asdasdas', 100);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `post_photos` text DEFAULT NULL,
  `post_schedule` datetime NOT NULL,
  `post_draft` tinyint(4) NOT NULL DEFAULT 0,
  `post_calendar_type` varchar(8) NOT NULL DEFAULT 'Standard'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `organization_id`, `post_calendar`, `post_title`, `post_description`, `post_photos`, `post_schedule`, `post_draft`, `post_calendar_type`) VALUES
(28, 6, '2023-06-07', 'Kislap Livelihood is finally here!', 'Join us as we light up the world in this year\'s livelihood program hold by 𝐉𝐮𝐧𝐢𝐨𝐫 𝐌𝐚𝐫𝐤𝐞𝐭𝐢𝐧𝐠 𝐀𝐬𝐬𝐨𝐜𝐢𝐚𝐭𝐢𝐨𝐧 𝐨𝐟 𝐭𝐡𝐞 𝐏𝐡𝐢𝐥𝐢𝐩𝐩𝐢𝐧𝐞𝐬 - 𝐁𝐚𝐭𝐜𝐡 𝐙𝐞𝐭𝐚. This activity will run starting June 6-8, 2023 from 2pm-4pm in PUP-SRC. All registered participants, check your email for the further details.\r\n\r\nShine vividly, Iskolar ng Bayan! 🕯️✨', '', '2023-01-07 02:07:33', 0, 'Standard'),
(29, 5, '2023-06-12', 'JEHRA Seminar', '“𝑨𝒏 𝒐𝒓𝒈𝒂𝒏𝒊𝒛𝒂𝒕𝒊𝒐𝒏’𝒔 𝒂𝒃𝒊𝒍𝒊𝒕𝒚 𝒕𝒐 𝑳𝑬𝑨𝑹𝑵, 𝒂𝒏𝒅 𝒕𝒓𝒂𝒏𝒔𝒍𝒂𝒕𝒆 𝒕𝒉𝒂𝒕 𝒍𝒆𝒂𝒓𝒏𝒊𝒏𝒈 𝒊𝒏𝒕𝒐 𝑨𝑪𝑻𝑰𝑶𝑵 𝒓𝒂𝒑𝒊𝒅𝒍𝒚 𝒊𝒔 𝒕𝒉𝒆 𝒖𝒍𝒕𝒊𝒎𝒂𝒕𝒆 𝑪𝑶𝑴𝑷𝑬𝑻𝑰𝑻𝑰𝑽𝑬 𝑨𝑫𝑽𝑨𝑵𝑻𝑨𝑮𝑬.” – 𝑱𝒂𝒄𝒌 𝑾𝒆𝒍𝒄𝒉\r\n\r\nWarmest Greetings!\r\n\r\nWe are inviting you to join us on the 𝟏𝟐𝒕𝒉 𝒐𝒇 𝑱𝒂𝒏𝒖𝒂𝒓𝒚 𝟐𝟎𝟐𝟑 (Thursday), from 𝟐:𝟎𝟎𝑷𝑴 𝒕𝒐 𝟓:𝟎𝟎 𝑷𝑴at the 𝑨𝒖𝒅𝒊𝒐-𝒗𝒊𝒔𝒖𝒂𝒍 𝑹𝒐𝒐𝒎 𝟑𝟎𝟖 (𝟑𝒓𝒅 𝑭𝒍𝒐𝒐𝒓), 𝑷𝑼𝑷 𝑺𝒂𝒏𝒕𝒂 𝑹𝒐𝒔𝒂 𝑪𝒂𝒎𝒑𝒖𝒔.\r\n\r\nGet ready to learn as we discuss 𝑻𝑹𝑨𝑰𝑵𝑰𝑵𝑮 𝑨𝑵𝑫 𝑫𝑬𝑽𝑬𝑳𝑶𝑷𝑴𝑬𝑵𝑻: 𝑨𝒑𝒑𝒓𝒐𝒂𝒄𝒉𝒆𝒔 𝒂𝒏𝒅 𝑻𝒆𝒄𝒉𝒏𝒊𝒒𝒖𝒆𝒔 𝒊𝒏 𝑬𝒒𝒖𝒊𝒑𝒑𝒊𝒏𝒈 𝑷𝒆𝒐𝒑𝒍𝒆 𝑻𝒐𝒘𝒂𝒓𝒅𝒔 𝑪𝒐𝒎𝒑𝒂𝒏𝒚 𝑺𝒖𝒄𝒄𝒆𝒔𝒔. Immerse ourselves in a thorough exploration of the significance of proficiently educating individuals within an organization, considering our role as a Future Human Resource.\r\n\r\n𝐖𝐞 𝐚𝐫𝐞 𝐭𝐫𝐚𝐢𝐧𝐞𝐝 𝐭𝐨 𝐭𝐫𝐚𝐢𝐧 𝐩𝐞𝐨𝐩𝐥𝐞 𝐚𝐧𝐝 𝐦𝐨𝐥𝐝 𝐭𝐡𝐞𝐦 𝐭𝐨 𝐛𝐞 𝐭𝐡𝐞 𝐜𝐨𝐦𝐩𝐚𝐧𝐲’𝐬 𝐚𝐬𝐬𝐞𝐭𝐬.', '', '2023-02-12 02:09:10', 0, 'Standard'),
(30, 1, '0000-00-00', 'ACAP Midyear Graduates', '\"𝐆𝐫𝐞𝐚𝐭 𝐥𝐞𝐚𝐝𝐞𝐫𝐬 𝐝𝐨𝐧\'𝐭 𝐬𝐞𝐭 𝐨𝐮𝐭 𝐭𝐨 𝐛𝐞 𝐚 𝐥𝐞𝐚𝐝𝐞𝐫. 𝐓𝐡𝐞𝐲 𝐬𝐞𝐭 𝐨𝐮𝐭 𝐭𝐨 𝐦𝐚𝐤𝐞 𝐭𝐡𝐞 𝐝𝐢𝐟𝐟𝐞𝐫𝐞𝐧𝐜𝐞. 𝐈𝐭 𝐢𝐬 𝐧𝐞𝐯𝐞𝐫 𝐚𝐛𝐨𝐮𝐭 𝐭𝐡𝐞 𝐫𝐨𝐥𝐞 - 𝐚𝐥𝐰𝐚𝐲𝐬 𝐚𝐛𝐨𝐮𝐭 𝐭𝐡𝐞 𝐠𝐨𝐚𝐥.\" - 𝐋𝐢𝐬𝐚 𝐇𝐚𝐢𝐬𝐡𝐚\r\n\r\nThese exceptional women showcased their unwavering dedication to assisting and supporting their students and colleagues despite facing various challenges during their academic journeys. Managing your education, profession, and organizational duties can be difficult, but you have persevered and are now eagerly approaching the conclusion of this remarkable journey.\r\n\r\nWith that, we are pleased to recognize the midyear graduates of the Polytechnic University of the Philippines Santa Rosa Campus who have assisted the (𝟭) 𝑨𝒔𝒔𝒐𝒄𝒊𝒂𝒕𝒊𝒐𝒏 𝒐𝒇 𝑪𝒐𝒎𝒑𝒆𝒕𝒆𝒏𝒕 𝒂𝒏𝒅 𝑨𝒔𝒑𝒊𝒓𝒊𝒏𝒈 𝑷𝒔𝒚𝒄𝒉𝒐𝒍𝒐𝒈𝒊𝒔𝒕𝒔 and (𝟮) 𝑺𝒕𝒖𝒅𝒆𝒏𝒕 𝑪𝒐𝒖𝒏𝒄𝒊𝒍 𝑶𝒓𝒈𝒂𝒏𝒊𝒛𝒂𝒕𝒊𝒐𝒏. ✨\r\n\r\nThank you for your hard work, commitment, and for making a difference. Hat\'s off, Sikolohistas! 🧑🏻‍🎓🔱\r\n\r\n#ACAPFamily #PUP #BatchPinagpala 🤍💜', '', '2023-03-07 02:09:51', 0, 'Standard'),
(31, 0, '0000-00-00', 'Flag Ceremony', 'It’s the first week of the month, that’s why the PUP Santa Rosa Campus, together with AECES will spearhead the Flag Raising Ceremony for the Month of June.\r\n\r\nWe are encouraging every student to join the flag raising, morning exercises and other programs as we start this month of June.\r\n\r\nSo be on time at 7:30 AM, PUPSRC School Grounds and don’t forget to observe the wearing of proper school uniform. However, students who will attend the program that does not have a uniform yet, must wear white t-shirt and pants pursuant to the school’s official dress codes.\r\n\r\n𝙎𝙚𝙚 𝙮𝙤𝙪 𝙩𝙝𝙚𝙧𝙚 𝙋𝙐𝙋𝙞𝙖𝙣𝙨!', '', '2023-04-01 02:10:40', 0, 'Standard'),
(32, 3, '2023-06-26', 'ELITE Audition Post', 'ATTENTION ENTHUSIASTS! 🧡🖤\r\n\r\nWe are excited to have you join us for our audition for ELITE\'s IT Dance Squad!\r\n\r\nInterested? Audition will take place on Monday, January 9, 2023 in Kanluran Court, 9:00 am - 12:00 pm. Prepare a 30 second - 1 minute piece.\r\n\r\nFor further inquiries please approach Joshua Basa (BSIT 4-2) or Paulo Ariel Griarte (BSIT 4-1).\r\n\r\nSee you then!!', '', '2023-06-26 04:11:56', 0, 'Standard'),
(33, 0, '2023-06-07', 'Mother’s Day', '“𝓣𝓱𝓮 𝓲𝓷𝓯𝓵𝓾𝓮𝓷𝓬𝓮 𝓸𝓯 𝓪 𝓶𝓸𝓽𝓱𝓮𝓻 𝓲𝓷 𝓽𝓱𝓮 𝓵𝓲𝓿𝓮𝓼 𝓸𝓯 𝓱𝓮𝓻 𝓬𝓱𝓲𝓵𝓭𝓻𝓮𝓷 𝓲𝓼 𝓫𝓮𝔂𝓸𝓷𝓭 𝓬𝓪𝓵𝓬𝓾𝓵𝓪𝓽𝓲𝓸𝓷.”—𝓙𝓪𝓶𝓮𝓼 𝓔. 𝓕𝓪𝓾𝓼𝓽\r\n\r\nWe, extends our heartfelt greetings to all the mothers and individuals who firmly stands as the light of the world a 𝐇𝐀𝐏𝐏𝐘 𝐌𝐎𝐓𝐇𝐄𝐑𝐒 𝐃𝐀𝐘!🎊💛. Your unconditional warmth love and endless sacrifices has truly made a significant impact on who we are today.', '', '2023-06-07 12:28:10', 0, 'Standard'),
(34, 2, '2023-06-14', 'Bridging the Gap', 'Calling all Electronics Engineering Students! Join us in our upcoming seminar as we delve into the crucial role of electronics engineers in advancing medical technology. Be part of the movement in \'Bridging the Gap\' and discover the opportunities for technological innovation in the field of medicine. Register now and empower yourself to make a difference!asd\r\n\r\nwith the topic of \"𝗕𝗿𝗶𝗱𝗴𝗶𝗻𝗴 𝘁𝗵𝗲 𝗚𝗮𝗽: 𝗘𝗺𝗽𝗼𝘄𝗲𝗿𝗶𝗻𝗴 𝘁𝗵𝗲 𝗩𝗶𝘁𝗮𝗹 𝗥𝗼𝗹𝗲 𝗼𝗳 𝗘𝗹𝗲𝗰𝘁𝗿𝗼𝗻𝗶𝗰𝘀 𝗘𝗻𝗴𝗶𝗻𝗲𝗲𝗿𝘀 𝗶𝗻 𝘁𝗵𝗲 𝗠𝗲𝗱𝗶𝗰𝗮𝗹 𝗙𝗶𝗲𝗹𝗱\"\r\n\r\nPlease be advised that the number of available slots for this event is 𝗹𝗶𝗺𝗶𝘁𝗲𝗱 𝘁𝗼 𝟳𝟱, 𝘄𝗶𝘁𝗵 𝘁𝗵𝗲 𝗲𝘅𝗰𝗹𝘂𝘀𝗶𝗼𝗻 𝗼𝗳 𝟰𝘁𝗵-𝘆𝗲𝗮𝗿 𝘀𝘁𝘂𝗱𝗲𝗻𝘁𝘀. We highly encourage interested participants to register at the earliest possible time.\r\n\r\n𝗪𝗵𝗲𝗻: May 12, 2023 | Friday\r\n𝗪𝗵𝗲𝗿𝗲: PUP - Sta. Rosa Campus (AVR)\r\n𝗧𝗶𝗺𝗲: 8:00 AM- 12:00 PM\r\n𝗦𝗽𝗲𝗮𝗸𝗲𝗿: Engr. Mark Dairen C. Camcaman', '', '2023-06-07 02:28:10', 0, 'Standard');

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
  ADD KEY `ongoing_criterion_id` (`ongoing_criterion_id`);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
