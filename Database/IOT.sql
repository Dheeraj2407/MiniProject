-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 15, 2019 at 11:53 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `IOT`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `LOGOUT` (IN `UNAME` VARCHAR(30))  UPDATE LOGS SET LOGOUT=NOW() WHERE EMAIL=UNAME AND LOGOUT IS NULL$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ADMIN`
--

CREATE TABLE `ADMIN` (
  `EMAIL` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `IDNUM` char(7) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ADMIN`
--

INSERT INTO `ADMIN` (`EMAIL`, `IDNUM`) VALUES
('kumaaar48@gmail.com', 'ID00001');

--
-- Triggers `ADMIN`
--
DELIMITER $$
CREATE TRIGGER `ONLOGIN` BEFORE INSERT ON `ADMIN` FOR EACH ROW UPDATE LOGS SET LOGOUT=NOW() WHERE NEW.EMAIL=EMAIL AND LOGOUT IS NULL
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `CUSTOMER`
--

CREATE TABLE `CUSTOMER` (
  `EMAIL` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `UNAME` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PHONE` char(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PASSWORD` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `channelid` varchar(8) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `CUSTOMER`
--

INSERT INTO `CUSTOMER` (`EMAIL`, `UNAME`, `PHONE`, `PASSWORD`, `channelid`) VALUES
('kumaaar48@gmail.com', 'Dheeraj', '8667661936', 'Dheer@j12345', '877932');

--
-- Triggers `CUSTOMER`
--
DELIMITER $$
CREATE TRIGGER `ONUPDATE` BEFORE UPDATE ON `CUSTOMER` FOR EACH ROW INSERT INTO UPDATELOGS(EMAIL,UNAME,PHONE) select EMAIL,UNAME,PHONE from CUSTOMER WHERE EMAIL=NEW.EMAIL
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ID`
--

CREATE TABLE `ID` (
  `IDNUM` char(7) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ID`
--

INSERT INTO `ID` (`IDNUM`) VALUES
('ID00001');

-- --------------------------------------------------------

--
-- Table structure for table `LOGS`
--

CREATE TABLE `LOGS` (
  `EMAIL` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `LOGIN` datetime DEFAULT current_timestamp(),
  `LOGOUT` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `UPDATELOGS`
--

CREATE TABLE `UPDATELOGS` (
  `EMAIL` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `UNAME` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `PHONE` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `UPDATETIME` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `UPDATELOGS`
--

INSERT INTO `UPDATELOGS` (`EMAIL`, `UNAME`, `PHONE`, `UPDATETIME`) VALUES
('kumaaar48@gmail.com', 'Dheeraj', '8667661936', '2019-10-03 18:35:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ADMIN`
--
ALTER TABLE `ADMIN`
  ADD PRIMARY KEY (`IDNUM`,`EMAIL`),
  ADD KEY `ADMIN_ibfk_1` (`EMAIL`);

--
-- Indexes for table `CUSTOMER`
--
ALTER TABLE `CUSTOMER`
  ADD PRIMARY KEY (`EMAIL`);

--
-- Indexes for table `ID`
--
ALTER TABLE `ID`
  ADD PRIMARY KEY (`IDNUM`);

--
-- Indexes for table `LOGS`
--
ALTER TABLE `LOGS`
  ADD KEY `LOGS_ibfk_1` (`EMAIL`);

--
-- Indexes for table `UPDATELOGS`
--
ALTER TABLE `UPDATELOGS`
  ADD KEY `EMAIL` (`EMAIL`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ADMIN`
--
ALTER TABLE `ADMIN`
  ADD CONSTRAINT `ADMIN_ibfk_1` FOREIGN KEY (`EMAIL`) REFERENCES `CUSTOMER` (`EMAIL`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `ADMIN_ibfk_2` FOREIGN KEY (`IDNUM`) REFERENCES `ID` (`IDNUM`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LOGS`
--
ALTER TABLE `LOGS`
  ADD CONSTRAINT `LOGS_ibfk_1` FOREIGN KEY (`EMAIL`) REFERENCES `CUSTOMER` (`EMAIL`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `UPDATELOGS`
--
ALTER TABLE `UPDATELOGS`
  ADD CONSTRAINT `UPDATELOGS_ibfk_1` FOREIGN KEY (`EMAIL`) REFERENCES `CUSTOMER` (`EMAIL`) ON DELETE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `Truncate` ON SCHEDULE EVERY 1 HOUR STARTS '2018-11-27 11:19:52' ON COMPLETION NOT PRESERVE ENABLE DO DELETE from SENSOR where time<now()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
