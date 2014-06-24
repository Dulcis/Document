-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2014 年 6 朁E24 日 03:10
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
-- テーブルの構造 `buy`
--

CREATE TABLE IF NOT EXISTS `buy` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='注文データが格納されている。				' AUTO_INCREMENT=5 ;

--
-- テーブルのデータのダンプ `buy`
--

INSERT INTO `buy` (`ono`, `mno`, `odate`, `osum`, `opt`, `oname`, `opost`, `oaddress`, `otel`, `omail`, `ocard`) VALUES
(1, NULL, '2014-06-23 05:01:53', 300, NULL, 'テスト', '8120016', '福岡県', '09012345678', 'test@test.co.jp', '0202'),
(2, 1, '2014-06-23 05:23:37', 1080, 108, '岩永 一鷹', '8120016', '福岡県福岡市博多区', '09057274249', '1101574@st.asojuku.ac.jp', '0202'),
(3, NULL, '2014-06-23 05:26:53', 960, NULL, 'テスト', '8120016', '福岡県', '09057274249', 'test@test.co.jp', '0202'),
(4, 2, '2014-06-24 00:58:35', 1580, 158, 'テスト', '0202', '福岡', '090', 'test@test.ac.jp', '0022');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='カートデータが格納されている。非会員はセッションにカートを保持する。' AUTO_INCREMENT=3 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='ジャンルデータが格納されている。				' AUTO_INCREMENT=19 ;

--
-- テーブルのデータのダンプ `genre`
--

