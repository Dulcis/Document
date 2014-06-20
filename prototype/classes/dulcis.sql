-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2014 年 6 朁E10 日 13:03
-- サーバのバージョン： 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dulcis`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `cno` int(7) NOT NULL AUTO_INCREMENT COMMENT 'カート番号',
  `mno` int(7) NOT NULL COMMENT '会員番号',
  `ino` int(5) NOT NULL COMMENT '商品番号',
  `csum` int(3) NOT NULL COMMENT '数量',
  PRIMARY KEY (`cno`),
  KEY `mno` (`mno`),
  KEY `ino` (`ino`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='カートデータが格納されている。非会員はセッションにカートを保持する。' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `dreview`
--

CREATE TABLE IF NOT EXISTS `dreview` (
  `rno` int(5) NOT NULL COMMENT 'レビュー番号',
  `rct` int(3) NOT NULL DEFAULT '0' COMMENT 'カウント',
  PRIMARY KEY (`rno`),
  KEY `rct` (`rct`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='削除依頼があるレビューIDを格納する。';

-- --------------------------------------------------------

--
-- テーブルの構造 `genre`
--

CREATE TABLE IF NOT EXISTS `genre` (
  `gno` int(2) NOT NULL AUTO_INCREMENT COMMENT 'ジャンル番号',
  `gname` varchar(25) NOT NULL COMMENT 'ジャンル名',
  PRIMARY KEY (`gno`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='ジャンルデータが格納されている。				' AUTO_INCREMENT=9 ;

--
-- テーブルのデータのダンプ `genre`
--

INSERT INTO `genre` (`gno`, `gname`) VALUES
(6, 'ãŠè“å­'),
(7, 'ã‚¢ã‚¤ã‚¹'),
(8, 'ã‚­ãƒ£ãƒ³ãƒ‡ãƒ¼');

-- --------------------------------------------------------

--
-- テーブルの構造 `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `ino` int(5) NOT NULL AUTO_INCREMENT COMMENT '商品番号',
  `iname` varchar(80) NOT NULL COMMENT '商品名',
  `iprice` int(6) NOT NULL DEFAULT '0' COMMENT '単価',
  `isum` int(6) NOT NULL DEFAULT '0' COMMENT '在庫数',
  `gno` int(2) NOT NULL COMMENT 'ジャンル番号',
  `ico` text NOT NULL COMMENT 'コメント',
  PRIMARY KEY (`ino`),
  KEY `gno` (`gno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商品データが格納されている。' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `line`
--

CREATE TABLE IF NOT EXISTS `line` (
  `lno` bigint(13) NOT NULL AUTO_INCREMENT COMMENT '注文明細番号',
  `ono` int(10) NOT NULL COMMENT '注文番号',
  `ino` int(5) NOT NULL COMMENT '商品番号',
  `lprice` int(6) NOT NULL COMMENT '単価',
  `lsum` int(6) NOT NULL COMMENT '数量',
  `lpt` int(6) DEFAULT '0' COMMENT 'ポイント数',
  PRIMARY KEY (`lno`),
  KEY `ono` (`ono`),
  KEY `ino` (`ino`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='注文明細データが格納されている。' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `mno` int(7) NOT NULL AUTO_INCREMENT COMMENT '会員番号',
  `mpass` varchar(15) NOT NULL COMMENT 'パスワード',
  `mmail` varchar(40) NOT NULL COMMENT 'メールアドレス',
  `mname` varchar(20) NOT NULL COMMENT '名前',
  `mpost` varchar(8) NOT NULL COMMENT '郵便番号',
  `maddress` varchar(100) NOT NULL COMMENT '住所',
  `mtel` varchar(13) NOT NULL COMMENT '電話番号',
  `mpt` int(6) NOT NULL DEFAULT '0' COMMENT '累計ポイント',
  `mcard` varchar(16) NOT NULL COMMENT 'クレジットカード',
  PRIMARY KEY (`mno`),
  KEY `mmail` (`mmail`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='会員データが格納されている。' AUTO_INCREMENT=2 ;

--
-- テーブルのデータのダンプ `member`
--

INSERT INTO `member` (`mno`, `mpass`, `mmail`, `mname`, `mpost`, `maddress`, `mtel`, `mpt`, `mcard`) VALUES
(1, '0202', '1101574@st.asojuku.ac.jp', 'å²©æ°¸ ä¸€é·¹', '8120016', 'ç¦å²¡çœŒç¦å²¡å¸‚åšå¤šåŒºåšå¤šé§…å—äºŒä¸ç›®', '09057274249', 0, '0202');

-- --------------------------------------------------------

--
-- テーブルの構造 `notice`
--

CREATE TABLE IF NOT EXISTS `notice` (
  `nno` int(4) NOT NULL AUTO_INCREMENT COMMENT 'お知らせ番号',
  `ntitle` varchar(80) NOT NULL COMMENT 'タイトル',
  `nword` text NOT NULL COMMENT '文',
  `nurl` varchar(80) NOT NULL COMMENT 'URL',
  PRIMARY KEY (`nno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='お知らせデータが格納されている。' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `ono` int(10) NOT NULL AUTO_INCREMENT COMMENT '注文番号',
  `mno` int(8) DEFAULT NULL COMMENT '会員番号',
  `odate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '日付',
  `osum` int(9) NOT NULL COMMENT '合計金額',
  `opt` int(6) DEFAULT NULL COMMENT '合計ポイント',
  `oname` varchar(20) NOT NULL COMMENT '名前',
  `opost` varchar(8) NOT NULL COMMENT '郵便番号',
  `oaddress` varchar(100) NOT NULL COMMENT '住所',
  `otel` varchar(13) NOT NULL COMMENT '電話番号',
  `omail` varchar(40) NOT NULL COMMENT 'メールアドレス',
  `ocard` varchar(16) NOT NULL COMMENT 'クレジットカード番号',
  PRIMARY KEY (`ono`),
  KEY `mno` (`mno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='注文データが格納されている。				' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `review`
--

CREATE TABLE IF NOT EXISTS `review` (
  `rno` int(8) NOT NULL AUTO_INCREMENT COMMENT 'レビュー番号',
  `rtitle` varchar(80) NOT NULL COMMENT 'レビュータイトル',
  `rword` text NOT NULL COMMENT 'レビュー文',
  `rtime` timestamp NULL DEFAULT NULL COMMENT '投稿日時',
  `rstar` int(1) NOT NULL DEFAULT '3' COMMENT '星',
  `mno` int(7) NOT NULL COMMENT '会員番号',
  `ino` int(5) NOT NULL COMMENT '商品番号',
  PRIMARY KEY (`rno`),
  KEY `mno` (`mno`),
  KEY `ino` (`ino`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='レビューデータが格納されている。レビューは会員のみ投稿できる。' AUTO_INCREMENT=1 ;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`mno`) REFERENCES `member` (`mno`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`ino`) REFERENCES `item` (`ino`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- テーブルの制約 `dreview`
--
ALTER TABLE `dreview`
  ADD CONSTRAINT `dreview_ibfk_1` FOREIGN KEY (`rno`) REFERENCES `review` (`rno`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- テーブルの制約 `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`gno`) REFERENCES `genre` (`gno`) ON UPDATE CASCADE;

--
-- テーブルの制約 `line`
--
ALTER TABLE `line`
  ADD CONSTRAINT `line_ibfk_1` FOREIGN KEY (`ono`) REFERENCES `order` (`ono`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `line_ibfk_2` FOREIGN KEY (`ino`) REFERENCES `item` (`ino`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- テーブルの制約 `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`mno`) REFERENCES `member` (`mno`) ON DELETE SET NULL;

--
-- テーブルの制約 `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`mno`) REFERENCES `member` (`mno`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`ino`) REFERENCES `item` (`ino`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
