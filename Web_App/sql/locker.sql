-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2015 at 05:18 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `locker`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
`No` int(11) NOT NULL,
  `RfidTag` varchar(20) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `SName` varchar(20) NOT NULL,
  `UserName` varchar(40) NOT NULL,
  `PassWord` varchar(60) NOT NULL,
  `Privileges` varchar(20) NOT NULL,
  `Level` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`No`, `RfidTag`, `Name`, `SName`, `UserName`, `PassWord`, `Privileges`, `Level`) VALUES
(1, '688312026117', 'ศรีสุดา', 'สรนันต์ศรี', 'srisuda', 'MTIzNHBhc3M=', 'ผู้ใช้งานทั่วไป', 0),
(2, '165137114212138', 'ชนาเนตร', 'อรรถยุกติ', 'chananate', 'MTIzNHBhc3M=', 'ผู้ดูแลระบบ', 0),
(3, '61782261507', 'ชาญวิทย์', 'มุสิกะ', 'chanwit', 'MTIzNHBhc3M=', 'ผู้ดูแลระบบ', 1),
(4, '11015', 'ปิยะ', 'ถิรพันธุ์เมธี', 'piya', 'MTIzNHBhc3M=', 'ผู้ใช้งานทั่วไป', 0),
(5, '2452507846111', 'สถิระ', 'ชัยชนะกลาง', 'satira', 'MTIzNDVmYWls', 'ผู้ใช้งานทั่วไป', 1);

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `Data` varchar(40) DEFAULT NULL,
  `Status` varchar(10) NOT NULL,
  `Town` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`Data`, `Status`, `Town`) VALUES
('', 'ready', '9');

-- --------------------------------------------------------

--
-- Table structure for table `datetime`
--

