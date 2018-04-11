<?php

spl_autoload_register(function($class) {
  $prefix = 'MyApp\\'; // 名前空間を指定する
  if(strpos($class, $prefix) === 0) { // strpos() ... 文字列内の部分文字列が最初に現れる場所を見つける。第一引数に検索を行う文字列、第二引数に検索したい部分文字列を指定する。0と等しい場合にMyAppから始まると言う意味になる
    $className = substr($class, strlen($prefix)); // substr() ... 文字列の一部を返す。第一引数に入力文字列、第二引数にスタート位置、第三引数に指定されたスタート位置から何文字文化を指定する。スタート位置が正の場合に返される文字列は第一引数で指定した文字列の0から数えてスタート一番目から始まる文字列となる。例えば、substr('abcdef', 2, 1)としたらcが返る。これにより名前空間を除いたクラス名を取得する
    $classFilePath = __DIR__ . '/' . $className . '.php';

    if(file_exists($classFilePath)) {
      require $classFilePath;
    } else {
      echo 'No such class: ' . $className;
    }
  }
});
