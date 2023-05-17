-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2023 at 01:46 PM
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
-- Database: `pupets`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorynametb`
--

CREATE TABLE `categorynametb` (
  `category_name_id` int(11) NOT NULL,
  `event_name_id` int(11) NOT NULL,
  `event_type_id` int(11) NOT NULL,
  `category_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categorynametb`
--

INSERT INTO `categorynametb` (`category_name_id`, `event_name_id`, `event_type_id`, `category_name`) VALUES
(65, 53, 1, 'Basketball'),
(66, 50, 2, 'Poster Making'),
(67, 54, 3, 'Basta Laro'),
(69, 50, 2, 'asdsadsad'),
(70, 50, 2, 'Basketball');

-- --------------------------------------------------------

--
-- Table structure for table `eventnametb`
--

CREATE TABLE `eventnametb` (
  `event_name_id` int(11) NOT NULL,
  `event_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `eventnametb`
--

INSERT INTO `eventnametb` (`event_name_id`, `event_name`) VALUES
(50, 'Foundation Day'),
(53, 'Buwan ng Wika'),
(54, 'Example'),
(55, 'asdaa'),
(57, 'ExampleB');

-- --------------------------------------------------------

--
-- Table structure for table `eventtypetb`
--

CREATE TABLE `eventtypetb` (
  `event_type_id` int(11) NOT NULL,
  `event_type` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `eventtypetb`
--

INSERT INTO `eventtypetb` (`event_type_id`, `event_type`) VALUES
(1, 'Tournament'),
(2, 'Competition'),
(3, 'Standard');

-- --------------------------------------------------------

--
-- Table structure for table `listofeventtb`
--

CREATE TABLE `listofeventtb` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(25) NOT NULL,
  `event_type` varchar(11) NOT NULL,
  `category_name` varchar(25) NOT NULL,
  `event_description` text NOT NULL,
  `event_code` varchar(12) NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `listofeventtb`
--

INSERT INTO `listofeventtb` (`event_id`, `event_name`, `event_type`, `category_name`, `event_description`, `event_code`, `event_date`, `event_time`) VALUES
(104, 'Foundation Day', 'Competition', 'asdsadsad', 'asdsadsadsadsadsadsadsadsa', 'ttj3Os36heho', '2023-05-22', '05:51:00'),
(106, 'Foundation Day', 'Competition', 'Basketball', 'aasdsadas', 'bm1GqK2GMCpz', '2023-05-29', '03:44:00');

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
  `post_schedule` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `post_calendar`, `post_tag`, `post_title`, `post_description`, `post_cover`, `post_photos`, `post_schedule`) VALUES
(16, '0000-00-00', 'ELITE', 'Happy Birthday to Executive Treasurer Junard Joshua Calma!', '\"Count your age by friends, not years. Count your life by smiles, not tears.\" -  John Lennon\r\n\r\nHappy birthday to Junard Joshua Calma our Executive Treasurer of our beloved organization!\r\n\r\nYou are a valuable officer and friend to the company, and we appreciate that. We wish you a day filled with feelings of adoration, gratitude, and celebration. May you experience much joy, success, and happiness this year. May you realize all of your hopes and dreams and you the fortitude and power to face any challenges that may arise. We are happy to have you in our lives since you are a special and valuable individual. Have a happy birthday and may it mark the start of a wonderful new chapter in your life, Junard. 🧡🖤🧡🖤\r\n\r\n(Manlilibre daw siya now.)', '', '', '2023-05-16 03:03:00'),
(19, '0000-00-00', 'SC', 'RE: WALANG PASOKk', 'Gov. Ramil L. Hernandez on January 14, 2020.\r\n\r\nWALANG PASOK bukas, January 15, 2020, sa lahat ng antas, pribado at pampublikong paaralan sa Laguna.\r\n\r\nMinabuti natin ito upang bigyan ng sapat na panahon ang mga paaralan na linisin ang kanilang pasilidad bago ito gamitin ng mga mag-aaral.\r\nInatasan ko rin ang Provincial Health Office, pangunahin na ang Sanitation Division, na makipag-ugnayan sa Division Office ng Department of Education upang magsagawa ng clean-up drive sa mga paaralan.\r\nHangand natin ang kaligtasan at mabuting kalusugan ng mga mag-aaral at guro.', '', '', '2023-05-16 04:35:39'),
(26, '0000-00-00', 'GIVE', 'das', 'sadas', '', '', '2023-05-17 07:06:38');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_username` varchar(20) NOT NULL,
  `user_password` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_username`, `user_password`) VALUES
('admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorynametb`
--
ALTER TABLE `categorynametb`
  ADD PRIMARY KEY (`category_name_id`);

--
-- Indexes for table `eventnametb`
--
ALTER TABLE `eventnametb`
  ADD PRIMARY KEY (`event_name_id`);

--
-- Indexes for table `eventtypetb`
--
ALTER TABLE `eventtypetb`
  ADD PRIMARY KEY (`event_type_id`);

--
-- Indexes for table `listofeventtb`
--
ALTER TABLE `listofeventtb`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorynametb`
--
ALTER TABLE `categorynametb`
  MODIFY `category_name_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `eventnametb`
--
ALTER TABLE `eventnametb`
  MODIFY `event_name_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `eventtypetb`
--
ALTER TABLE `eventtypetb`
  MODIFY `event_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `listofeventtb`
--
ALTER TABLE `listofeventtb`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
