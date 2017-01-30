-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2017 at 10:15 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bipartite_matching_game`
--

-- --------------------------------------------------------

--
-- Table structure for table `score_table`
--

CREATE TABLE `score_table` (
  `ID` int(11) NOT NULL,
  `graph_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `num_match` int(11) NOT NULL,
  `match_score` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `score_table`
--

INSERT INTO `score_table` (`ID`, `graph_id`, `name`, `num_match`, `match_score`, `duration`, `date`) VALUES
(1, 1, 'john', 1, 1, 1620, '2016-03-02 20:30:29'),
(2, 1, 'john', 1, 1, 2, '2016-03-02 20:30:35'),
(3, 1, 'john', 1, 1, 2, '2016-03-02 20:30:41'),
(4, 1, 'john', 1, 1, 191, '2016-03-02 20:34:39'),
(5, 1, 'john', 0, 0, 11, '2016-03-02 20:37:59'),
(6, 1, 'Anonymous', 1, 1, 207, '2016-03-02 20:48:56'),
(7, 2, 'Anonymous', 2, 8, 9, '2016-03-02 20:49:16'),
(8, 1, 'Anonymous', 1, 1, 25, '2016-03-02 20:50:31'),
(9, 1, 'Anonymous', 2, 2, 7, '2016-03-02 20:50:45'),
(10, 1, 'Anonymous', 2, 2, 32, '2016-03-02 20:51:49'),
(11, 1, 'Anonymous', 2, 2, 8, '2016-03-02 20:52:04'),
(12, 1, 'Kester', 2, 2, 18, '2016-03-02 20:52:34'),
(13, 2, 'Kester', 2, 3, 3, '2016-03-02 20:53:16'),
(14, 2, 'Kester', 2, 8, 5, '2016-03-02 20:53:54'),
(15, 2, 'Kester', 1, 2, 3, '2016-03-02 20:54:05'),
(16, 1, 'Kester', 1, 1, 4, '2016-03-02 20:54:28'),
(17, 1, 'Kester', 2, 2, 2, '2016-03-02 20:56:10'),
(18, 1, 'Kester', 1, 1, 2, '2016-03-02 20:56:17'),
(19, 1, 'Anonymous', 0, 0, 2, '2016-03-02 20:57:10'),
(20, 1, 'Anonymous', 0, 0, 4, '2016-03-02 20:57:42'),
(21, 1, 'Anonymous', 0, 0, 1, '2016-03-02 20:59:05'),
(22, 1, 'Anonymous', 2, 2, 4, '2016-03-02 21:01:02'),
(31, 1, 'Anonymous', 2, 2, 8, '2016-03-02 12:14:09'),
(41, 1, 'Anonymous', 1, 1, 2, '2016-03-03 13:39:47'),
(51, 2, 'Anonymous', 1, 5, 3, '2016-03-03 13:39:56'),
(61, 2, 'Kester', 2, 3, 3, '2016-03-03 13:40:25'),
(71, 2, 'Kester', 3, 4, 6, '2016-03-03 13:40:47'),
(81, 1, 'Anonymous', 2, 2, 3, '2016-03-03 13:42:37'),
(91, 3, 'Kester', 2, 19, 6, '2016-03-03 14:16:54'),
(101, 3, 'Kester', 2, 23, 5, '2016-03-03 14:17:12'),
(111, 3, 'Kester', 3, 26, 5, '2016-03-03 14:17:27'),
(121, 4, 'Kester', 4, 45, 8, '2016-03-03 14:18:11'),
(131, 3, 'Kester', 2, 19, 8, '2016-03-03 14:18:32'),
(141, 3, '007', 2, 19, 5, '2016-03-03 14:20:30'),
(151, 6, 'Kester', 5, 43, 16, '2016-03-03 17:32:21'),
(161, 1, 'Anonymous', 0, 0, 208, '2016-03-03 21:24:15'),
(171, 9, 'Anonymous', 9, 64, 150, '2016-03-03 21:25:03'),
(181, 9, 'YULONGLON', 10, 55, 99, '2016-03-03 21:27:06'),
(191, 1, 'Anonymous', 2, 2, 58, '2016-03-03 22:30:45'),
(201, 1, 'Anonymous', 2, 2, 7, '2016-03-03 22:31:23'),
(211, 6, 'Anonymous', 6, 46, 27, '2016-03-03 22:33:24'),
(221, 5, '=.=', 5, 46, 18, '2016-03-03 22:34:14'),
(231, 5, '=.=', 6, 50, 12, '2016-03-03 22:34:28'),
(241, 2, '=.=', 3, 4, 5, '2016-03-03 22:34:44'),
(251, 3, '=.=', 3, 26, 6, '2016-03-03 22:34:55'),
(261, 3, '=.=', 3, 26, 9, '2016-03-03 22:35:13'),
(271, 3, '=.=', 3, 26, 3, '2016-03-03 22:35:30'),
(281, 9, '=.=', 9, 98, 17, '2016-03-03 22:36:11'),
(291, 9, '=.=', 10, 98, 17, '2016-03-03 22:36:36'),
(301, 3, 'Kester', 0, 0, 11, '2016-03-03 22:36:50'),
(311, 3, 'Kester', 3, 26, 9, '2016-03-03 22:37:03'),
(321, 8, '=.=', 8, 101, 33, '2016-03-03 22:41:56'),
(331, 4, 'Kester', 4, 45, 7, '2016-03-03 22:45:11'),
(341, 4, 'Kester', 4, 70, 8, '2016-03-03 22:45:25'),
(351, 4, 'Kester', 0, 0, 15, '2016-03-03 22:45:59'),
(352, 4, 'Kester', 0, 0, 1, '2016-03-03 22:46:14'),
(362, 4, 'Kester', 0, 0, 2, '2016-03-03 22:46:24'),
(371, 4, 'Kester', 0, 0, 2, '2016-03-03 22:47:00'),
(381, 4, 'Kester', 0, 0, 4, '2016-03-03 22:47:16'),
(391, 4, 'Kester', 2, 26, 89, '2016-03-03 22:59:01'),
(401, 4, 'Kester', 3, 40, 5, '2016-03-03 22:59:52'),
(402, 5, ':)', 5, 43, 14, '2016-03-05 15:52:23'),
(411, 5, ':)', 6, 50, 10, '2016-03-05 15:52:55'),
(421, 5, 'Anonymous', 2, 31, 13, '2016-03-05 15:53:26'),
(431, 5, ':D', 4, 42, 8, '2016-03-05 15:53:53'),
(432, 5, 'Kester', 2, 17, 5, '2016-03-05 23:59:59'),
(441, 5, 'Hi :)', 4, 45, 5, '2016-03-06 01:42:27'),
(451, 1, 'Anonymous', 2, 2, 25, '2016-03-06 02:42:38'),
(461, 3, 'Ian', 3, 26, 25, '2016-03-06 02:43:36'),
(471, 3, 'Ian', 3, 26, 7, '2016-03-06 02:44:19'),
(481, 1, 'Ian', 2, 2, 9, '2016-03-06 02:45:10'),
(491, 5, 'Kester', 6, 50, 12, '2016-03-06 19:29:08'),
(501, 5, 'Kester', 1, 15, 18, '2016-03-09 19:47:23'),
(511, 2, 'Nia', 3, 9, 34, '2016-03-09 19:49:30'),
(521, 3, 'Nia', 3, 26, 73, '2016-03-09 19:51:01'),
(531, 4, 'Nia', 4, 45, 38, '2016-03-09 19:51:52'),
(541, 5, 'Nia', 5, 55, 65, '2016-03-09 19:53:16'),
(551, 6, 'Nia', 6, 71, 64, '2016-03-09 19:55:09'),
(552, 1, 'student2', 2, 2, 9, '2016-03-16 00:59:20'),
(553, 5, 'student2', 4, 45, 7, '2016-03-16 00:59:50');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` varchar(20) NOT NULL,
  `hashed_password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL DEFAULT '1',
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `hashed_password`, `role`, `email`) VALUES
('boss', '$1$U13.Ny3.$1mfbA6nbJQ1I3HqncRm4o/', 0, 'yulonglong2005@gmail.com'),
('student1', '$1$Jl3.eN4.$jc1EbuBnlCdQnmGy2SYe.1', 1, 'yulonglong2005@gmail.com'),
('student2', '$1$S7..zM3.$IUp1LRQTUMvcDFkCKHdOX1', 1, 'yulonglong2005@gmail.com'),
('student3', '$1$dZ/.iz5.$PDx3rr6DjYooTxI2KCJ9n.', 1, 'yulonglong2005@gmail.com'),
('student4', '$1$ZI..uP0.$KfpG0kSNHoMc.UoI8QLtI/', 1, 'yulonglong2005@gmail.com'),
('yulonglong', '$1$pg2.8j3.$UwRa7vRZbP1KReH/oWCXe.', 1, 'yulonglong2005@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `score_table`
--
ALTER TABLE `score_table`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `score_table`
--
ALTER TABLE `score_table`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=554;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
