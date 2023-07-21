-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2023 at 06:22 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

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
(1, 1, 1, 1, 0.00, 1),
(2, 2, 1, 1, 0.00, 1),
(3, 3, 1, 1, 0.00, 1),
(4, 4, 1, 1, 0.00, 1),
(5, 5, 1, 1, 0.00, 1),
(6, 6, 1, 1, 0.00, 1),
(7, 7, 1, 1, 0.00, 1),
(8, 8, 1, 1, 0.00, 1),
(9, 1, 2, 2, 0.00, 1),
(10, 2, 2, 2, 0.00, 1),
(11, 3, 2, 2, 0.00, 1),
(12, 4, 2, 2, 0.00, 1),
(13, 5, 2, 2, 0.00, 1),
(14, 6, 2, 2, 0.00, 1),
(15, 7, 2, 2, 0.00, 1),
(16, 8, 2, 2, 0.00, 1);

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
(1, 1, NULL, NULL, 0),
(44, 53, '2023-07-22 00:14:00', '2023-07-26 00:14:00', 0),
(45, 54, '2023-07-22 00:15:00', '2023-07-24 00:15:00', 0),
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
  `criterion_final_score` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `criterion_scoring`
--

INSERT INTO `criterion_scoring` (`criterion_scoring_id`, `ongoing_criterion_id`, `participants_id`, `judge_id`, `criterion_temp_score`, `criterion_final_score`) VALUES
(13, 85, 3, 2, NULL, 8),
(14, 86, 3, 2, NULL, 8),
(15, 87, 3, 2, NULL, 8),
(16, 85, 4, 2, NULL, 9),
(17, 86, 4, 2, NULL, 9),
(18, 87, 4, 2, NULL, 9),
(19, 85, 5, 2, NULL, 9),
(20, 86, 5, 2, NULL, 9),
(21, 87, 5, 2, NULL, 9),
(22, 85, 6, 2, NULL, 8),
(23, 86, 6, 2, NULL, 8),
(24, 87, 6, 2, NULL, 8),
(25, 85, 7, 2, NULL, 9),
(26, 86, 7, 2, NULL, 9),
(27, 87, 7, 2, NULL, 9),
(28, 85, 3, 3, NULL, 8),
(29, 86, 3, 3, NULL, 8),
(30, 87, 3, 3, NULL, 8),
(31, 85, 4, 3, NULL, 9),
(32, 86, 4, 3, NULL, 9),
(33, 87, 4, 3, NULL, 9),
(34, 85, 5, 3, NULL, 9),
(35, 86, 5, 3, NULL, 9),
(36, 87, 5, 3, NULL, 9),
(37, 85, 6, 3, NULL, 8),
(38, 86, 6, 3, NULL, 8),
(39, 87, 6, 3, NULL, 8),
(40, 85, 7, 3, NULL, 9),
(41, 86, 7, 3, NULL, 9),
(42, 87, 7, 3, NULL, 9),
(53, 88, 13, 5, NULL, 8),
(54, 89, 13, 5, NULL, 8),
(55, 88, 14, 5, NULL, 8),
(56, 89, 14, 5, NULL, 8),
(57, 88, 15, 5, NULL, 8),
(58, 89, 15, 5, NULL, 8),
(59, 88, 16, 5, NULL, 8),
(60, 89, 16, 5, NULL, 8),
(61, 88, 17, 5, NULL, 8),
(62, 89, 17, 5, NULL, 8),
(63, 89, 8, 7, NULL, 8),
(64, 88, 8, 7, NULL, 8),
(65, 88, 9, 7, NULL, 8),
(66, 89, 9, 7, NULL, 8),
(67, 88, 10, 7, NULL, 8),
(68, 89, 10, 7, NULL, 8),
(69, 88, 11, 7, NULL, 8),
(70, 89, 11, 7, NULL, 8),
(71, 88, 12, 7, NULL, 8),
(72, 89, 12, 7, NULL, 8),
(73, 88, 13, 7, NULL, 9),
(74, 89, 13, 7, NULL, 9),
(75, 88, 14, 7, NULL, 9),
(76, 89, 14, 7, NULL, 9),
(77, 88, 15, 7, NULL, 9),
(78, 89, 15, 7, NULL, 9),
(79, 88, 16, 7, NULL, 9),
(80, 88, 16, 7, NULL, 9),
(81, 89, 17, 7, NULL, 9),
(82, 89, 17, 7, NULL, 9),
(83, 88, 13, 6, NULL, 9),
(84, 89, 13, 6, NULL, 9),
(85, 88, 14, 6, NULL, 9),
(86, 89, 14, 6, NULL, 9),
(87, 89, 15, 6, NULL, 9),
(88, 88, 15, 6, NULL, 9),
(89, 88, 16, 6, NULL, 9),
(90, 88, 16, 6, NULL, 9),
(91, 89, 17, 6, NULL, 9),
(92, 89, 17, 6, NULL, 9),
(93, 85, 3, 4, NULL, 8),
(94, 86, 3, 4, NULL, 8),
(95, 87, 3, 4, NULL, 8),
(96, 85, 4, 4, NULL, 9),
(97, 86, 4, 4, NULL, 9),
(98, 87, 4, 4, NULL, 9),
(99, 85, 5, 4, NULL, 9),
(100, 86, 5, 4, NULL, 9),
(101, 87, 5, 4, NULL, 9),
(102, 85, 6, 4, NULL, 8),
(103, 86, 6, 4, NULL, 8),
(104, 87, 6, 4, NULL, 8),
(105, 85, 7, 4, NULL, 9),
(106, 86, 7, 4, NULL, 9),
(107, 87, 7, 4, NULL, 9),
(108, 88, 18, 5, NULL, 8),
(109, 89, 18, 5, NULL, 8),
(110, 88, 19, 5, NULL, 8),
(111, 89, 19, 5, NULL, 8),
(112, 88, 20, 5, NULL, 8),
(113, 89, 20, 5, NULL, 8),
(114, 88, 21, 5, NULL, 8),
(115, 89, 21, 5, NULL, 8),
(116, 88, 22, 5, NULL, 8),
(117, 89, 22, 5, NULL, 8),
(118, 88, 18, 6, NULL, 8),
(119, 89, 18, 6, NULL, 8),
(120, 88, 19, 6, NULL, 8),
(121, 89, 19, 6, NULL, 8),
(122, 88, 20, 6, NULL, 8),
(123, 89, 20, 6, NULL, 8),
(124, 88, 21, 6, NULL, 8),
(125, 89, 21, 6, NULL, 8),
(126, 88, 22, 6, NULL, 8),
(127, 89, 22, 6, NULL, 8),
(128, 88, 18, 7, NULL, 8),
(129, 89, 18, 7, NULL, 8),
(130, 88, 19, 7, NULL, 8),
(131, 89, 19, 7, NULL, 8),
(132, 88, 20, 7, NULL, 8),
(133, 89, 20, 7, NULL, 8),
(134, 88, 21, 7, NULL, 8),
(135, 89, 21, 7, NULL, 8),
(136, 88, 22, 7, NULL, 8),
(137, 89, 22, 7, NULL, 8);

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
(2, 'Intramurals'),
(3, 'National Heroes Day');

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
(355, '2023-07-21', '16:13:17', 1, 'Added \'Buwan ng Wika\' in event_name(event_name) (Events)'),
(356, '2023-07-21', '16:13:34', 1, 'Added \'Intramurals\' in event_name(event_name) (Events)'),
(357, '2023-07-21', '16:13:59', 1, 'Added \'National Heroes Day\' in event_name(event_name) (Events)'),
(358, '2023-07-21', '16:14:31', 1, 'Added \'11\', \'2\', \'Makatang Pagtutula\' in category_name(event_name_id, (Events)'),
(359, '2023-07-21', '16:22:27', 1, 'Added \'Buwan ng Wika\' in event_name(event_name) (Events)'),
(360, '2023-07-21', '16:22:32', 1, 'Added \'Intramurals\' in event_name(event_name) (Events)'),
(361, '2023-07-21', '16:22:48', 1, 'Added \'National Heroes Day\' in event_name(event_name) (Events)'),
(362, '2023-07-21', '16:23:16', 1, 'Added \'1\', \'2\', \'Makatang Pagtutula\' in category_name(event_name_id, (Events)'),
(363, '2023-07-21', '16:23:41', 1, 'Added \'2\', \'1\', \'Cyber League\' in category_name(event_name_id, (Events)'),
(364, '2023-07-21', '16:30:23', 1, 'Added \'1\', \'1\', \'1\', \'2\', \'Makatang Pagtutula\', \'Bilang pakikiisa sa Buwan ng Wikang Pambansa taong 2023, naghanda ng mga patimpalak ang ating sintang paaralan para sa mga PUPians. \', \'2023-08-25\', \'08:00\' in ongoing_list_of_event (Events)'),
(365, '2023-07-21', '16:31:31', 1, 'Added \'2\', \'2\', \'2\', \'1\', \'Cyber League\', \'Embraced the advancement of technology by joining the Cyber league. Registration will be available soon...\', \'2023-07-21\', \'14:00\' in ongoing_list_of_event (Events)'),
(366, '2023-07-21', '16:33:30', 1, 'Added \'3\', \'3\', \'3\', \'It is the day that we give gratitude to those people who sacrifice their life for the better future of our nation.\', \'2023-08-28\', \'00:00\' in ongoing_list_of_event (Events)'),
(367, '2023-07-21', '22:44:20', 1, 'Added \'\', \'0\', \'dsaaaaa\', \'sdaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\', \'2023-07-21 22:44:20\' in post (Announcements)'),
(368, '2023-07-21', '22:45:07', 1, 'Added \'\', \'0\', \'PHOTO\', \'asddddddddddddddddddddddddddddddddddddddddddddddddddddddddd\', \'2023-07-21T22:46\' in post (Announcements)'),
(369, '2023-07-21', '22:50:45', 1, 'Added \'\', \'0\', \'DSAAAAAA\', \'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA\', \'2023-07-21 22:50:45\' in post (Announcements)');

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
(1, 1, 1, 1, 'Nilalaman', 50),
(2, 2, 1, 1, 'Damdamin', 20),
(3, 3, 1, 1, 'Paksa', 30),
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
(1, 1, 'Buwan ng Wika', '2023', 0),
(2, 2, 'Intramurals', '2023', 0),
(3, 3, 'National Heroes Day', '2023', 0),
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
(1, 1, 1, 1, 2, 'Makatang Pagtutula', 'Bilang pakikiisa sa Buwan ng Wikang Pambansa taong 2023, naghanda ng mga patimpalak ang ating sintang paaralan para sa mga PUPians. ', 'RcVdOdXbFbm2', '2023-08-25', '08:00:00', 0, 0, 1, 0),
(2, 2, 2, 2, 1, 'Cyber League', 'Embraced the advancement of technology by joining the Cyber league. Registration will be available soon...', NULL, '2023-07-21', '14:00:00', 0, 0, 1, 0),
(3, 3, NULL, 3, 3, NULL, 'It is the day that we give gratitude to those people who sacrifice their life for the better future of our nation.', NULL, '2023-08-28', '00:00:00', 0, 0, 0, 0),
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
(3, 44, 3, 'Vincent Cosio', '3-2', 80.00),
(4, 44, 4, 'Lance Lira', '2-2', 80.00),
(5, 44, 7, 'Charlene Castro', '4-1', 90.00),
(6, 44, 6, 'Jhimwell Robles', '1-2', 80.00),
(7, 44, 8, 'Renz Esona', '3-1', 80.00),
(8, 45, 1, 'Julianne Climaco', '3-2', 80.00),
(9, 45, 1, 'Raphael Barba', '3-2', 80.00),
(10, 45, 1, 'Kaye Dayo', '3-1', 80.00),
(11, 45, 1, 'Michael Calaguas', '4-2', 80.00),
(12, 45, 1, 'Rhenz Casunuran', '4-1', 80.00),
(13, 45, 2, 'Ephraim Gardoce', '1-1', 90.00),
(14, 45, 2, 'Camille Bermejo', '3-1', 90.00),
(15, 45, 2, 'Louisse Del Mundo', '4-1', 90.00),
(16, 45, 2, 'Junard Calma', '4-2', 90.00),
(17, 45, 2, 'Kathrina Hernandez', '4-2', 90.00),
(18, 45, 5, 'Lance Dalanon', '1-2', 90.00),
(19, 45, 5, 'Rhona Del Rosario', '2-2', 90.00),
(20, 45, 5, 'Sophia Acuzar', '2-1', 90.00),
(21, 45, 5, 'Zemory Casantusan', '4-1', 90.00),
(22, 45, 5, 'Kate Infante', '4-2', 90.00);

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
(86, 6, '0000-00-00 00:00:00', 'Larong Pinoy', '𝐋𝐞𝐭\'𝐬 𝐠𝐨 𝐛𝐚𝐜𝐤 𝐭𝐨 𝐨𝐮𝐫 𝐫𝐨𝐨𝐭𝐬, 𝐈𝐬𝐤𝐨 𝐚𝐧𝐝 𝐈𝐬𝐤𝐚!\r\nLet’s go out with a bang with 𝐋𝐚𝐫𝐨𝐧𝐠 𝐏𝐢𝐧𝐨𝐲, which will bring us back to our nostalgic childhood games that will definitely unlock fond memories as we create brand-new ones with our fellow Marketistas. \r\n\r\n𝗠𝘂𝘀𝘁𝗲𝗿 𝘆𝗼𝘂𝗿 𝘀𝗸𝗶𝗹𝗹𝘀 𝗮𝗻𝗱 𝗰𝗮𝗹𝗹 𝘆𝗼𝘂𝗿 𝗽𝗹𝗮𝘆𝗺𝗮𝘁𝗲𝘀!\r\n\r\n𝗟𝗮𝗿𝗼𝗻𝗴 𝗣𝗶𝗻𝗼𝘆\r\nhttps://l.messenger.com/l.php?u=https%3A%2F%2Fdocs.google.com%2F...%2F1Yk368pwBdx5FCSQ8sHki...%2Fedit&h=AT1btJTrzHodgpUFeqMY7SH5W0r9qQoVRVsXe3GqGpeeuyZ_YWnRHOOUzEbVpkHw5H8e0ScD-F40P_ul-NewVrcEe_49QGR_ruLQxOvGTYp0LpxHlLeDJWl1bmVY50fot4SCzA\r\n\r\n#MarketistaSemEnder2023\r\n#JMAPPUPSRC\r\n#JMAPBatchZeta\r\n#BreakBarriersCreateMeaningfulConnections', '86_COVER_64ac412a6470b.png', '2023-07-11 01:34:34', 0, 'Standard'),
(89, 3, '2023-07-01 00:00:00', 'Project T.A.L.E.N.T.', '𝗜𝗴𝗻𝗶𝘁𝗲 𝘆𝗼𝘂𝗿 𝘀𝗸𝗶𝗹𝗹𝘀 𝗮𝗻𝗱 𝘂𝗻𝗹𝗲𝗮𝘀𝗵 𝘆𝗼𝘂𝗿 𝗽𝗼𝘁𝗲𝗻𝘁𝗶𝗮𝗹 𝘄𝗶𝘁𝗵 \"𝗣𝗿𝗼𝗷𝗲𝗰𝘁 𝗧𝗔𝗟𝗘𝗡𝗧\"! 🚀\r\n\r\nWhether you\'re an aspiring designer, a meticulous tester, a creative graphic artist, or a budding web developer, Project TALENT has something in store for you. \r\n\r\n📅 Mark your calendars for July 1, 2023, from 8:00am to 6:00pm, as we embark on a transformative journey through four exciting topics: \r\n(1) Web Development\r\n(2) UI/UX\r\n(3) Graphics, and;\r\n(4) Quality Assurance\r\n\r\nDon\'t miss your chance to gain valuable insights into these cutting-edge fields. Each seminar is limited to only 60 slots, so make sure to secure your spot early! ⏰\r\n\r\nEmbrace the future of technology and embrace your true potential. Register for Project TALENT and unlock the doors to endless possibilities! 🎉\r\n\r\nPlease take note that this event will be available exclusively to ELITE members only. Registration will be open on June 26 (Monday). \r\n\r\nStay tuned for more details and exciting announcements in the coming days. See you there, ITellectuals! 🧡🖤', '89_COVER_64ac43e9673b2.jpg', '2023-06-24 01:46:17', 0, 'Standard'),
(95, 5, '2023-07-15 00:00:00', 'SOMETHING BIG IS COMING!', '📢 Save the Date! 🗓️\r\n\r\nJoin us, Humanistas, on July 15th as we dive into the world of innovation, technology, and transformative management strategies. Discover how the synergy of these elements can unlock limitless potential, driving both businesses and society forward.\r\n\r\nGet ready for a thought-provoking event that will empower you with the knowledge and insights needed to navigate the ever-evolving landscape. Together, we\'ll explore cutting-edge technologies, share best practices, and discuss effective strategies for success.\r\n\r\nDon\'t miss out on this opportunity to connect with industry leaders, entrepreneurs, and change-makers. Mark your calendars and join us on July 15th to unlock the power of technology and effective management for a brighter future! 🌐💼✨', '95_COVER_64ac470dc541b.png', '2023-07-01 01:59:41', 0, 'Standard'),
(98, 7, '0000-00-00 00:00:00', 'Winners of REVAMP Academic Webinar Series Raffle Games', 'We are thrilled to announce the triumphant recipients of our raffle games during the REVAMP Academic Webinar Series: Bridging the Gaps towards Excellence! All the prizes have been successfully dispatched to the winners\' respective email addresses. If you have any concerns or inquiries regarding this matter, please don\'t hesitate to reach out to us via the 𝑷𝑼𝑷 𝑺𝑹𝑪 𝑱𝑷𝑰𝑨 𝑭𝒂𝒄𝒆𝒃𝒐𝒐𝒌 𝑷𝒂𝒈𝒆 or contact our 𝑽𝑷 𝒇𝒐𝒓 𝑨𝒄𝒂𝒅𝒆𝒎𝒊𝒄𝒔, 𝑱𝒂𝒏𝒆𝒍𝒍𝒂 𝑴𝒂𝒓𝒂𝒏̃𝒐.\r\n\r\nOnce again, we extend our warmest congratulations to all the winners!\r\n\r\nSponsors:\r\n🍄 𝗥𝗲𝗶𝗴𝗻𝗮 & 𝗥𝗼𝗴𝗴𝗶𝗲 𝗔𝗽𝗮𝗿𝘁𝗺𝗲𝗻𝘁\r\n🍰 𝗝𝗼𝘆\'𝘀 𝗣𝘂𝘁𝗼𝗰𝗮𝗸𝗲:\r\n🧶 𝗥𝗲𝗰𝗿𝗼𝗰𝗵𝗲𝘁\r\n🏢 𝗙𝗿𝗮𝗻𝗰𝗵𝗶𝘀𝗲𝗠𝗮𝗻𝗶𝗹𝗮.𝗰𝗼𝗺\r\n🎓 𝗖𝗣𝗔 𝗢𝗻𝗹𝗶𝗻𝗲 𝗥𝗲𝘃𝗶𝗲𝘄 𝗦𝗰𝗵𝗼𝗼𝗹\r\n🔧 𝗔𝘀𝗵 𝗧𝗲𝗰𝗵\r\n📜 𝗣𝗮𝗽𝗲𝗿𝗹𝗮𝗻𝗱\r\n🍰 𝗔𝗘\'𝘀 𝗦𝘄𝗲𝗲𝘁 𝗖𝗿𝗲𝗮𝘁𝗶𝗼𝗻𝘀\r\n❄️ 𝗜𝗰𝘆 𝗦𝗼𝗹𝗲𝘀\r\n\r\nLayout: Myk De Mesa', 'cover-JPIA.png', '2023-03-03 02:06:03', 0, 'Standard'),
(99, 0, '0000-00-00 00:00:00', '19th Cityhood Anniversary', 'By virtue of Presidential Proclamation no. 268, July 10, 2023, Monday, is hereby declared as a Special Non-Working Holiday in the City of Santa Rosa, Laguna. This is due to the celebration of its 19th Cityhood Anniversary\r\n\r\nPlease be guided accordingly. Thank you.', '99_COVER_64ac4903c0415.jpg', '2023-07-11 02:08:03', 0, 'Standard'),
(101, 3, '0000-00-00 00:00:00', 'Lanyard Making Contest 2023 Winners', '𝗖𝗼𝗻𝗴𝗿𝗮𝘁𝘂𝗹𝗮𝘁𝗶𝗼𝗻𝘀 𝘁𝗼 𝘁𝗵𝗲 𝗼𝗳𝗳𝗶𝗰𝗶𝗮𝗹 𝘄𝗶𝗻𝗻𝗲𝗿𝘀 𝗼𝗳 𝘁𝗵𝗲 𝗟𝗮𝗻𝘆𝗮𝗿𝗱 𝗠𝗮𝗸𝗶𝗻𝗴 𝗖𝗼𝗻𝘁𝗲𝘀𝘁 𝟮𝟬𝟮𝟯! 🎉\r\n\r\nCongratulations to the brilliant minds behind the winning lanyard designs of the Lanyard Making Contest 2023! 🎨 A big round of applause for our top 2 winners who showcased their exceptional creativity and talent. 🙌\r\n\r\n🏆 𝗞𝗹𝗮𝗿𝗸𝗶𝗲𝗻 𝗣. 𝗚𝘂𝗶𝗹𝗹𝗲𝗻𝗮 (𝗕𝗦𝗜𝗧 𝟯-𝟮) - 𝟯𝟭.𝟱%\r\n🏆 𝗖𝗿𝘆𝘀𝘁𝗮𝗹 𝗦𝗵𝗮𝗻𝗲 𝗚𝗮𝗿𝗻𝗶𝗰𝗮 (𝗕𝗦𝗜𝗧 𝟭-𝟮) - 𝟮𝟮.𝟱%\r\n\r\nWe also extend our heartfelt appreciation to each and every participant who contributed to the success of this event. Your passion and dedication made it a memorable competition. Stay tuned for more amazing contests in the future! 🧡🖤\r\n\r\nLayout by: Ayumi Hidalgo', '101_COVER_64b9f114386a9.jpg', '2023-07-11 02:00:00', 0, 'Standard'),
(103, 0, '0000-00-00 00:00:00', 'Printing of Certificate of Candidacy for Year-End Graduation', 'Please be informed that the printing of Certificate of Candidacy (COC) for Year-End Graduation,  A.Y. 2022-2023 will start on July 11 until August 07, 2023. \r\n\r\nAll are required to print the COC for their names to be included in the list of Candidates for Graduation.\r\n\r\nPlease be guided accordingly. Thank you!', 'cover-SC.png', '2023-07-12 19:51:56', 0, 'Standard'),
(104, 3, '0000-00-00 00:00:00', 'Ready, Set, Code! 🤖💻', 'Brace yourselves for an exhilarating journey into the realms of digital creation and problem-solving through our Hackathon 2023, happening this August 3-5, 2023! \r\n\r\nArmed with keyboards and caffeine, we\'re forging a path toward technological marvels. So, keep your ears perked and your curiosity ignited as we prepare to unveil an electrifying torrent of updates in the following days.  Let\'s shatter limits, and weave our dreams into lines of code!', '104_COVER_64ba3e33a4f97.jpg', '2023-07-18 08:00:39', 0, 'Standard'),
(105, 1, '0000-00-00 00:00:00', 'GILAS SIKOLOHISTAS BLEPP 2023! 💻', 'The Board Licensure Exam for Psychologists and Psychometricians (BLEPP) 2023 is drawing near! This year\'s BLEPP is set on August 1 and 2, almost a month left in our calendar.\r\n\r\nThe Association of Competent and Aspiring Psychologists (ACAP) extends its support to all our psychmate aspirants who will take the said examination. To our Polytechnic University of the Philippines - Sta. Rosa Campus Psychology Alumni, we wish you all the best! May the stars align and be in your favor!\r\n\r\nFor PUP-SRC BS Psychology Alumni who will be taking BLEPP 2023, we encourage you to answer this survey form:\r\nhttps://tinyurl.com/PUPSRCBLEPP2023Takers', '105_COVER_64ba40ee928b7.jpg', '2023-07-04 09:00:18', 0, 'Standard'),
(106, 2, '0000-00-00 00:00:00', 'IECEP-Laguna Chapter now opens!', '𝙃𝙚𝙖𝙙𝙨 𝙪𝙥, 𝙀𝘾𝙀𝙨!\r\n\r\nThe IECEP-Laguna Chapter now opens its annual individual registration. The registration is open for new and old members (incoming 2nd Years-4th Years BSECE students) amounting to 150 for the old and 200 for the new ones. \r\n\r\nRegister now and indulge with the following perks:\r\n1. Recieve you IECEP LSC ID and Lanyard\r\n2. Build camaraderie across all affiliated organizations of the chapter.\r\n3. Enjoy free seminars with free certificates.\r\n4. Avail special discounts on chapter\'s events held by IECEP-LSC and discounts from partners\' services.\r\n5. Be updated and prioritized on exclusive opportunities offered to the chapter.\r\n6. 50 PHP registration discount on the upcoming IECEP General Assembly 2023 happening this September.\r\n\r\nThat\'s why, register now and be one of us! Registration for AECES members lasts on July 3-27, 2023 only. See you one of these days,  Ka-IECEP!\r\n\r\nRegistration link:\r\nhttps://forms.gle/jMGtzc59SdnJpxKWA', 'cover-AECES.png', '2023-07-18 16:27:06', 0, 'Standard'),
(107, 4, '0000-00-00 00:00:00', 'Education Students A.Y. 2022-2023', 'Para sa\'yo na nagpapatuloy kahit nalilito. \r\nPara sa\'yo na kahit nadarapa ay muling tumatayo. \r\nPara sa\'yo na sinusubok ng panahon ngunit sumasabay pa rin sa agos nito. \r\nPara sa\'yo na hindi sumusuko kahit nakakapagod ang mundo.\r\n\r\nPagbati sa iyong husay, talino, tyaga, at katatagan! Kaunti na lamang at maaabot mo na ang iyong matagal nang pinagpapaguran at hinihintay. \r\n\r\nMuli, dahil alam naming ikaw na \'yan, alam naming kaya mo yan! Kapwa educ, laban pa, laban lang, laban lagi!\r\n\r\nDisclaimer: Ang post na ito ay hindi para sa pagtatapos ng mga nabanggit na mag-aaral bagkus isang pagkilala sa kanilang sakripisyo,  husay, at pagpapagal habang nasa Sintang Paaralan sa loob ng apat na taon.', '107_COVER_64ba4349186e0.jpg', '2023-06-12 12:16:21', 0, 'Standard');

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
(32, 89, '89_PHOTO_64ac43e967fda.jpg'),
(33, 89, '89_PHOTO_64ac43e968a6f.jpg'),
(34, 89, '89_PHOTO_64ac43e9693ea.jpg'),
(35, 89, '89_PHOTO_64ac43e969dbd.jpg'),
(38, 95, '95_PHOTO_64ac470dc60e9.png'),
(42, 98, '98_PHOTO_64ac488b36afe.jpg'),
(43, 98, '98_PHOTO_64ac488b37376.jpg'),
(44, 98, '98_PHOTO_64ac488b37cc8.jpg'),
(45, 98, '98_PHOTO_64ac488b3862e.jpg'),
(46, 98, '98_PHOTO_64ac488b38df0.jpg'),
(47, 98, '98_PHOTO_64ac488b395c0.jpg'),
(48, 101, '101_PHOTO_64b9f114391ab.jpg'),
(49, 101, '101_PHOTO_64b9f11439a6a.jpg'),
(55, 104, '104_PHOTO_64ba3e33a6217.jpg'),
(56, 105, '105_PHOTO_64ba40ee9344d.jpg'),
(57, 106, '106_PHOTO_64ba420e55241.jpg'),
(58, 106, '106_PHOTO_64ba420e55b59.jpg'),
(59, 106, '106_PHOTO_64ba420e56a69.jpg'),
(60, 106, '106_PHOTO_64ba420e5770b.jpg'),
(61, 107, '107_PHOTO_64ba434918ffd.jpg'),
(62, 107, '107_PHOTO_64ba434919bf5.jpg'),
(63, 107, '107_PHOTO_64ba43491a88a.jpg'),
(64, 107, '107_PHOTO_64ba43491b2cc.jpg'),
(65, 107, '107_PHOTO_64ba43491ba73.jpg');

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
(1, 2, 2, 0, NULL);

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
  MODIFY `organization_bar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
  MODIFY `category_name_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `criterion_scoring_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `event_name`
--
ALTER TABLE `event_name`
  MODIFY `event_name_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `event_type`
--
ALTER TABLE `event_type`
  MODIFY `event_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `highlights`
--
ALTER TABLE `highlights`
  MODIFY `highlight_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `judges`
--
ALTER TABLE `judges`
  MODIFY `judge_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=370;

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
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `post_photo`
--
ALTER TABLE `post_photo`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `score_rule`
--
ALTER TABLE `score_rule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tournament`
--
ALTER TABLE `tournament`
  MODIFY `tournament_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  ADD CONSTRAINT `post_photo_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE;

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
