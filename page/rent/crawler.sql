-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生日期: 2020 年 05 月 18 日 13:54
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
-- 表的結構 `money_change`
--

CREATE TABLE IF NOT EXISTS `money_change` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `Link` varchar(255) NOT NULL COMMENT 'foreign key 網站Link',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `money` int(10) NOT NULL,
  `userid` int(10) NOT NULL DEFAULT '2' COMMENT 'foreign key `user` ''id''',
  PRIMARY KEY (`id`,`Link`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=121 ;

--
-- 轉存資料表中的資料 `money_change`
--

INSERT INTO `money_change` (`id`, `Link`, `date`, `money`, `userid`) VALUES
(1, 'https://www.sinyi.com.tw/rent/houseno/C215430', '2020-05-18 21:25:21', 30000, 2),
(2, 'https://www.sinyi.com.tw/rent/houseno/C208020', '2020-05-18 21:25:21', 29000, 2),
(3, 'https://www.sinyi.com.tw/rent/houseno/C221012', '2020-05-18 21:25:21', 13500, 2),
(4, 'https://www.sinyi.com.tw/rent/houseno/C219198', '2020-05-18 21:25:21', 85000, 2),
(5, 'https://www.sinyi.com.tw/rent/houseno/C219237', '2020-05-18 21:25:21', 65000, 2),
(6, 'https://www.sinyi.com.tw/rent/houseno/C208931', '2020-05-18 21:25:21', 75000, 2),
(7, 'https://www.sinyi.com.tw/rent/houseno/C220585', '2020-05-18 21:25:21', 35000, 2),
(8, 'https://www.sinyi.com.tw/rent/houseno/C212731', '2020-05-18 21:25:21', 55000, 2),
(9, 'https://www.sinyi.com.tw/rent/houseno/C220582', '2020-05-18 21:25:21', 50000, 2),
(10, 'https://www.sinyi.com.tw/rent/houseno/C220292', '2020-05-18 21:25:21', 35000, 2),
(11, 'https://www.sinyi.com.tw/rent/houseno/C211394', '2020-05-18 21:25:21', 48000, 2),
(12, 'https://www.sinyi.com.tw/rent/houseno/C215460', '2020-05-18 21:25:21', 39000, 2),
(13, 'https://www.sinyi.com.tw/rent/houseno/C210064', '2020-05-18 21:25:21', 82000, 2),
(14, 'https://www.sinyi.com.tw/rent/houseno/C219872', '2020-05-18 21:25:21', 41000, 2),
(15, 'https://www.sinyi.com.tw/rent/houseno/C220675', '2020-05-18 21:25:21', 27000, 2),
(16, 'https://www.sinyi.com.tw/rent/houseno/C203575', '2020-05-18 21:25:21', 32000, 2),
(17, 'https://www.sinyi.com.tw/rent/houseno/C203184', '2020-05-18 21:25:22', 88000, 2),
(18, 'https://www.sinyi.com.tw/rent/houseno/C219906', '2020-05-18 21:25:22', 145000, 2),
(19, 'https://www.sinyi.com.tw/rent/houseno/C206480', '2020-05-18 21:25:22', 22000, 2),
(20, 'https://www.sinyi.com.tw/rent/houseno/C202895', '2020-05-18 21:25:22', 50000, 3),
(21, 'https://www.sinyi.com.tw/rent/houseno/C202643', '2020-05-18 21:25:22', 22000, 3),
(22, 'https://www.sinyi.com.tw/rent/houseno/C212706', '2020-05-18 21:25:22', 32000, 2),
(23, 'https://www.sinyi.com.tw/rent/houseno/C215940', '2020-05-18 21:25:22', 30000, 2),
(24, 'https://www.sinyi.com.tw/rent/houseno/C217036', '2020-05-18 21:25:22', 27000, 2),
(25, 'https://www.sinyi.com.tw/rent/houseno/C217034', '2020-05-18 21:25:22', 18500, 2),
(26, 'https://www.sinyi.com.tw/rent/houseno/C211030', '2020-05-18 21:25:22', 200000, 2),
(27, 'https://www.sinyi.com.tw/rent/houseno/C213224', '2020-05-18 21:25:22', 23000, 2),
(28, 'https://www.sinyi.com.tw/rent/houseno/C217380', '2020-05-18 21:25:22', 18500, 2),
(29, 'https://www.sinyi.com.tw/rent/houseno/C207132', '2020-05-18 21:25:22', 24000, 2),
(30, 'https://www.sinyi.com.tw/rent/houseno/C208993', '2020-05-18 21:25:22', 21000, 2),
(31, 'https://www.sinyi.com.tw/rent/houseno/C214003', '2020-05-18 21:25:22', 76000, 2),
(32, 'https://www.sinyi.com.tw/rent/houseno/C215519', '2020-05-18 21:25:22', 35000, 2),
(33, 'https://www.sinyi.com.tw/rent/houseno/C217648', '2020-05-18 21:25:22', 45000, 2),
(34, 'https://www.sinyi.com.tw/rent/houseno/C217646', '2020-05-18 21:25:22', 16000, 2),
(35, 'https://www.sinyi.com.tw/rent/houseno/C207876', '2020-05-18 21:25:22', 16000, 3),
(36, 'https://www.sinyi.com.tw/rent/houseno/C210690', '2020-05-18 21:25:22', 15000, 2),
(37, 'https://www.sinyi.com.tw/rent/houseno/C216511', '2020-05-18 21:25:22', 15000, 2),
(38, 'https://www.sinyi.com.tw/rent/houseno/C210398', '2020-05-18 21:25:23', 17000, 2),
(39, 'https://www.sinyi.com.tw/rent/houseno/C215599', '2020-05-18 21:25:23', 75000, 2),
(40, 'https://www.sinyi.com.tw/rent/houseno/C212776', '2020-05-18 21:25:23', 39000, 2),
(41, 'https://www.sinyi.com.tw/rent/houseno/C216051', '2020-05-18 21:25:23', 25000, 2),
(42, 'https://www.sinyi.com.tw/rent/houseno/C217066', '2020-05-18 21:25:23', 45000, 2),
(43, 'https://www.sinyi.com.tw/rent/houseno/C212469', '2020-05-18 21:25:23', 34000, 2),
(44, 'https://www.sinyi.com.tw/rent/houseno/C212462', '2020-05-18 21:25:23', 55000, 2),
(45, 'https://www.sinyi.com.tw/rent/houseno/C222374', '2020-05-18 21:25:23', 158000, 2),
(46, 'https://www.sinyi.com.tw/rent/houseno/C213937', '2020-05-18 21:25:23', 120000, 2),
(47, 'https://www.sinyi.com.tw/rent/houseno/C220326', '2020-05-18 21:25:23', 39800, 2),
(48, 'https://www.sinyi.com.tw/rent/houseno/C219276', '2020-05-18 21:25:23', 600000, 2),
(49, 'https://www.sinyi.com.tw/rent/houseno/C221253', '2020-05-18 21:25:23', 36000, 2),
(50, 'https://www.sinyi.com.tw/rent/houseno/C206030', '2020-05-18 21:25:23', 32000, 3),
(51, 'https://www.sinyi.com.tw/rent/houseno/C205323', '2020-05-18 21:25:23', 25000, 2),
(52, 'https://www.sinyi.com.tw/rent/houseno/C217514', '2020-05-18 21:25:23', 39500, 2),
(53, 'https://www.sinyi.com.tw/rent/houseno/C215747', '2020-05-18 21:25:23', 22000, 2),
(54, 'https://www.sinyi.com.tw/rent/houseno/C212397', '2020-05-18 21:25:23', 20000, 2),
(55, 'https://www.sinyi.com.tw/rent/houseno/C202900', '2020-05-18 21:25:23', 60000, 2),
(56, 'https://www.sinyi.com.tw/rent/houseno/C215715', '2020-05-18 21:25:23', 35000, 2),
(57, 'https://www.sinyi.com.tw/rent/houseno/C215714', '2020-05-18 21:25:23', 40000, 2),
(58, 'https://www.sinyi.com.tw/rent/houseno/C215713', '2020-05-18 21:25:23', 60000, 2),
(59, 'https://www.sinyi.com.tw/rent/houseno/C215712', '2020-05-18 21:25:23', 35000, 2),
(60, 'https://www.sinyi.com.tw/rent/houseno/C217917', '2020-05-18 21:25:23', 27000, 2),
(61, 'https://www.sinyi.com.tw/rent/houseno/C215430', '2020-05-18 21:52:02', 30000, 2),
(62, 'https://www.sinyi.com.tw/rent/houseno/C208020', '2020-05-18 21:52:03', 29000, 2),
(63, 'https://www.sinyi.com.tw/rent/houseno/C221012', '2020-05-18 21:52:03', 13500, 2),
(64, 'https://www.sinyi.com.tw/rent/houseno/C219198', '2020-05-18 21:52:03', 85000, 2),
(65, 'https://www.sinyi.com.tw/rent/houseno/C219237', '2020-05-18 21:52:03', 65000, 2),
(66, 'https://www.sinyi.com.tw/rent/houseno/C208931', '2020-05-18 21:52:03', 75000, 2),
(67, 'https://www.sinyi.com.tw/rent/houseno/C220585', '2020-05-18 21:52:03', 35000, 2),
(68, 'https://www.sinyi.com.tw/rent/houseno/C212731', '2020-05-18 21:52:03', 55000, 2),
(69, 'https://www.sinyi.com.tw/rent/houseno/C220582', '2020-05-18 21:52:03', 50000, 2),
(70, 'https://www.sinyi.com.tw/rent/houseno/C220292', '2020-05-18 21:52:03', 35000, 2),
(71, 'https://www.sinyi.com.tw/rent/houseno/C211394', '2020-05-18 21:52:03', 48000, 2),
(72, 'https://www.sinyi.com.tw/rent/houseno/C215460', '2020-05-18 21:52:03', 39000, 2),
(73, 'https://www.sinyi.com.tw/rent/houseno/C210064', '2020-05-18 21:52:03', 82000, 2),
(74, 'https://www.sinyi.com.tw/rent/houseno/C219872', '2020-05-18 21:52:03', 41000, 2),
(75, 'https://www.sinyi.com.tw/rent/houseno/C220675', '2020-05-18 21:52:03', 27000, 2),
(76, 'https://www.sinyi.com.tw/rent/houseno/C203575', '2020-05-18 21:52:03', 32000, 2),
(77, 'https://www.sinyi.com.tw/rent/houseno/C203184', '2020-05-18 21:52:03', 88000, 2),
(78, 'https://www.sinyi.com.tw/rent/houseno/C219906', '2020-05-18 21:52:03', 145000, 2),
(79, 'https://www.sinyi.com.tw/rent/houseno/C206480', '2020-05-18 21:52:03', 22000, 2),
(80, 'https://www.sinyi.com.tw/rent/houseno/C202895', '2020-05-18 21:52:03', 50000, 3),
(81, 'https://www.sinyi.com.tw/rent/houseno/C202643', '2020-05-18 21:52:03', 22000, 3),
(82, 'https://www.sinyi.com.tw/rent/houseno/C212706', '2020-05-18 21:52:03', 32000, 2),
(83, 'https://www.sinyi.com.tw/rent/houseno/C215940', '2020-05-18 21:52:03', 30000, 2),
(84, 'https://www.sinyi.com.tw/rent/houseno/C217036', '2020-05-18 21:52:04', 27000, 2),
(85, 'https://www.sinyi.com.tw/rent/houseno/C217034', '2020-05-18 21:52:04', 18500, 2),
(86, 'https://www.sinyi.com.tw/rent/houseno/C211030', '2020-05-18 21:52:04', 200000, 2),
(87, 'https://www.sinyi.com.tw/rent/houseno/C213224', '2020-05-18 21:52:04', 23000, 2),
(88, 'https://www.sinyi.com.tw/rent/houseno/C217380', '2020-05-18 21:52:04', 18500, 2),
(89, 'https://www.sinyi.com.tw/rent/houseno/C207132', '2020-05-18 21:52:04', 24000, 2),
(90, 'https://www.sinyi.com.tw/rent/houseno/C208993', '2020-05-18 21:52:04', 21000, 2),
(91, 'https://www.sinyi.com.tw/rent/houseno/C214003', '2020-05-18 21:52:04', 76000, 2),
(92, 'https://www.sinyi.com.tw/rent/houseno/C215519', '2020-05-18 21:52:04', 35000, 2),
(93, 'https://www.sinyi.com.tw/rent/houseno/C217648', '2020-05-18 21:52:04', 45000, 2),
(94, 'https://www.sinyi.com.tw/rent/houseno/C217646', '2020-05-18 21:52:04', 16000, 2),
(95, 'https://www.sinyi.com.tw/rent/houseno/C207876', '2020-05-18 21:52:04', 16000, 2),
(96, 'https://www.sinyi.com.tw/rent/houseno/C210690', '2020-05-18 21:52:04', 15000, 2),
(97, 'https://www.sinyi.com.tw/rent/houseno/C216511', '2020-05-18 21:52:04', 15000, 2),
(98, 'https://www.sinyi.com.tw/rent/houseno/C210398', '2020-05-18 21:52:04', 17000, 2),
(99, 'https://www.sinyi.com.tw/rent/houseno/C215599', '2020-05-18 21:52:04', 75000, 2),
(100, 'https://www.sinyi.com.tw/rent/houseno/C212776', '2020-05-18 21:52:05', 39000, 2),
(101, 'https://www.sinyi.com.tw/rent/houseno/C216051', '2020-05-18 21:52:05', 25000, 2),
(102, 'https://www.sinyi.com.tw/rent/houseno/C217066', '2020-05-18 21:52:05', 45000, 2),
(103, 'https://www.sinyi.com.tw/rent/houseno/C212469', '2020-05-18 21:52:05', 34000, 2),
(104, 'https://www.sinyi.com.tw/rent/houseno/C212462', '2020-05-18 21:52:05', 55000, 2),
(105, 'https://www.sinyi.com.tw/rent/houseno/C222374', '2020-05-18 21:52:05', 158000, 2),
(106, 'https://www.sinyi.com.tw/rent/houseno/C213937', '2020-05-18 21:52:05', 120000, 2),
(107, 'https://www.sinyi.com.tw/rent/houseno/C220326', '2020-05-18 21:52:05', 39800, 2),
(108, 'https://www.sinyi.com.tw/rent/houseno/C219276', '2020-05-18 21:52:05', 600000, 2),
(109, 'https://www.sinyi.com.tw/rent/houseno/C221253', '2020-05-18 21:52:05', 36000, 2),
(110, 'https://www.sinyi.com.tw/rent/houseno/C206030', '2020-05-18 21:52:05', 32000, 2),
(111, 'https://www.sinyi.com.tw/rent/houseno/C205323', '2020-05-18 21:52:05', 25000, 2),
(112, 'https://www.sinyi.com.tw/rent/houseno/C217514', '2020-05-18 21:52:05', 39500, 2),
(113, 'https://www.sinyi.com.tw/rent/houseno/C215747', '2020-05-18 21:52:05', 22000, 2),
(114, 'https://www.sinyi.com.tw/rent/houseno/C212397', '2020-05-18 21:52:05', 20000, 2),
(115, 'https://www.sinyi.com.tw/rent/houseno/C202900', '2020-05-18 21:52:06', 60000, 2),
(116, 'https://www.sinyi.com.tw/rent/houseno/C215715', '2020-05-18 21:52:06', 35000, 2),
(117, 'https://www.sinyi.com.tw/rent/houseno/C215714', '2020-05-18 21:52:06', 40000, 2),
(118, 'https://www.sinyi.com.tw/rent/houseno/C215713', '2020-05-18 21:52:06', 60000, 2),
(119, 'https://www.sinyi.com.tw/rent/houseno/C215712', '2020-05-18 21:52:06', 35000, 2),
(120, 'https://www.sinyi.com.tw/rent/houseno/C217917', '2020-05-18 21:52:06', 27000, 2);

-- --------------------------------------------------------

--
-- 表的結構 `page_data`
--

CREATE TABLE IF NOT EXISTS `page_data` (
  `images` varchar(255) NOT NULL,
  `WebName` varchar(255) DEFAULT NULL,
  `Link` varchar(255) NOT NULL,
  `house` varchar(255) DEFAULT NULL,
  `adress` varchar(255) DEFAULT NULL,
  `money` int(10) DEFAULT NULL,
  `house_type` varchar(255) NOT NULL,
  `floor` varchar(10) NOT NULL,
  `square_meters` int(10) NOT NULL,
  `pattern` varchar(10) NOT NULL COMMENT '房,廳,衛,室',
  PRIMARY KEY (`Link`),
  UNIQUE KEY `Link` (`Link`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 轉存資料表中的資料 `page_data`
--

INSERT INTO `page_data` (`images`, `WebName`, `Link`, `house`, `adress`, `money`, `house_type`, `floor`, `square_meters`, `pattern`) VALUES
('https://res.sinyi.com.tw/rent/C202643/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C202643', '富宇水花園美兩房', '新竹縣竹北市隘口六街', 22000, '成屋', '3/12', 31, '2210'),
('https://res.sinyi.com.tw/rent/C202895/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C202895', '安康路一二樓店面', '新北市新店區安康路二段', 50000, '成屋', '1/2', 47, '1211'),
('https://res.sinyi.com.tw/rent/C202900/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C202900', '近未來捷運金店面', '連城智慧大樓   /   新北市中和區連城路', 60000, '成屋', '1/12', 32, '0111'),
('https://res.sinyi.com.tw/rent/C203184/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C203184', '中正名邸３＋１房', '玥賞   /   台北市大安區杭州南路二段', 88000, '成屋', '3/7', 53, '4220'),
('https://res.sinyi.com.tw/rent/C203575/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C203575', '整棟透天店面', '台中市東區東光園路', 32000, '成屋', '1-4/4', 107, '5240'),
('https://res.sinyi.com.tw/rent/C205323/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C205323', '海棠春溫馨出租', '新北市林口區文化三路二段', 25000, '成屋', '2/11', 38, '2221'),
('https://res.sinyi.com.tw/rent/C206030/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C206030', '大同莊園裝潢三房', '新北市土城區莊園街', 32000, '成屋', '8/27', 31, '3220'),
('https://res.sinyi.com.tw/rent/C206480/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C206480', '公園四季獨身貴族', '新北市永和區安樂路', 22000, '成屋', '4/15', 19, '1110'),
('https://res.sinyi.com.tw/rent/C207132/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C207132', '兵仔市芳鄰美透天', '台南市永康區中華一路', 24000, '成屋', '1-5/5', 70, '7230'),
('https://res.sinyi.com.tw/rent/C207876/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C207876', '福祥公寓小資首選', '新北市土城區福祥街', 16000, '成屋', '5/5', 27, '3210'),
('https://res.sinyi.com.tw/rent/C208020/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C208020', '永春二樓屋況佳', '台北市信義區永吉路', 29000, '成屋', '2/4', 24, '3210'),
('https://res.sinyi.com.tw/rent/C208931/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C208931', '大直香檳樓中樓', '香檳   /   台北市中山區明水路', 75000, '成屋', '7-8/14', 59, '3221'),
('https://res.sinyi.com.tw/rent/C208993/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C208993', '科工館大面寬金店', '高雄市三民區教仁路', 21000, '成屋', '1/12', 21, '0110'),
('https://res.sinyi.com.tw/rent/C210064/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C210064', '逸仙國管美屋', '台北市信義區逸仙路', 82000, '成屋', '2/12', 70, '322.50'),
('https://res.sinyi.com.tw/rent/C210398/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C210398', '墨爾本視野美屋', '桃園市八德區豐德路', 17000, '成屋', '13/15', 47, '3220'),
('https://res.sinyi.com.tw/rent/C210690/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C210690', '近高鐵超亮兩房', '高雄市左營區重建路', 15000, '成屋', '3/14', 24, '2210'),
('https://res.sinyi.com.tw/rent/C211030/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C211030', '中港文心旗艦店面', '德安臻藏   /   台中市西屯區文心路三段', 200000, '成屋', '-1/10', 339, '0120'),
('https://res.sinyi.com.tw/rent/C211394/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C211394', '士東路面寬金店面', '台北市士林區士東路', 48000, '成屋', '1/5', 21, '0121'),
('https://res.sinyi.com.tw/rent/C212397/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C212397', '大同街２樓面花園', '台北市北投區大同街', 20000, '成屋', '2/5', 17, '3210'),
('https://res.sinyi.com.tw/rent/C212462/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C212462', '忠孝商圈招財店面', '新北市三重區忠孝路三段', 55000, '成屋', '1/4', 25, '0110'),
('https://res.sinyi.com.tw/rent/C212469/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C212469', '三和硯露臺三房車', '新北市三重區自強路三段', 34000, '成屋', '2/14', 38, '3210'),
('https://res.sinyi.com.tw/rent/C212706/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C212706', '和平東路走九遍', '台北市信義區和平東路三段', 32000, '成屋', '2/4', 24, '3110'),
('https://res.sinyi.com.tw/rent/C212731/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C212731', '文化中心正路金店', '高雄市苓雅區青年一路', 55000, '成屋', '1/7', 29, '2210'),
('https://res.sinyi.com.tw/rent/C212776/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C212776', '華夏崇德透天店面', '高雄市左營區華夏路', 39000, '成屋', '1-2/2', 29, '0210'),
('https://res.sinyi.com.tw/rent/C213224/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C213224', '經國之星三房車位', '經國之星   /   桃園市桃園區經國路', 23000, '成屋', '13/13', 42, '3220'),
('https://res.sinyi.com.tw/rent/C213937/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C213937', '仁愛陛廈附雙車位', '台北市大安區仁愛路四段', 120000, '成屋', '8/14', 80, '522.50'),
('https://res.sinyi.com.tw/rent/C214003/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C214003', '國家印象４房車位', '國家印象   /   台北市中正區羅斯福路三段', 76000, '成屋', '4/14', 69, '4220'),
('https://res.sinyi.com.tw/rent/C215430/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C215430', '石牌金店面旺', '天母花都   /   台北市北投區實踐街', 30000, '成屋', '1/8', 11, '0110'),
('https://res.sinyi.com.tw/rent/C215460/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C215460', '捷運稀有雙敦兩房', '芝麻大廈   /   台北市松山區復興北路', 39000, '成屋', '14/15', 26, '2210'),
('https://res.sinyi.com.tw/rent/C215519/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C215519', '全新幸福兩房車位', '新北市新莊區中平路', 35000, '成屋', '8/14', 41, '2220'),
('https://res.sinyi.com.tw/rent/C215599/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C215599', '名峰山莊', '名峰山莊   /   台北市北投區中和街', 75000, '成屋', 'B1-2/2', 91, '6340'),
('https://res.sinyi.com.tw/rent/C215712/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C215712', '碧瑤天鑽２樓辦公', '新北市新莊區中央路', 35000, '成屋', '2/19', 42, '0010'),
('https://res.sinyi.com.tw/rent/C215713/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C215713', '碧瑤天鑽金店面', '新北市新莊區中央路', 60000, '成屋', '1/19', 42, '0010'),
('https://res.sinyi.com.tw/rent/C215714/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C215714', '碧瑤天鑽辦公２樓', '新北市新莊區中央路', 40000, '成屋', '2/19', 43, '0010'),
('https://res.sinyi.com.tw/rent/C215715/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C215715', '碧瑤優質辦公２樓', '新北市新莊區中華路三段', 35000, '成屋', '2/19', 28, '0010'),
('https://res.sinyi.com.tw/rent/C215747/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C215747', '高樓採光美三房', '九龍世第2   /   新竹縣竹北市成功十五街', 22000, '成屋', '8/12', 49, '3220'),
('https://res.sinyi.com.tw/rent/C215940/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C215940', '公館商圈黃金店面', '台北市中正區羅斯福路四段', 30000, '成屋', '2/7', 32, '0110'),
('https://res.sinyi.com.tw/rent/C216051/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C216051', '南門文教商圈金店', '台南市中西區南門路', 25000, '成屋', '1-3/1', 12, '0110'),
('https://res.sinyi.com.tw/rent/C216511/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C216511', '八德一路２樓店辦', '高雄市新興區八德一路', 15000, '成屋', '2/12', 61, '0123'),
('https://res.sinyi.com.tw/rent/C217034/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C217034', '世界之心一房', '世界之心   /   台中市西屯區文心路三段', 18500, '成屋', '8/26', 24, '1110'),
('https://res.sinyi.com.tw/rent/C217036/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C217036', '世界之心兩房平車', '世界之心   /   台中市西屯區文心路三段', 27000, '成屋', '14/26', 38, '2210'),
('https://res.sinyi.com.tw/rent/C217066/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C217066', '向上大三房車位', '亞昕向上   /   新北市新莊區中原路', 45000, '成屋', '13/24', 66, '3220'),
('https://res.sinyi.com.tw/rent/C217380/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C217380', '漢神ＤＣ採光美宅', '漢神DC   /   高雄市左營區明華一路', 18500, '成屋', '15/15', 38, '2220'),
('https://res.sinyi.com.tw/rent/C217514/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C217514', '鄉林夏都三房平車', '鄉林夏都   /   台中市西區忠明南路', 39500, '成屋', '2/15', 55, '3220'),
('https://res.sinyi.com.tw/rent/C217646/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C217646', '社子３樓美屋', '台北市士林區延平北路五段', 16000, '成屋', '3/4', 20, '2210'),
('https://res.sinyi.com.tw/rent/C217648/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C217648', '捷運管理高樓２房', '紫金   /   台北市士林區福國路', 45000, '成屋', '10/11', 22, '2210'),
('https://res.sinyi.com.tw/rent/C217917/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C217917', '禮躍３樓兩房車位', '新北市新莊區福美街', 27000, '成屋', '3/15', 37, '2210'),
('https://res.sinyi.com.tw/rent/C219198/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C219198', '東京花園－樓中樓', '台北市南港區重陽路', 85000, '成屋', '10-11/11', 69, '5221'),
('https://res.sinyi.com.tw/rent/C219237/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C219237', '吉林裝潢美住辦', '台北市中山區吉林路', 65000, '成屋', '1/7', 44, '1330'),
('https://res.sinyi.com.tw/rent/C219276/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C219276', '承德電梯透天店辦', '台北市大同區承德路三段', 600000, '成屋', '1-4/4', 203, '8641'),
('https://res.sinyi.com.tw/rent/C219872/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C219872', '敦化高樓摘星邊間', '台北市松山區復興北路', 41000, '成屋', '10/12', 21, '2210'),
('https://res.sinyi.com.tw/rent/C219906/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C219906', '高樓磊若兩房車', '台北市中山區樂群二路', 145000, '成屋', '9/10', 88, '2221'),
('https://res.sinyi.com.tw/rent/C220292/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C220292', 'Ａ８捷運雅堺兩房', '桃園市龜山區復興北路', 35000, '成屋', '5/6', 35, '2110'),
('https://res.sinyi.com.tw/rent/C220326/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C220326', '富比世美兩房', '富比世   /   台北市信義區松仁路', 39800, '成屋', '4/16', 20, '2210'),
('https://res.sinyi.com.tw/rent/C220582/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C220582', '中山路好店面', '新北市樹林區中山路一段', 50000, '成屋', '1/5', 35, '2210'),
('https://res.sinyi.com.tw/rent/C220585/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C220585', '原鄉高樓三房車位', '新北市板橋區僑中二街', 35000, '成屋', '13/22', 46, '3220'),
('https://res.sinyi.com.tw/rent/C220675/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C220675', '雲世紀二房車位', '雲世紀B區米勒拾穗   /   台中市西屯區國安一路', 27000, '成屋', '5/21', 41, '2220'),
('https://res.sinyi.com.tw/rent/C221012/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C221012', '金花園超優套房', '台北市士林區承德路四段', 13500, '成屋', '3/12', 8, '4040'),
('https://res.sinyi.com.tw/rent/C221253/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C221253', '映象太和溫馨兩房', '新北市中和區建康路', 36000, '成屋', '23/27', 40, '2110'),
('https://res.sinyi.com.tw/rent/C222374/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C222374', '海德堡超值店辦', '台北市內湖區內湖路一段', 158000, '成屋', '1/10', 113, '1100');

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
  `account` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `birth` date NOT NULL,
  `subscribe` varchar(1) NOT NULL DEFAULT '0' COMMENT '1有通知;0無通知',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 轉存資料表中的資料 `user`
--

INSERT INTO `user` (`id`, `account`, `password`, `name`, `image`, `phone`, `birth`, `subscribe`) VALUES
(1, 'a1234@gmail.com', '1234', '1234', '', '', '0000-00-00', ''),
(2, 'a@a.a', '1234', 'a', '214639kpavoexwtk0xgwwk.jpg', '0348215213', '2020-05-05', ''),
(3, 's@s.s', '1234', 's', '', '0909660051', '2020-04-27', ''),
(4, 'root@1.1', '1234', 'root', '', '0909660051', '2020-04-28', ''),
(5, '1@1.1', '1234', '2', '', '0909660051', '2020-05-05', ''),
(6, '5@5.5', '123456', '密碼正確', '', '0909660051', '2020-04-27', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
