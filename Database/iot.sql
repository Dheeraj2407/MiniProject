-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2018 at 01:54 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iot`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `LOGOUT` (IN `UNAME` VARCHAR(30))  UPDATE LOGS SET LOGOUT=NOW() WHERE EMAIL=UNAME AND LOGOUT IS NULL$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `EMAIL` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `IDNUM` char(7) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`EMAIL`, `IDNUM`) VALUES
('kumaaar48@gmail.com', 'ID00001');

--
-- Triggers `admin`
--
DELIMITER $$
CREATE TRIGGER `ONLOGIN` BEFORE INSERT ON `admin` FOR EACH ROW UPDATE LOGS SET LOGOUT=NOW() WHERE NEW.EMAIL=EMAIL AND LOGOUT IS NULL
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bulb_status`
--

CREATE TABLE `bulb_status` (
  `IP` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Status` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'OFF'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bulb_status`
--

INSERT INTO `bulb_status` (`IP`, `Status`) VALUES
('192.168.43.197', 'OFF'),
('192.168.43.197', 'OFF');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `EMAIL` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `UNAME` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PHONE` char(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PASSWORD` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`EMAIL`, `UNAME`, `PHONE`, `PASSWORD`) VALUES
('ka48sunil007@gmail.com', 'Dheeraj', '8667661936', 'Dheer@j12345'),
('kumaaar48@gmail.com', 'Dheeraj V', '8667661936', 'Dheer@j12345');

--
-- Triggers `customer`
--
DELIMITER $$
CREATE TRIGGER `ONUPDATE` BEFORE UPDATE ON `customer` FOR EACH ROW INSERT INTO UPDATELOGS(EMAIL,UNAME,PHONE) select EMAIL,UNAME,PHONE from CUSTOMER WHERE EMAIL=NEW.EMAIL
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `Email` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `IP` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`Email`, `IP`) VALUES
('kumaaar48@gmail.com', '192.168.43.197');

--
-- Triggers `devices`
--
DELIMITER $$
CREATE TRIGGER `ONDEVICE` AFTER INSERT ON `devices` FOR EACH ROW INSERT INTO bulb_status (IP) (SELECT IP FROM devices WHERE EMAIL=NEW.EMAIL)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `id`
--

CREATE TABLE `id` (
  `IDNUM` char(7) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `id`
--

INSERT INTO `id` (`IDNUM`) VALUES
('ID00001');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `EMAIL` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `LOGIN` datetime DEFAULT CURRENT_TIMESTAMP,
  `LOGOUT` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`EMAIL`, `LOGIN`, `LOGOUT`) VALUES
('kumaaar48@gmail.com', '2018-11-27 15:14:03', '2018-11-27 15:17:42'),
('kumaaar48@gmail.com', '2018-11-27 15:18:03', '2018-11-27 15:18:26'),
('kumaaar48@gmail.com', '2018-11-27 15:18:37', '2018-11-27 15:18:50'),
('kumaaar48@gmail.com', '2018-11-27 15:19:09', '2018-11-27 15:23:29'),
('kumaaar48@gmail.com', '2018-11-27 15:36:05', '2018-11-27 15:48:10'),
('ka48sunil007@gmail.com', '2018-11-27 15:50:10', '2018-11-27 17:14:54'),
('kumaaar48@gmail.com', '2018-11-27 17:16:03', '2018-11-28 10:04:41'),
('kumaaar48@gmail.com', '2018-11-28 10:02:12', '2018-11-28 10:04:41');

-- --------------------------------------------------------

--
-- Table structure for table `sensor`
--

