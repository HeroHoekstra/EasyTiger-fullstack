-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 18, 2023 at 07:05 AM
-- Server version: 5.7.40
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `easy_tiger_patio`
--

-- --------------------------------------------------------

--
-- Table structure for table `band`
--

DROP TABLE IF EXISTS `band`;
CREATE TABLE IF NOT EXISTS `band` (
  `Band_id` varchar(20) NOT NULL,
  `Naam` varchar(250) DEFAULT NULL,
  `Genre` varchar(250) DEFAULT NULL,
  `Herkomst` varchar(250) DEFAULT NULL,
  `Omschrijving` text,
  PRIMARY KEY (`Band_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `band`
--

INSERT INTO `band` (`Band_id`, `Naam`, `Genre`, `Herkomst`, `Omschrijving`) VALUES
('1769842275767399', 'Coole naam', 'Sex music', 'The moon', 'men <3');

-- --------------------------------------------------------

--
-- Table structure for table `bandleden`
--

DROP TABLE IF EXISTS `bandleden`;
CREATE TABLE IF NOT EXISTS `bandleden` (
  `Lid_id` varchar(20) NOT NULL,
  `Band_id` varchar(20) NOT NULL,
  `Naam` varchar(250) DEFAULT NULL,
  `Email` varchar(250) DEFAULT NULL,
  `Telefoon` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`Lid_id`),
  KEY `fk_Bandleden_Band_idx` (`Band_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bezoeker`
--

DROP TABLE IF EXISTS `bezoeker`;
CREATE TABLE IF NOT EXISTS `bezoeker` (
  `Bezoeker_id` varchar(20) NOT NULL,
  `Username` varchar(250) NOT NULL,
  `Email` varchar(350) NOT NULL,
  `Postcode` varchar(20) DEFAULT NULL,
  `Pass` varchar(250) NOT NULL,
  `Is_Admin` tinyint(4) NOT NULL,
  PRIMARY KEY (`Bezoeker_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bezoeker`
--

INSERT INTO `bezoeker` (`Bezoeker_id`, `Username`, `Email`, `Postcode`, `Pass`, `Is_Admin`) VALUES
('1770030402268549', 'a', 'a@a.a', 'a', '$2y$10$WNXlXx0ADcy7uPoTitN8fuD4sMF2yF2bqmSVSe56HP1ImjhBFpkYq', 0),
('1770031092080941', 'b', 'b@b.b', 'b', '$2y$10$OY3Z3tEb7F0vk17.pKoWPumLimNu20HxJm6EAjtsSKoo0Sz0y2Kga', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bezoekers_events`
--

DROP TABLE IF EXISTS `bezoekers_events`;
CREATE TABLE IF NOT EXISTS `bezoekers_events` (
  `Bezoeker_id` varchar(20) NOT NULL,
  `Event_id` varchar(20) NOT NULL,
  PRIMARY KEY (`Bezoeker_id`,`Event_id`),
  KEY `fk_Bezoeker_has_Evenementen_Evenementen1_idx` (`Event_id`),
  KEY `fk_Bezoeker_has_Evenementen_Bezoeker1_idx` (`Bezoeker_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `evenementen`
--

DROP TABLE IF EXISTS `evenementen`;
CREATE TABLE IF NOT EXISTS `evenementen` (
  `Event_id` varchar(20) NOT NULL,
  `Datum` date DEFAULT NULL,
  `Starttijd` time DEFAULT NULL,
  `Entreegeld` decimal(10,2) DEFAULT NULL,
  `Drankgeld` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`Event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `optredens`
--

DROP TABLE IF EXISTS `optredens`;
CREATE TABLE IF NOT EXISTS `optredens` (
  `Optreden_id` varchar(20) NOT NULL,
  `Event_id` varchar(20) NOT NULL,
  `Band_id` varchar(20) NOT NULL,
  `Sets` int(5) DEFAULT NULL,
  `Starttijd` time DEFAULT NULL,
  `Eindtijd` time DEFAULT NULL,
  PRIMARY KEY (`Optreden_id`,`Event_id`),
  KEY `fk_Optredens_Evenementen1_idx` (`Event_id`),
  KEY `fk_Optredens_Band1_idx` (`Band_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bandleden`
--
ALTER TABLE `bandleden`
  ADD CONSTRAINT `fk_Bandleden_Band` FOREIGN KEY (`Band_id`) REFERENCES `band` (`Band_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `bezoekers_events`
--
ALTER TABLE `bezoekers_events`
  ADD CONSTRAINT `fk_Bezoeker_has_Evenementen_Bezoeker1` FOREIGN KEY (`Bezoeker_id`) REFERENCES `bezoeker` (`Bezoeker_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Bezoeker_has_Evenementen_Evenementen1` FOREIGN KEY (`Event_id`) REFERENCES `evenementen` (`Event_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `optredens`
--
ALTER TABLE `optredens`
  ADD CONSTRAINT `fk_Optredens_Band1` FOREIGN KEY (`Band_id`) REFERENCES `band` (`Band_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Optredens_Evenementen1` FOREIGN KEY (`Event_id`) REFERENCES `evenementen` (`Event_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
