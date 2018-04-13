<?php

require_once(__DIR__ . '/config.php');

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  try { // セキュリティを高めるためにログアウトでPOSTした時のCSRF対策をする
    MyApp\Token::validate('token');
  } catch(Exception $e) {
    echo $e->getMessage();
    exit;
  }

  $_SESSION = []; // $_SESSIONを空にする

  /*
    ■$_COOKIE
      現在のスクリプトにHTTPクッキーから渡された変数の連想配列。
    ■session_name()
      現在のセッション名を取得または設定する。返り値は現在のセッション名。引数を渡すとセッション名を上書きして元のセッション名を返す。
    ■setcookie()
      クッキーを送信する。第一引数にクッキー名、第二引数にクッキーの値(nameが'cookiename'だとすると、その値は$_COOKIE['cookiename']で取得することができる)、第三引数にクッキーの有効期限(Unixタイムスタンプ)、第四引数にサーバー上でのクッキーを有効としたいパス'/'を指定する。
    ■session_destroy()
      現在のセッションに関連づけられた全てのデータを破棄する。ただし、この関数はセッションに関するグローバル変数を破棄しない。また、セッションのクッキーを破棄しない。
  */
  if(isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 86400, '/'); // 空の値を指定してクッキーを空にする
  }
  session_destroy();
}
goHome();
