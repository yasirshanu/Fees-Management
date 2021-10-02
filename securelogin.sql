-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2021 at 11:30 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `securelogin`
--

-- --------------------------------------------------------

--
-- Table structure for table `confidential`
--

CREATE TABLE `confidential` (
  `user_id` int(11) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `mname` varchar(20) DEFAULT NULL,
  `lname` varchar(20) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `confidential`
--

INSERT INTO `confidential` (`user_id`, `fname`, `mname`, `lname`, `username`, `email`, `password`) VALUES
(1, 'Yasir', NULL, 'Ansari', 'yasirshanu', 'yasirshanu@gmail.com', '$2y$10$MUav9pHYQ8LG1krUO0DWBOTa7bZ7vs1KR01WFOgXTuvH/zsPXjjVu');

-- --------------------------------------------------------

--
-- Table structure for table `loginrecord`
--

CREATE TABLE `loginrecord` (
  `login_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cookie` varchar(50) NOT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `platform` varchar(20) DEFAULT NULL,
  `browser` varchar(20) DEFAULT NULL,
  `device` varchar(20) NOT NULL,
  `first_login` bigint(20) DEFAULT NULL,
  `last_login` bigint(20) DEFAULT NULL,
  `blocked` int(11) NOT NULL DEFAULT 0,
  `logout` int(11) NOT NULL DEFAULT 0,
  `active` int(11) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting_id` int(11) NOT NULL,
  `setting_name` varchar(20) NOT NULL,
  `setting_value` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_id`, `setting_name`, `setting_value`) VALUES
(1, 'sitetitle', '<b>Secure</b> Login'),
(2, 'sitename', 'Secure Login');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `confidential`
--
ALTER TABLE `confidential`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `loginrecord`
--
ALTER TABLE `loginrecord`
  ADD PRIMARY KEY (`login_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `confidential`
--
ALTER TABLE `confidential`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `loginrecord`
--
ALTER TABLE `loginrecord`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