INSERT INTO `genre` (`gno`, `gname`) VALUES
(9, 'チョコレート'),
(10, 'ビスケット'),
(11, 'スナック'),
(12, 'キャラメル'),
(13, 'キャンディ'),
(14, 'カップアイス'),
(15, 'モナカ・サンド'),
(16, 'バー・その他のアイス'),
(17, 'マルチパック'),
(18, 'その他');

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
  `iimg` varchar(100) NOT NULL,
  PRIMARY KEY (`ino`),
  KEY `gno` (`gno`),
  FULLTEXT KEY `iimg` (`iimg`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='商品データが格納されている。' AUTO_INCREMENT=32 ;

--
-- テーブルのデータのダンプ `item`
--

INSERT INTO `item` (`ino`, `iname`, `iprice`, `isum`, `gno`, `ico`, `iimg`) VALUES
(1, 'チョコボール<ピーナッツ>', 72, 100, 9, '・内容量：25g\r\n\r\n・栄養成分[ １箱（25ｇ）当り ]\r\n熱量:１４２ｋｃａｌ たんぱく質:３．０ｇ 脂質:９．２ｇ 炭水化物:１１．７ｇ ナトリウム:１３ｍｇ カルシウム:２７ｍｇ\r\n\r\n・原材料\r\nピーナッツ 砂糖 植物油脂 カカオマス 小麦粉 とうもろこしでん粉 全粉乳 ココアバター 乳糖 水あめ モルトエキス ミルクカルシウム デキストリン 食塩 光沢剤 香料 乳化剤（大豆由来）\r\n\r\n・製造工場\r\n国内で製造しています。', '1.jpg'),
(2, 'チョコボール<キャラメル>', 60, 100, 9, '・内容量：２９ｇ\r\n\r\n・栄養成分[ １箱（２９ｇ）当り ]\r\n熱量:１４０ｋｃａｌ たんぱく質:１．２ｇ 脂質:６．０ｇ 炭水化物:２０．３ｇ ナトリウム:１９ｍｇ カルシウム:４２ｍｇ\r\n\r\n・原材料\r\n砂糖 水あめ 植物油脂 カカオマス 加糖練乳 全粉乳 加糖脱脂練乳 ココアバター 乳糖 ホエイパウダー 小麦たんぱく ミルクカルシウム デキストリン モルトエキス 食塩 ソルビトール 光沢剤 乳化剤（大豆由来） 増粘剤（カラギナン） 香料\r\n\r\n・製造工場\r\n国内で製造しています。', '3.jpg'),
(3, 'チョコボール<いちご>', 72, 100, 9, '・内容量：26ｇ\r\n\r\n・栄養成分[ １箱（26ｇ）当り ]\r\n熱量：１４５kcal たんぱく質：０．９ｇ 脂質：８.７ｇ 炭水化物：１５.８ｇ ナトリウム：１５ｍｇ カルシウム：３４ｍｇ\r\n\r\n・原材料\r\n砂糖 植物油脂 全粉乳 ココアバター デキストリン 米パフ（小麦を含む） 乳糖 いちごパウダー 水あめ 乳化剤（大豆由来） 光沢剤 香料 膨脹剤 ベニバナ赤色素\r\n\r\n・製造工場\r\n国内で製造しています。', '2.jpg'),
(6, 'ダース<ミルク>', 148, 100, 9, '・内容量：４５ｇ（１２粒）\r\n\r\n・栄養成分[ １粒（標準3.8ｇ）当り ]\r\n熱量:22ｋｃａｌ たんぱく質:0.3g 脂質:1.5ｇ	炭水化物:1.9ｇ ナトリウム:2.8ｍｇ\r\n\r\n・原材料\r\n砂糖 ココアバター 全粉乳 カカオマス 植物油脂 脱脂粉乳 生クリーム ヘーゼルナッツペースト ホエイパウダー 乳化剤（大豆由来） 香料\r\n\r\n・製造工場\r\n国内で製造しています。', '4.jpg'),
(7, 'ダース<ビター>', 158, 100, 9, '・内容量：４５ｇ（１２粒）\r\n\r\n・栄養成分[ １粒（標準3.8ｇ）当り ]\r\n熱量:22ｋｃａｌ たんぱく質:0.2ｇ 脂質:1.5ｇ 炭水化物:2.0ｇ ナトリウム:0~1ｍｇ\r\n\r\n・原材料\r\n砂糖 カカオマス ココアバター バターオイル 植物油脂 乳化剤(大豆由来) 香料\r\n\r\n・製造工場\r\n国内で製造しています。', '5.jpg'),
(8, '白いダース', 158, 100, 9, '・内容量：４５ｇ（１２粒）\r\n\r\n・栄養成分[ １粒（標準3.8ｇ）当り ]\r\n熱量:22ｋｃａｌ たんぱく質:0.3ｇ 脂質:1.5ｇ 炭水化物:1.9ｇ ナトリウム:3.2ｍｇ\r\n\r\n・原材料\r\n砂糖 全粉乳 ココアバター 植物油脂 脱脂粉乳 乳化剤（大豆由来） 香料\r\n\r\n・製造工場\r\n国内で製造しています。', '6.jpg'),
(9, 'ダース<ミント>', 158, 100, 9, '・内容量：１２粒\r\n・栄養成分[ １粒（標準3.8ｇ）当り ]\r\n熱量:２３ｋｃａｌ たんぱく質:０．１８ｇ 脂質:１．５ｇ 炭水化物:２．１ｇ ナトリウム:１．４ｍｇ\r\n\r\n・原材料\r\n砂糖 カカオマス ココアバター 植物油脂 乳糖 全粉乳 デキストリン	脱脂粉乳 濃縮ホエイ バターオイル ホエイパウダー ミント風味チップ ペパーミントリーフ粉末 乳化剤（大豆由来） 香料 ベニバナ黄色素 加工デンプン クチナシ青色素 増粘多糖類\r\n\r\n・製造工場\r\n国内で製造しています。', '7.jpg'),
(10, 'チョコでくるんだザクザククッキー', 198, 100, 10, '・内容量：1個\r\n\r\n・栄養成分[ 1個（標準34ｇ）当り ]\r\n熱量：180kcal たんぱく質：1.9g 脂質：9.9g 炭水化物：20.7g	ナトリウム：50mg\r\n\r\n・原材料\r\n砂糖 小麦粉 フルーツゼリー（濃縮アプリコットピューレ 濃縮りんごピューレ 転化糖 砂糖） ショートニング カカオマス 全粉乳 ココアバター 植物油脂 チョコレートチップ アーモンド 脱脂粉乳 ココアパウダー 乳糖 食塩 果糖 グリセリン 香料 セルロース 膨脹剤 乳化剤（大豆由来） 酸味料、ゲル化剤（ペクチン） 酸化防止剤（ビタミンＣ） アナトー色素\r\n\r\n・製造工場\r\n国内で製造しています。', '8.jpg'),
(11, 'マリー', 206, 100, 10, '・内容量：２４枚（３枚パック×８袋）\r\n\r\n・栄養成分[ １枚（標準5.8ｇ）当り ]\r\n熱量:25ｋｃａｌ たんぱく質:0.4ｇ 脂質:0.6ｇ 炭水化物:4.6ｇ ナトリウム:19ｍｇ\r\n\r\n・原材料\r\n小麦粉 砂糖 牛乳 とうもろこしでん粉 ショートニング バターオイル マーガリン 全粉乳 植物油脂 ぶどう糖果糖液糖 食塩 たんぱく質濃縮ホエイパウダー 膨脹剤 香料 乳化剤（大豆由来）\r\n\r\n・製造工場\r\n国内で製造しています。', '9.jpg'),
(12, 'チョイス', 173, 100, 10, '・内容量：１６枚（２枚パック×８袋）\r\n\r\n・栄養成分[ １枚（標準9.2ｇ）当り ]\r\n熱量:48ｋｃａｌ たんぱく質:0.6ｇ 脂質:2.3ｇ 炭水化物:6.1ｇ ナトリウム:17ｍｇ\r\n\r\n・原材料\r\n小麦粉 砂糖 ショートニング 卵白 バターオイル バター 植物油脂 チーズパウダー たんぱく質濃縮ホエイパウダー 食塩 膨脹剤 香料 乳化剤(大豆由来)\r\n\r\n・製造工場\r\n国内で製造しています。', '10.jpg'),
(13, 'ムーンライト', 178, 100, 10, '・内容量：１６枚（２枚パック×８袋）\r\n\r\n・栄養成分[１枚（標準8.5ｇ）当り ]\r\n熱量:44ｋｃａｌ たんぱく質:0.5ｇ 脂質:2.3ｇ 炭水化物:5.4ｇ ナトリウム:16ｍｇ\r\n\r\n・原材料\r\n小麦粉 砂糖 ショートニング 鶏卵 バターオイル 植物油脂 マーガリン 卵黄 食塩 乳化剤(大豆由来) 香料 膨脹剤 カロテン色素\r\n\r\n・製造工場\r\n国内で製造しています。', '11.jpg'),
(14, 'チョコチップクッキー', 178, 100, 10, '・内容量：１４枚（２枚パック×７袋）\r\n\r\n・栄養成分[ １枚（標準9.5ｇ）当り ]\r\n熱量:50ｋｃａｌ たんぱく質:0.6ｇ 脂質:2.6ｇ 炭水化物:6.1ｇ ナトリウム:15ｍｇ\r\n・原材料\r\n小麦粉 チョコレートチップ ショートニング 砂糖 オートミール ぶどう糖果糖液糖 ホエイパウダー（乳製品） ココアパウダー 黒みつ 食塩 膨脹剤 乳化剤（大豆由来） 香料\r\n\r\n・製造工場\r\n国内で製造しています。', '12.jpg'),
(15, 'アーモンドクッキー', 238, 100, 10, '・内容量：１４枚（２枚パック×７袋）\r\n\r\n・栄養成分[ １枚（標準８．６ｇ）当り ]\r\n熱量:４６ｋｃａｌ たんぱく質:０．６ｇ 脂質:２．６ｇ 炭水化物:５．１ｇ ナトリウム:２１ｍｇ\r\n\r\n・原材料\r\n小麦粉 砂糖 ローストアーモンド マーガリン（乳成分を含む） ショートニング アーモンドペースト 食塩 クリーム加工品 膨脹剤 乳化剤（大豆由来） 酸化防止剤（ビタミンＥ） 香料\r\n\r\n・製造工場\r\n国内で製造しています。', '13.jpg'),
(16, '森永の煎餅<キャラメル味>', 148, 100, 11, '・内容量：50g\r\n\r\n・栄養成分[ １袋（５０ｇ）当り ]\r\n熱量:２４７ｋｃａｌ たんぱく質:２．６ｇ 脂質:１１．３ｇ 炭水化物:３３．７ｇ ナトリウム:２４５ｍｇ\r\n\r\n・原材料\r\nキャラメルクリーム（砂糖 植物油脂 乳糖 全粉乳 キャラメル粉末 食塩） 米（国産） 小麦粉 砂糖 米パフパウダー しょうゆ ぶどう糖 食塩 植物油脂 乳化剤（大豆由来） トレハロース 香料 膨脹剤 酸化防止剤（ビタミンＥ）\r\n\r\n・その他\r\n食塩相当量0.27g\r\n\r\n・製造工場\r\n国内で製造しています。', '14.jpg'),
(17, 'おっとっと<うすしお味>', 54, 100, 11, '・内容量：19g\r\n\r\n・栄養成分[ 1袋（19g）当り ]\r\n熱量：84kcal たんぱく質：1.1g 脂質：2.4g 炭水化物：14.4g ナトリウム：107mg カルシウム：52mg\r\n\r\n・原材料\r\n乾燥じゃがいも ショートニング 小麦粉 植物油脂 ホエイパウダー（乳製品） 砂糖 とうもろこしでん粉 シーズニングパウダー（食塩 乳糖 チキンパウダー オニオンエキスパウダー 酵母エキスパウダー（大豆を含む） 麦芽糖 香辛料） 食塩 たんぱく加水分解物 加工デンプン 貝Ｃａ 調味料（アミノ酸等） 膨脹剤 乳化剤 香料（キウイフルーツ由来） 酸化防止剤（ビタミンＥ ビタミンＣ） カロテン色素\r\n\r\n・その他\r\n食塩相当量0.27g\r\n\r\n・製造工場\r\n国内で製造しています。', '15.jpg'),
(18, 'ファッジ', 132, 100, 12, '・内容量：38g\r\n\r\n・栄養成分[ １袋（38ｇ）当り ]\r\n熱量:165ｋｃａｌ たんぱく質:0.9ｇ 	脂質:4.3ｇ 炭水化物:30.7ｇ ナトリウム:81ｍｇ\r\n\r\n・原材料\r\n砂糖 乳製品 水あめ クリーミングパウダー（乳製品 乳糖） 植物油脂 食塩 デキストリン ステアリン酸カルシウム 乳化剤（大豆由来） 香料 酸化防止剤（ビタミンＣ ビタミンＥ）\r\n\r\n・製造工場\r\n国内で製造しています。', '16.jpg'),
(19, 'プレミアムミルクキャラメル', 520, 100, 12, '・内容量：12粒\r\n\r\n・栄養成分[ １粒（標準4.9ｇ）当り ]\r\n熱量:21ｋｃａｌ たんぱく質:0.24ｇ 	脂質:0.49ｇ 炭水化物:3.8ｇ ナトリウム:6.4ｍｇ\r\n\r\n・原材料\r\n水あめ 加糖練乳 砂糖 生クリーム 加糖脱脂練乳 \r\n全粉乳 バター カラメルソース 小麦たんぱく モルトエキス 黒みつ 食塩 ソルビトール 乳化剤（大豆由来） 香料\r\n\r\n・製造工場\r\n国内で製造しています。', '17.jpg'),
(20, 'ハイチュウ<ゴールデンパイ>', 48, 100, 13, '・内容量 12粒\r\n\r\n・栄養成分[ 1粒（標準4.8ｇ）当り ]\r\n熱量：１９ｋｃａｌ たんぱく質 ：０．０７ｇ 脂質：０．３６ｇ 炭水化物：３．８ｇ ナトリウム：０ｍｇ\r\n\r\n・原材料\r\n水あめ 砂糖 植物油脂 ゼラチン 濃縮パインアップル果汁（ゴールデンパイン） 酸味料 香料 乳化剤 ベニバナ黄色素\r\n\r\n・製造工場\r\n国内で製造しています。', '18.jpg'),
(21, 'ハイチュウ<完熟メロン>', 108, 100, 13, '・内容量：12粒\r\n\r\n・栄養成分[ １粒（標準４．６ｇ）当り ]\r\n熱量：１９ｋｃａｌ たんぱく質 ：０．０７ｇ 脂質：０．３６ｇ 炭水化物：３．８ｇ ナトリウム：０ｍｇ\r\n\r\n・原材料\r\n水あめ、砂糖、植物油脂、ゼラチン、はちみつ、濃縮ヨーグルト、濃縮メロン果汁、香料、酸味料、乳化剤、ベニバナ黄色素、クチナシ青色素\r\n\r\n・製造工場\r\n国内で製造しています。', '19.jpg'),
(22, 'ドトールフローズンカフェ・オ・レ', 149, 100, 14, '・内容量：165ml\r\n\r\n・栄養成分[ 1カップ当り ]\r\n熱量：166kcal たんぱく質 ：2.6g 脂質：4.6g 炭水化物： 28.5g ナトリウム ：38mg\r\n\r\n・原材料\r\n砂糖、乳製品、コーヒー、水あめ、植物油、異性化液糖、デキストリン、卵黄、安定剤（ゼラチン、増粘多糖類）、乳化剤、香料\r\n\r\n・製造工場\r\n国内で製造しています。', '20.jpg'),
(23, 'アイスボックス<グレープフルーツ>', 149, 100, 14, '・内容量：135ml\r\n\r\n・栄養成分[ 1カップ当り ]\r\n熱量：13kcal たんぱく質：0g 脂質：0g 炭水化物：3.3g ナトリウム：16mg\r\n\r\n・原材料\r\nグレープフルーツ果汁、異性化液糖、香料、酸味料、甘味料(アスパルテーム・Ｌ-フェニルアラニン化合物、スクラロース、アセスルファムＫ)、ポリリン酸Na、カロテン色素\r\n\r\n・製造工場\r\n国内で製造しています。', '21.jpg'),
(24, 'チョコビスコッティ', 148, 100, 15, '・内容量：92ｍｌ\r\n\r\n・栄養成分[ 1個当り ]\r\n熱量：311kcal たんぱく質：4.6g 脂質：18.9g 炭水化物：30.7g ナトリウム：93mg\r\n\r\n・原材料\r\n乳製品、チョコレートコーチング、ビスケット（小麦を含む）、砂糖、水あめ、卵黄、デキストリン、乳化剤（大豆由来）、香料、膨脹剤、安定剤（増粘多糖類）\r\n\r\n・製造工場\r\n国内で製造しています。', '22.jpg'),
(25, 'ニコサンド', 148, 100, 15, '・内容量：40ml×2個\r\n\r\n・栄養成分[ １個当り ]\r\n熱量：107ｋｃａｌ たんぱく質：1.4g 脂質：4.5g 炭水化物：15.1g ナトリウム：63ｍｇ\r\n\r\n・原材料\r\nクッキー（小麦を含む）、砂糖、乳製品、水あめ、植物油、デキストリン、膨脹剤、乳化剤（大豆由来）、安定剤（増粘多糖類）、香料、カロテン色素\r\n\r\n・製造工場\r\n国内で製造しています。', '23.jpg'),
(26, '板チョコアイス<Wクッキー>', 148, 100, 16, '・内容量：72ｍｌ\r\n\r\n・栄養成分[ 1個当り ]\r\n熱量：301kcal たんぱく質：2.9g 脂質：20.5g 炭水化物：26.3g ナトリウム：45mg\r\n\r\n・原材料\r\nチョコレートコーチング、クッキークランチ（小麦を含む）、砂糖、乳製品、水あめ、植物油、デキストリン、	乳化剤（大豆由来）、香料、安定剤（増粘多糖類）、膨脹剤、カロテン色素\r\n\r\n・製造工場\r\n国内で製造しています。', '24.jpg'),
(27, 'ホットケーキイチゴのデザートアイス', 148, 100, 16, '・内容量：７０ｍｌ\r\n\r\n・栄養成分[ 1個当り ]\r\n熱量：196kcal たんぱく質：2.9g 脂質：7.6g 炭水化物：28.9g ナトリウム：104mg\r\n\r\n・原材料\r\nホットケーキシート（小麦粉、鶏卵、砂糖、還元水あめ、植物油、乳製品、水あめ、食塩、グルコマンナン、乳清たんぱく）、いちごソース、乳製品、砂糖、卵黄、デキストリン、水あめ、安定剤（増粘多糖類、ゼラチン）、乳化剤（大豆由来）、ｐＨ調整剤、膨脹剤、酸味料、	香料、着色料（紅麹、アナトー、ウコン）、乳酸Ｃａ、加工デンプン、脂肪酸、セルロース\r\n\r\n・製造工場\r\n国内で製造しています。', '25.jpg'),
(28, 'パキシエル', 340, 100, 17, '・内容量：40ｍｌ×7本\r\n\r\n・栄養成分[ １本当り ]\r\n熱量：１３３ｋｃａｌ たんぱく質：１.１ｇ 脂質：１０.１ｇ 炭水化物：９.４ｇ ナトリウム：１２ｍｇ\r\n\r\n・原材料\r\nチョコレートコーチング、砂糖、乳製品、植物油（ピーナッツを含む）、ココアパウダー、異性化液糖、デキストリン、乳化剤（大豆由来）、安定剤（増粘多糖類）、香料\r\n\r\n・製造工場\r\n国内で製造しています。', '26.jpg'),
(29, 'パリパリバー<バニラ>', 380, 100, 17, '・内容量：48ｍｌ×8本\r\n\r\n・栄養成分[ 1本当り ]\r\n熱量：９１kcal たんぱく質：１．２g 脂質　５．７ml 炭水化物　８．６g ナトリウム　１９mg\r\n\r\n・原材料\r\nチョコレートコーチング、砂糖、乳製品、植物油、水あめ、デキストリン、食塩、乳化剤（大豆由来）、香料、安定剤（増粘多糖類、ゼラチン）、カロテン色素\r\n\r\n・製造工場\r\n国内で製造しています。', '27.jpg'),
(30, 'ウイダーinゼリー　プロテイン', 200, 100, 18, '・内容量：180ｇ\r\n\r\n・栄養成分[ 1袋（180ｇ）当り ]\r\n熱量：90kcal たんぱく質：5.0g	脂質：0g 炭水化物：17.5g ナトリウム：79mg カルシウム：60mg ビタミンB1：0.10～0.32mg ビタミンB2：0.11～0.27mg ビタミンB6：0.33～0.76mg ビタミンB12：0.67～1.9μg ナイアシン：1.1～2.1mg 葉酸：67～800μg パントテン酸：0.55～3.7mg\r\n\r\nホエイペプチド：5,000mg クエン酸：1,000mg\r\n※上記のたんぱく質5.0gは、ホエイペプチドを含んだ量です。\r\n※上記の炭水化物17.5gは、クエン酸1,000mgを含んだ量です。\r\n\r\n・原材料\r\n果糖ぶどう糖液糖、砂糖、ホエイペプチド（ホエイたんぱく質分解物）、安定剤（大豆多糖類）、クエン酸、ゲル化剤（増粘多糖類）、乳酸Ｃａ、香料、乳化剤、塩化Ｋ、甘味料（スクラロース）、酵素処理ルチン、パントテン酸Ｃａ、葉酸、Ｖ．Ｂ６、Ｖ．Ｂ１、Ｖ．Ｂ２、Ｖ．Ｂ１２、（原材料の一部に乳成分を含む）\r\n\r\n・製造工場\r\n国内で製造しています。', '28.jpg'),
(31, 'ウイダーinゼリー　エネルギー', 173, 100, 18, '・内容量：180g\r\n\r\n・栄養成分[ 1袋（180ｇ）当り ]\r\n熱量：180kcal たんぱく質：0ｇ 脂質：0ｇ 炭水化物：45ｇ ナトリウム：43mg ビタミンA：45～120μg ビタミンB1：0.09～0.22mg ビタミンB2：0.11～0.21mg ビタミンB6：0.10～0.20mg ビタミンB12：0.20～0.67μg ナイアシン：1.0～1.9mg ビタミンC：80～190mg ビタミンD：0.42～1.7μg　ビタミンE：0.74～1.2mg 葉酸：20～80μg パントテン酸：0.46～2.1mg\r\n\r\n・原材料\r\nマルトデキストリン、果糖ぶどう糖液糖、マスカット果汁、ゲル化剤（増粘多糖類）、乳酸Ｃａ、クエン酸、Ｖ．Ｃ、クエン酸Ｎａ、香料、塩化Ｋ、乳化剤、パントテン酸Ｃａ、ナイアシン、Ｖ．Ｅ、Ｖ．Ｂ１、Ｖ．Ｂ２、Ｖ．Ｂ６、Ｖ．Ａ、葉酸、Ｖ．Ｄ、Ｖ．Ｂ１２\r\n\r\n・製造工場\r\n国内で製造しています。', '29.jpg');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='注文明細データが格納されている。' AUTO_INCREMENT=7 ;

--
-- テーブルのデータのダンプ `line`
--

INSERT INTO `line` (`lno`, `ono`, `ino`, `lprice`, `lsum`, `lpt`) VALUES
(1, 1, 2, 60, 5, 0),
(2, 2, 1, 72, 10, 72),
(3, 2, 3, 72, 5, 36),
(4, 3, 1, 72, 5, 0),
(5, 3, 2, 60, 10, 0),
(6, 4, 7, 158, 10, 158);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='会員データが格納されている。' AUTO_INCREMENT=3 ;

--
-- テーブルのデータのダンプ `member`
--

INSERT INTO `member` (`mno`, `mpass`, `mmail`, `mname`, `mpost`, `maddress`, `mtel`, `mpt`, `mcard`) VALUES
(1, '0202', '1101574@st.asojuku.ac.jp', '岩永 一鷹', '8120016', '福岡県福岡市博多区', '09057274249', 108, '0202'),
(2, '0202', 'test@test.ac.jp', 'テスト', '0202', '福岡', '090', 158, '0022');

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
-- テーブルの制約 `buy`
--
ALTER TABLE `buy`
  ADD CONSTRAINT `buy_ibfk_1` FOREIGN KEY (`mno`) REFERENCES `member` (`mno`) ON DELETE SET NULL;

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
  ADD CONSTRAINT `line_ibfk_1` FOREIGN KEY (`ono`) REFERENCES `buy` (`ono`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `line_ibfk_2` FOREIGN KEY (`ino`) REFERENCES `item` (`ino`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- テーブルの制約 `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`mno`) REFERENCES `member` (`mno`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`ino`) REFERENCES `item` (`ino`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
