-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2021 at 04:45 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fees`
--

-- --------------------------------------------------------

--
-- Table structure for table `confidential`
--

CREATE TABLE `confidential` (
  `user_id` int(11) NOT NULL,
  `usertype` int(11) DEFAULT NULL,
  `fname` varchar(20) NOT NULL,
  `mname` varchar(20) DEFAULT NULL,
  `lname` varchar(20) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `passreset` int(11) NOT NULL DEFAULT 0,
  `passresetkey` varchar(50) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `time` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `confidential`
--

INSERT INTO `confidential` (`user_id`, `usertype`, `fname`, `mname`, `lname`, `username`, `email`, `password`, `passreset`, `passresetkey`, `added_by`, `time`) VALUES
(1, 1, 'Yasir', NULL, 'Ansari', 'yasirshanu', 'yasirshanu@gmail.com', '$2y$10$gS3IP2wTFM1h2xx5C2jGMeMSojjI3MZJfD/bdRDUKwMqj/x1effs.', 0, NULL, 1, 1633209141),
(2, 2, 'Sumaiya', '', 'Sheebani', 'summi', 'sumaiyasheebani@gmail.com', '$2y$10$/8C21p.siNJztu6oWiJHfur4Cz6RTZ7LZbJ8K1Xr6C65jVcGD9MoC', 0, NULL, 1, 1634409424);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(50) NOT NULL,
  `course_tuition_fee` float NOT NULL DEFAULT 0,
  `course_exam_fee` float NOT NULL DEFAULT 0,
  `course_type` int(11) NOT NULL DEFAULT 0,
  `course_period` int(11) NOT NULL DEFAULT 1,
  `course_remark` text DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `added_time` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL,
  `invoice_no` varchar(30) DEFAULT NULL,
  `invoice_date` bigint(20) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `added_time` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_content`
--

CREATE TABLE `invoice_content` (
  `invoice_content_id` int(11) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `student_id` int(11) NOT NULL,
  `head` varchar(30) NOT NULL,
  `dsc` varchar(50) DEFAULT NULL,
  `amount` float NOT NULL,
  `tax` float NOT NULL,
  `subt` float NOT NULL,
  `remark` text DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `added_time` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

--
-- Dumping data for table `loginrecord`
--

INSERT INTO `loginrecord` (`login_id`, `user_id`, `cookie`, `ip`, `platform`, `browser`, `device`, `first_login`, `last_login`, `blocked`, `logout`, `active`) VALUES
(1, 1, '03818a617b9186725a09bca9ec06afad', '::1', 'Windows 10', 'Google Chrome', 'Unknown Device', 1638684665, NULL, 0, 1, 1),
(2, 1, 'b97ee755ace1f134d0a9472327fe24b6', '::1', 'Windows 10', 'Google Chrome', 'Unknown Device', 1638686066, NULL, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting_id` int(11) NOT NULL,
  `setting_name` varchar(20) NOT NULL,
  `setting_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_id`, `setting_name`, `setting_value`) VALUES
(1, 'sitetitle', '<b>MAT</b> College'),
(2, 'sitename', 'MAT College'),
(3, 'insti_name', 'MAT College of Education'),
(4, 'Insti_add1', 'Agra Bombay Road,'),
(5, 'insti_add2', 'Satanwada, Shivpuri (M.P.)'),
(6, 'insti_add3', 'PIN - 473551'),
(7, 'insti_contact1', '1234567890'),
(8, 'insti_contact2', ''),
(9, 'insti_email', 'matcollege@gmail.com'),
(10, 'siteURL', 'https://www.yasiransari.in/MAT'),
(11, 'mailer', '1'),
(12, 'PHPmailerhost', 'smtp.gmail.com'),
(13, 'PHPmailerusername', 'yasirshanu@gmail.com'),
(14, 'PHPmailerpassword', 'wttrltzpdoaaklke'),
(15, 'PHPmailerport', '465');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `student_name` varchar(50) NOT NULL,
  `f_name` varchar(50) NOT NULL,
  `m_name` varchar(50) NOT NULL,
  `dob` bigint(20) NOT NULL,
  `course` int(11) NOT NULL,
  `course_tuition_fee` float NOT NULL DEFAULT 0,
  `course_exam_fee` float NOT NULL DEFAULT 0,
  `course_type` int(11) NOT NULL DEFAULT 0,
  `course_period` int(11) NOT NULL DEFAULT 1,
  `enroll_year` int(11) NOT NULL,
  `enroll` varchar(30) DEFAULT NULL,
  `roll` varchar(30) DEFAULT NULL,
  `student_email` varchar(50) DEFAULT NULL,
  `student_mob1` varchar(15) DEFAULT NULL,
  `student_mob2` varchar(15) DEFAULT NULL,
  `student_add1` text DEFAULT NULL,
  `student_add2` text DEFAULT NULL,
  `student_add3` text DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `added_time` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `usertype`
--

CREATE TABLE `usertype` (
  `usertype_id` int(11) NOT NULL,
  `usertype_name` varchar(25) NOT NULL,
  `created_by` int(11) NOT NULL,
  `time` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usertype`
--

INSERT INTO `usertype` (`usertype_id`, `usertype_name`, `created_by`, `time`) VALUES
(1, 'Super Admin', 1, 1633209141),
(2, 'Admin', 1, 1634409359);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `confidential`
--
ALTER TABLE `confidential`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `invoice_content`
--
ALTER TABLE `invoice_content`
  ADD PRIMARY KEY (`invoice_content_id`);

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
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `usertype`
--
ALTER TABLE `usertype`
  ADD PRIMARY KEY (`usertype_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `confidential`
--
ALTER TABLE `confidential`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_content`
--
ALTER TABLE `invoice_content`
  MODIFY `invoice_content_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loginrecord`
--
ALTER TABLE `loginrecord`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usertype`
--
ALTER TABLE `usertype`
  MODIFY `usertype_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
