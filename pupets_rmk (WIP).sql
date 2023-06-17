-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2023 at 11:24 AM
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
-- Database: `pupets`
--

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
(14, 5, 1, 'Basketball'),
(15, 6, 2, 'Example A'),
(19, 8, 1, 'JAJAJAJA');

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
-- Table structure for table `eventhistorytb`
--

CREATE TABLE `eventhistorytb` (
  `event_id` int(11) NOT NULL,
  `category_name_id` int(11) NOT NULL,
  `event_description` varchar(255) NOT NULL,
  `event_code` varchar(12) NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `judge_id` int(11) NOT NULL,
  `suggested_status` tinyint(4) NOT NULL
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
(5, 'Foundation Day'),
(6, 'Event A'),
(7, 'Buwan ng Wiks'),
(8, 'HAHAHAHA');

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
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `filename` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image_Info` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image_Description` varchar(3000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id`, `filename`, `image_Info`, `image_Description`, `status`) VALUES
(6, '6465195ead571.jpg', 'tanglaw', 'CARL', 0),
(7, '6465199f405c1.jpg', 'ASDSAD', 'DASDASSADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADASDASSADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADASDASSADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADASDASSADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADASDASSADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADASDASSADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADASDASSADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADASDASSADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADASDASSADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADASDASSADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADASDASSADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADASDASSADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADASDASSADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADASDASSADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADASDASSADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADASDASSADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADASDASSADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADASDASSADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADASDASSADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADASDASSADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADASDASSADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', 0),
(16, '64879e11336ab.jpg', 'asdasdas', 'asdasd', 0),
(17, '64879e3fd309e.jpg', 'as', 'as', 0);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `log_id` bigint(20) NOT NULL,
  `log_date` date NOT NULL,
  `log_time` time NOT NULL,
  `admin` varchar(255) NOT NULL,
  `activity_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`log_id`, `log_date`, `log_time`, `admin`, `activity_description`) VALUES
(1, '2023-06-13', '06:24:19', 'admin', 'Added in Events'),
(2, '2023-06-13', '06:24:19', 'admin', 'Edited in Events'),
(3, '2023-06-13', '06:25:25', 'admin', 'Added in Events'),
(4, '2023-06-13', '06:25:25', 'admin', 'Edited in Events'),
(5, '2023-06-13', '06:32:47', 'admin', 'Removed in Event History'),
(6, '2023-06-13', '06:37:51', 'admin', 'Added in Event History'),
(7, '2023-06-13', '06:38:18', 'admin', 'Edited in Event History'),
(8, '2023-06-13', '06:38:19', 'admin', 'Edited in Event History'),
(9, '2023-06-13', '06:38:19', 'admin', 'Edited in Event History'),
(10, '2023-06-13', '06:38:22', 'admin', 'Edited in Event History'),
(11, '2023-06-13', '06:38:22', 'admin', 'Edited in Event History'),
(12, '2023-06-13', '06:38:22', 'admin', 'Edited in Event History'),
(13, '2023-06-13', '06:39:30', 'admin', 'Added in Event History'),
(14, '2023-06-13', '06:39:48', 'admin', 'Removed in Event History'),
(15, '2023-06-13', '06:42:24', 'admin', 'Added in Announcements'),
(16, '2023-06-13', '06:43:21', 'admin', 'Removed in Announcements'),
(17, '2023-06-13', '06:45:07', 'admin', 'Edited in Announcements'),
(18, '2023-06-13', '06:45:20', 'admin', 'Edited in Announcements'),
(19, '2023-06-13', '06:55:57', 'admin', 'Added in Participants and Judges'),
(20, '2023-06-13', '06:55:57', 'admin', 'Added in Participants and Judges'),
(21, '2023-06-13', '06:56:30', 'admin', 'Added in Participants and Judges'),
(22, '2023-06-13', '06:56:30', 'admin', 'Added in Participants and Judges'),
(23, '2023-06-13', '06:56:52', 'admin', 'Added in Participants and Judges'),
(24, '2023-06-13', '06:56:52', 'admin', 'Added in Participants and Judges'),
(25, '2023-06-13', '06:56:52', 'admin', 'Added in Participants and Judges'),
(26, '2023-06-13', '06:56:52', 'admin', 'Added in Participants and Judges'),
(27, '2023-06-13', '06:59:14', 'admin', 'Edited in Overall Results'),
(28, '2023-06-13', '06:59:17', 'admin', 'Edited in Overall Results'),
(29, '2023-06-13', '06:59:20', 'admin', 'Edited in Overall Results'),
(30, '2023-06-13', '06:59:26', 'admin', 'Edited in Overall Results'),
(31, '2023-06-13', '07:03:20', 'admin', 'Added in Announcements'),
(32, '2023-06-13', '07:05:18', 'admin', 'Edited in Announcements'),
(33, '2023-06-13', '07:05:40', 'admin', 'Edited in Overall Results'),
(34, '2023-06-13', '07:06:11', 'admin', 'Edited in Event History'),
(35, '2023-06-13', '07:06:12', 'admin', 'Edited in Event History'),
(36, '2023-06-13', '07:06:12', 'admin', 'Edited in Event History'),
(37, '2023-06-13', '07:06:14', 'admin', 'Edited in Event History'),
(38, '2023-06-13', '07:06:14', 'admin', 'Edited in Event History'),
(39, '2023-06-13', '07:06:14', 'admin', 'Edited in Event History'),
(40, '2023-06-13', '07:06:42', 'admin', 'Added in Event History'),
(41, '2023-06-13', '07:06:49', 'admin', 'Removed in Event History'),
(42, '2023-06-13', '07:07:10', 'admin', 'Added in Participants and Judges'),
(43, '2023-06-13', '07:07:10', 'admin', 'Added in Participants and Judges'),
(44, '2023-06-13', '07:07:26', 'admin', 'Added in Participants and Judges'),
(45, '2023-06-13', '07:08:13', 'admin', 'Added in Participants and Judges'),
(46, '2023-06-13', '07:08:13', 'admin', 'Added in Participants and Judges');

-- --------------------------------------------------------

--
-- Table structure for table `ongoing_category_name`
--

CREATE TABLE `ongoing_category_name` (
  `category_name_id` int(11) NOT NULL,
  `event_name_id` int(11) NOT NULL,
  `event_type_id` int(11) NOT NULL,
  `category_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ongoing_category_name`
--

INSERT INTO `ongoing_category_name` (`category_name_id`, `event_name_id`, `event_type_id`, `category_name`) VALUES
(14, 5, 1, 'Basketball'),
(17, 7, 2, 'Poster Making'),
(18, 7, 2, 'FAFAFA');

-- --------------------------------------------------------

--
-- Table structure for table `ongoing_criterion`
--

CREATE TABLE `ongoing_criterion` (
  `criterion_id` int(11) NOT NULL,
  `category_name_id` int(11) NOT NULL,
  `criterion_name` varchar(50) NOT NULL,
  `criterion_percent` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ongoing_criterion`
--

INSERT INTO `ongoing_criterion` (`criterion_id`, `category_name_id`, `criterion_name`, `criterion_percent`) VALUES
(6, 17, 'Creativity', 50),
(7, 17, 'Originality', 50),
(8, 18, 'Criteria A', 25),
(9, 18, 'Criteria B', 25),
(10, 18, 'Criteria C', 50);

-- --------------------------------------------------------

--
-- Table structure for table `ongoing_event_name`
--

CREATE TABLE `ongoing_event_name` (
  `event_name_id` int(11) NOT NULL,
  `event_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ongoing_event_name`
--

INSERT INTO `ongoing_event_name` (`event_name_id`, `event_name`) VALUES
(5, 'Foundation Day'),
(7, 'Buwan ng Wiks');

-- --------------------------------------------------------

--
-- Table structure for table `ongoing_list_of_event`
--

CREATE TABLE `ongoing_list_of_event` (
  `event_id` int(11) NOT NULL,
  `category_name_id` int(11) NOT NULL,
  `event_description` varchar(255) NOT NULL,
  `event_code` varchar(12) NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `judge_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ongoing_list_of_event`
--

INSERT INTO `ongoing_list_of_event` (`event_id`, `category_name_id`, `event_description`, `event_code`, `event_date`, `event_time`, `judge_id`) VALUES
(21, 18, 'GAGAGAGAGAGs', 'lpXOgCbWFU4T', '2023-07-06', '11:40:00', 0),
(26, 17, 'HAHAHAHAHAHA', 'RKDwN2ItD2xs', '2023-06-30', '22:48:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ongoing_tournament`
--

CREATE TABLE `ongoing_tournament` (
  `tournament_id` int(11) NOT NULL,
  `category_name_id` int(11) NOT NULL,
  `number_of_wins` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `post_calendar` date DEFAULT NULL,
  `post_tag` varchar(15) NOT NULL,
  `post_title` varchar(60) NOT NULL,
  `post_description` text NOT NULL,
  `post_cover` text DEFAULT NULL,
  `post_photos` text DEFAULT NULL,
  `post_schedule` datetime NOT NULL,
  `post_calendar_type` varchar(8) DEFAULT 'Standard'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `post_calendar`, `post_tag`, `post_title`, `post_description`, `post_cover`, `post_photos`, `post_schedule`, `post_calendar_type`) VALUES
(28, '2023-06-07', 'JMAP', 'Kislap Livelihood is finally here!', 'Join us as we light up the world in this year\'s livelihood program hold by 𝐉𝐮𝐧𝐢𝐨𝐫 𝐌𝐚𝐫𝐤𝐞𝐭𝐢𝐧𝐠 𝐀𝐬𝐬𝐨𝐜𝐢𝐚𝐭𝐢𝐨𝐧 𝐨𝐟 𝐭𝐡𝐞 𝐏𝐡𝐢𝐥𝐢𝐩𝐩𝐢𝐧𝐞𝐬 - 𝐁𝐚𝐭𝐜𝐡 𝐙𝐞𝐭𝐚. This activity will run starting June 6-8, 2023 from 2pm-4pm in PUP-SRC. All registered participants, check your email for the further details.\r\n\r\nShine vividly, Iskolar ng Bayan! 🕯️✨', NULL, NULL, '2023-01-07 02:07:33', 'Standard'),
(29, '2023-06-12', 'JEHRA', 'JEHRA Seminar', '“𝑨𝒏 𝒐𝒓𝒈𝒂𝒏𝒊𝒛𝒂𝒕𝒊𝒐𝒏’𝒔 𝒂𝒃𝒊𝒍𝒊𝒕𝒚 𝒕𝒐 𝑳𝑬𝑨𝑹𝑵, 𝒂𝒏𝒅 𝒕𝒓𝒂𝒏𝒔𝒍𝒂𝒕𝒆 𝒕𝒉𝒂𝒕 𝒍𝒆𝒂𝒓𝒏𝒊𝒏𝒈 𝒊𝒏𝒕𝒐 𝑨𝑪𝑻𝑰𝑶𝑵 𝒓𝒂𝒑𝒊𝒅𝒍𝒚 𝒊𝒔 𝒕𝒉𝒆 𝒖𝒍𝒕𝒊𝒎𝒂𝒕𝒆 𝑪𝑶𝑴𝑷𝑬𝑻𝑰𝑻𝑰𝑽𝑬 𝑨𝑫𝑽𝑨𝑵𝑻𝑨𝑮𝑬.” – 𝑱𝒂𝒄𝒌 𝑾𝒆𝒍𝒄𝒉\r\n\r\nWarmest Greetings!\r\n\r\nWe are inviting you to join us on the 𝟏𝟐𝒕𝒉 𝒐𝒇 𝑱𝒂𝒏𝒖𝒂𝒓𝒚 𝟐𝟎𝟐𝟑 (Thursday), from 𝟐:𝟎𝟎𝑷𝑴 𝒕𝒐 𝟓:𝟎𝟎 𝑷𝑴at the 𝑨𝒖𝒅𝒊𝒐-𝒗𝒊𝒔𝒖𝒂𝒍 𝑹𝒐𝒐𝒎 𝟑𝟎𝟖 (𝟑𝒓𝒅 𝑭𝒍𝒐𝒐𝒓), 𝑷𝑼𝑷 𝑺𝒂𝒏𝒕𝒂 𝑹𝒐𝒔𝒂 𝑪𝒂𝒎𝒑𝒖𝒔.\r\n\r\nGet ready to learn as we discuss 𝑻𝑹𝑨𝑰𝑵𝑰𝑵𝑮 𝑨𝑵𝑫 𝑫𝑬𝑽𝑬𝑳𝑶𝑷𝑴𝑬𝑵𝑻: 𝑨𝒑𝒑𝒓𝒐𝒂𝒄𝒉𝒆𝒔 𝒂𝒏𝒅 𝑻𝒆𝒄𝒉𝒏𝒊𝒒𝒖𝒆𝒔 𝒊𝒏 𝑬𝒒𝒖𝒊𝒑𝒑𝒊𝒏𝒈 𝑷𝒆𝒐𝒑𝒍𝒆 𝑻𝒐𝒘𝒂𝒓𝒅𝒔 𝑪𝒐𝒎𝒑𝒂𝒏𝒚 𝑺𝒖𝒄𝒄𝒆𝒔𝒔. Immerse ourselves in a thorough exploration of the significance of proficiently educating individuals within an organization, considering our role as a Future Human Resource.\r\n\r\n𝐖𝐞 𝐚𝐫𝐞 𝐭𝐫𝐚𝐢𝐧𝐞𝐝 𝐭𝐨 𝐭𝐫𝐚𝐢𝐧 𝐩𝐞𝐨𝐩𝐥𝐞 𝐚𝐧𝐝 𝐦𝐨𝐥𝐝 𝐭𝐡𝐞𝐦 𝐭𝐨 𝐛𝐞 𝐭𝐡𝐞 𝐜𝐨𝐦𝐩𝐚𝐧𝐲’𝐬 𝐚𝐬𝐬𝐞𝐭𝐬.', NULL, NULL, '2023-02-12 02:09:10', 'Standard'),
(30, '0000-00-00', 'ACAP', 'ACAP Midyear Graduates', '\"𝐆𝐫𝐞𝐚𝐭 𝐥𝐞𝐚𝐝𝐞𝐫𝐬 𝐝𝐨𝐧\'𝐭 𝐬𝐞𝐭 𝐨𝐮𝐭 𝐭𝐨 𝐛𝐞 𝐚 𝐥𝐞𝐚𝐝𝐞𝐫. 𝐓𝐡𝐞𝐲 𝐬𝐞𝐭 𝐨𝐮𝐭 𝐭𝐨 𝐦𝐚𝐤𝐞 𝐭𝐡𝐞 𝐝𝐢𝐟𝐟𝐞𝐫𝐞𝐧𝐜𝐞. 𝐈𝐭 𝐢𝐬 𝐧𝐞𝐯𝐞𝐫 𝐚𝐛𝐨𝐮𝐭 𝐭𝐡𝐞 𝐫𝐨𝐥𝐞 - 𝐚𝐥𝐰𝐚𝐲𝐬 𝐚𝐛𝐨𝐮𝐭 𝐭𝐡𝐞 𝐠𝐨𝐚𝐥.\" - 𝐋𝐢𝐬𝐚 𝐇𝐚𝐢𝐬𝐡𝐚\r\n\r\nThese exceptional women showcased their unwavering dedication to assisting and supporting their students and colleagues despite facing various challenges during their academic journeys. Managing your education, profession, and organizational duties can be difficult, but you have persevered and are now eagerly approaching the conclusion of this remarkable journey.\r\n\r\nWith that, we are pleased to recognize the midyear graduates of the Polytechnic University of the Philippines Santa Rosa Campus who have assisted the (𝟭) 𝑨𝒔𝒔𝒐𝒄𝒊𝒂𝒕𝒊𝒐𝒏 𝒐𝒇 𝑪𝒐𝒎𝒑𝒆𝒕𝒆𝒏𝒕 𝒂𝒏𝒅 𝑨𝒔𝒑𝒊𝒓𝒊𝒏𝒈 𝑷𝒔𝒚𝒄𝒉𝒐𝒍𝒐𝒈𝒊𝒔𝒕𝒔 and (𝟮) 𝑺𝒕𝒖𝒅𝒆𝒏𝒕 𝑪𝒐𝒖𝒏𝒄𝒊𝒍 𝑶𝒓𝒈𝒂𝒏𝒊𝒛𝒂𝒕𝒊𝒐𝒏. ✨\r\n\r\nThank you for your hard work, commitment, and for making a difference. Hat\'s off, Sikolohistas! 🧑🏻‍🎓🔱\r\n\r\n#ACAPFamily #PUP #BatchPinagpala 🤍💜', NULL, NULL, '2023-03-07 02:09:51', 'Standard'),
(31, '0000-00-00', 'SC', 'Flag Ceremony', 'It’s the first week of the month, that’s why the PUP Santa Rosa Campus, together with AECES will spearhead the Flag Raising Ceremony for the Month of June.\r\n\r\nWe are encouraging every student to join the flag raising, morning exercises and other programs as we start this month of June.\r\n\r\nSo be on time at 7:30 AM, PUPSRC School Grounds and don’t forget to observe the wearing of proper school uniform. However, students who will attend the program that does not have a uniform yet, must wear white t-shirt and pants pursuant to the school’s official dress codes.\r\n\r\n𝙎𝙚𝙚 𝙮𝙤𝙪 𝙩𝙝𝙚𝙧𝙚 𝙋𝙐𝙋𝙞𝙖𝙣𝙨!', NULL, NULL, '2023-04-01 02:10:40', 'Standard'),
(32, '2023-06-09', 'ELITE', 'ELITE Audition Post', 'ATTENTION ENTHUSIASTS! 🧡🖤\r\n\r\nWe are excited to have you join us for our audition for ELITE\'s IT Dance Squad!\r\n\r\nInterested? Audition will take place on Monday, January 9, 2023 in Kanluran Court, 9:00 am - 12:00 pm. Prepare a 30 second - 1 minute piece.\r\n\r\nFor further inquiries please approach Joshua Basa (BSIT 4-2) or Paulo Ariel Griarte (BSIT 4-1).\r\n\r\nSee you then!!', NULL, NULL, '2023-04-07 02:11:17', 'Standard'),
(33, '2023-06-07', 'SC', 'Mother’s Day', '“𝓣𝓱𝓮 𝓲𝓷𝓯𝓵𝓾𝓮𝓷𝓬𝓮 𝓸𝓯 𝓪 𝓶𝓸𝓽𝓱𝓮𝓻 𝓲𝓷 𝓽𝓱𝓮 𝓵𝓲𝓿𝓮𝓼 𝓸𝓯 𝓱𝓮𝓻 𝓬𝓱𝓲𝓵𝓭𝓻𝓮𝓷 𝓲𝓼 𝓫𝓮𝔂𝓸𝓷𝓭 𝓬𝓪𝓵𝓬𝓾𝓵𝓪𝓽𝓲𝓸𝓷.”—𝓙𝓪𝓶𝓮𝓼 𝓔. 𝓕𝓪𝓾𝓼𝓽\r\n\r\nWe, extends our heartfelt greetings to all the mothers and individuals who firmly stands as the light of the world a 𝐇𝐀𝐏𝐏𝐘 𝐌𝐎𝐓𝐇𝐄𝐑𝐒 𝐃𝐀𝐘!🎊💛. Your unconditional warmth love and endless sacrifices has truly made a significant impact on who we are today.', NULL, NULL, '2023-05-23 02:15:48', 'Standard'),
(34, '2023-06-14', 'AECES', 'Bridging the Gap', 'Calling all Electronics Engineering Students! Join us in our upcoming seminar as we delve into the crucial role of electronics engineers in advancing medical technology. Be part of the movement in \'Bridging the Gap\' and discover the opportunities for technological innovation in the field of medicine. Register now and empower yourself to make a difference!asd\r\n\r\nwith the topic of \"𝗕𝗿𝗶𝗱𝗴𝗶𝗻𝗴 𝘁𝗵𝗲 𝗚𝗮𝗽: 𝗘𝗺𝗽𝗼𝘄𝗲𝗿𝗶𝗻𝗴 𝘁𝗵𝗲 𝗩𝗶𝘁𝗮𝗹 𝗥𝗼𝗹𝗲 𝗼𝗳 𝗘𝗹𝗲𝗰𝘁𝗿𝗼𝗻𝗶𝗰𝘀 𝗘𝗻𝗴𝗶𝗻𝗲𝗲𝗿𝘀 𝗶𝗻 𝘁𝗵𝗲 𝗠𝗲𝗱𝗶𝗰𝗮𝗹 𝗙𝗶𝗲𝗹𝗱\"\r\n\r\nPlease be advised that the number of available slots for this event is 𝗹𝗶𝗺𝗶𝘁𝗲𝗱 𝘁𝗼 𝟳𝟱, 𝘄𝗶𝘁𝗵 𝘁𝗵𝗲 𝗲𝘅𝗰𝗹𝘂𝘀𝗶𝗼𝗻 𝗼𝗳 𝟰𝘁𝗵-𝘆𝗲𝗮𝗿 𝘀𝘁𝘂𝗱𝗲𝗻𝘁𝘀. We highly encourage interested participants to register at the earliest possible time.\r\n\r\n𝗪𝗵𝗲𝗻: May 12, 2023 | Friday\r\n𝗪𝗵𝗲𝗿𝗲: PUP - Sta. Rosa Campus (AVR)\r\n𝗧𝗶𝗺𝗲: 8:00 AM- 12:00 PM\r\n𝗦𝗽𝗲𝗮𝗸𝗲𝗿: Engr. Mark Dairen C. Camcaman', NULL, NULL, '2023-06-07 02:28:10', 'Standard'),
(36, '2023-06-16', 'AECES', 'asdasd', 'asdasdasdasdasd', NULL, NULL, '2023-06-13 01:03:20', 'Standard');

-- --------------------------------------------------------

--
-- Table structure for table `tournament`
--

CREATE TABLE `tournament` (
  `tournament_id` int(11) NOT NULL,
  `category_name_id` int(11) NOT NULL,
  `number_of_wins` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `user_username` varchar(20) NOT NULL,
  `user_password` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_username`, `user_password`) VALUES
(1, 'admin', 'admin'),
(2, 'admin', 'admin'),
(3, 'admin', 'admin'),
(4, 'admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category_name`
--
ALTER TABLE `category_name`
  ADD PRIMARY KEY (`category_name_id`),
  ADD KEY `event_name_id` (`event_name_id`),
  ADD KEY `event_type_id` (`event_type_id`);

--
-- Indexes for table `criterion`
--
ALTER TABLE `criterion`
  ADD PRIMARY KEY (`criterion_id`),
  ADD KEY `category_name_id` (`category_name_id`);

--
-- Indexes for table `eventhistorytb`
--
ALTER TABLE `eventhistorytb`
  ADD PRIMARY KEY (`event_id`),
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
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `ongoing_category_name`
--
ALTER TABLE `ongoing_category_name`
  ADD PRIMARY KEY (`category_name_id`),
  ADD KEY `event_type_id` (`event_type_id`),
  ADD KEY `ongoing_category_name_ibfk_1` (`event_name_id`);

--
-- Indexes for table `ongoing_criterion`
--
ALTER TABLE `ongoing_criterion`
  ADD PRIMARY KEY (`criterion_id`),
  ADD KEY `category_name_id` (`category_name_id`);

--
-- Indexes for table `ongoing_event_name`
--
ALTER TABLE `ongoing_event_name`
  ADD PRIMARY KEY (`event_name_id`);

--
-- Indexes for table `ongoing_list_of_event`
--
ALTER TABLE `ongoing_list_of_event`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `category_name_id` (`category_name_id`);

--
-- Indexes for table `ongoing_tournament`
--
ALTER TABLE `ongoing_tournament`
  ADD PRIMARY KEY (`tournament_id`),
  ADD KEY `category_name_id` (`category_name_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `tournament`
--
ALTER TABLE `tournament`
  ADD PRIMARY KEY (`tournament_id`),
  ADD KEY `category_name_id` (`category_name_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category_name`
--
ALTER TABLE `category_name`
  MODIFY `category_name_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `criterion`
--
ALTER TABLE `criterion`
  MODIFY `criterion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `eventhistorytb`
--
ALTER TABLE `eventhistorytb`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_name`
--
ALTER TABLE `event_name`
  MODIFY `event_name_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `event_type`
--
ALTER TABLE `event_type`
  MODIFY `event_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `ongoing_category_name`
--
ALTER TABLE `ongoing_category_name`
  MODIFY `category_name_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `ongoing_criterion`
--
ALTER TABLE `ongoing_criterion`
  MODIFY `criterion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ongoing_event_name`
--
ALTER TABLE `ongoing_event_name`
  MODIFY `event_name_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ongoing_list_of_event`
--
ALTER TABLE `ongoing_list_of_event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `ongoing_tournament`
--
ALTER TABLE `ongoing_tournament`
  MODIFY `tournament_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tournament`
--
ALTER TABLE `tournament`
  MODIFY `tournament_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category_name`
--
ALTER TABLE `category_name`
  ADD CONSTRAINT `category_name_ibfk_1` FOREIGN KEY (`event_name_id`) REFERENCES `event_name` (`event_name_id`),
  ADD CONSTRAINT `category_name_ibfk_2` FOREIGN KEY (`event_type_id`) REFERENCES `event_type` (`event_type_id`);

--
-- Constraints for table `criterion`
--
ALTER TABLE `criterion`
  ADD CONSTRAINT `criterion_ibfk_1` FOREIGN KEY (`category_name_id`) REFERENCES `category_name` (`category_name_id`);

--
-- Constraints for table `eventhistorytb`
--
ALTER TABLE `eventhistorytb`
  ADD CONSTRAINT `eventhistorytb_ibfk_1` FOREIGN KEY (`category_name_id`) REFERENCES `ongoing_category_name` (`category_name_id`);

--
-- Constraints for table `ongoing_category_name`
--
ALTER TABLE `ongoing_category_name`
  ADD CONSTRAINT `ongoing_category_name_ibfk_1` FOREIGN KEY (`event_name_id`) REFERENCES `ongoing_event_name` (`event_name_id`),
  ADD CONSTRAINT `ongoing_category_name_ibfk_2` FOREIGN KEY (`event_type_id`) REFERENCES `event_type` (`event_type_id`);

--
-- Constraints for table `ongoing_criterion`
--
ALTER TABLE `ongoing_criterion`
  ADD CONSTRAINT `ongoing_criterion_ibfk_1` FOREIGN KEY (`category_name_id`) REFERENCES `ongoing_category_name` (`category_name_id`);

--
-- Constraints for table `ongoing_list_of_event`
--
ALTER TABLE `ongoing_list_of_event`
  ADD CONSTRAINT `ongoing_list_of_event_ibfk_1` FOREIGN KEY (`category_name_id`) REFERENCES `ongoing_category_name` (`category_name_id`);

--
-- Constraints for table `ongoing_tournament`
--
ALTER TABLE `ongoing_tournament`
  ADD CONSTRAINT `ongoing_tournament_ibfk_1` FOREIGN KEY (`category_name_id`) REFERENCES `ongoing_category_name` (`category_name_id`);

--
-- Constraints for table `tournament`
--
ALTER TABLE `tournament`
  ADD CONSTRAINT `tournament_ibfk_1` FOREIGN KEY (`category_name_id`) REFERENCES `category_name` (`category_name_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
