<?php

// ログインページ

require_once(__DIR__ . '/../config/config.php');

// インスタンス化
$app = new MyApp\Controller\Login();
$app->run();

?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>Log In</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <div id="container">
      <form action="" method="post" id="login">
        <p>
          <input type="text" name="email" placeholder="email" value="<?= isset($app->getValues()->email) ? h($app->getValues()->email) : ''; ?>"> <!-- パスワードエラーが出た時にも入力したemailの値を保持するためにemailの値を入れる -->
        </p>
        <p>
          <input type="password" name="password" placeholder="password">
        </p>
        <p class="err"><?= h($app->getErrors('login')); ?></p> <!-- エラーを取得して表示 -->
        <div class="btn" onclick="document.getElementById('login').submit()">Log In</div>
        <p class="fs12"><a href="/signup.php">Sign Up</a></p>
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>"> <!-- CSRF対策(セッションのトークンを記述)  -->
      </form>
    </div>
  </body>
</html>
