-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2023 at 04:15 PM
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
  `isAnon` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bar_graph`
--

INSERT INTO `bar_graph` (`organization_bar_id`, `organization_id`, `ongoing_event_name_id`, `event_name_id`, `bar_meter`, `isAnon`) VALUES
(1, 1, 1, 1, '0.00', 1),
(2, 2, 1, 1, '0.00', 1),
(3, 3, 1, 1, '0.00', 1),
(4, 4, 1, 1, '0.00', 1),
(5, 5, 1, 1, '0.00', 1),
(6, 6, 1, 1, '0.00', 1),
(7, 7, 1, 1, '0.00', 1),
(8, 8, 1, 1, '0.00', 1),
(9, 1, 2, 2, '0.00', 1),
(10, 2, 2, 2, '0.00', 1),
(11, 3, 2, 2, '0.00', 1),
(12, 4, 2, 2, '0.00', 1),
(13, 5, 2, 2, '0.00', 1),
(14, 6, 2, 2, '0.00', 1),
(15, 7, 2, 2, '0.00', 1),
(16, 8, 2, 2, '0.00', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(1, 1, NULL, NULL, 0);

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
(2, 'Intramurals'),
(3, 'National Heroes Day');

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
(366, '2023-07-21', '16:33:30', 1, 'Added \'3\', \'3\', \'3\', \'It is the day that we give gratitude to those people who sacrifice their life for the better future of our nation.\', \'2023-08-28\', \'00:00\' in ongoing_list_of_event (Events)');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ongoing_criterion`
--

INSERT INTO `ongoing_criterion` (`ongoing_criterion_id`, `criterion_id`, `category_name_id`, `event_id`, `criterion_name`, `criterion_percent`) VALUES
(1, 1, 1, 1, 'Nilalaman', 50),
(2, 2, 1, 1, 'Damdamin', 20),
(3, 3, 1, 1, 'Paksa', 30);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ongoing_event_name`
--

INSERT INTO `ongoing_event_name` (`ongoing_event_name_id`, `event_name_id`, `event_name`, `year_created`, `is_done`) VALUES
(1, 1, 'Buwan ng Wika', 2023, 0),
(2, 2, 'Intramurals', 2023, 0),
(3, 3, 'National Heroes Day', 2023, 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ongoing_list_of_event`
--

INSERT INTO `ongoing_list_of_event` (`event_id`, `ongoing_event_name_id`, `category_name_id`, `event_name_id`, `event_type_id`, `category_name`, `event_description`, `event_code`, `event_date`, `event_time`, `is_archived`, `suggested_status`, `overall_include`, `is_deleted`) VALUES
(1, 1, 1, 1, 2, 'Makatang Pagtutula', 'Bilang pakikiisa sa Buwan ng Wikang Pambansa taong 2023, naghanda ng mga patimpalak ang ating sintang paaralan para sa mga PUPians. ', 'RcVdOdXbFbm2', '2023-08-25', '08:00:00', 0, 0, 1, 0),
(2, 2, 2, 2, 1, 'Cyber League', 'Embraced the advancement of technology by joining the Cyber league. Registration will be available soon...', NULL, '2023-07-21', '14:00:00', 0, 0, 1, 0),
(3, 3, NULL, 3, 3, NULL, 'It is the day that we give gratitude to those people who sacrifice their life for the better future of our nation.', NULL, '2023-08-28', '00:00:00', 0, 0, 0, 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `participant_section` varchar(50) NOT NULL,
  `final_score` decimal(5,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `post_photo`
--

CREATE TABLE `post_photo` (
  `photo_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `file_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  MODIFY `competition_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `criterion`
--
ALTER TABLE `criterion`
  MODIFY `criterion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `criterion_scoring`
--
ALTER TABLE `criterion_scoring`
  MODIFY `criterion_scoring_id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `judge_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=367;

--
-- AUTO_INCREMENT for table `number_of_wins`
--
ALTER TABLE `number_of_wins`
  MODIFY `number_of_wins_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ongoing_criterion`
--
ALTER TABLE `ongoing_criterion`
  MODIFY `ongoing_criterion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ongoing_event_name`
--
ALTER TABLE `ongoing_event_name`
  MODIFY `ongoing_event_name_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ongoing_list_of_event`
--
ALTER TABLE `ongoing_list_of_event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `participants_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_photo`
--
ALTER TABLE `post_photo`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT;

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
