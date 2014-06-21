<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>購入画面</title>
</head>
<body>
	<?php
		//パスの設定
		require_once('include_path.php');
		require_once('ipath.php');
		//パーツ導入
		require_once('header_menu.php');
		require_once('left_menu.php');
		//require_once('session_start.php');
		if(isset($_SESSION['user_id'])) {
			//会員である場合、セッションから会員情報を取得する
			$user_id = $_SESSION['user_id'];
			if(isset($_POST['query'])) {
				//決済ボタンが押されたとき
				//データを取得する
				$user_name = $_POST['user_name'];
				$user_mailadd = $_POST['user_mailadd'];
				$user_post = $_POST['user_post'];
				$user_add = $_POST['user_add'];
				$user_tel = $_POST['user_tel'];
				$user_card = $_POST['user_card'];
				$buy_price = $_POST['buy_price'];
				$buy_pt = $_POST['buy_pt'];
				$pt = $_POST['pt'];
				$user_pt = $_POST['user_pt'];
				
				require_once('db.php');
				if($pt == 1) {
					//ポイント使用時（減算）
					$query = "UPDATE member SET 
					mpt = mpt - '$user_pt' 
					WHERE mno = '$user_id';";
					$result = mysqli_query($dbc, $query);
				}
				//注文テーブルにデータを挿入
				$query = "INSERT INTO buy(mno, oname, omail, opost, oaddress, otel, ocard, osum, opt) 
						VALUE ('$user_id', '$user_name', '$user_mailadd', '$user_post', '$user_add', '$user_tel', '$user_card', '$buy_price', '$buy_pt')";
				$result = mysqli_query($dbc, $query);
				
				//注文テーブルから先ほど挿入したデータを検索
				$query = "select ono from buy where mno = '$user_id' order by odate desc limit 1";
				$result = mysqli_query($dbc, $query);
				//注文番号を取得
				while($row = mysqli_fetch_array($result)) {
					$buy_id = $row['ono'];
				}
				//カートから商品データを取得
				$query = "SELECT * 
						FROM cart c INNER JOIN item i ON c.ino = i.ino 
						WHERE c.mno = '$user_id'";
				$result2 = mysqli_query($dbc, $query);
				while($row2 = mysqli_fetch_array($result2)) {
					//SQLの結果からデータを取得
					$item_id = $row2['ino'];
					$item_price = $row2['iprice'];
					$item_sum = $row2['csum'];
					$item_pt = floor(($item_price * $item_sum) / 10);
					//注文明細テーブルへ挿入
					$query = "INSERT INTO line(ono, ino, lprice, lsum, lpt) 
							VALUE ('$buy_id', '$item_id', '$item_price', '$item_sum', '$item_pt')";
					$result = mysqli_query($dbc, $query);
				}
				//累計ポイントに発生ポイントを追加
				$query = "UPDATE member SET 
				mpt = mpt + '$buy_pt' 
				WHERE mno = '$user_id';";
				$result = mysqli_query($dbc, $query);
				//累計ポイントを取り出す
				$query = "select mpt from member where mno = '$user_id'";
				$result3 = mysqli_query($dbc, $query);
				while($row3 = mysqli_fetch_array($result3)) {
					//セッションの累計ポイントに反映
					$_SESSION['user_pt'] = $row3['mpt'];
				}
				//カートを削除
				$query = "DELETE FROM cart WHERE mno = '$user_id'";
				$result = mysqli_query($dbc, $query);
				mysqli_close($dbc);
				echo '商品の購入が完了しました。';
			} else {
				//カート内の商品を表示する
				//SQLでカート情報を取得する
				require_once('db.php');
				$query = "SELECT * 
						FROM cart c INNER JOIN item i ON c.ino = i.ino 
							INNER JOIN genre g ON i.gno = g.gno 
						WHERE c.mno = '$user_id'";
				$result = mysqli_query($dbc, $query);
				mysqli_close($dbc);
				//合計金額、発生ポイント変数初期化
				$buy_price = 0;
				$buy_pt = 0;
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
						echo '<a href="item.php?item_id=' . $item_id . '">' . $item_name . '</a>';
						echo '<a href="item_select.php?genre_id=' . $genre_id . '">' . $genre_name . '</a><br />';
						echo '<a href="item.php?item_id=' . $item_id . '"><img src="' . ipath . $item_img . '" alt="' . $item_name . '" /></a><br />';
						echo '価格：' . $item_price . '<br />';
						echo '数量：' . $item_sum . '<br />';
						echo '<br />';
						
						//支払合計金額を集計
						$buy_price += $item_price * $item_sum;
						//発生ポイントを集計
						$buy_pt += floor($item_price * $item_sum / 10);
					}
					
					if(isset($_POST['check'])) {
						//確認ボタンが押されたとき
						//フォームに入力された情報を取得
						$user_name = $_POST['user_name'];
						$user_mailadd = $_POST['user_mailadd'];
						$user_post = $_POST['user_post'];
						$user_add = $_POST['user_add'];
						$user_tel = $_POST['user_tel'];
						$user_pt = $_POST['user_pt'];
						$user_card = $_POST['user_card'];
						//合計金額
						$buy_price = $_POST['buy_price'];
						//ポイント使用の有無
						$pt = $_POST['pt'];
						//今回発生するポイント
						$buy_pt = $_POST['buy_pt'];
						
						//表示処理
						echo '<form action="buy.php" method="POST">';
							//会員情報
							echo '<p>商品の送り先</p>';
							echo '<input type="hidden" name="user_name" value="' . $user_name . '" />';
							echo '<p>名前：' . $user_name . '</p>';
							echo '<input type="hidden" name="user_mailadd" value="' . $user_mailadd . '" />';
							echo '<p>メールアドレス：' . $user_mailadd . '</p>';
							echo '<input type="hidden" name="user_post" value="' . $user_post . '" />';
							echo '<p>郵便番号：' . $user_post . '</p>';
							echo '<input type="hidden" name="user_add" value="' . $user_add . '" />';
							echo '<p>住所：' . $user_add . '</p>';
							echo '<input type="hidden" name="user_tel" value="' . $user_tel . '" />';
							echo '<p>電話番号：' . $user_tel . '</p>';
							echo '<input type="hidden" name="user_card" value="' . $user_card . '" />';
							echo '<p>クレジットカード番号：' . $user_card . '</p>';
							echo '<p>ポイントを使用';
							if($pt == 0) {
								//ポイントを使用しない場合
								echo 'しない</p>';
								echo '<p>合計金額：' . $buy_price . '</p>';
							} else {
								//ポイントを使用する場合
								echo 'する</p>';
								if($user_pt > $buy_price) {
									//累計ポイントが合計金額を上回っていた場合
									$user_pt = $buy_price;
								}
								echo '<p>使用するポイント数：' . $user_pt . '</p>';
								echo '<p>合計金額：' . $buy_price . '</p>';
								echo '<p>ポイント適用後の合計金額：' . $buy_price -= $user_pt . '</p>';
							}
							//金額やボタンなど
							echo '<input type="hidden" name="pt" value="' . $pt . '" />';
							echo '<input type="hidden" name="user_pt" value="' . $user_pt . '" />';
							echo '<input type="hidden" name="buy_price" value="' . $buy_price . '" />';
							echo '<p>今回発生するポイント：' . $buy_pt . '</p>';
							echo '<input type="hidden" name="buy_pt" value="' . $buy_pt . '">';
							echo '<p>以上の内容で購入手続きを行います。よろしいですか？</p>';
							echo '<input type="submit" name="query" value="決済" />';
							echo '<input type="submit" name="change" value="変更" />';
							echo '<a href="cart.php">カートへ戻る</a>';
						echo '</form>';
						
					} else {
						 if(isset($_POST['change'])){
							//変更ボタンが押されたとき
							$user_name = $_POST['user_name'];
							$user_mailadd = $_POST['user_mailadd'];
							$user_post = $_POST['user_post'];
							$user_add = $_POST['user_add'];
							$user_tel = $_POST['user_tel'];
							$user_pt = $_POST['user_pt'];
							$user_card = $_POST['user_card'];
						} else {
							//初回アクセス時
							//セッションから会員情報を取得
							$user_name = $_SESSION['user_name'];
							$user_mailadd = $_SESSION['user_mailadd'];
							$user_post = $_SESSION['user_post'];
							$user_add = $_SESSION['user_add'];
							$user_tel = $_SESSION['user_tel'];
							$user_pt = $_SESSION['user_pt'];
							$user_card = $_SESSION['user_card'];
						}
						echo '<form action="buy.php" method="POST">';
							//会員情報
							echo '<p>商品の送り先</p>';
							echo '<p>名前：<input type="text" name="user_name" value="' . $user_name . '" required /></p>';
							echo '<p>メールアドレス：<input type="text" name="user_mailadd" value="' . $user_mailadd . '" required /></p>';
							echo '<p>郵便番号：<input type="text" name="user_post" value="' . $user_post . '" required /></p>';
							echo '<p>住所：<input type="text" name="user_add" value="' . $user_add . '" required /></p>';
							echo '<p>電話番号：<input type="text" name="user_tel" value="' . $user_tel . '" required /></p>';
							echo '<p>クレジットカード番号：<input type="text" name="user_card" value="' . $user_card . '" required /></p>';
							echo '<input type="hidden" name="user_pt" value="' . $user_pt . '">';
							echo '<p>累計ポイント：' . $user_pt . '</p>';
							echo '<p>ポイントを　<input type="radio" name="pt" value="1" checked />使う　<input type="radio" name="pt" value="0" />使わない</p>';
							//金額やボタンなど
							echo '<input type="hidden" name="buy_price" value="' . $buy_price . '" />';
							echo '<p>合計金額：' . $buy_price . '</p>';
							echo '<p>今回発生するポイント：' . $buy_pt . '</p>';
							echo '<input type="hidden" name="buy_pt" value="' . $buy_pt . '" />';
							echo '<input type="submit" name="check" value="確認" />';
							echo '<a href="cart.php">カートへ戻る</a>';
						echo '</form>';
					}
				}
			}
		} else {
			//会員でない場合
			if(isset($_POST['query'])) {
				//決済ボタンが押されたとき
				//データを取得する
				$user_name = $_POST['user_name'];
				$user_mailadd = $_POST['user_mailadd'];
				$user_post = $_POST['user_post'];
				$user_add = $_POST['user_add'];
				$user_tel = $_POST['user_tel'];
				$user_card = $_POST['user_card'];
				$buy_price = $_POST['buy_price'];
				
				require_once('db.php');
				//注文テーブルにデータを挿入
				$query = "INSERT INTO buy(oname, omail, opost, oaddress, otel, ocard, osum) 
						VALUE ('$user_name', '$user_mailadd', '$user_post', '$user_add', '$user_tel', '$user_card', '$buy_price')";
				$result = mysqli_query($dbc, $query);
				
				//注文テーブルから先ほど挿入したデータを検索
				$query = "select ono from buy where omail = '$user_mailadd' order by odate desc limit 1";
				$result = mysqli_query($dbc, $query);
				//注文番号を取得
				while($row = mysqli_fetch_array($result)) {
					$buy_id = $row['ono'];
				}
				//セッションのカートから商品データを取得
				foreach($_SESSION['cart'] as $item_id => $cart) {
					$item_name = $cart['item_name'];
					$item_price = $cart['item_price'];
					$item_sum = $cart['item_sum'];
					//注文明細テーブルへ挿入
					$query = "INSERT INTO line(ono, ino, lprice, lsum) 
							VALUE ('$buy_id', '$item_id', '$item_price', '$item_sum')";
					$result = mysqli_query($dbc, $query);
				}
				//カートを削除
				unset($_SESSION['cart']);
				mysqli_close($dbc);
				echo '商品の購入が完了しました。';
			} else {
				//カート内の商品を表示する
				//合計金額変数初期化
				$buy_price = 0;
				//取得したデータを一覧表示
				if(!isset($_SESSION['cart'])) {
					//カートに商品が無い場合
					echo "カートに商品が入っていません。";
				} else {
					//カートに商品がある場合
					require_once('db.php');
					foreach($_SESSION['cart'] as $item_id => $cart) {
						//セッションのカートからデータを取得
						$item_name = $cart['item_name'];
						$genre_id = $cart['genre_id'];
						$genre_name = $cart['genre_name'];
						$item_price = $cart['item_price'];
						$item_img = $cart['item_img'];
						$item_sum = $cart['item_sum'];
						//表示処理
						echo '<a href="item.php?item_id=' . $item_id . '">' . $item_name . '</a>';
						echo '<a href="item_select.php?genre_id=' . $genre_id . '">' . $genre_name . '</a><br />';
						echo '<a href="item.php?item_id=' . $item_id . '"><img src="' . ipath . $item_img . '" alt="' . $item_name . '" /></a><br />';
						echo '価格：' . $item_price . '<br />';
						echo '数量：' . $item_sum . '<br />';
						echo '<br />';
						
						//支払合計金額を集計
						$buy_price += $item_price * $item_sum;
					}
					if(isset($_POST['check'])) {
						//確認ボタンが押されたとき
						//フォームに入力された情報を取得
						$user_name = $_POST['user_name'];
						$user_mailadd = $_POST['user_mailadd'];
						$user_post = $_POST['user_post'];
						$user_add = $_POST['user_add'];
						$user_tel = $_POST['user_tel'];
						$user_card = $_POST['user_card'];
						//合計金額
						$buy_price = $_POST['buy_price'];
						//表示処理
						echo '<form action="buy.php" method="POST">';
							//お客様情報
							echo '<p>商品の送り先</p>';
							echo '<input type="hidden" name="user_name" value="' . $user_name . '" />';
							echo '<p>名前：' . $user_name . '</p>';
							echo '<input type="hidden" name="user_mailadd" value="' . $user_mailadd . '" />';
							echo '<p>メールアドレス：' . $user_mailadd . '</p>';
							echo '<input type="hidden" name="user_post" value="' . $user_post . '" />';
							echo '<p>郵便番号：' . $user_post . '</p>';
							echo '<input type="hidden" name="user_add" value="' . $user_add . '" />';
							echo '<p>住所：' . $user_add . '</p>';
							echo '<input type="hidden" name="user_tel" value="' . $user_tel . '" />';
							echo '<p>電話番号：' . $user_tel . '</p>';
							echo '<input type="hidden" name="user_card" value="' . $user_card . '" />';
							echo '<p>クレジットカード番号：' . $user_card . '</p>';
							echo '<p>合計金額：' . $buy_price . '</p>';
							//金額や、ボタンなど
							echo '<input type="hidden" name="buy_price" value="' . $buy_price . '" />';
							echo '<p>以上の内容で購入手続きを行います。よろしいですか？</p>';
							echo '<input type="submit" name="query" value="決済" />';
							echo '<input type="submit" name="change" value="変更" />';
							echo '<a href="cart.php">カートへ戻る</a>';
						echo '</form>';
						
					} else {
						 if(isset($_POST['change'])){
							//変更ボタンが押されたとき
							$user_name = $_POST['user_name'];
							$user_mailadd = $_POST['user_mailadd'];
							$user_post = $_POST['user_post'];
							$user_add = $_POST['user_add'];
							$user_tel = $_POST['user_tel'];
							$user_card = $_POST['user_card'];
							echo '<form action="buy.php" method="POST">';
								//お客様情報
								echo '<p>商品の送り先</p>';
								echo '<p>名前：<input type="text" name="user_name" value="' . $user_name . '" required /></p>';
								echo '<p>メールアドレス：<input type="text" name="user_mailadd" value="' . $user_mailadd . '" required /></p>';
								echo '<p>郵便番号：<input type="text" name="user_post" value="' . $user_post . '" required /></p>';
								echo '<p>住所：<input type="text" name="user_add" value="' . $user_add . '" required /></p>';
								echo '<p>電話番号：<input type="text" name="user_tel" value="' . $user_tel . '" required /></p>';
								echo '<p>クレジットカード番号：<input type="text" name="user_card" value="' . $user_card . '" required /></p>';
								//金額やボタンなど
								echo '<input type="hidden" name="buy_price" value="' . $buy_price . '" />';
								echo '<p>合計金額：' . $buy_price . '</p>';
								echo '<input type="submit" name="check" value="確認" />';
								echo '<a href="cart.php">カートへ戻る</a>';
							echo '</form>';
						} else {
							//初回アクセス時
							echo '<form action="buy.php" method="POST">';
								//お客様情報
								echo '<p>商品の送り先</p>';
								echo '<p>名前：<input type="text" name="user_name" required /></p>';
								echo '<p>メールアドレス：<input type="text" name="user_mailadd" required /></p>';
								echo '<p>郵便番号：<input type="text" name="user_post" required /></p>';
								echo '<p>住所：<input type="text" name="user_add" required /></p>';
								echo '<p>電話番号：<input type="text" name="user_tel" required /></p>';
								echo '<p>クレジットカード番号：<input type="text" name="user_card" required /></p>';
								//金額やボタンなど
								echo '<input type="hidden" name="buy_price" value="' . $buy_price . '" />';
								echo '<p>合計金額：' . $buy_price . '</p>';
								echo '<input type="submit" name="check" value="確認" />';
								echo '<a href="cart.php">カートへ戻る</a>';
							echo '</form>';
						}
					}
				}
			}
		}
		//パーツ導入
		require_once('ranking_menu.php');
		require_once('footer_menu.php');
	?>
</body>
</html>