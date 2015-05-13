-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2015 at 04:44 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `prt451gr_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE IF NOT EXISTS `equipment` (
  `equipmentid` int(11) NOT NULL,
  `repairid` int(11) NOT NULL,
  `equipmentname` varchar(32) NOT NULL,
  `assetno` varchar(32) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `repairs`
--

CREATE TABLE IF NOT EXISTS `repairs` (
  `repairid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `location` varchar(16) NOT NULL DEFAULT '',
  `duedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `completion` int(11) NOT NULL DEFAULT '-1',
  `priority` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `repairs`
--

INSERT INTO `repairs` (`repairid`, `userid`, `location`, `duedate`, `completion`, `priority`) VALUES
(2, 1, '', '2015-05-12 22:28:42', -1, 0),
(5, 1, '', '2015-05-13 02:36:12', -1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userid` int(11) NOT NULL,
  `hash` varchar(256) NOT NULL,
  `salt` varchar(256) NOT NULL,
  `username` varchar(32) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `hash`, `salt`, `username`) VALUES
(1, 'aacc0e763cdeed8ff874375b7980bf8565577886f5adcf3469d90dea4327bc63', 'LAKN6FSPi+mTD4BtV7Wqerujjasyc74P42Y5m2x7uJOxR/bO074EIE11BJ/NNqB8rV7o17FWTEUp4jOavlPGiCiOpA6s63dLQAYUZVoQbYsgML8R3mZRX69S6YsIsjT7ThDbl1cBWkprIlHiWz50nQBfftGXvGv37HOlx8irYCw=', 'TestUser');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`equipmentid`), ADD KEY `repairid` (`repairid`);

--
-- Indexes for table `repairs`
--
ALTER TABLE `repairs`
  ADD PRIMARY KEY (`repairid`), ADD KEY `userid` (`userid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`), ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `equipmentid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `repairs`
--
ALTER TABLE `repairs`
  MODIFY `repairid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `equipment`
--
ALTER TABLE `equipment`
ADD CONSTRAINT `equipment_ibfk_1` FOREIGN KEY (`repairid`) REFERENCES `repairs` (`repairid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `repairs`
--
ALTER TABLE `repairs`
ADD CONSTRAINT `repairs_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
