<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>会員情報変更画面</title>
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
		echo '<p>会員情報変更画面</p>';
		if(isset($_SESSION['user_id'])) {
			//ユーザがログインしている場合（会員状態時）
			if(isset($_POST['fase1']) || isset($_POST['fase2']) || isset($_POST['fase3']) || isset($_POST['fase4']) || isset($_POST['fase5'])) {
				//確認ボタン、変更ボタン、更新ボタン、削除ボタンが押されたとき
				//フォームからデータの取得
				$user_id = $_POST['user_id'];
				$user_name = $_POST['user_name'];
				$user_mailadd = $_POST['user_mailadd'];
				$user_pw = $_POST['user_pw'];
				$user_post = $_POST['user_post'];
				$user_add = $_POST['user_add'];
				$user_tel = $_POST['user_tel'];
				$user_card = $_POST['user_card'];
				
				//フォームに入力されたデータの判定
				if(/*empty($user_name) || empty($user_mailadd) 
					|| empty($user_pw) || empty($user_post) 
					|| empty($user_add) || empty($user_tel) 
					|| empty($user_card) */isset($user_name) && isset($user_mailadd) 
					&& isset($user_pw) && isset($user_post) 
					&& isset($user_add) && isset($user_tel) 
					&& isset($user_card)/* || isset($user_name{21}) 
					|| isset($user_mailadd{41}) || isset($user_pw{16}) 
					|| isset($user_post{9}) || isset($user_add{101}) 
					|| isset($user_tel{14}) || isset($user_card{17})*/) {
					//通常時
					$flg = 0;
				} else {
					//入力項目に誤りがある場合
					$flg = 1;
				}
				
				if(isset($_POST['fase1'])) {
					//確認ボタンが押されたとき
					echo '<p>以下の内容に更新します。よろしいですか？</p>';
					echo '<form action="user_info_edit.php" method="POST">';
						echo '<input type="hidden" name="user_id" value="' . $user_id . '" />';
						echo'<p>氏名：' . $user_name . '<input type="hidden" name="user_name" value="' . $user_name . '" /></p>';
						echo'<p>メールアドレス：' . $user_mailadd . '<input type="hidden" name="user_mailadd" value="' . $user_mailadd . '" /></p>';
						echo'<p>パスワード：' . $user_pw . '<input type="hidden" name="user_pw" value="' . $user_pw . '" /></p>';
						echo'<p>郵便番号：' . $user_post . '<input type="hidden" name="user_post" value="' . $user_post . '" /></p>';
						echo'<p>住所：' . $user_add . '<input type="hidden" name="user_add" value="' . $user_add . '" /></p>';
						echo'<p>電話番号：' . $user_tel . '<input type="hidden" name="user_tel" value="' . $user_tel . '" /></p>';
						echo'<p>クレジットカード番号：' . $user_card . '<input type="hidden" name="user_card" value="' . $user_card . '" /></p>';
						echo'<input type="submit" value="変更" name="fase2" />';
						echo'<input type="submit" value="確定" name="fase3" />';
					echo'</form>';
					//トップ画面へのリンク
					echo'<a href="index.php">トップへ戻る</a>';
				} else if(isset($_POST['fase2']) || $flg == 1) {
					//変更ボタンが押されたとき、または入力項目に誤りがあった場合
					if($flg == 1) {
						//入力項目に誤りがあった場合
						echo'<p>入力項目に誤りがあります。</p>';
					} else {
						
					}
					echo '<form action="user_info_edit.php" method="POST">';
						echo '<input type="hidden" name="user_id" value="' . $user_id . '" />';
						echo'<p>氏名：<input type="text" name="user_name" value="' . $user_name . '" maxlength="" required /></p>';
						echo'<p>メールアドレス：<input type="text" name="user_mailadd" value="' . $user_mailadd . '" maxlength="" required /></p>';
						echo'<p>パスワード：<input type="password" name="user_pw" maxlength="" required /></p>';
						echo'<p>パスワード（確認）：<input type="password" name="user_pwch" maxlength="" required /></p>';
						echo'<p>郵便番号：<input type="text" name="user_post" value="' . $user_post . '" maxlength="" required /></p>';
						echo'<p>住所：<input type="text" name="user_add" value="' . $user_add . '" maxlength="" required /></p>';
						echo'<p>電話番号：<input type="text" name="user_tel" value="' . $user_tel . '" maxlength="" required /></p>';
						echo'<p>クレジットカード番号：<input type="text" name="user_card" value="' . $user_card . '" maxlength="" required /></p>';
						echo'<input type="submit" value="確認" name="fase1" />';
					echo'</form>';
					//トップ画面へのリンク
					echo'<a href="index.php">トップへ戻る</a>';
				} else if(isset($_POST['fase3'])) {
					//更新ボタンが押されたとき
					//自分以外の会員のメールアドレスと重複がないかの確認
					$query = "select mmail from member where mmail = '$user_mailadd' and mno != '$user_id'";
					$result = mysqli_query($dbc, $query);
					
					if(mysqli_num_rows($result) >= 1) {
						//mailの重複時の処理
						echo '<p>入力されたメールドレスは既に使われています。</p>';
					} else {
						//通常時の処理
						//SQL文格納（UPDATE）
						$query = "UPDATE member SET 
						mpass = '$user_pw', mmail = '$user_mailadd', mname = '$user_name',  
						mpost = '$user_post', maddress = '$user_add', mtel = '$user_tel', mcard = '$user_card' 
						WHERE mno = '$user_id';";
						//SQL文実行
						$result = mysqli_query($dbc, $query);
						
						//自分自身を検索
						$query = "select mmail from member where mmail = '$user_mailadd' and mpass = '$user_pw'";
						$result = mysqli_query($dbc, $query);
						//データベースとの接続を切断
						mysqli_close($dbc);
						
						if(!mysqli_num_rows($result) == 1) {
							//update処理失敗時の処理
							echo 'データの更新に失敗しました。しばらくお待ちの上再度お試し下さい。<br />';
						} else {
							//処理完了とお知らせ
							require_once('session_out.php');
							echo '<p>会員情報の更新が完了しました。</p>';
							echo '<p>トップページへ戻り、ログインしてください。</p>';
						}
					}
					//トップ画面へのリンク
					echo'<a href="index.php">トップへ戻る</a>';
				} else if(isset($_POST['fase4'])) {
					//削除ボタンが押されたとき
					//セッションから会員情報を取得
					$user_id = $_SESSION['user_id'];
					$user_name = $_SESSION['user_name'];
					$user_mailadd = $_SESSION['user_mailadd'];
					$user_post = $_SESSION['user_post'];
					$user_add = $_SESSION['user_add'];
					$user_tel = $_SESSION['user_tel'];
					$user_card = $_SESSION['user_card'];
					echo '<p>以下の会員情報を削除し、退会します。よろしいですか？</p>';
					echo '<form action="user_info_edit.php" method="POST">';
						echo '<input type="hidden" name="user_id" value="' . $user_id . '" />';
						echo'<p>氏名：' . $user_name . '<input type="hidden" name="user_name" value="' . $user_name . '" /></p>';
						echo'<p>メールアドレス：' . $user_mailadd . '<input type="hidden" name="user_mailadd" value="' . $user_mailadd . '" /></p>';
						echo'<p>パスワード：' . $user_pw . '<input type="hidden" name="user_pw" value="' . $user_pw . '" /></p>';
						echo'<p>郵便番号：' . $user_post . '<input type="hidden" name="user_post" value="' . $user_post . '" /></p>';
						echo'<p>住所：' . $user_add . '<input type="hidden" name="user_add" value="' . $user_add . '" /></p>';
						echo'<p>電話番号：' . $user_tel . '<input type="hidden" name="user_tel" value="' . $user_tel . '" /></p>';
						echo'<p>クレジットカード番号：' . $user_card . '<input type="hidden" name="user_card" value="' . $user_card . '" /></p>';
						echo'<input type="submit" value="キャンセル" name="cancel" />';
						echo'<input type="submit" value="確定" name="fase5" />';
					echo'</form>';
					//トップ画面へのリンク
					echo'<a href="index.php">トップへ戻る</a>';
				} else if(isset($_POST['fase5'])) {
					//確定ボタンが押されたとき
					//SQL文の格納、実行（DELETE）
					$query = "DELETE FROM member WHERE mno = '$user_id'";
					$result = mysqli_query($dbc, $query);
					//自分自身を検索
					$query = "select mmail from member where mmail = '$user_mailadd' and mpass = '$user_pw'";
					$result = mysqli_query($dbc, $query);
					//データベースとの接続を切断
					mysqli_close($dbc);
					
					if(mysqli_num_rows($result)) {
						//delete処理失敗時の処理
						echo 'データの削除に失敗しました。しばらくお待ちの上再度お試し下さい。';
					} else {
						//処理完了のお知らせ
						require_once('session_out.php');
						echo '<p>退会処理が完了しました。</p>';
						echo '<p>またのご利用をお待ちしております。</p>';
					}
					//トップ画面へのリンク
					echo'<a href="index.php">トップへ戻る</a>';
				}
			} else {
				//初回アクセス時
				//セッションから会員情報を取得
				$user_id = $_SESSION['user_id'];
				$user_name = $_SESSION['user_name'];
				$user_mailadd = $_SESSION['user_mailadd'];
				$user_post = $_SESSION['user_post'];
				$user_add = $_SESSION['user_add'];
				$user_tel = $_SESSION['user_tel'];
				$user_card = $_SESSION['user_card'];
				echo '<form action="user_info_edit.php" method="POST">';
					echo '<input type="hidden" name="user_id" value="' . $user_id . '">';
					echo '<p>氏名：<input type="text" name="user_name" value="' . $user_name . '" maxlength="" required /></p>';
					echo '<p>メールアドレス：<input type="text" name="user_mailadd" value="' . $user_mailadd . '" maxlength="" required /></p>';
					echo '<p>パスワード：<input type="password" name="user_pw" maxlength="" required /></p>';
					echo '<p>パスワード（確認）：<input type="password" name="user_pwch" maxlength="" required /></p>';
					echo '<p>郵便番号：<input type="text" name="user_post" value="' . $user_post . '" maxlength="" required /></p>';
					echo '<p>住所：<input type="text" name="user_add" value="' . $user_add . '" maxlength="" required /></p>';
					echo '<p>電話番号：<input type="text" name="user_tel" value="' . $user_tel . '" maxlength="" required /></p>';
					echo '<p>クレジットカード番号：<input type="text" name="user_card" value="' . $user_card . '" maxlength="" required /></p>';
					echo '<input type="submit" value="更新" name="fase1" />';
					echo '<input type="submit" value="削除" name="fase4" />';
				echo '</form>';
				//トップ画面へのリンク
				echo'<a href="index.php">トップへ戻る</a>';
			}
		} else {
			//ユーザがログアウト状態であるとき（非会員状態時）
			echo '<p>非会員であるため、この操作を行うことができません。</p>';
			echo '<a href="index.php">トップへ戻る</a>';
		}
		//パーツ導入
		require_once('ranking_menu.php');
		require_once('footer_menu.php');
	?>
</body>
</html>
