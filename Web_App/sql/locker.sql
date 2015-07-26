-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2015 at 04:28 AM
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
  `RfidTag` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `SName` varchar(255) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `PassWord` varchar(255) NOT NULL,
  `Privileges` varchar(255) NOT NULL,
  `Level` int(11) NOT NULL DEFAULT '0',
  `Flag` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`No`, `RfidTag`, `Name`, `SName`, `UserName`, `PassWord`, `Privileges`, `Level`, `Flag`) VALUES
(1, '', 'admin', '', 'admin', 'MTIzNHBhc3M=', 'ผู้ดูแลระบบ', 0, 1),
(2, '35196183246', 'ปิยะ', 'ถิรพันธุ์เมธี', 'piya', 'MTIzNHBhc3M=', 'หัวหน้าสาขา/ประธานหลักสูตร', 1, 1),
(3, '3770171116188', 'ศรีสุดา', 'สรนันต์ศรี', 'srisuda', 'MTIzNHBhc3M=', 'ผู้ดูแลระบบ', 1, 1),
(4, '688312026117', 'ชนาเนตร', 'อรรถยุกติ', 'chananate', 'MTIzNHBhc3M=', 'ผู้ดูแลระบบ', 1, 1),
(5, '165137114212138', 'ชาญวิทย์', 'มุสิกะ', 'chanwit', 'MTIzNHBhc3M=', 'ผู้ดูแลระบบ', 1, 1),
(6, '185349174138', 'สุรีพร', 'นวลนิ่ม', 'sureporn', 'MTIzNHBhc3M=', 'ผู้ใช้งานทั่วไป', 1, 1),
(7, '2492412774212', 'ธวัชชัย', 'สารวงษ์', 'tawatchi', 'MTIzNHBhc3M=', 'ผู้ใช้งานทั่วไป', 1, 1),
(8, '18510412774228', 'ปทุม', 'วัฒนพรพรหม', 'patum', 'MTIzNHBhc3M=', 'ผู้ใช้งานทั่วไป', 0, 1),
(9, '2452507846111', 'สถิระ', 'ชัยชนะกลาง', 'sathira', 'MTIzNHBhc3M=', 'ผู้ใช้งานทั่วไป', 1, 1),
(10, '3172249086', 'สิริอร', 'นุชผดุง', 'sirion', 'MTIzNHBhc3M=', 'ผู้ใช้งานทั่วไป', 1, 1);

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
('2015-08-17', '08:30:00');

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
  `Status` varchar(255) NOT NULL,
  `Replace` varchar(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`No`, `No_account`, `No_numberlocker`, `No_timetable`, `No_overtime`, `Year`, `Term`, `Begin`, `End`, `Status`, `Replace`) VALUES
