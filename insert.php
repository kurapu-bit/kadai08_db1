<?php
//エラー表示
ini_set("display_errors", 1); //0=非表示

//1. POSTデータ取得
$name = $_POST["name"];
$url = $_POST["url"];
$url = $_POST["rank"];
$tag = $_POST["tag"];
$naiyou = $_POST["naiyou"];

//2. DB接続します
// ローカルのデータベースにアクセスするための必要な情報を変数に渡す
$db_name = 'xxxxx';               // データベース名
$db_host = 'xxxxx';     // DBホスト
$db_id   = 'xxxxx';               // ユーザー名(さくらサーバはDB名と同一)
$db_pw   = 'xxxxx';                   // パスワード

// try catch構文でデータベースの情報取得を実施
try {
    $server_info = 'mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host;
    $pdo = new PDO($server_info, $db_id, $db_pw);
} catch (PDOException $e) {
  exit('DBConnectError!!:'.$e->getMessage());
}


//３．データ登録SQL作成
$sql = "INSERT INTO gs_bm_table(書籍名,書籍URL,評価,タグ,コメント,登録日時)VALUES(:name,:url,:rank,:tag,:naiyou,sysdate()); "; //ここにINSERT文
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name); //サニタイジング・無効化
$stmt->bindValue(':url', $url);
$stmt->bindValue(':rank', $rank);
$stmt->bindValue(':tag', $tag);
$stmt->bindValue(':naiyou', $naiyou);
$status = $stmt->execute();
//$status true=成功, false=SQLエラー

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("SQLError!!:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("Location: index.php");
  exit();
}
?>