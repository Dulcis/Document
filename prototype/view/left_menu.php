<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<hr />
	<?php
		if (!isset($_SESSION["genre"])){
			//genreのセッションがない場合
			//includeのパス設定
			require_once('include_path.php');
			//データベース接続
			require_once('db.php');
			
			//SQL文格納（SELECT）
			$sql = "SELECT * FROM genre ORDER BY gno";
			//SQL文実行、結果の格納
			$result = mysqli_query($dbc,$sql);
			mysqli_close($dbc);
			
			// 取得したデータを一覧表示
			while($row = mysqli_fetch_array($result)){
				//セッションに格納
				$_SESSION['genre'][$row['gno']] = array(
					'genre_id' => $row['gno'],
					'genre_name' => $row['gname']
				);
				//表示処理
				$genre_id = $row['gno'];
				$genre_name = $row['gname'];
				echo '<a href="item_select.php?genre_id=' . $genre_id . '">' . $genre_name . '</a><br />';
			}
		}else{
			//genreのセッションがある場合
			//セッションからデータを取り出す
			foreach ($_SESSION['genre'] as $genre_id => $genre) {
				$genre_id = $genre['genre_id'];
				$genre_name =$genre['genre_name'];
				
				echo '<a href="item_select.php?genre_id=' . $genre_id . '">' . $genre_name . '</a><br />';
				
			}
		}
	?>
<hr />
</body>
</html>
