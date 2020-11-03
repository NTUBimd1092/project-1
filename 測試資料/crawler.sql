-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生日期: 2020 年 11 月 03 日 09:11
-- 伺服器版本: 5.6.12-log
-- PHP 版本: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫: `crawler`
--
CREATE DATABASE IF NOT EXISTS `crawler` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `crawler`;

-- --------------------------------------------------------

--
-- 表的結構 `localtion`
--

CREATE TABLE IF NOT EXISTS `localtion` (
  `houseid` int(10) NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的結構 `money_change`
--

CREATE TABLE IF NOT EXISTS `money_change` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `Link` varchar(255) NOT NULL COMMENT 'foreign key 網站Link',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `money` int(10) NOT NULL,
  PRIMARY KEY (`id`,`Link`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14920 ;

-- --------------------------------------------------------

--
-- 表的結構 `page_data`
--

CREATE TABLE IF NOT EXISTS `page_data` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `WebName` varchar(255) DEFAULT NULL,
  `images` text NOT NULL,
  `Link` varchar(255) DEFAULT NULL,
  `house` varchar(255) DEFAULT NULL,
  `adress` varchar(255) DEFAULT NULL,
  `money` int(10) DEFAULT NULL,
  `house_type` varchar(255) NOT NULL,
  `floor` varchar(10) NOT NULL,
  `square_meters` float NOT NULL,
  `pattern` varchar(10) NOT NULL COMMENT '房,廳,衛,室',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Is_Delete` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14669 ;

-- --------------------------------------------------------

--
-- 表的結構 `subscription`
--

CREATE TABLE IF NOT EXISTS `subscription` (
  `userid` int(10) NOT NULL,
  `Link` varchar(255) NOT NULL,
  PRIMARY KEY (`userid`,`Link`),
  KEY `Link` (`Link`),
  KEY `Link_2` (`Link`),
  KEY `Link_3` (`Link`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的結構 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `account` mediumtext NOT NULL,
  `password` mediumtext NOT NULL,
  `name` mediumtext NOT NULL,
  `image` mediumtext NOT NULL,
  `phone` mediumtext NOT NULL,
  `subscribe` varchar(1) NOT NULL DEFAULT '0' COMMENT '1有通知;0無通知',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
