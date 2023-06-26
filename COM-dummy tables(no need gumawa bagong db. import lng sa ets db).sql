-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2023 at 03:32 AM
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
-- Table structure for table `competitions_table`
--

CREATE TABLE `competitions_table` (
  `competition_id` int(11) NOT NULL,
  `competition_name` varchar(255) NOT NULL,
  `event_id` int(11) NOT NULL,
  `schedule` datetime DEFAULT NULL,
  `schedule_end` datetime DEFAULT NULL,
  `archived` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `competitions_table`
--

INSERT INTO `competitions_table` (`competition_id`, `competition_name`, `event_id`, `schedule`, `schedule_end`, `archived`) VALUES
(1, 'Essay Writing', 1, NULL, NULL, 0),
(2, 'Spoken Poetry', 1, NULL, NULL, 0),
(3, 'Zumba', 2, NULL, NULL, 0),
(4, 'Cheerleading', 2, NULL, NULL, 0),
(5, 'Eating Contest', 2, NULL, NULL, 0),
(6, 'Sepak Takraw', 1, NULL, NULL, 0),
(7, 'Dance Dance', 2, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `criteria_table`
--

CREATE TABLE `criteria_table` (
  `criteria_id` int(11) NOT NULL,
  `criteria_name` varchar(255) NOT NULL,
  `max_score` decimal(5,2) NOT NULL,
  `competition_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `criteria_table`
--

INSERT INTO `criteria_table` (`criteria_id`, `criteria_name`, `max_score`, `competition_id`) VALUES
(1, 'Relevance', 25.00, 1),
(2, 'Comprehensiveness', 25.00, 1),
(3, 'Originality', 25.00, 1),
(4, 'Insight', 25.00, 1),
(5, 'Presence', 10.00, 2),
(6, 'Articulation', 15.00, 2),
(7, 'Dramatic Appropriation', 15.00, 2),
(8, 'Overall Performance', 10.00, 2),
(17, 'Dance Moves', 25.00, 3);

-- --------------------------------------------------------


--
-- Table structure for table `events_table`
--

CREATE TABLE `events_table` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events_table`
--

INSERT INTO `events_table` (`event_id`, `event_name`) VALUES
(1, 'Buwan ng Wika'),
(2, 'Foundation'),
(1, 'Buwan ng Wika'),
(2, 'Foundation'),
(1, 'Buwan ng Wika'),
(2, 'Foundation');

-- --------------------------------------------------------


--
-- Table structure for table `overall_scores_table`
--

CREATE TABLE `overall_scores_table` (
  `competition_id` int(11) NOT NULL,
  `participant_id` int(11) NOT NULL,
  `overall_score` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `overall_scores_table`
--

INSERT INTO `overall_scores_table` (`competition_id`, `participant_id`, `overall_score`) VALUES
(1, 1, 192.00),
(1, 2, 184.00),
(1, 3, 176.00),
(1, 4, 168.00),
(2, 5, 100.00),
(2, 6, 92.00),
(2, 7, 84.00),
(2, 8, 76.00),
(3, 9, 50.00),
(1, 1, 192.00),
(1, 2, 184.00),
(1, 3, 176.00),
(1, 4, 168.00),
(2, 5, 100.00),
(2, 6, 92.00),
(2, 7, 84.00),
(2, 8, 76.00),
(3, 9, 50.00),
(1, 1, 192.00),
(1, 2, 184.00),
(1, 3, 176.00),
(1, 4, 168.00),
(2, 5, 100.00),
(2, 6, 92.00),
(2, 7, 84.00),
(2, 8, 76.00),
(3, 9, 50.00);

-- --------------------------------------------------------

--
-- Table structure for table `participants_table`
--

CREATE TABLE `participants_table` (
  `participant_id` int(11) NOT NULL,
  `participant_name` varchar(255) NOT NULL,
  `organization` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `participants_table`
--

INSERT INTO `participants_table` (`participant_id`, `participant_name`, `organization`) VALUES
(1, 'Robbie 1 Boco', 'ELITE'),
(2, 'Robbie 2 Boco', 'JMAP'),
(3, 'Robbie 3 Boco', 'JEHRA'),
(4, 'Robbie 4 Boco', 'ACAP'),
(5, 'Robbie 5 Boco', 'MenInBlack'),
(6, 'Robbie 6 Boco', 'Illuminati'),
(7, 'Robbie 7 Boco', 'Olympus'),
(8, 'Robbie 8 Boco', 'Avengers'),
(9, 'Robbie 9 Boco', 'Teamates'),
(1, 'Robbie 1 Boco', 'ELITE'),
(2, 'Robbie 2 Boco', 'JMAP'),
(3, 'Robbie 3 Boco', 'JEHRA'),
(4, 'Robbie 4 Boco', 'ACAP'),
(5, 'Robbie 5 Boco', 'MenInBlack'),
(6, 'Robbie 6 Boco', 'Illuminati'),
(7, 'Robbie 7 Boco', 'Olympus'),
(8, 'Robbie 8 Boco', 'Avengers'),
(9, 'Robbie 9 Boco', 'Teamates'),
(1, 'Robbie 1 Boco', 'ELITE'),
(2, 'Robbie 2 Boco', 'JMAP'),
(3, 'Robbie 3 Boco', 'JEHRA'),
(4, 'Robbie 4 Boco', 'ACAP'),
(5, 'Robbie 5 Boco', 'MenInBlack'),
(6, 'Robbie 6 Boco', 'Illuminati'),
(7, 'Robbie 7 Boco', 'Olympus'),
(8, 'Robbie 8 Boco', 'Avengers'),
(9, 'Robbie 9 Boco', 'Teamates');

-- --------------------------------------------------------


-- --------------------------------------------------------



-- --------------------------------------------------------

--
-- Table structure for table `scores_table`
--

CREATE TABLE `scores_table` (
  `score_id` int(11) NOT NULL,
  `participant_id` int(11) NOT NULL,
  `criteria_id` int(11) NOT NULL,
  `score` decimal(5,2) NOT NULL,
  `competition_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scores_table`
--

INSERT INTO `scores_table` (`score_id`, `participant_id`, `criteria_id`, `score`, `competition_id`) VALUES
(1, 1, 1, 24.00, 1),
(2, 1, 2, 24.00, 1),
(3, 1, 3, 24.00, 1),
(4, 1, 4, 24.00, 1),
(5, 2, 1, 23.00, 1),
(6, 2, 2, 23.00, 1),
(7, 2, 3, 23.00, 1),
(8, 2, 4, 23.00, 1),
(9, 3, 1, 22.00, 1),
(10, 3, 2, 22.00, 1),
(11, 3, 3, 22.00, 1),
(12, 3, 4, 22.00, 1),
(13, 4, 1, 21.00, 1),
(14, 4, 2, 21.00, 1),
(15, 4, 3, 21.00, 1),
(16, 4, 4, 21.00, 1),
(17, 5, 5, 10.00, 2),
(18, 5, 6, 15.00, 2),
(19, 5, 7, 15.00, 2),
(20, 5, 8, 10.00, 2),
(21, 6, 5, 9.00, 2),
(22, 6, 6, 14.00, 2),
(23, 6, 7, 14.00, 2),
(24, 6, 8, 9.00, 2),
(25, 7, 5, 8.00, 2),
(26, 7, 6, 13.00, 2),
(27, 7, 7, 13.00, 2),
(28, 7, 8, 8.00, 2),
(29, 8, 5, 7.00, 2),
(30, 8, 6, 12.00, 2),
(31, 8, 7, 12.00, 2),
(32, 8, 8, 7.00, 2),
(33, 9, 17, 25.00, 3),
(1, 1, 1, 24.00, 1),
(2, 1, 2, 24.00, 1),
(3, 1, 3, 24.00, 1),
(4, 1, 4, 24.00, 1),
(5, 2, 1, 23.00, 1),
(6, 2, 2, 23.00, 1),
(7, 2, 3, 23.00, 1),
(8, 2, 4, 23.00, 1),
(9, 3, 1, 22.00, 1),
(10, 3, 2, 22.00, 1),
(11, 3, 3, 22.00, 1),
(12, 3, 4, 22.00, 1),
(13, 4, 1, 21.00, 1),
(14, 4, 2, 21.00, 1),
(15, 4, 3, 21.00, 1),
(16, 4, 4, 21.00, 1),
(17, 5, 5, 10.00, 2),
(18, 5, 6, 15.00, 2),
(19, 5, 7, 15.00, 2),
(20, 5, 8, 10.00, 2),
(21, 6, 5, 9.00, 2),
(22, 6, 6, 14.00, 2),
(23, 6, 7, 14.00, 2),
(24, 6, 8, 9.00, 2),
(25, 7, 5, 8.00, 2),
(26, 7, 6, 13.00, 2),
(27, 7, 7, 13.00, 2),
(28, 7, 8, 8.00, 2),
(29, 8, 5, 7.00, 2),
(30, 8, 6, 12.00, 2),
(31, 8, 7, 12.00, 2),
(32, 8, 8, 7.00, 2),
(33, 9, 17, 25.00, 3);

--
-- Triggers `scores_table`
--
DELIMITER $$
CREATE TRIGGER `calculate_overall_score` AFTER INSERT ON `scores_table` FOR EACH ROW BEGIN

  DELETE FROM overall_scores_table
  WHERE participant_id = NEW.participant_id AND competition_id = NEW.competition_id;
  
  INSERT INTO overall_scores_table (competition_id, participant_id, overall_score)
  VALUES (NEW.competition_id, NEW.participant_id,
    (SELECT SUM(score)
     FROM scores_table
     WHERE participant_id = NEW.participant_id AND competition_id = NEW.competition_id));
END
$$
DELIMITER ;

-- --------------------------------------------------------

-- --------------------------------------------------------



--
-- Indexes for table `competitions_table`
--
ALTER TABLE `competitions_table`
  ADD PRIMARY KEY (`competition_id`),
  ADD KEY `event_id` (`event_id`);



--
-- Indexes for table `criteria_table`
--
ALTER TABLE `criteria_table`
  ADD PRIMARY KEY (`criteria_id`),
  ADD KEY `competition to criteria` (`competition_id`);






