<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">登録一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="insert.php">
  <div class="jumbotron">
   <fieldset>
    <legend>読んだ本/読みたい本を記録に残そう！</legend><br>
     <label>書籍名：<input type="text" name="name"></label><br><br>
     <label>書籍URL：<input type="text" name="url"></label><br><br>
    <label>評価：<input type="text" name="rank"></label><br><br>
    <label>タグ：<input type="text" name="tag"></label><br><br>
     <label><p>コメント：</p><textArea name="naiyou" rows="5" cols="40"></textArea></label><br><br>
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>