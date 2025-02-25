-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2025 at 03:57 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `canadian_legislation`
--

-- --------------------------------------------------------

--
-- Table structure for table `amendments`
--

CREATE TABLE `amendments` (
  `amendment_id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `reviewer` varchar(50) NOT NULL,
  `amendment_text` text NOT NULL,
  `status` enum('Pending','Accepted','Rejected') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `amendments`
--

INSERT INTO `amendments` (`amendment_id`, `bill_id`, `reviewer`, `amendment_text`, `status`, `created_at`) VALUES
(1, 1, 'Reviewer', 'new bill 2025', 'Pending', '2025-02-25 02:23:10');

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `bill_id` int(11) NOT NULL,
  `bill_title` varchar(255) NOT NULL,
  `bill_description` text NOT NULL,
  `author` varchar(50) NOT NULL,
  `status` enum('Draft','Review','Approved','Rejected') DEFAULT 'Draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`bill_id`, `bill_title`, `bill_description`, `author`, `status`, `created_at`) VALUES
(1, 'Bill 2', 'Voteddd', 'raj_patel', 'Approved', '2025-02-19 20:36:59'),
(4, 'voting', 'Creating a bill for the legislature', 'Admin', 'Draft', '2025-02-25 01:38:53'),
(5, 'Legislation Bill', 'Legislation Bill', 'Legislator', 'Draft', '2025-02-25 01:43:51'),
(6, 'Review Bill', 'Reviews', 'Reviewer', 'Rejected', '2025-02-25 01:44:43'),
(8, 'Final bill Legislation', 'This is the final bill for the legislation', 'Legislator', 'Draft', '2025-02-25 02:28:16'),
(9, 'New Prospect ', 'New Prospect ', 'Legislator', 'Draft', '2025-02-25 02:40:09'),
(10, '2025 Bill', '2025 Bill', 'Legislator', 'Approved', '2025-02-25 02:42:43');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `member_id` int(11) NOT NULL,
  `member_name` varchar(50) NOT NULL,
  `member_password` varchar(255) NOT NULL,
  `member_role` enum('Legislator','Reviewer','Admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `member_name`, `member_password`, `member_role`) VALUES
(1, 'Legislator', 'Legislator', 'Legislator'),
(2, 'Reviewer', 'Reviewer', 'Reviewer'),
(3, 'raj_patel', 'adminsecure', 'Admin'),
(4, 'Admin', 'Admin', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `vote_id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `mp_name` varchar(50) NOT NULL,
  `vote_choice` enum('For','Against','Abstain') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`vote_id`, `bill_id`, `mp_name`, `vote_choice`, `created_at`) VALUES
(1, 1, 'Legislator', 'For', '2025-02-25 02:33:28'),
(2, 10, 'Legislator', 'Against', '2025-02-25 02:49:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `amendments`
--
ALTER TABLE `amendments`
  ADD PRIMARY KEY (`amendment_id`),
  ADD KEY `bill_id` (`bill_id`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`bill_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`),
  ADD UNIQUE KEY `member_name` (`member_name`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`vote_id`),
  ADD KEY `bill_id` (`bill_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `amendments`
--
ALTER TABLE `amendments`
  MODIFY `amendment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `vote_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `amendments`
--
ALTER TABLE `amendments`
  ADD CONSTRAINT `amendments_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`bill_id`);

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`bill_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
