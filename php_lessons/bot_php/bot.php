<?php

require_once(__DIR__ . '/config.php');

/*
  ■Composer
    PHPのパッケージ管理システム。
    パッケージ管理システムがない環境では、メンバーがそれぞれ必要なライブラリの公式サイトにアクセスし、zipファイルをダウンロードし、ローカルに展開する必要がある。パッケージ管理システムはそれらを個人の裁量に依存せずに導入できる仕組み。以下のようなイニシャルコストが必要になるが、PHPプロジェクトでは必須となる。
      - パッケージ管理システム自体のインストールが必要
      - パッケージ管理システムの使い方の理解が必要(コマンドオプション、設定、ファイルの記述方法)
    composerを使えば、コマンド一発で必要なパッケージを全てインストールできる。
  ■Twitter API Key
    ▼Consumer Key (API Key)
      アプリケーションAPI Key。アプリケーションごとに付与されるユニークなID
    ▼Consumer Key Secret
      アプリケーションごとに付与されるアプリケーションのAPIシークレット
    ▼Oauth Token
      リクエストトークン、ユーザー認証までの一時的なトークン。
    ▼Oauth Token Secret
      リクエストトークンのシークレット
    ▼Access Token
      それぞれのユーザーがそのアプリ用に発行されるもの。それが紐づけられてるユーザーはアプリ側から操作できる。
      ユーザーアカウントにおけるIDとPASSのように、「Access Token Key」と「Acess Token Secret」という2種類の文字列を指す。これはアプリケーションがユーザーの代わりにユーザーデータにアクセスするための「通行許可証」のようなもの。言わば、第三者(Webサービスなど)用に用意されたユーザーIDとユーザーPASSと言っても良い。第三者が限られた範囲であなたのデータにアクセスするための仕組みがアクセストークン。
    ▼Access Token Secret
      アクセストークンのシークレット
  ■プログラミングの流れ
    1. リクエストトークンをCONSUMER_KEYを使って取得する
    2. リクエストトークンをパラメータにつけて、ユーザーを認証画面に飛ばす
    3. ユーザーが認証画面でアプリ連携を許可する
    4. 許可証となるコードがパラメターに付けられて、ユーザーがCallback URLで設定したURLアドレスに飛ばされてくる
    5. 許可証となるコードを利用してアクセストークンを取得する
*/

use Abraham\TwitterOAuth\TwitterOAuth;
$connection = new TwitterOAuth(
  CONSUMER_KEY,
  CONSUMER_SECRET,
  ACCESS_TOKEN,
  ACCESS_TOKEN_SECRET
);
// $content = $connection->get("account/verify_credentials"); // アカウント情報の取得
// $content = $connection->get("statuses/home_timeline", ['count' => 3]); // 投稿の取得。配列の中でcountの値を指定することで取得数を指定できる
// var_dump($content);

// $res = $connection->post("statuses/update", [ // 新規投稿
//   'status' => '不安すぎる。。。'
// ]);

/* 画像付きでつぶやく(まず初めに画像をアップロードしてその後につぶやく) */
$media = $connection->upload("media/upload", [ // 画像のアップロード
  'media' => __DIR__ . '/html_lesson.png'
]);
$res = $connection->post("statuses/update", [ // つぶやき
  /*
    date() ... ローカルの日付/時刻を書式化する。引数に出力される日付文字列の書式を指定する。返り値は日付を表す文字列。
    メディアをくっつける場合は、media_idsというパラメータになるので、それに$mediaで帰って来たmedia_idをくっつける
  */
  'status' => date('m月d日') . 'は特に不安。。。(by cron)', 'media_ids' => $media->media_id
]);

if($connection->getLastHttpCode() === 200) {
  echo 'Success!' . PHP_EOL; // PHP_EOL ... 改行を表していて、環境によって自動で改行コードを切り替えてくれる
} else {
  echo 'Error!' . $res->errors[0]->messages . PHP_EOL;
}

/*
  定期的にbot.phpを実行するように設定する。
  ▼cron
      ♦︎命令
        crontab -l ... 現在の設定を確認
        crontab -e ... 設定を編集
      ♦︎書式
        min hour day month youbi(0-7) command(絶対パスで指定する)
        (0もしくは7が日曜日、1が月曜日、2が火曜日...といったようになる)
        例) 0 7 * * * command (毎朝7時に実行する。毎日は*で指定可能)
      ♦︎実行例
        25 21 * * * /usr/bin/php /home/vagrant/bot_php/bot.php
        (21時25分に実行。commandの絶対パスは/usr/bin/php、bot.phpの絶対パスは/home/vagrant/bot_php/bot.php)
        crontab -e とするとviが立ち上がるので、
        25 21 * * * /usr/bin/php /home/vagrant/bot_php/bot.php
        を記述する
*/
