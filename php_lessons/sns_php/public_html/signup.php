<?php

// æ–°è¦�ç™»éŒ²

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Signup();
$app->run();

// echo 'login screen';
// exit;
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <div id="container">
      <form action="" method="post" id="signup">
        <p>
          <input type="text" name="email" placeholder="email">
        </p>
        <p class="err"><?= h($app->getErrors('email')); ?></p>
        <p>
          <input type="password" name="password" placeholder="password">
        </p>
        <p class="err"><?= h($app->getErrors('password')); ?></p>
        <div class="btn" onclick="document.getElementById('signup').submit()">Sign Up</div>
        <p class="fs12"><a href="/login.php">Log In</a></p>
      </form>
    </div>
  </body>
</html>
