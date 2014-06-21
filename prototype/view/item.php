<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>商品詳細画面</title>
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
		if(isset($_GET['item_id'])) {
			$item_id = $_GET['item_id'];
		}
		if(isset($_POST['item_id'])) {
			//カートに入れるボタンが押されたとき
			$item_id = $_POST['item_id'];
			$item_name = $_POST['item_name'];
			$genre_id = $_POST['genre_id'];
			$genre_name = $_POST['genre_name'];
			$item_price = $_POST['item_price'];
			$item_img = $_POST['item_img'];
			$item_sum = $_POST['item_sum'];
			if(isset($_SESSION['user_id'])) {
				//会員の処理
				$user_id = $_SESSION['user_id'];
				$dbc = mysqli_connect(db_host, db_user, db_pass, db_name);
				$query = "select * from cart where mno = '$user_id' and ino = '$item_id'";
				$result = mysqli_query($dbc, $query);
				mysqli_close($dbc);
				if(mysqli_num_rows($result) == 1) {
					//既に商品があった場合
					while($row = mysqli_fetch_array($result)) {
						$item_sumupdate = $row['csum'] + $item_sum;
					}
					$dbc = mysqli_connect(db_host, db_user, db_pass, db_name);
					$query = "update cart set csum = '$item_sumupdate' 
							where mno = '$user_id' and ino = '$item_id'";
					$result = mysqli_query($dbc, $query);
					mysqli_close($dbc);
				} else {
					//新規商品であった場合
					//SQL文格納（INSERT）（※実装時はテーブル名の修正が必要）
					$dbc = mysqli_connect(db_host, db_user, db_pass, db_name);
					$query = "INSERT INTO cart(mno, ino, csum) 
							VALUE ('$user_id', '$item_id', '$item_sum')";
					//SQL文実行
					$result = mysqli_query($dbc, $query);
					mysqli_close($dbc);
				}
			} else {
				//非会員の処理
				if(isset($_SESSION['cart'][$item_id])) {
					//カートがあった場合
					$_SESSION['cart'][$item_id]['item_sum'] += $item_sum;
					
				} else {
					//カートがなかった場合
					$_SESSION['cart'][$item_id]['item_name'] = $item_name;
					$_SESSION['cart'][$item_id]['genre_id'] = $genre_id;
					$_SESSION['cart'][$item_id]['genre_name'] = $genre_name;
					$_SESSION['cart'][$item_id]['item_price'] = $item_price;
					$_SESSION['cart'][$item_id]['item_img'] = $item_img;
					$_SESSION['cart'][$item_id]['item_sum'] = $item_sum;
				}
			}
			echo '商品の追加が完了しました。';
		}
		$dbc = mysqli_connect(db_host, db_user, db_pass, db_name);
		$query = "select * from item a left join genre b on a.gno = b.gno where a.ino = '$item_id'";
		$result = mysqli_query($dbc, $query);
		mysqli_close($dbc);
		//arrayのデータ数分繰り返し、表示する
		while($row = mysqli_fetch_array($result)) {
			//結果を変数へ格納
			$item_id = $row['ino'];
			$item_name = $row['iname'];
			$item_price = $row['iprice'];
			$item_sum = $row['isum'];
			$genre_id = $row['gno'];
			$genre_name = $row['gname'];
			$item_co = $row['ico'];
			$item_img = $row['iimg'];
			//表示する処理
			echo '<form action="item.php" method="POST">';
				echo '<input type="hidden" name="item_id" value="' . $item_id . '" />';
				echo '<input type="hidden" name="item_name" value="' . $item_name . '" />';
				echo '<input type="hidden" name="item_price" value="' . $item_price . '" />';
				echo '<input type="hidden" name="genre_id" value="' . $genre_id . '" />';
				echo '<input type="hidden" name="genre_name" value="' . $genre_name . '" />';
				echo '<input type="hidden" name="item_img" value="' . $item_img . '" />';
				echo '<p>商品名：' . $item_name . '</p>';
				echo '<p><img src="' . ipath . $item_img . '" alt="' . $item_name . '" /></p>';
				echo '<p>単価：' . $item_price . '</p>';
				echo '<p>在庫数：' . $item_sum . '</p>';
				echo '数量：<input type="number" name="item_sum" min="1" max="10" value="1" />';
				echo '<p>ジャンル名：' . $genre_name . '</p>';
				echo '<p>商品詳細情報：<br />' . nl2br($item_co) . '</p>';
				echo '<input type="submit" value="カートに入れる" />';
			echo '</form>';
		}
		//パーツ導入
		require_once('ranking_menu.php');
		require_once('footer_menu.php');
	?>
</body>
</html>
