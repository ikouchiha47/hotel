-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 19, 2013 at 05:19 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hotelbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE IF NOT EXISTS `bookings` (
  `bookID` int(11) NOT NULL AUTO_INCREMENT,
  `hotelID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `managerID` int(11) NOT NULL,
  `takenrooms` int(11) NOT NULL,
  `takenbeds` varchar(11) NOT NULL,
  `checkin` varchar(12) NOT NULL,
  `checkout` varchar(12) NOT NULL,
  `confirm` tinyint(4) NOT NULL DEFAULT '0',
  `bookdate` date NOT NULL,
  PRIMARY KEY (`bookID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `customerID` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `email` varchar(60) NOT NULL,
  `pass` varchar(100) NOT NULL,
  PRIMARY KEY (`customerID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `geonames`
--

CREATE TABLE IF NOT EXISTS `geonames` (
  `country_name` varchar(100) DEFAULT NULL,
  `country_code` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE IF NOT EXISTS `hotels` (
  `hotelID` int(11) NOT NULL AUTO_INCREMENT,
  `managerID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `rooms` int(11) NOT NULL,
  `rating` int(11) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `tags` varchar(100) NOT NULL,
  `pricebed` int(4) NOT NULL DEFAULT '100',
  `verify` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`hotelID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE IF NOT EXISTS `manager` (
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `managerID` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(60) NOT NULL,
  `pass` varchar(100) NOT NULL,
  PRIMARY KEY (`managerID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `bookID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `managerID` int(11) NOT NULL,
  `payable` int(50) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `taglist`
--

CREATE TABLE IF NOT EXISTS `taglist` (
  `tagid` int(11) NOT NULL AUTO_INCREMENT,
  `tagname` varchar(50) NOT NULL,
  PRIMARY KEY (`tagid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;
