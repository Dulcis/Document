<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>商品検索結果一覧画面</title>
</head>
<body>
	<?php
		//パスの設定
		require_once('include_path.php');
		require_once('ipath.php');
		//パーツ導入
		require_once('header_menu.php');
		require_once('left_menu.php');
		//データベースへ接続
		require_once('db.php');
		//require_once('session_start.php');
		if(isset($_POST['item_word'])) {
			//検索ボタンが押されたとき。
			//検索ワードを取得
			$item_word = '%' . $_POST['item_word'] . '%';
			
			//SQL文の格納
			$dbc = mysqli_connect(db_host, db_user, db_pass, db_name);
			$query = "select * from item, genre 
					where item.gno = genre.gno and item.iname like '$item_word' 
					order by item.iname";
			$result = mysqli_query($dbc, $query);
			mysqli_close($dbc);
			echo '<p>検索ワード：' . $_POST['item_word'] . '</p>';
			if(mysqli_num_rows($result) == 0) {
				//該当する商品が見つからない場合
				echo '該当する商品が見つかりませんでした。';
			} else {
				//arrayのデータ数分繰り返し、表示する
				while($row = mysqli_fetch_array($result)) {
					//結果を変数へ格納
					$item_id = $row['ino'];
					$item_name = $row['iname'];
					$item_price = $row['iprice'];
					$item_sum = $row['isum'];
					$genre_id = $row['gno'];
					$genre_name = $row['gname'];
					$item_img = $row['iimg'];
					//表示する処理
					echo '<a href="item.php?item_id=' . $item_id . '">' . $item_name . '</a>';
					echo '<a href="item_select.php?genre_id=' . $genre_id . '">' . $genre_name . '</a><br />';
					echo '<a href="item.php?item_id=' . $item_id . '"><img src="' . ipath . $item_img . '" alt="' . $item_name . '" /></a>';
					echo '<p>単価：' . $item_price . '</p>';
					echo '<p>在庫数：' . $item_sum . '</p>';
				}
			}
		} else if($_GET['genre_id']) {
			//ジャンルボタンが押されたとき。
			//ジャンル番号を取得
			$genre_id = $_GET['genre_id'];
			
			//SQL文の格納
			$dbc = mysqli_connect(db_host, db_user, db_pass, db_name);
			$query = "select * from item, genre 
					where item.gno = genre.gno and item.gno = '$genre_id' 
					order by item.iname";
			$result = mysqli_query($dbc, $query);
			mysqli_close($dbc);
			if(mysqli_num_rows($result) == 0) {
				//該当する商品が見つからない場合
				echo '該当する商品が見つかりませんでした。';
			} else {
				//arrayのデータ数分繰り返し、表示する
				while($row = mysqli_fetch_array($result)) {
					//結果を変数へ格納
					$item_id = $row['ino'];
					$item_name = $row['iname'];
					$item_price = $row['iprice'];
					$item_sum = $row['isum'];
					$genre_id = $row['gno'];
					$genre_name = $row['gname'];
					$item_img = $row['iimg'];
					//表示する処理
					echo '<a href="item.php?item_id=' . $item_id . '">' . $item_name . '</a>';
					echo '<a href="item_select.php?genre_id=' . $genre_id . '">' . $genre_name . '</a><br />';
					echo '<a href="item.php?item_id=' . $item_id . '"><img src="' . ipath . $item_img . '" alt="' . $item_name . '" /></a>';
					echo '<p>単価：' . $item_price . '</p>';
					echo '<p>在庫数：' . $item_sum . '</p>';
				}
			}
		} else {
			//それ以外の時
			echo '検索ワードを入力し検索ボタンを押すか、ジャンルを選んでください。';
		}
		//パーツ導入
		require_once('ranking_menu.php');
		require_once('footer_menu.php');
	?>
</body>
</html>