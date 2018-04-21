<?php

// ユーザーの一覧を表示
require_once(__DIR__ . '/../config/config.php');

// インスタンス化(Controllerをインスタンス化することでController.phpのコンストラクタで$_SESSION['token']がセットされる)
$app = new MyApp\Controller\Index();
$app->run();

?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>Home</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <div id="container">
      <form action="logout.php" method="post" id="logout">
        <?= h($app->me()->email); ?> <input type="submit" value="Log Out"> <!-- me() ... ログインしているユーザー情報を取得 -->
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>"> <!-- CSRF対策(セッションのトークンを記述)  -->
      </form>
      <h1>Users <span class="fs12">(<?= count($app->getValues()->users); ?>)</span></h1> <!-- getValues()->users ... 登録されているユーザーの一覧を取得 -->
      <ul>
        <?php foreach ($app->getValues()->users as $user) :?>
        <li><?= h($user->email); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </body>
</html>
