<?php

require_once(__DIR__ . '/../config/config.php');

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  if(!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
    echo 'Invalid Token!';
    exit;
  }

  // セッションの中身を空にする
  $_SESSION = [];

  // PHPではセッションの管理にクッキーを使うので、そのクッキーを削除する
  if(isset($_COOKIE[session_name()])) { // session_name() ... 現在のセッション名を取得または設定する
    setcookie(session_name(), '', time() - 84600, '/'); // setcookie() ... クッキーを送信する。第一引数にクッキーの名前、第二引数にクッキーの値(この値はクライアントのコンピュータに保存されるので、重要な情報は格納しないようにする。今回は空にする)、第三引数にクッキーの有効期限(過去の日付にすることでクッキーを削除することができる)、第四引数にクッキーのパス(サーバー上でのクッキーを有効としたいパス'/'をセットするとクッキーはdomain配下の全てで有効となる)を指定する
  }

  // セッションの削除
  session_destroy();

  // HOMEにリダイレクト
  header('Location: ' . SITE_URL);
}