CREATE TABLE IF NOT EXISTS `datetime` (
  `date` date NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `datetime`
--

INSERT INTO `datetime` (`date`, `time`) VALUES
('2015-05-05', '11:10:00');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE IF NOT EXISTS `history` (
`No` int(11) NOT NULL,
  `No_account` int(11) NOT NULL,
  `No_numberlocker` int(11) NOT NULL DEFAULT '0',
  `No_timetable` int(11) NOT NULL DEFAULT '0',
  `No_overtime` int(11) NOT NULL DEFAULT '0',
  `Year` int(11) NOT NULL,
  `Term` int(11) NOT NULL,
  `Begin` datetime NOT NULL,
  `End` datetime DEFAULT NULL,
  `Status` varchar(30) NOT NULL,
  `Replace` varchar(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`No`, `No_account`, `No_numberlocker`, `No_timetable`, `No_overtime`, `Year`, `Term`, `Begin`, `End`, `Status`, `Replace`) VALUES
(1, 1, 1, 3, 0, 2557, 1, '2014-01-01 08:00:00', '2015-05-04 07:10:00', 'เข้าสอนตรงเวลา', NULL),
(2, 2, 1, 12, 0, 2557, 1, '2014-01-01 13:00:00', '2014-01-01 17:00:00', 'เข้าสอนตรงเวลา', NULL),
(3, 1, 1, 4, 0, 2557, 1, '2014-01-02 08:00:00', '2015-05-04 13:10:00', 'เข้าสอนตรงเวลา', NULL),
(4, 2, 1, 14, 0, 2557, 1, '2014-01-02 13:00:00', '2014-01-02 17:00:00', 'เข้าสอนตรงเวลา', NULL),
(5, 1, 1, 5, 0, 2557, 1, '2014-01-03 08:00:00', '2014-01-03 12:00:00', 'เข้าสอนตรงเวลา', NULL),
(6, 2, 1, 15, 0, 2557, 1, '2014-01-03 13:00:00', '2015-05-05 07:10:00', 'เข้าสอนตรงเวลา', NULL),
(7, 1, 1, 2, 0, 2557, 1, '2014-01-06 08:00:00', '2014-01-06 12:00:00', 'เข้าสอนตรงเวลา', NULL),
(8, 2, 1, 11, 0, 2557, 1, '2014-01-06 13:00:00', '2014-01-06 17:00:00', 'เข้าสอนตรงเวลา', NULL),
(9, 1, 1, 1, 0, 2557, 1, '2014-01-07 08:00:00', '2015-05-04 07:10:00', 'เข้าสอนตรงเวลา', NULL),
(10, 2, 1, 13, 0, 2557, 1, '2014-01-07 13:00:00', '2014-01-07 17:00:00', 'เข้าสอนตรงเวลา', NULL),
(11, 1, 1, 3, 0, 2557, 1, '2014-01-08 08:00:00', '2014-01-08 12:00:00', 'เข้าสอนสาย', NULL),
(12, 2, 1, 12, 0, 2557, 1, '2014-01-08 13:00:00', '2014-01-08 17:00:00', 'เข้าสอนสาย', NULL),
(13, 1, 1, 4, 0, 2557, 1, '2014-01-09 08:00:00', '2014-01-09 12:00:00', 'เข้าสอนสาย', NULL),
(14, 2, 1, 14, 0, 2557, 1, '2014-01-09 13:00:00', '2014-01-09 17:00:00', 'เข้าสอนสาย', NULL),
(15, 1, 1, 5, 0, 2557, 1, '2014-01-10 08:00:00', '2014-01-10 12:00:00', 'เข้าสอนสาย', NULL),
(16, 2, 1, 15, 0, 2557, 1, '2014-01-10 13:00:00', '2014-01-10 17:00:00', 'เข้าสอนสาย', NULL),
(17, 1, 1, 2, 0, 2557, 1, '2014-01-13 08:00:00', '2014-01-13 12:00:00', 'เข้าสอนสาย', NULL),
(18, 2, 1, 11, 0, 2557, 1, '2014-01-13 13:00:00', '2014-01-13 17:00:00', 'เข้าสอนสาย', NULL),
(19, 1, 1, 1, 0, 2557, 1, '2014-01-14 08:00:00', '2014-01-14 12:00:00', 'เข้าสอนสาย', NULL),
(20, 2, 1, 13, 0, 2557, 1, '2014-01-14 13:00:00', '2014-01-14 17:00:00', 'เข้าสอนสาย', NULL),
(21, 1, 2, 0, 0, 2557, 1, '2014-01-14 18:00:00', '2014-01-14 19:00:00', 'empty', NULL),
(22, 2, 3, 0, 0, 2557, 1, '2014-01-14 18:00:00', '2014-01-14 19:00:00', 'empty', NULL),
(23, 1, 2, 0, 0, 2557, 1, '2014-01-15 18:00:00', '2014-01-15 19:00:00', 'empty', NULL),
(24, 2, 3, 0, 0, 2557, 1, '2014-01-15 18:00:00', '2014-01-15 19:00:00', 'empty', NULL),
(25, 2, 1, 16, 0, 2557, 2, '2014-06-02 08:00:00', '2014-06-02 12:00:00', 'เข้าสอนตรงเวลา', NULL),
(26, 1, 1, 6, 0, 2557, 2, '2014-06-02 13:00:00', '2014-06-02 17:00:00', 'เข้าสอนตรงเวลา', NULL),
(27, 2, 1, 18, 0, 2557, 2, '2014-06-03 08:00:00', '2014-06-03 12:00:00', 'เข้าสอนตรงเวลา', NULL),
(28, 1, 1, 7, 0, 2557, 2, '2014-06-03 13:00:00', '2014-06-03 17:00:00', 'เข้าสอนตรงเวลา', NULL),
(29, 2, 1, 17, 0, 2557, 2, '2014-06-04 08:00:00', '2014-06-04 12:00:00', 'เข้าสอนตรงเวลา', NULL),
(30, 1, 1, 9, 0, 2557, 2, '2014-06-04 13:00:00', '2014-06-04 17:00:00', 'เข้าสอนตรงเวลา', NULL),
(32, 1, 1, 0, 0, 2557, 2, '2014-06-04 17:00:00', '2014-06-04 18:00:00', 'empty', NULL),
(33, 2, 1, 19, 0, 2557, 2, '2014-06-05 08:00:00', '2014-06-05 12:00:00', 'เข้าสอนตรงเวลา', NULL),
(34, 1, 1, 8, 0, 2557, 2, '2014-06-05 13:00:00', '2014-06-05 17:00:00', 'เข้าสอนตรงเวลา', NULL),
(35, 1, 5, 0, 0, 2557, 2, '2014-06-05 18:00:00', '2014-06-05 18:00:00', 'empty', NULL),
(36, 2, 1, 20, 0, 2557, 2, '2014-06-06 08:00:00', '2014-06-06 12:00:00', 'เข้าสอนตรงเวลา', NULL),
(37, 1, 1, 10, 0, 2557, 2, '2014-06-06 13:00:00', '2014-06-06 17:00:00', 'เข้าสอนตรงเวลา', NULL),
(38, 2, 1, 16, 0, 2557, 2, '2014-06-09 08:00:00', '2014-06-09 12:00:00', 'เข้าสอนตรงเวลา', NULL),
(39, 1, 1, 6, 0, 2557, 2, '2014-06-09 13:00:00', '2014-06-09 17:00:00', 'เข้าสอนตรงเวลา', NULL),
(40, 2, 1, 18, 0, 2557, 2, '2014-06-10 08:00:00', '2014-06-10 12:00:00', 'เข้าสอนตรงเวลา', NULL),
(41, 1, 1, 7, 0, 2557, 2, '2014-06-10 13:00:00', '2014-06-10 17:00:00', 'เข้าสอนตรงเวลา', NULL),
(42, 2, 1, 17, 0, 2557, 2, '2014-06-11 08:00:00', '2014-06-11 12:00:00', 'เข้าสอนตรงเวลา', NULL),
(43, 1, 1, 9, 0, 2557, 2, '2014-06-11 13:00:00', '2014-06-11 17:00:00', 'เข้าสอนตรงเวลา', NULL),
(44, 2, 1, 19, 0, 2557, 2, '2014-06-12 08:00:00', '2014-06-12 12:00:00', 'เข้าสอนตรงเวลา', NULL),
(45, 1, 1, 8, 0, 2557, 2, '2014-06-12 13:00:00', '2014-06-12 17:00:00', 'เข้าสอนตรงเวลา', NULL),
(46, 2, 1, 20, 0, 2557, 2, '2014-06-13 08:00:00', '2014-06-13 12:00:00', 'เข้าสอนตรงเวลา', NULL),
(47, 1, 1, 10, 0, 2557, 2, '2014-06-13 13:00:00', '2014-06-13 17:00:00', 'เข้าสอนตรงเวลา', NULL),
(48, 1, 1, 23, 0, 2558, 1, '2015-01-01 08:00:00', '2014-01-01 12:00:00', 'เข้าสอนตรงเวลา', NULL),
(49, 1, 1, 24, 0, 2558, 1, '2015-01-02 08:00:00', '2014-01-02 12:00:00', 'เข้าสอนตรงเวลา', NULL),
(50, 1, 1, 21, 0, 2558, 1, '2015-01-05 08:00:00', '2014-01-05 12:00:00', 'เข้าสอนตรงเวลา', NULL),
(51, 1, 1, 25, 0, 2558, 1, '2015-01-06 08:00:00', '2014-01-06 12:00:00', 'เข้าสอนตรงเวลา', NULL),
(52, 1, 1, 22, 0, 2558, 1, '2015-01-07 08:00:00', '2014-01-07 12:00:00', 'เข้าสอนตรงเวลา', NULL),
(53, 1, 1, 23, 0, 2558, 1, '2015-01-08 08:00:00', '2014-01-08 12:00:00', 'เข้าสอนตรงเวลา', NULL),
(54, 1, 1, 24, 0, 2558, 1, '2015-01-09 08:00:00', '2014-01-09 12:00:00', 'เข้าสอนตรงเวลา', NULL),
(55, 1, 1, 21, 0, 2558, 1, '2015-01-12 08:00:00', '2014-01-12 12:00:00', 'เข้าสอนตรงเวลา', NULL),
(56, 1, 1, 25, 0, 2558, 1, '2015-01-13 08:00:00', '2014-01-13 12:00:00', 'เข้าสอนตรงเวลา', NULL),
(57, 1, 1, 22, 0, 2558, 1, '2015-01-14 08:00:00', '2014-01-14 12:00:00', 'เข้าสอนตรงเวลา', NULL),
(58, 1, 1, 23, 0, 2558, 1, '2015-01-15 08:00:00', '2014-01-15 12:00:00', 'เข้าสอนตรงเวลา', NULL),
(59, 1, 1, 24, 0, 2558, 1, '2015-01-16 08:00:00', '2014-01-16 12:00:00', 'เข้าสอนตรงเวลา', NULL),
(60, 1, 1, 21, 0, 2558, 1, '2015-01-19 08:00:00', '2014-01-19 12:00:00', 'เข้าสอนตรงเวลา', NULL),
(61, 1, 1, 25, 0, 2558, 1, '2015-01-20 08:00:00', '2014-01-20 12:00:00', 'เข้าสอนตรงเวลา', NULL),
(62, 1, 1, 22, 0, 2558, 1, '2015-01-21 08:00:00', '2014-01-21 12:00:00', 'เข้าสอนตรงเวลา', NULL),
(63, 1, 1, 23, 0, 2558, 1, '2015-01-22 08:00:00', '2014-01-22 12:00:00', 'เข้าสอนตรงเวลา', NULL),
(64, 1, 1, 27, 0, 2558, 2, '2015-06-02 13:00:00', '2015-06-02 17:00:00', 'เข้าสอนตรงเวลา', NULL),
(65, 2, 1, 32, 0, 2558, 2, '2015-06-02 18:00:00', '2015-06-02 21:00:00', 'เข้าสอนตรงเวลา', NULL),
(66, 1, 1, 28, 0, 2558, 2, '2015-06-03 13:00:00', '2015-06-03 17:00:00', 'เข้าสอนตรงเวลา', NULL),
(67, 2, 1, 31, 0, 2558, 2, '2015-06-03 18:00:00', '2015-06-03 21:00:00', 'เข้าสอนตรงเวลา', NULL),
(68, 1, 1, 29, 0, 2558, 2, '2015-06-04 13:00:00', '2015-06-04 17:00:00', 'เข้าสอนตรงเวลา', NULL),
(69, 2, 1, 33, 0, 2558, 2, '2015-06-04 18:00:00', '2015-06-04 21:00:00', 'เข้าสอนตรงเวลา', NULL),
(70, 1, 1, 30, 0, 2558, 2, '2015-06-05 13:00:00', '2015-06-05 17:00:00', 'เข้าสอนตรงเวลา', NULL),
(71, 2, 1, 35, 0, 2558, 2, '2015-06-05 18:00:00', '2015-06-05 21:00:00', 'เข้าสอนตรงเวลา', NULL),
(72, 1, 1, 26, 0, 2558, 2, '2015-06-08 13:00:00', '2015-06-08 17:00:00', 'เข้าสอนตรงเวลา', NULL),
(73, 2, 1, 34, 0, 2558, 2, '2015-06-08 18:00:00', '2015-06-08 21:00:00', 'เข้าสอนตรงเวลา', NULL),
(74, 1, 1, 27, 0, 2558, 2, '2015-06-09 13:00:00', '2015-06-09 17:00:00', 'เข้าสอนตรงเวลา', NULL),
(75, 2, 1, 32, 0, 2558, 2, '2015-06-09 18:00:00', '2015-06-09 21:00:00', 'เข้าสอนตรงเวลา', NULL),
(76, 1, 1, 28, 0, 2558, 2, '2015-06-10 13:00:00', '2015-06-10 17:00:00', 'เข้าสอนตรงเวลา', NULL),
(77, 2, 1, 31, 0, 2558, 2, '2015-06-10 18:00:00', '2015-06-10 21:00:00', 'เข้าสอนตรงเวลา', NULL),
(78, 1, 1, 29, 0, 2558, 2, '2015-06-11 13:00:00', '2015-06-11 17:00:00', 'เข้าสอนตรงเวลา', NULL),
(79, 2, 1, 33, 0, 2558, 2, '2015-06-11 18:00:00', '2015-06-11 21:00:00', 'เข้าสอนตรงเวลา', NULL),
(80, 1, 1, 30, 0, 2558, 2, '2015-06-12 13:00:00', '2015-06-12 17:00:00', 'เข้าสอนตรงเวลา', NULL),
(81, 2, 1, 35, 0, 2558, 2, '2015-06-12 18:00:00', '2015-06-12 21:00:00', 'เข้าสอนตรงเวลา', NULL),
(82, 2, 0, 0, 2, 2558, 1, '2015-03-30 17:00:00', '2015-03-30 19:00:00', 'แจ้ง', NULL),
(83, 2, 1, 11, 0, 2557, 1, '2014-01-20 12:50:00', '2014-01-20 17:10:00', 'เข้าสอนตรงเวลา', NULL),
(84, 2, 3, 38, 0, 2558, 1, '2015-04-27 12:55:00', '2015-04-27 12:55:00', 'เข้าสอนตรงเวลา', NULL),
(88, 5, 6, 40, 0, 2558, 1, '2015-05-05 07:10:00', '2015-05-05 12:00:00', 'เข้าสอนตรงเวลา', '4');

-- --------------------------------------------------------

--
-- Table structure for table `history_numberlocker`
--

CREATE TABLE IF NOT EXISTS `history_numberlocker` (
  `No_account` int(11) NOT NULL,
  `No_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `history_numberlocker`
--

INSERT INTO `history_numberlocker` (`No_account`, `No_number`) VALUES
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(3, 6),
(3, 7),
(5, 7),
(3, 8),
(3, 9),
(3, 10),
(3, 11),
(3, 12);

-- --------------------------------------------------------

--
-- Table structure for table `number_locker`
--

CREATE TABLE IF NOT EXISTS `number_locker` (
`No` int(11) NOT NULL,
  `Number_Room` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `number_locker`
--

INSERT INTO `number_locker` (`No`, `Number_Room`) VALUES
(1, 401),
(2, 402),
(3, 403),
(4, 404),
(5, 405),
(6, 406),
(7, 407),
(8, 408),
(9, 409),
(10, 410),
(11, 411),
(12, 412);

-- --------------------------------------------------------

--
-- Table structure for table `overtime_room`
--

CREATE TABLE IF NOT EXISTS `overtime_room` (
`No` int(11) NOT NULL,
  `No_account` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Time_Begin` time NOT NULL,
  `Time_End` time NOT NULL,
  `Room` varchar(5) NOT NULL,
  `Detail` varchar(40) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `overtime_room`
--

INSERT INTO `overtime_room` (`No`, `No_account`, `Date`, `Time_Begin`, `Time_End`, `Room`, `Detail`) VALUES
(1, 1, '2015-03-27', '17:47:00', '18:47:00', '409', 'สอนเพิ่ม'),
(2, 2, '2015-03-30', '17:47:00', '18:47:00', '405', 'สอนเพิ่ม'),
(3, 2, '2015-05-04', '08:00:00', '12:00:00', '402', 'สอนแทนอาจารย์ ศรีสุดา'),
(6, 2, '2015-05-04', '11:00:00', '12:00:00', '409', 'แนะแนว'),
(7, 1, '2015-05-04', '13:00:00', '17:00:00', '409', '222222222222222222');

-- --------------------------------------------------------

--
-- Table structure for table `setdate`
--

CREATE TABLE IF NOT EXISTS `setdate` (
`No` int(11) NOT NULL,
  `sDate` date NOT NULL,
  `eDate` date NOT NULL,
  `Year` int(11) NOT NULL,
  `Term` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setdate`
--

INSERT INTO `setdate` (`No`, `sDate`, `eDate`, `Year`, `Term`) VALUES
(1, '2014-01-01', '2014-06-01', 2557, 1),
(2, '2014-06-02', '2014-12-31', 2557, 2),
(3, '2015-01-01', '2015-06-01', 2558, 1),
(4, '2015-06-02', '2015-12-31', 2558, 2),
(5, '2016-01-01', '2016-06-01', 2559, 1),
(6, '2016-06-02', '2016-12-31', 2559, 2);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
`No` int(11) NOT NULL,
  `Id` int(11) NOT NULL,
  `Name` varchar(40) NOT NULL,
  `Hours` int(11) NOT NULL,
  `Level` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`No`, `Id`, `Name`, `Hours`, `Level`) VALUES
(1, 331001, 'java', 4, 0),
(2, 331002, 'db', 4, 0),
(3, 331003, 'se', 3, 0),
(5, 331005, 'cg', 4, 0),
(6, 331006, 'mis', 3, 1),
(7, 331007, 'os', 3, 0),
(8, 331008, 'android', 4, 0),
(9, 331009, 'micro', 4, 0),
(10, 331010, 'PJ', 4, 1),
(11, 331011, 'สัมนา', 4, 1),
(12, 3311019, 'digital', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `subject_timetable`
--

CREATE TABLE IF NOT EXISTS `subject_timetable` (
`No` int(11) NOT NULL,
  `No_account` int(11) NOT NULL,
  `No_subject` int(11) NOT NULL,
  `Year` varchar(10) NOT NULL,
  `Term` int(11) NOT NULL,
  `Day` varchar(10) NOT NULL,
  `Time_Begin` float(4,2) NOT NULL,
  `Time_End` float(4,2) NOT NULL,
  `Group` int(11) NOT NULL,
  `Town` varchar(40) NOT NULL,
  `Room` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `subject_timetable`
--

INSERT INTO `subject_timetable` (`No`, `No_account`, `No_subject`, `Year`, `Term`, `Day`, `Time_Begin`, `Time_End`, `Group`, `Town`, `Room`) VALUES
(1, 1, 2, '2557', 1, 'อังคาร', 8.00, 12.00, 1, '9', '402'),
(2, 1, 1, '2557', 1, 'จันทร์', 8.00, 12.00, 1, '9', '401'),
(3, 1, 3, '2557', 1, 'พุธ', 8.00, 11.00, 1, '9', '403'),
(4, 1, 5, '2557', 1, 'พฤหัสบดี', 8.00, 12.00, 1, '9', '404'),
(5, 1, 6, '2557', 1, 'ศุกร์', 8.00, 11.00, 1, '9', '405'),
(6, 1, 1, '2557', 2, 'จันทร์', 13.00, 17.00, 2, '9', '401'),
(7, 1, 2, '2557', 2, 'อังคาร', 13.00, 17.00, 2, '9', '402'),
(8, 1, 5, '2557', 2, 'พฤหัสบดี', 13.00, 17.00, 2, '9', '404'),
(9, 1, 3, '2557', 2, 'พุธ', 13.00, 16.00, 2, '9', '403'),
(10, 1, 6, '2557', 2, 'ศุกร์', 13.00, 16.00, 2, '9', '405'),
(11, 2, 1, '2557', 1, 'จันทร์', 13.00, 17.00, 2, '9', '401'),
(12, 2, 3, '2557', 1, 'พุธ', 13.00, 16.00, 2, '9', '403'),
(13, 2, 2, '2557', 1, 'อังคาร', 13.00, 17.00, 2, '9', '402'),
(14, 2, 5, '2557', 1, 'พฤหัสบดี', 13.00, 17.00, 2, '9', '404'),
(15, 2, 6, '2557', 1, 'ศุกร์', 13.00, 16.00, 2, '9', '405'),
(16, 2, 1, '2557', 2, 'จันทร์', 8.00, 12.00, 3, '9', '401'),
(17, 2, 3, '2557', 2, 'พุธ', 8.00, 11.00, 3, '9', '403'),
(18, 2, 2, '2557', 2, 'อังคาร', 8.00, 12.00, 3, '9', '402'),
(19, 2, 5, '2557', 2, 'พฤหัสบดี', 8.00, 12.00, 3, '9', '404'),
(20, 2, 6, '2557', 2, 'ศุกร์', 8.00, 11.00, 3, '9', '405'),
(21, 1, 1, '2558', 1, 'จันทร์', 8.00, 12.00, 1, '9', '401'),
(22, 1, 3, '2558', 1, 'พุธ', 8.00, 11.00, 1, '9', '403'),
(23, 1, 5, '2558', 1, 'พฤหัสบดี', 8.00, 12.00, 1, '9', '404'),
(24, 1, 6, '2558', 1, 'ศุกร์', 8.00, 11.00, 1, '9', '405'),
(25, 1, 2, '2558', 1, 'อังคาร', 8.00, 12.00, 1, '9', '402'),
(26, 1, 1, '2558', 2, 'จันทร์', 13.00, 17.00, 5, '9', '401'),
(27, 1, 2, '2558', 2, 'อังคาร', 13.00, 17.00, 5, '9', '402'),
(28, 1, 3, '2558', 2, 'พุธ', 13.00, 16.00, 5, '9', '403'),
(29, 1, 5, '2558', 2, 'พฤหัสบดี', 13.00, 17.00, 5, '9', '404'),
(30, 1, 6, '2558', 2, 'ศุกร์', 13.00, 16.00, 5, '9', '405'),
(31, 2, 3, '2558', 2, 'พุธ', 18.00, 21.00, 8, '9', '403'),
(32, 2, 2, '2558', 2, 'อังคาร', 18.00, 22.00, 8, '9', '402'),
(33, 2, 5, '2558', 2, 'พฤหัสบดี', 18.00, 22.00, 8, '9', '404'),
(34, 2, 1, '2558', 2, 'จันทร์', 18.00, 22.00, 8, '9', '401'),
(35, 2, 7, '2558', 2, 'ศุกร์', 18.00, 21.00, 8, '9', '405'),
(36, 3, 9, '2557', 1, 'อังคาร', 18.00, 22.00, 1, '1', '405'),
(37, 1, 1, '2557', 1, 'จันทร์', 18.00, 21.00, 8, '9', '401'),
(38, 2, 1, '2558', 1, 'จันทร์', 13.00, 17.00, 8, '9', '403'),
(39, 2, 6, '2558', 1, 'จันทร์', 8.00, 11.00, 8, '9', '409'),
(40, 5, 12, '2558', 1, 'อังคาร', 8.00, 12.00, 1, '9', '406');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
 ADD PRIMARY KEY (`No`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
 ADD PRIMARY KEY (`No`), ADD KEY `No_account` (`No_account`,`No_numberlocker`), ADD KEY `No_numberlocker` (`No_numberlocker`), ADD KEY `No_timetable` (`No_timetable`);

--
-- Indexes for table `history_numberlocker`
--
ALTER TABLE `history_numberlocker`
 ADD PRIMARY KEY (`No_account`,`No_number`), ADD KEY `No_number` (`No_number`);

--
-- Indexes for table `number_locker`
--
ALTER TABLE `number_locker`
 ADD PRIMARY KEY (`No`);

--
-- Indexes for table `overtime_room`
--
ALTER TABLE `overtime_room`
 ADD PRIMARY KEY (`No`), ADD KEY `No_account` (`No_account`);

--
-- Indexes for table `setdate`
--
ALTER TABLE `setdate`
 ADD PRIMARY KEY (`No`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
 ADD PRIMARY KEY (`No`);

--
-- Indexes for table `subject_timetable`
--
ALTER TABLE `subject_timetable`
 ADD PRIMARY KEY (`No`), ADD KEY `No_account` (`No_account`), ADD KEY `No_subject` (`No_subject`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
MODIFY `No` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
MODIFY `No` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=89;
--
-- AUTO_INCREMENT for table `number_locker`
--
ALTER TABLE `number_locker`
MODIFY `No` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `overtime_room`
--
ALTER TABLE `overtime_room`
MODIFY `No` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `setdate`
--
ALTER TABLE `setdate`
MODIFY `No` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
MODIFY `No` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `subject_timetable`
--
ALTER TABLE `subject_timetable`
MODIFY `No` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=41;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `history`
--
ALTER TABLE `history`
ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`No_account`) REFERENCES `account` (`No`);

--
-- Constraints for table `history_numberlocker`
--
ALTER TABLE `history_numberlocker`
ADD CONSTRAINT `history_numberlocker_ibfk_1` FOREIGN KEY (`No_number`) REFERENCES `number_locker` (`No`) ON DELETE CASCADE,
ADD CONSTRAINT `history_numberlocker_ibfk_2` FOREIGN KEY (`No_account`) REFERENCES `account` (`No`) ON DELETE CASCADE;

--
-- Constraints for table `overtime_room`
--
ALTER TABLE `overtime_room`
ADD CONSTRAINT `overtime_room_ibfk_1` FOREIGN KEY (`No_account`) REFERENCES `account` (`No`);

--
-- Constraints for table `subject_timetable`
--
ALTER TABLE `subject_timetable`
ADD CONSTRAINT `subject_timetable_ibfk_1` FOREIGN KEY (`No_account`) REFERENCES `account` (`No`),
ADD CONSTRAINT `subject_timetable_ibfk_2` FOREIGN KEY (`No_subject`) REFERENCES `subject` (`No`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
