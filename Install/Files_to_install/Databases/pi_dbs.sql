-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 26, 2016 at 03:33 AM
-- Server version: 5.5.44-0+deb8u1
-- PHP Version: 5.6.20-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pi`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

DROP TABLE IF EXISTS `tbl_settings`;
CREATE TABLE IF NOT EXISTS `tbl_settings` (
`id` int(1) NOT NULL,
  `stopnow` int(1) NOT NULL,
  `runforever` int(1) NOT NULL,
  `time_to_run` double NOT NULL,
  `startnewintervall` int(1) NOT NULL DEFAULT '0',
  `should_be_running` int(11) NOT NULL DEFAULT '0',
  `runned` int(11) DEFAULT '0',
  `paused` int(11) DEFAULT '0',
  `feuchtsens_use` int(11) NOT NULL,
  `tempsens_use` int(11) NOT NULL,
  `tempsens_temp` int(11) NOT NULL,
  `feuchtsens_feucht` int(11) NOT NULL,
  `time_to_pause` double NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_settings`
--

INSERT INTO `tbl_settings` (`id`, `stopnow`, `runforever`, `time_to_run`, `startnewintervall`, `should_be_running`, `runned`, `feuchtsens_use`, `tempsens_use`, `tempsens_temp`, `feuchtsens_feucht`, `time_to_pause`) VALUES
(1, 1, 0, 20, 0, 0, 0, 0, 0, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
MODIFY `id` int(1) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;--
-- Database: `pi_m`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_queue`
--

DROP TABLE IF EXISTS `tbl_queue`;
CREATE TABLE `tbl_queue` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `filepath` varchar(50) NOT NULL,
  `nowplaying` int(1) NOT NULL DEFAULT '0',
  `realname` varchar(900) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_queue`
--
ALTER TABLE `tbl_queue`
 ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_queue`
--
ALTER TABLE `tbl_queue`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
