-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql203.epizy.com
-- Generation Time: Sep 01, 2021 at 07:16 AM
-- Server version: 5.6.48-88.0
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epiz_26377317_tnp_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `log_token`
--

CREATE TABLE `log_token` (
  `no` bigint(20) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `token` varchar(650) NOT NULL,
  `device` varchar(60) NOT NULL,
  `datecreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log_token`
--

INSERT INTO `log_token` (`no`, `user_id`, `token`, `device`, `datecreated`) VALUES
(118, 1, 'fb57485a3f23952eed8bb69b1b151ce66563aeb3', 'web', '2020-11-11 04:42:06');

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `mem_type` tinyint(4) NOT NULL DEFAULT '0',
  `sch_no` varchar(20) NOT NULL DEFAULT '',
  `email` varchar(150) NOT NULL,
  `pass` varchar(150) NOT NULL DEFAULT '',
  `dateofbirth` date NOT NULL,
  `gender` varchar(6) NOT NULL,
  `rollno` varchar(20) NOT NULL DEFAULT '',
  `mobilenumber` varchar(10) NOT NULL DEFAULT '',
  `avatar` varchar(500) NOT NULL,
  `dateadded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `verified` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`user_id`, `mem_type`, `sch_no`, `email`, `pass`, `dateofbirth`, `gender`, `rollno`, `mobilenumber`, `avatar`, `dateadded`, `verified`) VALUES
(1, 1, 'asasa121', '007aniketmahajan@gmail.com', '$2y$10$X0UPhvJ5u/lROgQCGCdUfeQhPhq9V2ertYbNLC7oTVEJWe79r1HS6', '2020-08-17', 'Male', '', '8975168964', 'http://pccoetnp.epizy.com/profile_avatar/layer-0-12.png', '2020-08-26 14:39:08', 1),
(2, 1, '19117071A00157', 'mohitsrai@live.in', '$2y$10$uRI4PZl4RJdv.yO.NByzqemmniwmCzf28wlB4utSnlDifwBhQm5E.', '1997-08-03', 'Male', '43', '8989898989', '', '2020-08-27 08:02:58', 1),
(3, 0, '', 'rajkamal.sangole@gmail.com', '$2y$10$bR8UGOijkIYeZHvoYfmxSut9yWpH3hFcx90XrH6VlxW1tM7a3sLPi', '2003-09-08', 'Male', '', '8087445312', '', '2020-09-08 07:32:51', 1),
(4, 0, '', 'mohitsrai02@gmail.com', '$2y$10$uJyFa/RNid7EDE7OC5HXF.kifltoLDhjQiqaypMlCuIcofEySk89m', '1997-08-03', 'Male', '43', '8463899949', 'http://pccoetnp.epizy.com/profile_avatar/screenshot_20200-16.jpeg', '2020-09-08 07:37:45', 1);

-- --------------------------------------------------------

--
-- Table structure for table `temp`
--

CREATE TABLE `temp` (
  `sno` bigint(20) UNSIGNED NOT NULL,
  `verify_code` varchar(600) NOT NULL DEFAULT '',
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `email` varchar(250) NOT NULL,
  `datecreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `temp`
--

INSERT INTO `temp` (`sno`, `verify_code`, `user_id`, `email`, `datecreated`) VALUES
(11, 'b09d08dce6b2cf05a9c021599177b816', 5, 'deadlysin4fdfewfewfew14@gmail.com', '2020-09-08 08:14:06');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `no` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `pnr_number` varchar(20) NOT NULL DEFAULT '',
  `name` varchar(120) NOT NULL DEFAULT '',
  `coursename` varchar(120) NOT NULL DEFAULT '',
  `yearofcomplete` int(4) UNSIGNED NOT NULL DEFAULT '0',
  `otheremail` varchar(250) NOT NULL DEFAULT '',
  `peraddress` varchar(600) NOT NULL DEFAULT '',
  `localaddress` varchar(600) NOT NULL DEFAULT '',
  `hdistrict` varchar(250) NOT NULL DEFAULT '',
  `district` varchar(250) NOT NULL DEFAULT '',
  `state` varchar(350) NOT NULL DEFAULT '',
  `clgname` varchar(600) NOT NULL DEFAULT '',
  `ssc` decimal(6,0) NOT NULL DEFAULT '0',
  `sscboard` varchar(600) NOT NULL DEFAULT '',
  `sscyear` int(4) UNSIGNED NOT NULL DEFAULT '0',
  `hsc` decimal(6,0) NOT NULL DEFAULT '0',
  `hscboard` varchar(600) NOT NULL,
  `hscyear` int(4) UNSIGNED NOT NULL,
  `graduation` decimal(6,0) NOT NULL,
  `gradclg` varchar(600) NOT NULL,
  `gradyear` int(4) UNSIGNED NOT NULL DEFAULT '0',
  `fysem1sgpa` decimal(6,0) NOT NULL DEFAULT '0',
  `fysem1per` decimal(6,0) NOT NULL DEFAULT '0',
  `fysem2sgpa` decimal(6,0) NOT NULL DEFAULT '0',
  `fysem2per` decimal(6,0) NOT NULL DEFAULT '0',
  `sysem1sgpa` decimal(6,0) NOT NULL DEFAULT '0',
  `sysem1per` decimal(6,0) NOT NULL DEFAULT '0',
  `sysem2sgpa` decimal(6,0) NOT NULL DEFAULT '0',
  `sysem2per` decimal(6,0) NOT NULL DEFAULT '0',
  `tysem1sgpa` decimal(6,0) NOT NULL DEFAULT '0',
  `tysem1per` decimal(6,0) NOT NULL DEFAULT '0',
  `tysem2sgpa` decimal(6,0) NOT NULL DEFAULT '0',
  `tysem2per` decimal(6,0) NOT NULL DEFAULT '0',
  `aggcgpa` decimal(6,0) NOT NULL DEFAULT '0',
  `aggper` decimal(6,0) NOT NULL DEFAULT '0',
  `livebacklog` tinyint(2) NOT NULL DEFAULT '0',
  `deadbacklog` tinyint(2) NOT NULL DEFAULT '0',
  `noofyd` tinyint(2) NOT NULL DEFAULT '0',
  `profession` varchar(600) NOT NULL DEFAULT '',
  `company_name` varchar(600) NOT NULL DEFAULT '',
  `father_email` varchar(250) NOT NULL DEFAULT '',
  `father_number` varchar(10) NOT NULL DEFAULT '0',
  `resume` varchar(500) NOT NULL,
  `placed_status` tinyint(4) NOT NULL DEFAULT '0',
  `place_in` varchar(600) NOT NULL,
  `placed_on` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`no`, `user_id`, `pnr_number`, `name`, `coursename`, `yearofcomplete`, `otheremail`, `peraddress`, `localaddress`, `hdistrict`, `district`, `state`, `clgname`, `ssc`, `sscboard`, `sscyear`, `hsc`, `hscboard`, `hscyear`, `graduation`, `gradclg`, `gradyear`, `fysem1sgpa`, `fysem1per`, `fysem2sgpa`, `fysem2per`, `sysem1sgpa`, `sysem1per`, `sysem2sgpa`, `sysem2per`, `tysem1sgpa`, `tysem1per`, `tysem2sgpa`, `tysem2per`, `aggcgpa`, `aggper`, `livebacklog`, `deadbacklog`, `noofyd`, `profession`, `company_name`, `father_email`, `father_number`, `resume`, `placed_status`, `place_in`, `placed_on`) VALUES
