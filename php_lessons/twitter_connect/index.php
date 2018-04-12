<?php

require_once(__DIR__ . '/config.php');

?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>Twitter Connect!</title>
    <style>
      #container {
        width: 500px;
        margin: 0 auto;
      }
      h1 {
        font-size: 18px;
        border-bottom: 1px solid #ccc;
        padding: 3px 0;
      }
      #login {
        text-align: center;
        margin: 70px auto;
      }
    </style>
  </head>
  <body>
    <div id="container">
      <h1>My Timeline</h1>
      <div id="login">
        <a href="login.php"><img src="signin_button.png"></a>
      </div>
    </div>
  </body>
</html>
