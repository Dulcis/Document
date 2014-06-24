<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>カート画面</title>
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
		if(isset($_SESSION['user_id'])) {
			//会員である場合
			$user_id = $_SESSION['user_id'];
			$dbc = mysqli_connect(db_host, db_user, db_pass, db_name);
			if(isset($_POST['change']) || isset($_POST['delete'])) {
				//変更、削除ボタンが押されたとき
				//対象となる商品番号と数量を取得
				$item_id = $_POST['item_id'];
				$item_sum = $_POST['item_sum'];
				if(isset($_POST['delete']) || $item_sum == 0) {
					//削除ボタン、または取得した数量が0だった場合
					$query = "DELETE FROM cart WHERE ino = '$item_id'";
					$result = mysqli_query($dbc, $query);
				} else {
					//変更ボタンが押されたとき
					$query = "UPDATE cart SET 
							csum = '$item_sum' 
							WHERE ino = '$item_id' and mno = '$user_id'";
					$result = mysqli_query($dbc, $query);
				}
			echo '変更が適用されました。';
			}
			//SQLでカート情報を取得する
			$query = "SELECT * 
					FROM cart c INNER JOIN item i ON c.ino = i.ino 
						INNER JOIN genre g ON i.gno = g.gno 
					WHERE c.mno = '$user_id'";
			$result = mysqli_query($dbc, $query);
			mysqli_close($dbc);
			//取得したデータを一覧表示
			if(mysqli_num_rows($result) == 0) {
				//カートに商品が無い場合
				echo "カートに商品が入っていません。";
			} else {
				//カートに商品がある場合
				while($row = mysqli_fetch_array($result)) {
					//SQLの結果からデータを取得
					$item_id = $row['ino'];
					$item_name = $row['iname'];
					$item_img = $row['iimg'];
					$genre_id = $row['gno'];
					$genre_name = $row['gname'];
					$item_price = $row['iprice'];
					$item_sum = $row['csum'];
					//表示処理
					echo '<form action="cart.php" method="POST">';
						echo '<input type="hidden" name="item_id" value="' . $item_id . '">';
						echo '<a href="item.php?item_id=' . $item_id . '">' . $item_name . '</a>';
						echo '<a href="item_select.php?genre_id=' . $genre_id . '">' . $genre_name . '</a><br />';
						echo '<a href="item.php?item_id=' . $item_id . '"><img src="' . ipath . $item_img . '" alt="' . $item_name . '" /></a>';
						echo '価格：' . $item_price . '<br />';
						echo '数量：<input type="number" name="item_sum" value="' . $item_sum . '" min="0" max="99" /><br />';
						echo '<input type="submit" name="change" value="変更" />';
						echo '<input type="submit" name="delete" value="削除" />';
					echo '</form>';
					echo '<br />';
				}
				echo '<form action="buy.php" method="POST">';
					echo '<input type="submit" name="buy" value="購入手続きへ進む" />';
				echo '</form>';
			}
		} else {
			//会員でない場合
			//セッションにカートがあるかの確認
			if(isset($_SESSION['cart'])) {
				//カートがあった場合
				if(isset($_POST['change']) || isset($_POST['delete'])) {
					//変更、削除ボタンが押されたとき
					//対象となる商品番号と数量を取得
					$item_id = $_POST['item_id'];
					$item_sum = $_POST['item_sum'];
					if(isset($_POST['delete']) || $item_sum == 0) {
						//削除ボタン、または取得した数量が0だった場合
						unset($_SESSION['cart'][$item_id]);
						if(count($_SESSION['cart']) == 0) {
							//カートが空になった場合
							unset($_SESSION['cart']);
						}
					} else {
						//変更ボタンが押されたとき
						$_SESSION['cart'][$item_id]['item_sum'] = $item_sum;
					}
				echo '変更が適用されました。';
				}
				//取得したデータを一覧表示
				if(!isset($_SESSION['cart'])) {
					//カートに商品が無い場合
					echo "カートに商品が入っていません。";
				} else {
					//カートに商品がある場合
					foreach($_SESSION['cart'] as $item_id => $cart) {
						//セッションのカートからデータを取得
						$item_name = $cart['item_name'];
						$genre_id = $cart['genre_id'];
						$genre_name = $cart['genre_name'];
						$item_price = $cart['item_price'];
						$item_img = $cart['item_img'];
						$item_sum = $cart['item_sum'];
							//表示処理
							echo '<form action="cart.php" method="POST">';
								echo '<input type="hidden" name="item_id" value="' . $item_id . '">';
								echo '<a href="item.php?item_id=' . $item_id . '">' . $item_name . '</a>';
								echo '<a href="item_select.php?genre_id=' . $genre_id . '">' . $genre_name . '</a><br />';
								echo '<a href="item.php?item_id=' . $item_id . '"><img src="' . ipath . $item_img . '" alt="' . $item_name . '" /></a>';
								echo '価格：' . $item_price . '<br />';
								echo '数量：<input type="number" name="item_sum" value="' . $item_sum . '" min="0" max="99" /><br />';
								echo '<input type="submit" name="change" value="変更" />';
								echo '<input type="submit" name="delete" value="削除" />';
							echo '</form>';
							echo '<br />';
					}
					echo '<form action="buy.php" method="POST">';
						echo '<input type="submit" name="buy" value="購入手続きへ進む" />';
					echo '</form>';
				}
			} else {
				//カートが無かった場合
				echo 'カートに商品が入っていません。';
			}
		}
		//パーツ導入
		require_once('ranking_menu.php');
		require_once('footer_menu.php');
	?>
</body>
</html>