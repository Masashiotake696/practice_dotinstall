<?php

session_start();

# ファイル名の最初に_がついているのは、裏側で走る普通とは違った処理という意味で、慣習的につけるもの

require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/Todo.php');

// get Todos
$todoApp = new \MyApp\Todo();

if($_SERVER['REQUEST_METHOD'] === 'POST') { // ポストリクエストをキャッチ
  try {
    $res = $todoApp->post();
    /*
      header()について
        HTTPヘッダ情報を送信するときに使用する。
        HTTPヘッダとは、HTTPによるリクエスト→レスポンスの流れで、どのような情報をリクエストしてどのようなコンテンツを受け取るかを定義するためのもの。
        HTTPヘッダを定義するhaeder()は以下のように定義する。
          header($ヘッダ文字列 [, bool $replace = true [, int $http_responce_code ]])
            第一引数にはヘッダ文字列を指定する。この時、HTTP/から始まるヘッダを指定した場合は、HTTPステータスコードを示すために使用する。Location:から始まるヘッダを指定した場合は、指定したURLのブラウザを表示することができる。
            第二引数のreplaceオプションを指定すると、前に送信された類似のヘッダが指定された場合に、値を置換するかどうかを指定する。
            第三引数にhttp_responce_codeを指定すると、HTTPレスポンスコード(ステータスコード)を強制的に指定した値に設定することができる。
    */
    header('Content-Type: application/json'); // ヘッダーのContent-Typeをjsonに指定する
    echo json_encode($res); // json_encode() ... 値をJSON形式にして返す
    exit;
  } catch(Exception $e) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500); // $_SERVER['SERVER_PROTOCOL'] ... ページがリクエストされた際のプロトコル名とバージョン。例) HTTP/1.0
    echo $e->getMessage();
    exit;
  }
}
