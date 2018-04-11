<?php

require_once(__DIR__ . '/config.php');

/*
  Composer
    PHPのパッケージ管理システム。
    パッケージ管理システムがない環境では、メンバーがそれぞれ必要なライブラリの公式サイトにアクセスし、zipファイルをダウンロードし、ローカルに展開する必要がある。パッケージ管理システムはそれらを個人の裁量に依存せずに導入できる仕組み。以下のようなイニシャルコストが必要になるが、PHPプロジェクトでは必須となる。
      - パッケージ管理システム自体のインストールが必要
      - パッケージ管理システムの使い方の理解が必要(コマンドオプション、設定、ファイルの記述方法)
    composerを使えば、コマンド一発で必要なパッケージを全てインストールできる。
*/

use Abraham\TwitterOAuth\TwitterOAuth;
$connection = new TwitterOAuth(
  CONSUMER_KEY,
  CONSUMER_SECRET,
  ACCESS_TOKEN,
  ACCESS_TOKEN_SECRET
);
// $content = $connection->get("account/verify_credentials");
// $content = $connection->get("statuses/home_timeline", ['count' => 3]);
// var_dump($content);

$res = $connection->post("statuses/update", [
  'status' => '不安すぎる。。。'
]);
if($connection->getLastHttpCode() === 200) {
  echo 'Success!' . PHP_EOL; // PHP_EOL ... 改行を表していて、環境によって自動で改行コードを切り替えてくれる
} else {
  echo 'Error!' . $res->errors[0]->messages . PHP_EOL;
}
