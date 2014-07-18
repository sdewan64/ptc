-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2014 at 12:05 AM
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

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`Id`, `Title`, `Link`, `Views`, `ViewLimit`, `IsActive`, `Pays`) VALUES
(9, 'AI Nixon', 'http://www.ainixon.me/', 3, 30, 1, 5);

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

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `username`, `password`, `passmd5`, `email`, `country`, `paymenttype1`, `paymenttype2`, `paymenttype3`, `balance`, `paid`, `unpaid`, `membership`, `selfclick`, `refclick`, `selfclickearn`, `refclickearn`, `referredby`) VALUES
(1, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'sdewan64@gmail.com', 'Bangladesh', 'sdewan64@gmail.com', 'sdewan64@gmail.com', '01674992893', 32.5, 5, 855, 'Standard', 1, 10, 5, 27.5, 'admin'),
(2, 'sdewan64', 'sandle', '0f39c1eb338a533c0c60151d0d4c4965', 'asad@ad.com', 'Bangladesh', 'asad@ad.com', 'asad@ad.com', 'asad@ad.com', 25, 0, 0, 'Standard', 4, 0, 25, 0, 'admin'),
(3, 'asad', 'asd', '7815696ecbf1c96e6894b779456d330e', 'dd@dd.cc', 'Bangladesh', 'ads', 'dasdas', 'd', 27.5, 0, 0, 'Standard', 5, 1, 25, 2.5, 'admin'),
(4, 'poll', 'asd', '7815696ecbf1c96e6894b779456d330e', 'ff@s.d', 'Vanuatu', 'fg', 'fgfg', 'gf', 5, 0, 333, 'Standard', 1, 0, 5, 0, 'asad'),
(5, 'cvxv', 'zxc', '5fa72358f0b4fb4f2c5d7de8c9a41846', 'dd@dd.ccss', 'Bangladesh', 'sdf', 'fds', 'fds', 0, 0, 55, 'Standard', 0, 0, 0, 0, 'admin'),
(6, 'fkfg', 'kkj', 'dd7a506c589afcb146f0887b4c0cefdc', 'dd@dd.ccd', 'Bangladesh', 'fds', 'fds', 'sdf', 0, 505, 0, 'Standard', 0, 0, 0, 0, 'admin'),
(7, 'uty', 'ool', '6b29ac0a53114c539f06d5e58f50de0a', 'ffd@dfg.cf', 'Bangladesh', 'dg', 'df', 'gdf', 0, 111, 0, 'Standard', 0, 0, 0, 0, 'admin'),
(8, 'lolil', 'lopo', 'dff0f68cc126bff362b06b1088b84140', 'dd@dd.ccsss', 'AntiguaBarbuda', 'fdsdf', 'sdf', 'sdf', 0, 0, 0, 'Standard', 0, 0, 0, 0, 'admin');

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

--
-- Dumping data for table `view`
--

INSERT INTO `view` (`id`, `MemberId`, `AdId`, `isViewed`) VALUES
(1, 1, 1, 0),
(2, 2, 1, 0),
(4, 3, 1, 0),
(5, 1, 2, 0),
(6, 2, 2, 1),
(7, 3, 2, 0),
(8, 1, 3, 0),
(9, 2, 3, 0),
(10, 3, 3, 0),
(19, 1, 9, 1),
(20, 3, 9, 0),
(21, 5, 9, 0),
(22, 6, 9, 0),
(23, 8, 9, 0),
(24, 4, 9, 0),
(25, 2, 9, 1),
(26, 7, 9, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
