<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>ログアウト画面</title>
</head>
<body>
	<?php
		//パスの設定
		require_once('include_path.php');
		//パーツ導入
		require_once('header_menu.php');
		require_once('left_menu.php');
		//require_once('session_start.php');
		if(!isset($_SESSION['user_id'])) {
			//ログイン状態ではない場合
			echo '<p>現在ログイン状態ではありません。</p>';
			echo '<p><a href="index.php">トップへ戻る</a></p>';
		} else {
			//ログイン状態である場合
			require_once('session_out.php');
			echo '<p>ログアウトしました。</p>';
			echo '<p><a href="index.php">トップへ戻る</a></p>';
		}
		//パーツ導入
		require_once('ranking_menu.php');
		require_once('footer_menu.php');
	?>
</body>
</html>
