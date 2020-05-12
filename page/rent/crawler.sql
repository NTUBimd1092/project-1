-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生日期: 2020 年 05 月 12 日 08:30
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
  `money` varchar(30) DEFAULT NULL,
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
('https://res.sinyi.com.tw/rent/C173562/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C173562', '黃金名仕園', '名仕園   /   台北市士林區中山北路七段', '215,000', '成屋', '1/7', 124, '0123'),
('https://res.sinyi.com.tw/rent/C196020/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C196020', '政大熱鬧金店面', '台北市文山區指南路二段', '100,000', '成屋', '1/3', 22, '0110'),
('https://res.sinyi.com.tw/rent/C198945/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C198945', '開心一百黃金角店', '台中市潭子區中山路一段', '25,000', '成屋', '1/13', 35, '0110'),
('https://res.sinyi.com.tw/rent/C202337/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C202337', '都會情人美２房', '都會情人   /   高雄市鼓山區文信路', '16,000', '成屋', '4/15', 23, '2210'),
('https://res.sinyi.com.tw/rent/C203410/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C203410', '堤景採光三房車位', '香榭堤景   /   桃園市蘆竹區南昌路', '25,000', '成屋', '11/15', 52, '3221'),
('https://res.sinyi.com.tw/rent/C203828/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C203828', '中和中正廠辦‧２', '新北市中和區中正路', '90,000', '成屋', '2/3', 94, '3210'),
('https://res.sinyi.com.tw/rent/C203829/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C203829', '中和中正廠辦‧３', '新北市中和區中正路', '80,000', '成屋', '3/3', 94, '2210'),
('https://res.sinyi.com.tw/rent/C204527/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C204527', 'Ａ９三房美屋車位', '文化錄   /   新北市林口區文化三路一段', '28,000', '成屋', '3/12', 36, '3220'),
('https://res.sinyi.com.tw/rent/C205734/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C205734', '招財１＋２樓店面', '新北市永和區得和路', '50,000', '成屋', '1-2/4', 24, '0220'),
('https://res.sinyi.com.tw/rent/C206338/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C206338', '富國面寬邊間金店', '美夢成真NO.1   /   高雄市左營區富國路', '80,000', '成屋', '1/7', 63, '0210'),
('https://res.sinyi.com.tw/rent/C206518/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C206518', '士林捷運裝潢美廈', '小貴馥   /   台北市士林區福德路', '30,000', '成屋', '6/8', 10, '0110'),
('https://res.sinyi.com.tw/rent/C206958/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C206958', '新美齊高樓含車戶', '新北市三重區朝陽街', '38,000', '成屋', '12/12', 38, '2210'),
('https://res.sinyi.com.tw/rent/C208110/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C208110', '士北科好宅', '台北市北投區文林北路', '38,000', '成屋', '8/13', 45, '3220'),
('https://res.sinyi.com.tw/rent/C208193/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C208193', '大坪林捷運大店面', '新北市新店區民權路', '230,000', '成屋', '1/5', 66, '2330'),
('https://res.sinyi.com.tw/rent/C208194/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C208194', '玉上園景觀美宅', '玉上園   /   新北市新店區寶橋路', '68,000', '成屋', '25/27', 74, '4220'),
('https://res.sinyi.com.tw/rent/C208215/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C208215', '麗石邊間高樓景觀', '台北市北投區裕民二路', '90,000', '成屋', '12/19', 53, '221.51'),
('https://res.sinyi.com.tw/rent/C208380/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C208380', '捷運寬敞辦公', '台北市大同區重慶北路二段', '42,000', '成屋', '8/12', 37, '1110'),
('https://res.sinyi.com.tw/rent/C208488/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C208488', '聚合發經典好居宅', '聚合發經典   /   台中市西屯區市政路', '45,000', '成屋', '6/19', 64, '3220'),
('https://res.sinyi.com.tw/rent/C208586/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C208586', '耀嵩豐兩房平車', '高雄市左營區博愛四路', '32,000', '成屋', '17/28', 43, '2120'),
('https://res.sinyi.com.tw/rent/C209039/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C209039', '大墩學區三房車位', '大東家春風   /   台中市南屯區三和街', '25,000', '成屋', '5/8', 41, '3220'),
('https://res.sinyi.com.tw/rent/C209330/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C209330', '金門３樓', '新北市板橋區金門街', '16,000', '成屋', '3/4', 26, '2211'),
('https://res.sinyi.com.tw/rent/C209357/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C209357', '東湖商圈金店面', '台北市內湖區東湖路', '40,000', '成屋', '1/7', 43, '1111'),
('https://res.sinyi.com.tw/rent/C209627/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C209627', '聯上真品裝潢豪邸', '聯上真品   /   高雄市鼓山區文信路', '38,000', '成屋', '12/15', 65, '3221'),
('https://res.sinyi.com.tw/rent/C209640/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C209640', '國盛電梯方正２房', '台北市中正區中華路二段', '20,000', '成屋', '3/7', 11, '2110'),
('https://res.sinyi.com.tw/rent/C210034/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C210034', '正展演中心旁商辦', '桃園市桃園區藝文一街', '46,000', '成屋', '14/18', 30, '0100'),
('https://res.sinyi.com.tw/rent/C210112/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C210112', '農１６美四房車位', '高雄市鼓山區中華一路', '19,000', '成屋', '11/13', 48, '4220'),
('https://res.sinyi.com.tw/rent/C211704/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C211704', '永興大樓精美Ａ', '新北市中和區建康路', '17,500', '成屋', '8/9', 23, '1110'),
('https://res.sinyi.com.tw/rent/C212544/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C212544', '東方之冠高樓裝潢', '富宇東方之冠   /   台中市西屯區市政路', '100,000', '成屋', '15/38', 114, '4230'),
('https://res.sinyi.com.tw/rent/C213087/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C213087', '正勤好租好租三房', '正勤   /   高雄市前鎮區中華五路', '16,800', '成屋', '2/12', 42, '3220'),
('https://res.sinyi.com.tw/rent/C213092/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C213092', '筑丰天母三房', '台北市士林區中山北路六段', '79,500', '成屋', '9/21', 57, '3220'),
('https://res.sinyi.com.tw/rent/C213649/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C213649', '近好市多三房', '高雄市左營區大順一路', '13,000', '成屋', '18/20', 68, '3220'),
('https://res.sinyi.com.tw/rent/C213980/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C213980', '美麗尊邸美三房', '高雄市左營區重忠路', '15,000', '成屋', '8/14', 41, '3220'),
('https://res.sinyi.com.tw/rent/C214290/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C214290', '海洋都心成家三房', '新北市淡水區新市五路三段', '19,000', '成屋', '12/27', 45, '3220'),
('https://res.sinyi.com.tw/rent/C214466/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C214466', '民權西路電梯租屋', '台北市中山區天祥路', '26,500', '成屋', '4/5', 14, '1110'),
('https://res.sinyi.com.tw/rent/C215137/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C215137', '塗城京讚三房平車', '台中市大里區塗城路', '25,000', '成屋', '8/11', 48, '3220'),
('https://res.sinyi.com.tw/rent/C215457/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C215457', '長安東中山區辦公', '台北市中山區長安東路一段', '111,000', '成屋', '3/11', 74, '0107'),
('https://res.sinyi.com.tw/rent/C215542/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C215542', '德安印象極簡時尚', '台北市內湖區行善路', '120,000', '成屋', '4/13', 67, '4220'),
('https://res.sinyi.com.tw/rent/C215747/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C215747', '高樓採光美三房', '新竹縣竹北市成功十五街', '22,000', '成屋', '8/12', 49, '3220'),
('https://res.sinyi.com.tw/rent/C216138/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C216138', '永安捷運公寓二樓', '新北市永和區中和路', '14,000', '成屋', '2/5', 17, '3010'),
('https://res.sinyi.com.tw/rent/C216271/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C216271', '昇陽精緻邊間兩房', '昇陽GRAND   /   台北市大安區光復南路', '44,000', '成屋', '10/14', 25, '2110'),
('https://res.sinyi.com.tw/rent/C216315/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C216315', '邊間阿曼風尚雅居', '台北市中山區民生東路一段', '28,000', '成屋', '5/8', 16, '1110'),
('https://res.sinyi.com.tw/rent/C216333/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C216333', '西門裝潢溫馨套房', '台北市萬華區環河南路一段', '19,500', '成屋', '6/12', 13, '1120'),
('https://res.sinyi.com.tw/rent/C216427/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C216427', '百達富裔優美四房', '百達富裔   /   台中市西屯區臺灣大道三段', '118,888', '成屋', '27/35', 109, '4230'),
('https://res.sinyi.com.tw/rent/C216498/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C216498', '巨蛋佳人捷運三房', '博愛佳人   /   高雄市鼓山區博愛二路', '26,000', '成屋', '10/14', 47, '3220'),
('https://res.sinyi.com.tw/rent/C216525/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C216525', '捷運新都星金店面', '捷運新都星   /   新北市永和區信義路', '60,000', '成屋', '1/17', 24, '0110'),
('https://res.sinyi.com.tw/rent/C216704/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C216704', '仁愛管理高樓３房', '鴻福大樓   /   台北市大安區仁愛路四段', '32,000', '成屋', '12/14', 25, '3210'),
('https://res.sinyi.com.tw/rent/C217095/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C217095', '大坪林捷運美兩房', '新北市新店區中興路三段', '22,000', '成屋', '3/5', 22, '3220'),
('https://res.sinyi.com.tw/rent/C217096/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C217096', '大坪林捷運雅房Ａ', '新北市新店區中興路三段', '9,000', '成屋', '3/5', 18, '3220'),
('https://res.sinyi.com.tw/rent/C217097/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C217097', '大坪林捷運套房Ｂ', '新北市新店區中興路三段', '12,000', '成屋', '3/5', 20, '3220'),
('https://res.sinyi.com.tw/rent/C217149/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C217149', '海華鬧區面寬店面', '桃園市中壢區新生路', '98,000', '成屋', '1/22', 20, '0111'),
('https://res.sinyi.com.tw/rent/C219296/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C219296', '農１６超採光三房', '新世界   /   高雄市鼓山區裕誠路', '18,000', '成屋', '14/14', 36, '3220'),
('https://res.sinyi.com.tw/rent/C219481/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C219481', '海都一期舒適兩房', '新北市淡水區新市五路三段', '17,000', '成屋', '19/26', 31, '2210'),
('https://res.sinyi.com.tw/rent/C219569/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C219569', '松江寬大店面', '台北市中山區松江路', '50,000', '成屋', '1/5', 28, '2211'),
('https://res.sinyi.com.tw/rent/C219608/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C219608', '大安好租靜巷三房', '台北市大安區忠孝東路四段', '35,000', '成屋', '4/5', 34, '3220'),
('https://res.sinyi.com.tw/rent/C220121/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C220121', '重慶圓環金三角窗', '台北市大同區天水路', '98,000', '成屋', '1/19', 68, '1211'),
('https://res.sinyi.com.tw/rent/C220321/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C220321', '微美信義香榭', '信義香榭   /   台北市信義區信義路五段', '46,000', '成屋', '3/19', 26, '2210'),
('https://res.sinyi.com.tw/rent/C220671/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C220671', '雲Ｂ高樓三房平車', '雲世紀B區米勒拾穗   /   台中市西屯區國安一路', '29,000', '成屋', '19/21', 53, '3220'),
('https://res.sinyi.com.tw/rent/C221305/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C221305', '璀璨之都兩房', '璀璨之都   /   新北市五股區芳洲一路', '19,000', '成屋', '8/15', 30, '2210'),
('https://res.sinyi.com.tw/rent/C221931/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/C221931', '舒曼的家二房', '舒曼的家   /   台北市文山區興隆路二段', '25,000', '成屋', '2/13', 22, '2210'),
('https://res.sinyi.com.tw/rent/CZ02787/smallimg/A.JPG', '信義房屋', 'https://www.sinyi.com.tw/rent/houseno/CZ02787', '忠孝東路整層辦公', '台北市中正區忠孝東路一段', '440,000', '成屋', '4/12', 248, '0110');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 轉存資料表中的資料 `user`
--

INSERT INTO `user` (`id`, `account`, `password`, `name`, `image`, `phone`, `birth`) VALUES
(1, 'a1234@gmail.com', '1234', '1234', '', '', '0000-00-00'),
(2, 'a@a.a', '1234', 'a', '', '0348215213', '2020-05-05'),
(3, 's@s.s', '1234', 's', '', '0909660051', '2020-04-27'),
(4, 'root@1.1', '1234', 'root', '', '0909660051', '2020-04-28'),
(5, '1@1.1', '1234', '2', '', '0909660051', '2020-05-05'),
(6, '5@5.5', '123456', '密碼正確', '', '0909660051', '2020-04-27');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
