-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生日期: 2020 年 05 月 15 日 13:35
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
-- 表的結構 `page_data`
--

CREATE TABLE IF NOT EXISTS `page_data` (
  `images` varchar(255) NOT NULL,
  `WebName` varchar(255) DEFAULT NULL,
  `Link` varchar(255) NOT NULL,
  `house` varchar(255) DEFAULT NULL,
  `adress` varchar(255) DEFAULT NULL,
  `money` double DEFAULT NULL,
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
('https://res.sinyi.com.tw/rent/C198810/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C198810', '春天悅灣３房', '春天悅灣   /   新北市淡水區民族路', 36000, '成屋', '3/7', 62, '3220'),
('https://res.sinyi.com.tw/rent/C204218/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C204218', '麗思卡登二房車位', '桃園市桃園區永安路', 23000, '成屋', '10/15', 41, '2210'),
('https://res.sinyi.com.tw/rent/C205355/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C205355', 'Ｒ１５捷運美兩房', '高雄市左營區崇德路', 12500, '成屋', '14/14', 21, '2210'),
('https://res.sinyi.com.tw/rent/C205544/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C205544', '近新堀江金鑽透天', '高雄市苓雅區文橫二路', 35000, '成屋', '1-2/2', 24, '0200'),
('https://res.sinyi.com.tw/rent/C206030/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C206030', '大同莊園裝潢三房', '新北市土城區莊園街', 36000, '成屋', '8/27', 31, '3220'),
('https://res.sinyi.com.tw/rent/C207190/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C207190', '近捷運極品金店面', '新北市中和區自立路', 60000, '成屋', '1/5', 28, '0110'),
('https://res.sinyi.com.tw/rent/C207515/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C207515', '康朵溫馨套房', '台中市西屯區弘孝路', 16500, '成屋', '4/12', 21, '1110'),
('https://res.sinyi.com.tw/rent/C208488/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C208488', '聚合發經典好居宅', '聚合發經典   /   台中市西屯區市政路', 39000, '成屋', '6/19', 64, '3220'),
('https://res.sinyi.com.tw/rent/C208816/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C208816', '安中商圈大坪店面', '台南市安南區安中路一段', 50000, '成屋', '1/4', 46, '0210'),
('https://res.sinyi.com.tw/rent/C209000/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C209000', '高樓亮美兩房平車', '高雄市鳳山區建國路三段', 18500, '成屋', '9/15', 35, '2210'),
('https://res.sinyi.com.tw/rent/C209438/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C209438', '行善龍騰大店面', '台北市內湖區行善路', 198684, '成屋', '1/8', 166, '0302'),
('https://res.sinyi.com.tw/rent/C209603/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C209603', '西湖電梯四房車位', '爵堡   /   台北市內湖區內湖路一段', 40000, '成屋', '9/9', 50, '4220'),
('https://res.sinyi.com.tw/rent/C209670/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C209670', '星海別墅四棟連通', '星海別墅   /   新北市淡水區新市一路一段', 88000, '成屋', '1-4/4', 211, '114110'),
('https://res.sinyi.com.tw/rent/C209858/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C209858', '御丰擎天三房車位', '御丰莊園   /   桃園市八德區建德路', 19000, '成屋', '8/25', 62, '3221'),
('https://res.sinyi.com.tw/rent/C211030/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C211030', '中港文心旗艦店面', '德安臻藏   /   台中市西屯區文心路三段', 200000, '成屋', '-1/10', 339, '0120'),
('https://res.sinyi.com.tw/rent/C211365/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C211365', '中正檀廂車位', '台北市中正區南昌路一段', 5000, '車位', '-2/15', 14, '1110'),
('https://res.sinyi.com.tw/rent/C211407/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C211407', '近捷運樹海大四房', '大英博物館   /   新北市三峽區學成路', 35000, '成屋', '3/15', 74, '4220'),
('https://res.sinyi.com.tw/rent/C211444/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C211444', '中西區企業總部', '台南市中西區尊王路', 180000, '成屋', 'B1-7/7', 373, '6890'),
('https://res.sinyi.com.tw/rent/C211690/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C211690', '崇德文心兩房平車', '台中市北屯區瀋陽路三段', 25500, '成屋', '2/18', 38, '2210'),
('https://res.sinyi.com.tw/rent/C211859/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C211859', '璟都柏悅２房車位', '桃園市桃園區吉安一街', 25500, '成屋', '6/21', 32, '2210'),
('https://res.sinyi.com.tw/rent/C211953/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C211953', '京城鳳凰高樓兩房', '台南市永康區中華路', 19000, '成屋', '19/19', 27, '2210'),
('https://res.sinyi.com.tw/rent/C212122/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C212122', '大容翠堤三房車位', '台中市西屯區大容東街', 23000, '成屋', '9/12', 32, '3220'),
('https://res.sinyi.com.tw/rent/C212185/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C212185', '保平路２０３公寓', '新北市永和區保平路', 10000, '成屋', '5/5', 13, '2110'),
('https://res.sinyi.com.tw/rent/C212198/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C212198', '瓊林１＋１華廈', '新北市新莊區瓊林路', 18000, '成屋', '4/7', 17, '2110'),
('https://res.sinyi.com.tw/rent/C212721/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C212721', '富春四季小資首選', '富春四季   /   台北市文山區指南路三段', 25000, '成屋', '10/11', 25, '1110'),
('https://res.sinyi.com.tw/rent/C213564/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C213564', '霞關優質金店面', '太平洋霞關   /   台北市士林區中正路', 40000, '成屋', '1/16', 22, '0110'),
('https://res.sinyi.com.tw/rent/C214084/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C214084', '勝美學精美套房', '勝美學   /   台中市北區學士路', 19500, '成屋', '13/18', 25, '1110'),
('https://res.sinyi.com.tw/rent/C214087/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C214087', '書香世家女中美屋', '台中市西區四維街', 28000, '成屋', '7/7', 40, '3220'),
('https://res.sinyi.com.tw/rent/C214088/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C214088', '學士ＶＩＳＡ。租', '台中市北區學士路', 7900, '成屋', '3/8', 17, '1110'),
('https://res.sinyi.com.tw/rent/C214090/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C214090', '勤美草悟道美三房', '長安科博   /   台中市西區英才路', 35000, '成屋', '6/12', 52, '3220'),
('https://res.sinyi.com.tw/rent/C214237/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C214237', '精誠八街日式店面', '台中市西區精誠八街', 55000, '成屋', '1-2/2', 36, '3221'),
('https://res.sinyi.com.tw/rent/C214239/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C214239', '不二家四房平車位', '不二家I   /   台中市西屯區東興路三段', 25000, '成屋', '8/13', 43, '4220'),
('https://res.sinyi.com.tw/rent/C214470/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C214470', '民權大樓雙捷辦住', '台北市中山區民權西路', 25000, '成屋', '11/12', 12, '1110'),
('https://res.sinyi.com.tw/rent/C214837/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C214837', '植物園大面寬店面', '科博京隱   /   台中市北區忠明路', 48000, '成屋', '1/12', 61, '1220'),
('https://res.sinyi.com.tw/rent/C215208/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C215208', '東湖捷運美景華廈', '台北市內湖區民權東路六段', 30000, '成屋', '9-10/11', 42, '121.50'),
('https://res.sinyi.com.tw/rent/C215825/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C215825', '石牌懷德車位電梯', '振華公園華廈   /   台北市北投區懷德街', 38000, '成屋', '3/8', 43, '3220'),
('https://res.sinyi.com.tw/rent/C215826/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C215826', '幸福街精美透天', '台北市士林區幸福街', 50000, '成屋', '1-2/2', 21, '2221'),
('https://res.sinyi.com.tw/rent/C215905/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C215905', '內湖捷運４樓美寓', '台北市內湖區成功路四段', 35000, '成屋', '4/5', 37, '3220'),
('https://res.sinyi.com.tw/rent/C216109/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C216109', '逢甲福星路金店面', '台中市西屯區福星路', 188000, '成屋', '1-2/4', 46, '1110'),
('https://res.sinyi.com.tw/rent/C216827/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C216827', '正崇德路店面', '台中市北屯區崇德路一段', 48000, '成屋', 'B1-5/1', 18, '0110'),
('https://res.sinyi.com.tw/rent/C218004/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C218004', '日升月恆景觀美屋', '日升月恆   /   台北市南港區經貿二路', 110000, '成屋', '8/21', 91, '3220'),
('https://res.sinyi.com.tw/rent/C218014/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C218014', '復興路黃金店面', '新北市中和區復興路', 65000, '成屋', '1/5', 26, '0100'),
('https://res.sinyi.com.tw/rent/C218021/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C218021', '家綠寶兩房車位', '台中市南區忠明南路', 14000, '成屋', '8/12', 33, '2220'),
('https://res.sinyi.com.tw/rent/C218327/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C218327', '鄉林高樓視野美屋', '台中市西屯區漢口路二段', 30000, '成屋', '13/15', 50, '3220'),
('https://res.sinyi.com.tw/rent/C218334/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C218334', '大面寬邊間金店面', '台北市文山區興隆路二段', 100000, '成屋', '1/4', 35, '0310'),
('https://res.sinyi.com.tw/rent/C218491/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C218491', '北投市場二樓店面', '台北市北投區新市街', 166000, '成屋', '2/5', 70, '0110'),
('https://res.sinyi.com.tw/rent/C218492/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C218492', '北投市場一樓店面', '台北市北投區新市街', 150000, '成屋', '1/5', 71, '0110'),
('https://res.sinyi.com.tw/rent/C218544/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C218544', '汐止樟樹三樓美寓', '新北市汐止區樟樹一路', 18000, '成屋', '3/5', 29, '3210'),
('https://res.sinyi.com.tw/rent/C219401/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C219401', '安中路一樓店面', '台南市安南區安中路一段', 18000, '成屋', '1/4', 9, '0110'),
('https://res.sinyi.com.tw/rent/C219446/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C219446', '南方之星靚靚屋', '新北市中和區捷運路', 20000, '成屋', '5/19', 15, '0110'),
('https://res.sinyi.com.tw/rent/C219916/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C219916', '新月三房含車位', '新月   /   新北市淡水區新市一路三段', 20000, '成屋', '17/20', 49, '3220'),
('https://res.sinyi.com.tw/rent/C220131/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C220131', '捷運靜巷店面Ａ', '台北市內湖區康寧路三段', 43000, '成屋', '1/5', 16, '0110'),
('https://res.sinyi.com.tw/rent/C220441/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C220441', '新宿低公設兩房', '世貿新宿   /   新北市汐止區樟樹一路', 18000, '成屋', '2/7', 28, '2210'),
('https://res.sinyi.com.tw/rent/C220873/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C220873', '衛武營旁好住家', '高雄市苓雅區武嶺街', 10000, '成屋', '1-3/3', 12, '6330'),
('https://res.sinyi.com.tw/rent/C221035/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C221035', '西區文青面寬店面', '台中市西區大忠街', 46000, '成屋', '1/7', 50, '2210'),
('https://res.sinyi.com.tw/rent/C221037/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C221037', '鄉林夏都', '鄉林夏都   /   台中市西區忠明南路', 35000, '成屋', '10/15', 34, '2220'),
('https://res.sinyi.com.tw/rent/C222371/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C222371', '捷運君綻綠景三房', '台北市內湖區內湖路三段', 65000, '成屋', '10/15', 43, '3220'),
('https://res.sinyi.com.tw/rent/C222375/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C222375', '北大湖靜巷３樓', '北大湖社區   /   台北市內湖區成功路四段', 30000, '成屋', '3/5', 31, '3220'),
('https://res.sinyi.com.tw/rent/CZ02891/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/CZ02891', '文林北路景觀辦公', '遠東瑞市   /   台北市士林區文林北路', 141427, '成屋', '6/11', 123, '5120'),
('https://res.sinyi.com.tw/rent/CZ02966/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/CZ02966', '文林北路邊間店面', '台北市北投區文林北路', 191688, '成屋', '1/23', 91, '1010');

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
