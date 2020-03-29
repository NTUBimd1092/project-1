-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生日期: 2020 年 03 月 29 日 05:23
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
-- 表的結構 `menber`
--

CREATE TABLE IF NOT EXISTS `menber` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `account` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 轉存資料表中的資料 `menber`
--

INSERT INTO `menber` (`id`, `account`, `password`, `level`) VALUES
(1, 'admin@gmail.com', '1234', 1),
(2, 'menber@gmail.com', '1234', 0);

-- --------------------------------------------------------

--
-- 表的結構 `page_data`
--

CREATE TABLE IF NOT EXISTS `page_data` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pdf` varchar(255) DEFAULT NULL,
  `content` text,
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `page_name` varchar(255) DEFAULT NULL,
  `sort` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

--
-- 轉存資料表中的資料 `page_data`
--

INSERT INTO `page_data` (`id`, `pdf`, `content`, `datetime`, `page_name`, `sort`) VALUES
(1, 'pyhon', 'python content insert test', '2020-03-13 14:31:09', '', NULL),
(4, 'pyhon', 'pytht', '2020-03-13 17:35:12', '', NULL),
(5, '檔名', '內容', '2020-03-13 17:45:20', '', 'IT產業'),
(6, '檔名', '內容', '2020-03-13 17:46:19', 'root', 'IT產業'),
(7, '檔名', '內容', '2020-03-13 17:46:56', '', 'IT產業'),
(8, '檔名', '內容', '2020-03-13 18:00:56', '', 'IT產業'),
(9, '檔名', '內容', '2020-03-13 18:10:25', '123', 'IT產業'),
(10, '檔名', '內容', '2020-03-13 18:10:35', '123', 'IT產業'),
(11, '檔名', '內容', '2020-03-13 18:51:31', '網站名稱', '分類'),
(12, '檔名', '內容', '2020-03-13 18:51:59', '網站名稱', '分類'),
(13, 'pdf', 'content', '2020-03-13 19:17:17', 'page_name', 'sort'),
(14, 'pdf', 'content', '2020-03-13 19:21:56', 'page_name', 'sort'),
(15, 'pdf', 'content', '2020-03-19 15:46:21', 'page_name', 'sort'),
(16, '阿', '屋', '2020-03-19 16:06:13', '一', '挖'),
(17, '阿', '屋', '2020-03-19 16:06:49', '一', '挖'),
(18, '', '屋', '2020-03-19 16:10:51', '一', '挖'),
(19, 'Business & Technology Thought Leadership | Accenture', '屋', '2020-03-19 16:11:15', '一', '挖'),
(20, 'Business & Technology Thought Leadership | Accenture', '屋', '2020-03-19 16:11:51', '一', '挖'),
(21, 'Business & Technology Thought Leadership | Accenture', '屋', '2020-03-19 16:12:07', '一', '挖'),
(22, '埃森哲技术展望2020 | Accenture', '屋', '2020-03-19 16:18:07', '一', '挖'),
(23, '埃森哲技术展望2020 | Accenture', '屋', '2020-03-19 16:19:52', '一', 'None'),
(24, '埃森哲技术展望2020 | Accenture', '屋', '2020-03-19 16:35:25', '一', '挖'),
(25, '埃森哲技术展望2020 | Accenture', '屋', '2020-03-19 16:36:58', '一', '挖'),
(26, '', '企業', '2020-03-20 14:27:29', '埃森哲技术展望2020 | Accenture', ''),
(27, 'pdf', 'content', '2020-03-20 18:25:16', '埃森哲技术展望2020 | Accenture', 'sort'),
(28, '', '企?必?直面?一??，??技??世界?得更美好的承?。 \n', '2020-03-20 18:31:55', '埃森哲技术展望2020 | Accenture', ''),
(29, '', '企?必?直面?一??，??技??世界?得更美好的承?。 \n', '2020-03-20 18:35:09', '埃森哲技术展望2020 | Accenture', ''),
(30, '', '企?必?直面?一??，??技??世界?得更美好的承?。 \n', '2020-03-20 18:35:35', '展', ''),
(31, '', '企?必?直面?一??，??技??世界?得更美好的承?。 \n', '2020-03-20 18:35:55', 'A', ''),
(32, '', '企?必?直面?一??，??技??世界?得更美好的承?。 \n', '2020-03-20 18:36:47', 'A', ''),
(33, '', '企?必?直面?一??，??技??世界?得更美好的承?。 \n', '2020-03-20 18:37:08', 'Accenture', ''),
(34, '', '企?必?直面?一??，??技??世界?得更美好的承?。 \n', '2020-03-20 18:45:11', 'Accenture', ''),
(35, '', '企?必?直面?一??，??技??世界?得更美好的承?。 \n', '2020-03-20 18:45:21', 'Accenture', ''),
(36, '', '企业必须直面这一问题，兑现技术让世界变得更美好的承诺。 \n', '2020-03-27 20:18:06', 'Accenture', ''),
(37, '', '企业必须直面这一问题，兑现技术让世界变得更美好的承诺。 \n', '2020-03-27 20:18:24', 'Accenture', ''),
(38, '我是檔', '我是內容', '2020-03-29 02:17:03', '我是網名', '我是分類');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
