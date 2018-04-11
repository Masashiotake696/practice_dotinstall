<?php

// 名前空間をつける。名前空間は階層的に管理できて、バックスラッシュ(\)をつけてフォルダのように適当な階層をつける。名前空間はファイルの先頭に必ず書くルールとなっている。
namespace Dotinstall\Lib;

class User {
  public $name;
  public function __construct($name) {
    $this->name = $name;
  }
  public function sayHi() {
    echo "hi, i am $this->name!";
  }
}