(1, 5, 2, 62, 0, 2558, 1, '2015-08-17 12:50:00', '2015-08-21 08:30:00', 'เข้าสอนตรงเวลา', 'null'),
(2, 4, 4, 40, 0, 2558, 1, '2015-08-17 12:50:00', '2015-08-18 12:50:00', 'เข้าสอนตรงเวลา', 'null'),
(3, 9, 5, 44, 0, 2558, 1, '2015-08-17 12:50:00', '2015-08-18 17:10:00', 'เข้าสอนตรงเวลา', 'null'),
(4, 2, 1, 20, 0, 2558, 1, '2015-08-17 12:50:00', '2015-08-21 08:30:00', 'เข้าสอนตรงเวลา', 'null'),
(5, 5, 2, 63, 0, 2558, 1, '2015-08-18 07:40:00', '2015-08-17 08:30:00', 'เข้าสอนตรงเวลา', 'null'),
(6, 3, 4, 24, 0, 2558, 1, '2015-08-18 07:40:00', '2015-08-20 13:15:00', 'เข้าสอนตรงเวลา', 'null'),
(7, 9, 1, 45, 0, 2558, 1, '2015-08-18 08:50:00', '2015-08-18 12:10:00', 'เข้าสอนตรงเวลา', 'null'),
(8, 3, 4, 25, 0, 2558, 1, '2015-08-18 12:50:00', '2015-08-18 17:10:00', 'เข้าสอนตรงเวลา', 'null'),
(9, 6, 1, 52, 0, 2558, 1, '2015-08-18 12:50:00', '2015-08-18 16:10:00', 'เข้าสอนตรงเวลา', '10'),
(10, 5, 3, 66, 0, 2558, 1, '2015-08-18 15:50:00', '2015-08-19 07:50:00', 'เข้าสอนตรงเวลา', 'null'),
(11, 3, 1, 26, 0, 2558, 1, '2015-08-19 07:50:00', '2015-08-19 12:20:00', 'เข้าสอนตรงเวลา', 'null'),
(12, 4, 4, 41, 0, 2558, 1, '2015-08-19 07:50:00', '2015-08-19 12:20:00', 'เข้าสอนตรงเวลา', 'null'),
(13, 9, 5, 46, 0, 2558, 1, '2015-08-19 07:50:00', '2015-08-19 12:20:00', 'เข้าสอนตรงเวลา', 'null'),
(14, 8, 3, 37, 0, 2558, 1, '2015-08-19 09:10:00', '2015-08-19 12:20:00', 'เข้าสอนสาย', 'null'),
(15, 4, 4, 42, 0, 2558, 1, '2015-08-19 12:45:00', '2015-08-19 17:10:00', 'เข้าสอนตรงเวลา', 'null'),
(16, 2, 1, 21, 0, 2558, 1, '2015-08-19 13:10:00', '2015-08-19 16:10:00', 'เข้าสอนสาย', 'null'),
(17, 4, 3, 0, 0, 2558, 1, '2015-08-19 13:10:00', '2015-08-19 17:10:00', 'empty', 'null'),
(18, 2, 4, 22, 0, 2558, 1, '2015-08-20 07:50:00', '2015-08-20 12:50:00', 'เข้าสอนตรงเวลา', 'null'),
(19, 8, 3, 38, 0, 2558, 1, '2015-08-20 12:50:00', '2015-08-20 16:10:00', 'เข้าสอนตรงเวลา', 'null'),
(20, 10, 1, 0, 0, 2558, 1, '2015-08-20 13:15:00', '2015-08-20 18:00:00', 'empty', 'null'),
(21, 10, 5, 0, 0, 2558, 1, '2015-08-20 13:15:00', '2015-08-20 16:10:00', 'empty', 'null'),
(22, 8, 3, 39, 0, 2558, 1, '2015-08-21 08:30:00', '2015-08-21 08:30:00', 'เข้าสอนสาย', 'null'),
(23, 6, 1, 54, 0, 2558, 1, '2015-08-21 08:30:00', '2015-08-21 08:30:00', 'เข้าสอนตรงเวลา', 'null'),
(24, 4, 4, 43, 0, 2558, 1, '2015-08-21 12:50:00', '2015-07-20 17:10:00', 'เข้าสอนตรงเวลา', 'null'),
(25, 3, 2, 0, 0, 2558, 1, '2015-08-21 08:30:00', '2015-08-21 08:30:00', 'empty', 'null'),
(26, 9, 1, 0, 0, 2558, 1, '2015-08-21 08:30:00', '2015-08-21 08:30:00', 'empty', 'null');

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
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(9, 1),
(10, 1),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(9, 2),
(10, 2),
(2, 3),
(3, 3),
(4, 3),
(5, 3),
(6, 3),
(7, 3),
(9, 3),
(10, 3),
(2, 4),
(3, 4),
(4, 4),
(5, 4),
(6, 4),
(7, 4),
(9, 4),
(10, 4),
(2, 5),
(4, 5),
(5, 5),
(9, 5),
(10, 5),
(2, 6),
(4, 6),
(5, 6),
(9, 6),
(10, 6),
(2, 7),
(4, 7),
(5, 7),
(9, 7),
(10, 7);

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
(1, 403),
(2, 405),
(3, 406),
(4, 410),
(5, 308),
(6, 309),
(7, 310),
(8, 0),
(9, 0),
(10, 0),
(11, 0),
(12, 0);

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
  `Detail` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `overtime_room`
--

