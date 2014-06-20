<?php
//データベースへの接続情報
//ローカル側
define('db_host', 'localhost');
define('db_user', 'root');
define('db_pass', '0202');
define('db_name', 'dulcis');


//サーバ側
/*define('db_host', '172.20.17.214');
define('db_user', 'user1');
define('db_pass', '');
define('db_name', 'dulcis');
*/
$dbc = mysqli_connect(db_host, db_user, db_pass, db_name);
?>