<?php
/* フォームからデータの処理 */
$username = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // 送信された値は$_POSTに配列で入ってくる。キーはinputのname属性の値
  $username = $_POST['username'];
  $err = false;
  if (strlen($username) > 8) {
    $err = true;
  }
}
?>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Check username</title>
</head>
<body>
  <!-- actionが空欄になっているので、このファイル自体に飛んでくる  -->
  <form action="" method="POST">
    <!--
      htmlspecialchars ... フォームから送られてきた値や、データベースから取り出した値をブラウザ上に表示する場合に使用する。主に、悪意のあるコードの埋め込みを防ぐために使われる(エスケープと呼ばれる)。
      引数は以下の3つ。
      第一引数: 文字列
      第二引数: "または'を変換するかどうか。主な取り得る値は以下の三つ。
        ENT_CONPAT(初期値) ... ダブルクオートは変換するが、シングルクオートは変換しない。
        ENT_QUOTES ... シングルクオートとダブルクオートを共に変換する。
        ENT_NOQUOTES ... シングルクオートとダブルクオートを共に変換しない。
      第三引数: 文字コード
    -->
    <input type="text" name="username" placeholder="user name" value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>">
    <input type="submit" value="Check!">
    <?php if ($err) { echo "Too long!"; } ?>
  </form>
</body>
</html>
