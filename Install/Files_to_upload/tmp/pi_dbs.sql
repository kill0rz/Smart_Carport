CREATE DATABASE pi;
USE pi;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

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
  `tempfeuchtsens_use` int(11) NOT NULL,
  `soll_temp` int(11) NOT NULL,
  `soll_feucht` int(11) NOT NULL,
  `time_to_pause` double NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


INSERT INTO `tbl_settings` (`id`, `stopnow`, `runforever`, `time_to_run`, `startnewintervall`, `should_be_running`, `runned`, `tempsens_use`, `soll_temp`, `soll_feucht`, `time_to_pause`) VALUES
(1, 1, 0, 20, 0, 0, 0, 0, 0, 0, 0);

ALTER TABLE `tbl_settings`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_settings`
MODIFY `id` int(1) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;--

DROP TABLE IF EXISTS `tbl_queue`;
CREATE TABLE `tbl_queue` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `filepath` varchar(50) NOT NULL,
  `nowplaying` int(1) NOT NULL DEFAULT '0',
  `realname` varchar(900) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `tbl_queue`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;