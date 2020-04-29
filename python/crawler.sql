-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生日期: 2020 年 04 月 29 日 13:55
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
  `WebName` varchar(255) DEFAULT NULL,
  `Link` varchar(255) NOT NULL,
  `house` varchar(255) DEFAULT NULL,
  `adress` varchar(255) DEFAULT NULL,
  `money` varchar(30) DEFAULT NULL,
  `house_type` varchar(255) NOT NULL,
  `floor` varchar(10) NOT NULL,
  `square_meters` int(30) NOT NULL,
  `pattern` varchar(10) NOT NULL COMMENT '房,廳,衛,室',
  PRIMARY KEY (`Link`),
  UNIQUE KEY `Link` (`Link`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 轉存資料表中的資料 `page_data`
--

INSERT INTO `page_data` (`WebName`, `Link`, `house`, `adress`, `money`, `house_type`, `floor`, `square_meters`, `pattern`) VALUES
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=00069812664678b', '近新時代火車站★超秒殺★整棟新蓋★全新電梯頂級裝潢★陽台獨洗', '台中市南區建成路', '7,999', '電梯大廈', '6樓/7樓', 13, '1房1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=005b9112663890f', '近興大忠孝夜市★小資首選★全新電梯★採光優質★室內機車位', '台中市南區正義街', '4,999', '電梯大廈', '5樓/7樓', 9, '1房1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=008d46126607032', '近中原設計院✨高檔套房✨學生可預定7月✨環境單純~', '桃園市中壢區環中東路', '6,500', '透天厝', '2樓/4樓', 7, '1房1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=00eebb126579655', '✔大慶車站✔中山醫興大✔採光明亮✔安靜方便✔室內機車位✔秒殺', '台中市南區復興路一段', '6,199', '透天厝', '2樓/4樓', 999, '1房1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=0176e812658927f', '逢明街★獨立陽台★通風明亮★近新光遠百', '台中市西屯區逢明街', '6,499', '透天厝', '2樓/4樓', 12, '1房1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=023ca0126578414', '✔可貓狗✔流理臺✔獨洗曬✔空間大✔採光明亮✔只有一間✔超秒殺', '台中市西屯區甘肅路一段', '8,499', '公寓', '4樓/5樓', 10, '1房1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=025693126610730', '系統裝潢☀一房一廳/流理台/獨洗陽台☀僅一間☀一中中友中國醫', '台中市北區太平路', '11,999', '透天厝', '1樓/5樓', 17, '1房1廳1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=0280d8126586468', '✔電4元✔科博館✔中國醫✔採光明亮✔衛浴乾溼分離✔空間大✔', '台中市北區健行路', '7,299', '透天厝', '4樓/5樓', 10, '1房1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=02b0b3126625531', '近天津北平商圈★秒殺可寵★全新電梯時尚裝潢★陽台獨洗★管理員', '台中市北區中清路一段', '9,499', '電梯大廈', '5樓/8樓', 12, '1房1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=037606126610798', '✅現場實拍✅電梯套房✅管理員✅景觀戶✅迎賓大景✅陽台獨曬✅', '台中市南區學府路', '4,999', '電梯大廈', '16樓/18樓', 13, '1房1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=03e12a11077092e', '冠德大境景安捷運採光三房全新 24小時管理可報稅設戶籍', '新北市中和區景安路', '35,000', '電梯大廈', '5樓/23樓', 42, '3房2廳2衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=044d74126610240', '系統裝潢◕一房一廳◕流理台/獨洗陽台◕僅一間', '台中市北區太平路', '11,999', '透天厝', '1樓/5樓', 17, '1房1廳1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=049063126645873', 'C0E88）捷運松江南京站1分【電梯套房★傢俱齊全】小廚房', '台北市中山區南京東路二段', '40,000', '電梯大廈', '7樓/18樓', 15, '1房1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=04b34f125225571', '女性專屬的優質雅房/全新裝修/正市中心/生活機能強/住戶單純', '宜蘭縣宜蘭市慶和街', '4,000', '公寓', '4樓/5樓', 6, '4房1廳2衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=04e6c7126610517', '✅整棟全新✅現場實拍✅電梯新屋✅可貓✅陽台獨洗✅迎賓大景✅', '台中市北區健行路', '11,999', '電梯大廈', '3樓/7樓', 16, '1房1廳1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=04ff8212661056e', '✅現場實拍✅全新電梯新屋✅小資族首選✅超蝦✅獨曬窗✅室內機車', '台中市南區忠孝路', '49,999', '電梯大廈', '5樓/7樓', 12, '1房1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=05432a125975612', '女性套房出租', '桃園市龍潭區中原路一段', '4,000', '透天厝', '2樓/5樓', 5, '-'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=05d2d4126582476', '✔小一房廳✔陽台獨洗曬✔流理臺✔空間超大✔採光超明亮✔就一間', '台中市西區民生路', '7,499', '公寓', '6樓/6樓', 15, '1房1廳1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=060dc7126456569', '出租分租套房忠孝東路五段後山埤二號出口大廈', '台北市信義區忠孝東路五段', '12,500', '電梯大廈', '8樓/9樓', 7, '4房1廳2衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=0638f1126053496', '新裝潢店面出租', '雲林縣北港鎮大同路', '20,000', '華廈', '1樓/1樓', 16, '-'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=069efd12637932d', '高級別墅大套房/含家電網路第四台警衛', '台中市豐原區豐東路', '7,000', '別墅', '4樓/4樓', 8, '1房1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=06c533125374400', '中央河景大3房車位', '新北市新店區中央三街', '35,000', '電梯大廈', '3樓/24樓', 36, '3房2廳2衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=06c74e12658227c', '秒殺超便宜近中國醫✌電梯台水電✌陽台獨洗✌空間大沙發✌', '台中市北區五權路', '8,500', '電梯大廈', '8樓/9樓', 13, '-'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=06efb8126612472', '✌秒殺高級電梯套房✌陽台獨洗✌流理臺✌乾溼分離', '台中市西區柳川東路二段', '10,500', '別墅', '3樓/6樓', 12, '-'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=073825126576678', '✔小資族✔陽台獨洗曬✔採光明亮✔安靜又方便✔逢甲僑光✔超秒殺', '台中市西屯區西屯路二段', '6,799', '透天厝', '2樓/4樓', 9, '1房1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=077c22125401205', '基泰國際酒店式公寓正兩房--裝修精美附全套家具(月租)', '台北市信義區基隆路二段', '68,000', '電梯大廈', '3樓/15樓', 25, '2房2廳1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=07b86f12664661b', '大龍公園靜巷2房', '台北市大同區重慶北路三段', '18,000', '公寓', '4樓/4樓', 19, '2房2廳1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=07b8f1125222362', '可養寵/近文藻榮總', '高雄市三民區鼎中路', '13,000', '透天厝', '2樓~5樓/5樓', 15, '1房1廳1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=08630512194480e', '淡水捷運旁公明街精華段旺舖出租', '新北市淡水區公明街', '18.8', '公寓', '1樓/5樓', 50, '-'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=087983126610849', '高CP☀沙發/流理台☀獨洗曬☀僅一間/中國醫', '台中市北區美德街', '6,500', '公寓', '6樓/6樓', 9, '-'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=094be3126401604', '全新整理RC電梯廠房可廠登', '桃園市八德區和成路', '13', '廠房', '1樓~3樓/3樓', 290, '-'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=097eb0125662351', '中正路｜獨立設計師輕奢挑高景觀小宅 – " 萌芽 "', '新竹市東區中正路', '18,000', '電梯大廈', '8樓/10樓', 15, '1房1廳1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=09ae95125706877', '永和福和橋引道旁粉，男性分租套房', '新北市永和區成功路一段', '8,000', '公寓', '頂樓加蓋/-', 24, '1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=0a17c1126611704', '近中原商圈，美裝潢，採光好，優質木地板，室內機車位~', '桃園市中壢區中山東路一段', '5,500', '透天厝', '4樓/5樓', 7, '1房1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=0a187912661075e', '稀有可寵➤系統裝潢➤電梯/獨洗曬➤僅一間➤中國醫一中', '台中市北區美德街', '9,700', '華廈', '8樓/11樓', 14, '-'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=0aa9e9110785314', '全新冠德大境邊間四房三面採光景安捷運站', '新北市中和區景安路', '41,800', '電梯大廈', '6樓/23樓', 57, '4房2廳2衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=0b06e2126647009', '電梯陽台獨洗♥最後一間♥一中街、台中火車站', '台中市東區大公街', '8,999', '透天厝', '5樓/7樓', 12, '1房1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=0b40ca11945450d', '正木柵路二段店面出租（1、2樓共40坪）', '台北市文山區木柵路二段', '45,000', '透天厝', '1樓~2樓/2樓', 40, '-'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=0b7df812662654a', '廣豐新天地✨獨洗獨曬✨舒適大套房✨', '桃園市八德區忠勇一街', '10,000', '電梯大廈', '3樓/6樓', 10, '1房1廳1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=0bfdf1126598038', '葫洲捷運旁', '台北市內湖區民權東路六段', '25,000', '電梯大廈', '3樓/7樓', 16, '-'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=0c7647125514203', '正新竹站前商圈日藥本舖旁，難得一見店舖釋出', '新竹市東區大同路', '90,000', '電梯大廈', 'B1~1樓/2樓', 35, '-'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=0c78ed12496737f', '高雄全新套房#高餐學生、上班族最愛！', '高雄市小港區松興路', '4,500', '透天厝', '2樓~4樓/4樓', 8, '-'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=0ce63a126646031', 'J3A86）捷運港墘站2分【精緻3房2衛★傢俱齊】平面車位洽', '台北市內湖區港墘路', '46,500', '電梯大廈', '4樓/15樓', 32, '3房2廳2衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=0d3e5b12664623d', 'J2A68）內湖四期【電梯2房1廳★乾濕分離】可寵★車位洽', '台北市內湖區民權東路六段', '39,800', '電梯大廈', '5樓/5樓', 30, '2房1廳1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=0d48de9479334a', '大坪數流理臺套房，可烹飪，可接受短租', '台中市中區三民路二段', '10,000', '電梯大廈', '11樓/12樓', 12, '1房1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=0e6a82126572914', '鄰近善化火車站全新落成店面', '台南市善化區北子店', '20,000', '透天厝', '1樓/4樓', 22, '-'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=0e6f30126638990', '近中山醫五權車站★超秒殺★全新電梯時尚裝潢★流理台★陽台獨洗', '台中市南區美村路二段', '5,999', '電梯大廈', '3樓/7樓', 10, '1房1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=0e7eb212446119c', '逢甲僑光透天套房★可寵可狗★免仲介費★', '台中市西屯區福上巷', '7,000', '透天厝', '1樓~4樓/4樓', 8, '1房1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=0e9227126581835', '✔大套房✔一房一廳✔陽台獨洗流理臺✔空間大✔只有一間✔超秒殺', '台中市北區太平路', '11,999', '透天厝', '1樓/4樓', 15, '1房1廳1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=0f23c1126178991', '大學1號館套房出租靜宜、弘光(雙人床、獨立洗衣機)', '台中市沙鹿區晉文路', '4,800', '透天厝', '1樓~4樓/4樓', 5, '1房1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=0f56d7126610625', '✅現場實拍✅勤益803✅整棟全新✅陽台獨洗✅鬧中取靜✅高CP', '台中市太平區環太東路', '5,999', '電梯大廈', '1樓/6樓', 13, '1房1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=0fb017107932005', '中醫商圈電梯大厦套房、雅房分租', '台中市北區美德街', '6,000', '電梯大廈', '4樓/11樓', 4, '-'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=0fbf1a126556816', '新巨蛋*稀有邊間*頂級裝潢*家具家電齊*可報稅', '新北市板橋區文化路一段', '23,500', '電梯大廈', '12樓/40樓', 14, '1房1廳1衛'),
('樂屋網', 'https://www.rakuya.com.tw/rent_item/info?ehid=0fcb8611352496e', '新亮點商務中心＿66號黃金門牌登記2千', '台北市內湖區內湖路一段', '2,000', '辦公', '3樓/10樓', 1, '-');

-- --------------------------------------------------------

--
-- 表的結構 `subscription`
--

CREATE TABLE IF NOT EXISTS `subscription` (
  `username` varchar(255) NOT NULL,
  `Link` varchar(255) NOT NULL,
  PRIMARY KEY (`Link`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 轉存資料表中的資料 `subscription`
--

INSERT INTO `subscription` (`username`, `Link`) VALUES
('', 'https://www.rakuya.com.tw/rent_item/info?ehid=06efb8126612472');

-- --------------------------------------------------------

--
-- 表的結構 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `account` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 匯出資料表的 Constraints
--

--
-- 資料表的 Constraints `subscription`
--
ALTER TABLE `subscription`
  ADD CONSTRAINT `Link` FOREIGN KEY (`Link`) REFERENCES `page_data` (`Link`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
