-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 21, 2022 at 02:26 AM
-- Server version: 5.7.36
-- PHP Version: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mail_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

DROP TABLE IF EXISTS `attachments`;
CREATE TABLE IF NOT EXISTS `attachments` (
  `attachmentId` int(11) NOT NULL AUTO_INCREMENT,
  `messageId` int(11) DEFAULT NULL,
  `directoryPath` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`attachmentId`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attachments`
--

INSERT INTO `attachments` (`attachmentId`, `messageId`, `directoryPath`, `date`) VALUES
(1, 1, '1.png', '2022-12-21 00:12:02'),
(2, 1, '2.png', '2022-12-21 00:12:02'),
(3, 2, '1.png', '2022-12-21 00:12:02'),
(4, 2, '2.png', '2022-12-21 00:12:02'),
(5, 3, '1.png', '2022-12-21 00:12:02'),
(6, 3, '2.png', '2022-12-21 00:12:02');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `messageId` int(11) NOT NULL AUTO_INCREMENT,
  `recipientId` int(11) NOT NULL,
  `recipientString` varchar(255) DEFAULT NULL,
  `senderId` int(11) NOT NULL,
  `attachmentFlag` tinyint(2) NOT NULL DEFAULT '0',
  `replyFlag` tinyint(2) NOT NULL DEFAULT '0',
  `forwardFlag` tinyint(2) NOT NULL DEFAULT '0',
  `subject` varchar(255) DEFAULT NULL,
  `body` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`messageId`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`messageId`, `recipientId`, `recipientString`, `senderId`, `attachmentFlag`, `replyFlag`, `forwardFlag`, `subject`, `body`, `date`) VALUES
(1, 1, '', 0, 1, 0, 0, 'abcde', 'testtest', '2022-12-21 00:12:02'),
(2, 2, '', 0, 1, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(3, 3, '', 0, 1, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(4, 1, NULL, 0, 0, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(5, 1, NULL, 0, 0, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(6, 1, NULL, 0, 0, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(7, 1, NULL, 0, 0, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(8, 1, NULL, 0, 0, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(9, 1, NULL, 0, 0, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(10, 1, NULL, 0, 0, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(11, 1, NULL, 0, 0, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(12, 1, NULL, 0, 0, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(13, 1, NULL, 0, 0, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(14, 1, NULL, 0, 0, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(15, 1, NULL, 0, 0, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(16, 1, NULL, 0, 0, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(17, 1, NULL, 0, 0, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(18, 1, NULL, 0, 0, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(19, 1, NULL, 0, 0, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(20, 1, NULL, 0, 0, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(21, 1, NULL, 0, 0, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(22, 1, NULL, 0, 0, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(23, 1, NULL, 0, 0, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(24, 1, NULL, 0, 0, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(25, 1, NULL, 0, 0, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(26, 1, NULL, 0, 0, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(27, 1, NULL, 0, 0, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(28, 1, NULL, 0, 0, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(29, 1, NULL, 0, 0, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(30, 1, NULL, 0, 0, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(31, 1, NULL, 0, 0, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02'),
(32, 1, NULL, 0, 0, 0, 0, 'test', 'testtest', '2022-12-21 00:12:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`userId`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `username`, `date`) VALUES
(1, 'admin', '2022-12-21 02:47:25'),
(2, 'user1', '2022-12-21 02:47:31'),
(3, 'user2', '2022-12-21 02:47:36');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
