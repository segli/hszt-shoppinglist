-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 24, 2010 at 12:48 PM
-- Server version: 5.1.44
-- PHP Version: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shoppinglist`
--
DROP DATABASE IF EXISTS `shoppinglist`; 
CREATE DATABASE `shoppinglist`;
USE `shoppinglist`;
-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `bill_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `date_created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cost` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `shoppinglist_id` mediumint(8) unsigned NOT NULL,
  `user_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`bill_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `bill`
--


-- --------------------------------------------------------

--
-- Table structure for table `budget`
--

CREATE TABLE `budget` (
  `budget_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `time_start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `time_end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `budget_current` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `budget_quota` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `household_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`budget_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `budget`
--


-- --------------------------------------------------------

--
-- Table structure for table `household`
--

CREATE TABLE `household` (
  `household_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`household_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `household`
--

INSERT INTO `household` VALUES(1, 'JSWG');
INSERT INTO `household` VALUES(2, 'Simon Private');
INSERT INTO `household` VALUES(3, 'Thomas Private');
INSERT INTO `household` VALUES(4, 'Family');

-- --------------------------------------------------------

--
-- Table structure for table `invitation`
--

CREATE TABLE `invitation` (
  `inventation_id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(9) unsigned NOT NULL,
  `household_id` mediumint(9) unsigned NOT NULL,
  `pending` tinyint(4) unsigned NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`inventation_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `invitation`
--


-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `item_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `shoppinglist_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `item`
--

INSERT INTO `item` VALUES(1, 'liegestuhl', '', '75.0', 0, 1);
INSERT INTO `item` VALUES(2, 'sonnenschirm', '', '15.0', 0, 1);
INSERT INTO `item` VALUES(3, 'salat', 'aus der schweiz', '3.80', 0, 2);
INSERT INTO `item` VALUES(4, 'butter', '', '5.10', 0, 2);
INSERT INTO `item` VALUES(5, 'confiture', '', '3.95', 0, 2);
INSERT INTO `item` VALUES(6, 'eier', '', '1.10', 0, 3);
INSERT INTO `item` VALUES(7, 'zopf', '', '3.90', 0, 3);
INSERT INTO `item` VALUES(8, 'weissbrot', '', '3.20', 0, 3);
INSERT INTO `item` VALUES(9, 'sandwiches', '', '13.50', 0, 4);
INSERT INTO `item` VALUES(10, 'sandalen', '', '51.0', 0, 4);
INSERT INTO `item` VALUES(11, 'fernseher', '', '2900', 0, 5);
INSERT INTO `item` VALUES(12, 'fussball', '', '43.90', 0, 5);
INSERT INTO `item` VALUES(13, 'zahnpasta', '', '5.75', 0, 6);
INSERT INTO `item` VALUES(14, 'wc papier', '', '2.50', 0, 6);
INSERT INTO `item` VALUES(15, 'quark', '', '3.30', 0, 6);
INSERT INTO `item` VALUES(16, 'guetzli', '', '1.20', 0, 6);

-- --------------------------------------------------------

--
-- Table structure for table `shoppinglist`
--

CREATE TABLE `shoppinglist` (
  `shoppinglist_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_closed` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `household_id` mediumint(8) unsigned NOT NULL,
  `user_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`shoppinglist_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `shoppinglist`
--

INSERT INTO `shoppinglist` VALUES(1, 'ferien', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 1);
INSERT INTO `shoppinglist` VALUES(2, 'wocheneinkauf', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 1);
INSERT INTO `shoppinglist` VALUES(3, 'haushalt wg', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 3, 2);
INSERT INTO `shoppinglist` VALUES(4, 'ferien einkauf', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 4, 2);
INSERT INTO `shoppinglist` VALUES(5, 'geburi geschenke', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 1);
INSERT INTO `shoppinglist` VALUES(6, 'wünsche', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` VALUES(1, 'simon', '6db056887be232ff7ed8a9494396c03086eea35dbc00fb2745e2101d3c62f0f0', '1a07b20b4bda7', 'Simon', 'Egli');
INSERT INTO `user` VALUES(2, 'thomas', 'cfd582b85d869ece9831d31a991a45ea9f7157f15f57ca94333a1adc3ffb6002', '35f97f6b2a7a3', 'Thomas', 'Junghans');


-- --------------------------------------------------------

--
-- Table structure for table `user_household`
--

CREATE TABLE `user_household` (
  `user_household_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL,
  `household_id` mediumint(8) unsigned NOT NULL,
  `is_owner` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`user_household_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `user_household`
--

INSERT INTO `user_household` VALUES(1, 1, 1, 1);
INSERT INTO `user_household` VALUES(2, 1, 2, 1);
INSERT INTO `user_household` VALUES(3, 2, 3, 1);
INSERT INTO `user_household` VALUES(4, 2, 4, 1);
