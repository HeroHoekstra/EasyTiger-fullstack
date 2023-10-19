-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 19, 2023 at 12:03 PM
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
('1776197123819878', 'Eco Terrorism', 'Terrorism pop', 'Urk', 'Murder Kill Death :)'),
('1776817156889881', 'Scavs', 'Pearl music', 'Garbage Wastes', '*spears you from off screen*'),
('1778010407184912', 'Realistic Bart', 'Uhhh', 'Springfield', 'Eat short'),
('1779447080186996', 'Colon three', 'Boy kisser core', 'Den Helder', 'OOOOooOoOoh you like kissing boys');

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

--
-- Dumping data for table `bandleden`
--

INSERT INTO `bandleden` (`Lid_id`, `Band_id`, `Naam`, `Email`, `Telefoon`) VALUES
('1776197123821058', '1776197123819878', 'John McBalls', 'mcballs@eco.ter', '06 12345678'),
('1776197123822056', '1776197123819878', 'Josh', 'josh@eco.ter', '06 90123456'),
('1776817156896053', '1776817156889881', 'Scav n1', 'givmeporl@scav.com', '06 11231234'),
('1777364651816065', '1776817156889881', 'Scav n2', 'rockthrower@scav.com', '06 56789910'),
('1778010407195668', '1778010407184912', 'Bart', 'bart@bart.bart', '06 211820'),
('1778010407196744', '1778010407184912', 'Bort', 'bort@bort.bort', '06 2151820'),
('1778010407197028', '1778010407184912', 'Bert', 'bert@bert.bert', '06 251820'),
('1779447080195128', '1779447080186996', 'John McBalls pt2', 'boy@kisser.com', '06 96969696');

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
  `Naam` varchar(255) NOT NULL,
  `Datum` date DEFAULT NULL,
  `Starttijd` time DEFAULT NULL,
  `Entreegeld` decimal(10,2) DEFAULT NULL,
  `Drankgeld` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`Event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `evenementen`
--

INSERT INTO `evenementen` (`Event_id`, `Naam`, `Datum`, `Starttijd`, `Entreegeld`, `Drankgeld`) VALUES
('1778627131539287', 'Test event', '2023-12-31', '23:59:00', '15.00', NULL),
('1779910850361213', 'Test event n2', '2024-10-31', '12:00:00', '12.00', NULL),
('1779911602173817', 'test n3', '2023-12-13', '12:00:00', '69.00', NULL);

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
-- Dumping data for table `optredens`
--

INSERT INTO `optredens` (`Optreden_id`, `Event_id`, `Band_id`, `Sets`, `Starttijd`, `Eindtijd`) VALUES
('1778627131542144', '1778627131539287', '1776197123819878', 5, '00:00:00', '00:30:00'),
('1778627131547477', '1778627131539287', '1776817156889881', 7, '00:30:00', '01:00:00'),
('1778627131551590', '1778627131539287', '1778010407184912', 6, '01:30:00', '02:00:00'),
('1779910850395458', '1779910850361213', '1776817156889881', 7, '13:00:00', '14:00:00'),
('1779911602181899', '1779911602173817', '1778010407184912', 10, '12:00:00', '13:00:00'),
('1779911602187544', '1779911602173817', '1776197123819878', 10, '13:00:00', '14:00:00'),
('1779911602195559', '1779911602173817', '1776817156889881', 10, '14:00:00', '15:00:00'),
('1779911602199025', '1779911602173817', '1779447080186996', 10, '15:00:00', '16:00:00');

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
