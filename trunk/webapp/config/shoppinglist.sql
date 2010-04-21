-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 21, 2010 at 11:19 PM
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

DROP TABLE IF EXISTS `bill`;
CREATE TABLE IF NOT EXISTS `bill` (
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

DROP TABLE IF EXISTS `budget`;
CREATE TABLE IF NOT EXISTS `budget` (
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

DROP TABLE IF EXISTS `household`;
CREATE TABLE IF NOT EXISTS `household` (
  `household_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`household_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

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

DROP TABLE IF EXISTS `invitation`;
CREATE TABLE IF NOT EXISTS `invitation` (
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

DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `item_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `shoppinglist_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `item`
--


-- --------------------------------------------------------

--
-- Table structure for table `shoppinglist`
--

DROP TABLE IF EXISTS `shoppinglist`;
CREATE TABLE IF NOT EXISTS `shoppinglist` (
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

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` VALUES(1, 'simon', 'ccf7e9e8f7e8a763b26d739dc4ce31a2b61f168b', '1234', 'Simon', 'Egli');
INSERT INTO `user` VALUES(2, 'thomas', '0c5a36f8c1150b5960a56ef534f29320672f5fba', '1234', 'Thomas', 'Junghans');

-- --------------------------------------------------------

--
-- Table structure for table `user_household`
--

DROP TABLE IF EXISTS `user_household`;
CREATE TABLE IF NOT EXISTS `user_household` (
  `user_household_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL,
  `household_id` mediumint(8) unsigned NOT NULL,
  `is_owner` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`user_household_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user_household`
--

INSERT INTO `user_household` VALUES(1, 1, 1, 1);
INSERT INTO `user_household` VALUES(2, 1, 2, 1);
INSERT INTO `user_household` VALUES(3, 2, 3, 1);
INSERT INTO `user_household` VALUES(4, 2, 4, 1);
