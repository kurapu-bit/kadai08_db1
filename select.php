<?php
//エラー表示
ini_set("display_errors", 1);

//1.  DB接続します
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

//２．データ登録SQL作成
$sql = "SELECT * FROM gs_bm_table";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
$values = "";
if($status==false) {
  $error = $stmt->errorInfo();
  exit("SQLError:".$error[2]);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
$json = json_encode($values,JSON_UNESCAPED_UNICODE);

?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>登録一覧</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">

<!-- <style>
div{padding: 10px;font-size:16px;}
td{border: 1px solid black;}
</style> -->

<style>
  body { background: #f7f7f7; }
  .container { margin-top: 15px; }
  .table th, .table td { vertical-align: middle; }
  .break { word-break: break-all; }
</style>

</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">データ登録</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron">


<!-- <table>
<?php foreach($values as $v){ ?>
  <tr>
    <td><?=$v["ユニーク値"]?></td>
    <td><?=$v["書籍名"]?></td>
    <td><?=$v["書籍URL"]?></td>
    <td><?=$v["評価"]?></td>
    <td><?=$v["タグ"]?></td>
    <td><?=$v["コメント"]?></td>
  </tr>
<?php } ?>
</table> -->

<div class="table-responsive">
  <div class="form-group">
  <label for="tableSearch">検索（書籍名/タグ/コメントなど）</label>
  <input type="text" id="tableSearch" class="form-control" placeholder="例：PHP / 技術書 など">
</div>
<p style="color:#777; font-size:12px; margin-top:-6px;"><br>
  入力すると自動で絞り込みができます（空にすると全件表示）。
</p>
  <table id="bookTable" class="table table-striped table-bordered table-hover">
    <thead>
      <tr class="info">
        <th>ユニーク値</th>
        <th>書籍名</th>
        <th>書籍URL</th>
        <th>評価</th>
        <th>タグ</th>
        <th>コメント</th>
      </tr>
    </thead>

    <tbody>
    <?php foreach($values as $v){ ?>
      <tr>
        <td><?=$v["ユニーク値"]?></td>
        <td><?=$v["書籍名"]?></td>

        <td class="break">
          <a href="<?=$v["書籍URL"]?>" target="_blank" rel="noopener noreferrer">
            <?=$v["書籍URL"]?>
          </a>
        </td>

        <td><?=$v["評価"]?></td>
        <td><?=$v["タグ"]?></td>
        <td class="break"><?=$v["コメント"]?></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
</div>


  </div>
</div>
<!-- Main[End] -->
<script>
  const a = '<?php echo $json; ?>';
  console.log(JSON.parse(a));
  (function () {
    const input = document.getElementById('tableSearch');
    const table = document.getElementById('bookTable');

    // どちらかが無ければ何もしない
    if (!input || !table) return;

    const rows = table.querySelectorAll('tbody tr');

    function filterRows() {
      const keyword = input.value.trim().toLowerCase();

      rows.forEach(function (row) {
        // 行の中の文字をまとめて取得して検索
        const text = row.textContent.toLowerCase();
        row.style.display = (keyword === '' || text.indexOf(keyword) !== -1) ? '' : 'none';
      });
    }

    // 入力のたびに実行
    input.addEventListener('input', filterRows);
  })();

</script>
</body>
</html>
