<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>ログイン画面</title>
</head>
<body>
	<?php
		//パスの設定
		require_once('include_path.php');
		//パーツ導入
		require_once('header_menu.php');
		require_once('left_menu.php');
		//データベースへ接続
		require_once('db.php');
		//require_once('session_start.php');
		if(!isset($_SESSION['user_id'])) {
			//ログイン状態ではない場合
			if(isset($_POST['fase1'])) {
				//データの取得
				$user_mailadd = $_POST['user_mailadd'];
				$user_pw = $_POST['user_pw'];
				//データベースへ問合せ
				$query = "select * from member where mmail = '$user_mailadd' and mpass = '$user_pw'";
				$result = mysqli_query($dbc, $query);
				mysqli_close($dbc);
				//問合せ結果から数値をもらう
				if(!mysqli_num_rows($result) == 1) {
					//ログイン失敗時
					echo '<p>ログインに失敗しました。</p>';
					echo '<p><a href="index.php">戻る</a></p>';
				} else {
					//ログイン成功時
					while($row = mysqli_fetch_array($result)) {
						//ユーザ情報をセッションに格納する。
						$_SESSION['user_id'] = $row['mno'];
						$_SESSION['user_name'] = $row['mname'];
						$_SESSION['user_pw'] = $row['mpass'];
						$_SESSION['user_mailadd'] = $row['mmail'];
						$_SESSION['user_post'] = $row['mpost'];
						$_SESSION['user_add'] = $row['maddress'];
						$_SESSION['user_tel'] = $row['mtel'];
						$_SESSION['user_pt'] = $row['mpt'];
						$_SESSION['user_card'] = $row['mcard'];
						
					}
					echo '<p>ログインが完了しました。</p>';
					echo '<p><a href="index.php">トップへ戻る</a></p>';
				}
			} else {
				echo '<p>ログイン画面</p>';
				echo '<form action="login.php" method="POST">';
					echo '<p>メールアドレス<input type="text" name="user_mailadd" required /></p>';
					echo '<p>パスワード<input type="password" name="user_pw" required /></p>';
					echo '<p><input type="submit" value="ログイン" name="fase1" /></p>';
				echo '</form>';
				echo '<p><a href="index.php">トップへ戻る</a></p>';
			}
		} else {
			//ログイン状態である場合
			echo '<p>既にログイン状態です。</p>';
			echo '<p><a href="index.php">トップへ戻る</a></p>';
		}
		//パーツ導入
		require_once('ranking_menu.php');
		require_once('footer_menu.php');
	?>
</body>
</html>