INSERT INTO `overtime_room` (`No`, `No_account`, `Date`, `Time_Begin`, `Time_End`, `Room`, `Detail`) VALUES
(2, 5, '2015-09-03', '07:52:00', '12:00:00', '405', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `setdate`
--

CREATE TABLE IF NOT EXISTS `setdate` (
`No` int(11) NOT NULL,
  `sDate` date NOT NULL,
  `eDate` date NOT NULL,
  `sDateExam` date NOT NULL,
  `eDateExam` date NOT NULL,
  `Year` int(11) NOT NULL,
  `Term` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setdate`
--

INSERT INTO `setdate` (`No`, `sDate`, `eDate`, `sDateExam`, `eDateExam`, `Year`, `Term`) VALUES
(1, '2015-08-17', '2015-12-11', '2015-11-27', '2015-12-11', 2558, 1);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
`No` int(11) NOT NULL,
  `Id` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Hours` int(11) NOT NULL,
  `Level` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`No`, `Id`, `Name`, `Hours`, `Level`) VALUES
(1, '2-231-204', 'โครงสร้างข้อมูล', 3, 0),
(2, '2-234-301', 'การจัดระบบสารสนเทศในองค์กร	', 3, 0),
(3, '2-234-406', 'สัมมนาทางวิทยาการคอมพิวเตอร์', 3, 0),
(4, '2-235-404', 'การจัดการเครือข่ายคอมพิวเตอร์', 4, 0),
(5, '2-231-102', 'หลักการเขียนโปรแกรมคอมพิวเตอร์', 4, 0),
(6, '2-233-303', 'การวิเคราะห์และออกแบบระบบ', 4, 0),
(7, '2-001-301', 'การเตรียมสหกิจศึกษา', 1, 0),
(8, '2-232-305', 'ระบบไมโครคอมพิวเตอร์และการต่อประสาน', 4, 0),
(9, '2-233-411', 'โครงงานทางวิทยาการคอมพิวเตอร์ 2', 3, 0),
(10, '2-230-104', 'เทคโนโลยีและการประยุกต์ใช้อินเทอร์เน็ต', 4, 0),
(11, '2-230-102', 'ระบบมัลติมีเดียและการประยุกต์ใช้', 4, 0),
(12, '2-232-203', 'การจัดระเบียบคอมพิวเตอร์และสถาปัตยกรรม', 3, 0),
(13, '2-232-304', 'ระบบปฏิบัติการ', 4, 0),
(14, '2-231-101', 'วิทยาการคอมพิวเตอร์และเทคโนโลยีสารสนเทศ ', 3, 0),
(15, '2-233-201', 'โครงสร้างไม่ต่อเนื่อง', 3, 0),
(16, '2-233-414', 'ระบบสนับสนุนการตัดสินใจ', 4, 0),
(17, '2-230-101', 'คอมพิวเตอร์พื้นฐาน', 4, 0),
(18, '2-235-311', 'การออกแบบเว็บไซต์', 5, 0),
(19, '2-230-107', 'โปรแกรมสำเร็จรูป', 4, 0),
(20, '2-230-106', 'การเขียนโปรแกรมคอมพิวเตอร์เบื้องต้น', 4, 0),
(21, '2-233-409', 'วิศวกรรมซอฟต์แวร์', 3, 0),
(22, '2-231-413', 'การศึกษาเฉพาะเรื่องทางการพัฒนาโปรแกรมคอมพิวเตอร์', 4, 0),
(23, '2-231-205', 'การเขียนโปรแกรมเชิงวัตถุ', 4, 0),
(24, '2-233-410', 'โครงงานทางวิทยาการคอมพิวเตอร์ ', 3, 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `subject_timetable`
--

INSERT INTO `subject_timetable` (`No`, `No_account`, `No_subject`, `Year`, `Term`, `Day`, `Time_Begin`, `Time_End`, `Group`, `Town`, `Room`) VALUES
(20, 2, 1, '2558', 1, 'จันทร์', 13.00, 16.00, 1, '9', '403'),
(21, 2, 2, '2558', 1, 'พุธ', 13.00, 16.00, 1, '9', '403'),
(22, 2, 4, '2558', 1, 'พฤหัสบดี', 8.00, 12.00, 1, '9', '410'),
(23, 2, 3, '2558', 1, 'ศุกร์', 13.00, 16.00, 1, '9', '403'),
(24, 3, 5, '2558', 1, 'อังคาร', 8.00, 12.00, 3, '9', '410'),
(25, 3, 5, '2558', 1, 'อังคาร', 13.00, 17.00, 1, '9', '410'),
(26, 3, 6, '2558', 1, 'พุธ', 8.00, 12.00, 1, '9', '403'),
(27, 3, 5, '2558', 1, 'ศุกร์', 8.00, 12.00, 2, '9', '410'),
(34, 7, 13, '2558', 1, 'พฤหัสบดี', 13.00, 17.00, 1, '9', '403'),
(35, 8, 17, '2558', 1, 'จันทร์', 8.00, 12.00, 2, '9', '308'),
(36, 8, 17, '2558', 1, 'อังคาร', 8.00, 12.00, 4, '9', '309'),
(37, 8, 15, '2558', 1, 'พุธ', 9.00, 12.00, 2, '9', '406'),
(38, 8, 15, '2558', 1, 'พฤหัสบดี', 13.00, 16.00, 1, '9', '406'),
(39, 8, 16, '2558', 1, 'ศุกร์', 8.00, 12.00, 1, '9', '406'),
(40, 4, 21, '2558', 1, 'จันทร์', 13.00, 16.00, 1, '9', '410'),
(41, 4, 23, '2558', 1, 'พุธ', 8.00, 12.00, 1, '9', '410'),
(42, 4, 23, '2558', 1, 'พุธ', 13.00, 17.00, 2, '9', '410'),
(43, 4, 22, '2558', 1, 'ศุกร์', 13.00, 17.00, 1, '9', '410'),
(44, 9, 11, '2558', 1, 'จันทร์', 13.00, 17.00, 1, '9', '308'),
(45, 9, 12, '2558', 1, 'อังคาร', 9.00, 12.00, 1, '9', '403'),
(46, 9, 11, '2558', 1, 'พุธ', 8.00, 12.00, 2, '9', '308'),
(47, 9, 11, '2558', 1, 'พฤหัสบดี', 13.00, 17.00, 4, '9', '308'),
(49, 10, 17, '2558', 1, 'พฤหัสบดี', 13.00, 17.00, 10, '9', '309'),
(50, 10, 18, '2558', 1, 'ศุกร์', 13.00, 18.00, 1, '9', '308'),
(51, 6, 9, '2558', 1, 'อังคาร', 9.00, 12.00, 2, '9', '406'),
(52, 6, 14, '2558', 1, 'อังคาร', 13.00, 16.00, 2, '9', '403'),
(53, 6, 14, '2558', 1, 'พฤหัสบดี', 9.00, 12.00, 1, '9', '403'),
(54, 6, 14, '2558', 1, 'ศุกร์', 9.00, 12.00, 3, '9', '403'),
(62, 5, 8, '2558', 1, 'จันทร์', 13.00, 17.00, 1, '9', '405'),
(63, 5, 8, '2558', 1, 'อังคาร', 9.00, 12.00, 2, '9', '405'),
(64, 5, 9, '2558', 1, 'พุธ', 9.00, 12.00, 1, '9', '405'),
(65, 5, 9, '2558', 1, 'พฤหัสบดี', 9.00, 12.00, 1, '9', '405'),
(66, 5, 7, '2558', 1, 'อังคาร', 16.00, 17.00, 1, '9', '406'),
(67, 5, 10, '2558', 1, 'พุธ', 13.00, 17.00, 1, '9', '308'),
(69, 5, 7, '2558', 1, 'อังคาร', 17.00, 18.00, 2, '9', '406'),
(70, 10, 17, '2558', 1, 'อังคาร', 8.00, 12.00, 5, '9', '308'),
(72, 10, 21, '2558', 1, 'อังคาร', 13.00, 16.00, 1, '9', '405');

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
MODIFY `No` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
MODIFY `No` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `number_locker`
--
ALTER TABLE `number_locker`
MODIFY `No` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `overtime_room`
--
ALTER TABLE `overtime_room`
MODIFY `No` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `setdate`
--
ALTER TABLE `setdate`
MODIFY `No` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
MODIFY `No` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `subject_timetable`
--
ALTER TABLE `subject_timetable`
MODIFY `No` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=73;
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
