-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2014 at 07:08 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ptcbase`
--

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE IF NOT EXISTS `ads` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(100) NOT NULL,
  `Link` varchar(200) NOT NULL,
  `Views` int(11) NOT NULL DEFAULT '0',
  `ViewLimit` int(11) NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT '1',
  `Pays` float NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `passmd5` varchar(32) NOT NULL,
  `email` varchar(30) NOT NULL,
  `country` varchar(50) NOT NULL,
  `paymenttype1` varchar(50) NOT NULL,
  `paymenttype2` varchar(50) NOT NULL,
  `paymenttype3` varchar(100) NOT NULL,
  `balance` float NOT NULL DEFAULT '0',
  `paid` float NOT NULL DEFAULT '0',
  `unpaid` float NOT NULL DEFAULT '0',
  `membership` varchar(20) NOT NULL DEFAULT 'Standard',
  `selfclick` int(11) NOT NULL DEFAULT '0',
  `refclick` int(11) NOT NULL DEFAULT '0',
  `selfclickearn` float NOT NULL DEFAULT '0',
  `refclickearn` float NOT NULL DEFAULT '0',
  `referredby` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `siteinfo`
--

CREATE TABLE IF NOT EXISTS `siteinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `link` varchar(100) NOT NULL,
  `header` varchar(50) NOT NULL,
  `payment1` varchar(20) NOT NULL,
  `payment2` varchar(20) NOT NULL,
  `payment3` varchar(20) NOT NULL,
  `minimumtowithdraw` float NOT NULL,
  `adminuser` varchar(50) NOT NULL,
  `adminpass` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `siteinfo`
--

INSERT INTO `siteinfo` (`id`, `title`, `link`, `header`, `payment1`, `payment2`, `payment3`, `minimumtowithdraw`, `adminuser`, `adminpass`) VALUES
(1, 'BD View', 'http://www.bdview.com/', 'BD View', 'Payza Email', 'Bkash Number', 'Bank Account Details', 100, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `view`
--

CREATE TABLE IF NOT EXISTS `view` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `MemberId` int(11) NOT NULL,
  `AdId` int(11) NOT NULL,
  `isViewed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
