-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2023 at 12:19 PM
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
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