CREATE TABLE `sensor` (
  `IP` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `Humidity` int(11) NOT NULL,
  `Temparature` int(11) NOT NULL,
  `Time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sensor`
--

INSERT INTO `sensor` (`IP`, `Humidity`, `Temparature`, `Time`) VALUES
('192.168.43.197', 77, 51, '2018-11-27 17:20:54'),
('192.168.43.197', 77, 51, '2018-11-27 17:21:00'),
('192.168.43.197', 77, 51, '2018-11-27 17:21:07'),
('192.168.43.197', 77, 51, '2018-11-27 17:21:12'),
('192.168.43.197', 77, 51, '2018-11-27 17:21:18'),
('192.168.43.197', 73, 59, '2018-11-28 10:01:53'),
('192.168.43.197', 73, 58, '2018-11-28 10:01:59'),
('192.168.43.197', 73, 58, '2018-11-28 10:02:06'),
('192.168.43.197', 73, 57, '2018-11-28 10:02:12'),
('192.168.43.197', 73, 57, '2018-11-28 10:02:19'),
('192.168.43.197', 75, 57, '2018-11-28 10:02:25'),
('192.168.43.197', 73, 57, '2018-11-28 10:02:32'),
('192.168.43.197', 73, 57, '2018-11-28 10:02:39'),
('192.168.43.197', 73, 57, '2018-11-28 10:02:45'),
('192.168.43.197', 73, 57, '2018-11-28 10:02:51'),
('192.168.43.197', 73, 57, '2018-11-28 10:02:57'),
('192.168.43.197', 73, 57, '2018-11-28 10:03:02'),
('192.168.43.197', 73, 57, '2018-11-28 10:03:09'),
('192.168.43.197', 75, 56, '2018-11-28 10:04:16'),
('192.168.43.197', 75, 56, '2018-11-28 10:04:23'),
('192.168.43.197', 75, 56, '2018-11-28 10:04:29'),
('192.168.43.197', 75, 56, '2018-11-28 10:04:34'),
('192.168.43.197', 75, 56, '2018-11-28 10:04:41'),
('192.168.43.197', 75, 56, '2018-11-28 10:04:48');

-- --------------------------------------------------------

--
-- Table structure for table `updatelogs`
--

CREATE TABLE `updatelogs` (
  `EMAIL` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `UNAME` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `PHONE` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `UPDATETIME` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `updatelogs`
--

INSERT INTO `updatelogs` (`EMAIL`, `UNAME`, `PHONE`, `UPDATETIME`) VALUES
('kumaaar48@gmail.com', 'Dheeraj', '8667661936', '2018-11-07 18:12:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`IDNUM`,`EMAIL`),
  ADD KEY `ADMIN_ibfk_1` (`EMAIL`);

--
-- Indexes for table `bulb_status`
--
ALTER TABLE `bulb_status`
  ADD KEY `IP` (`IP`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`EMAIL`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`IP`),
  ADD KEY `Email` (`Email`);

--
-- Indexes for table `id`
--
ALTER TABLE `id`
  ADD PRIMARY KEY (`IDNUM`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD KEY `LOGS_ibfk_1` (`EMAIL`);

--
-- Indexes for table `sensor`
--
ALTER TABLE `sensor`
  ADD KEY `IP` (`IP`);

--
-- Indexes for table `updatelogs`
--
ALTER TABLE `updatelogs`
  ADD KEY `EMAIL` (`EMAIL`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `ADMIN_ibfk_1` FOREIGN KEY (`EMAIL`) REFERENCES `customer` (`EMAIL`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ADMIN_ibfk_2` FOREIGN KEY (`IDNUM`) REFERENCES `id` (`IDNUM`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `devices`
--
ALTER TABLE `devices`
  ADD CONSTRAINT `devices_ibfk_1` FOREIGN KEY (`Email`) REFERENCES `customer` (`EMAIL`);

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `LOGS_ibfk_1` FOREIGN KEY (`EMAIL`) REFERENCES `customer` (`EMAIL`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `updatelogs`
--
ALTER TABLE `updatelogs`
  ADD CONSTRAINT `UPDATELOGS_ibfk_1` FOREIGN KEY (`EMAIL`) REFERENCES `customer` (`EMAIL`) ON DELETE NO ACTION;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `Truncate` ON SCHEDULE EVERY 1 HOUR STARTS '2018-11-27 11:19:52' ON COMPLETION NOT PRESERVE ENABLE DO DELETE from sensor where time<now()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