(7, 1, '', 'Aniket Mahajan', 'MCA', 2000, '', '', '', '', '', 'Delhi', '', '0', '', 0, '0', '', 0, '0', '', 0, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 0, 0, 0, '', '', '', '7710943083', '', 1, 'Amazon', '2020-10-23 10:35:20'),
(8, 2, '6767676767', 'Mohit Rai', 'MCA', 2022, '', 'Rajeev Awas Vihar\r\n1096-H, Scheme No. 114', 'Rajeev Awas Vihar\r\n1096-H, Scheme No. 114', 'Indore', 'Indore', 'Madhya Pradesh', 'PCCOE', '67', 'CBSE', 2013, '67', 'CBSE', 2015, '67', 'DAVV', 2019, '67', '67', '67', '67', '67', '67', '67', '67', '67', '67', '67', '67', '67', '67', 0, 0, 0, 'Business', 'VMTC', 'email@email.com', '8989898989', '', 0, '', '2020-09-08 08:21:31'),
(9, 4, '676767676', 'Mohit Rai', 'MCA', 2020, '', 'Sch No. 114, Rajeev Awas  Vihar, 1096-H', 'Sch No. 114, Rajeev Awas  Vihar, 1096-H', 'Indore', 'Indore', 'Madhya Pradesh', 'PCCOE', '50', 'CBSE', 2019, '50', 'CBSE', 2020, '50', 'DAVV', 2020, '50', '50', '50', '50', '50', '50', '50', '50', '50', '50', '50', '50', '50', '50', 0, 0, 0, 'Business', 'VMTC', 'mohitsrai@live.in', '8463899949', 'http://pccoetnp.epizy.com/user_resume/javalab_symca43-38.pdf', 0, '', '2020-09-08 08:21:31'),
(10, 3, '', '', '', 0, '', '', '', '', '', '', '', '0', '', 0, '0', '', 0, '0', '', 0, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 0, 0, 0, '', '', '', '0', '', 0, '', '2020-09-08 08:21:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `log_token`
--
ALTER TABLE `log_token`
  ADD PRIMARY KEY (`no`),
  ADD KEY `log_token_ref_id` (`user_id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `temp`
--
ALTER TABLE `temp`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`no`),
  ADD KEY `user_info1` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `log_token`
--
ALTER TABLE `log_token`
  MODIFY `no` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `temp`
--
ALTER TABLE `temp`
  MODIFY `sno` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `no` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
