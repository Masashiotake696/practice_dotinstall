<?php

spl_autoload_register(function($class) {
  $prefix = 'MyApp\\';

  if(strpos($class, $prefix) === 0) { // strpos() ... 文字列内の部分文字列が最初に現れる場所を見つける。第一引数で検索を行う文字列、第二引数で検索する文字列を指定する。返り値は第二引数で指定した文字列が最初に現れた位置となる。
    $className = substr($class, strlen($prefix));
    $classFilePath = __DIR__ . '/' . $className . '.php';
    if(file_exists($classFilePath)) {
      require $classFilePath;
    } else {
      echo 'No such class: ' . $className;
      exit;
    }
  }
});
