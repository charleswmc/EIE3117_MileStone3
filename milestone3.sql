-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 13, 2019 at 12:33 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `milestone3`
--

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

DROP TABLE IF EXISTS `history`;
CREATE TABLE IF NOT EXISTS `history` (
  `requestNo` int(11) NOT NULL AUTO_INCREMENT,
  `passengerName` varchar(20) NOT NULL,
  `driverName` varchar(20) DEFAULT NULL,
  `startTime` datetime NOT NULL,
  `finishTime` datetime DEFAULT NULL,
  `fare` double DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT 'Request = 0, Confirmed = 1, Cancelled = 2, Finished = 3, Dispute = 4, Accept_dispute = 5, Reject_dispute = 6',
  `reason` varchar(200) DEFAULT NULL,
  `passenger_pk` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`requestNo`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`requestNo`, `passengerName`, `driverName`, `startTime`, `finishTime`, `fare`, `status`, `reason`, `passenger_pk`) VALUES
(27, 'noelwong', 'noel', '2019-03-17 01:15:51', '2019-03-17 02:05:47', 1000, 5, 'bad', ' '),
(28, 'charleswmc', 'charles', '2019-04-13 08:26:06', NULL, NULL, 1, NULL, '105dc3452309da247cc00220fe9b3b5f84c78c1d8dab4b5a05a0fd62f6a4d626'),
(29, 'charleswmc', NULL, '2019-04-13 08:26:12', NULL, NULL, 0, NULL, '105dc3452309da247cc00220fe9b3b5f84c78c1d8dab4b5a05a0fd62f6a4d626'),
(30, 'charleswmc', 'charles', '2019-04-13 08:29:50', '2019-04-13 08:30:24', 500, 3, NULL, ' ');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phoneNumber` int(12) DEFAULT NULL,
  `wallet` varchar(200) DEFAULT NULL,
  `email` text,
  `verified` int(11) NOT NULL COMMENT '0=no, 1=yes',
  `verification_code` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`username`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `id_2` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `password`, `phoneNumber`, `wallet`, `email`, `verified`, `verification_code`, `created_at`) VALUES
(12, 'charles', 'Wong Man Chung1', '$2y$10$r8bB705Xbbx.hfGBAyyT6u8kqf5ra1Xhlmryw7z0iOtF3Qlq5K6ae', 66451234, 'mvarUMHC4Nd68qDvsh5o39RniCFukEAz9F', 'eie3117group7b@gmail.com', 1, 'acf3d83ea1ad256eaca07bd60caf0099', '2019-04-11 02:15:31'),
(11, 'charleswmc', 'Wong Man Chung', '$2y$10$tmPooaq8TJy16detY9JQS.VMDATNMmhqgarhSvFsXo6.rFoZWNPii', 66452438, 'myqEtcKSDwVRUviR8uDmWAF5SysruZCnvL', 'charleswmc19970124@gmail.com', 1, 'ad9a7155ffdf16110343bb8013301084', '2019-03-19 04:41:37'),
(1, 'noel', '', '$2y$10$kDOV.n6gsibiyJRDCR1X9OU1GSvcFqu6swMh.fz.u45FsTpdCThuG', NULL, 'myqEtcKSDwVRUviR8uDmWAF5SysruZCnvL', NULL, 1, NULL, '2019-01-15 14:36:54'),
(2, 'noelwong', '', '$2y$10$.kJhEOZcWtzCLvTEvA2QdOMJV2UCNyrgs7VLZ8ZQSXU5TV1hCbTQ.', NULL, 'mvarUMHC4Nd68qDvsh5o39RniCFukEAz9F', NULL, 1, NULL, '2019-01-30 18:56:24');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
