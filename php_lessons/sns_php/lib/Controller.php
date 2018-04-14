<?php

namespace MyApp;

class Controller {
  private $_errors;

  public function __construct() {
    /*
      ■stdClass
        PHPでは全てのクラスの基本となるstdClassというクラスが存在する。
        通常、クラスを使う場合は何か定義しないといけないが、何も定義せずともstdClassを書くことができる。stdClassはあらかじめ自分で定義されていないにも関わらず、そのまま使える。これはPHPの内部であらかじめ定義されているから。データを配列ではなく、オブジェクトの形で保存したい場合などに使うことができる。オブジェクトにすることで、$obj->nameのような形でデータを記述でき、プログラムの内容によっては便利な場合がある
    */
    $this->_errors = new \stdClass();
  }

  protected function setErrors($key, $error) {
    $this->_errors->$key = $error;
  }

  public function getErrors($key) {
    return isset($this->_errors->$key) ? $this->_errors->$key : '';
  }

  protected function hasError() {
    return !empty(get_object_vars($this->_errors)); // get_object_vars() ... 指定したオブジェクトのプロパティを取得する。引数にはオブジェクトのインスタンスを指定する。
  }

  protected function isLoggedIn() {
    // セッションにログイン情報が入っているかどうかでログイン状態を確認
    return isset($_SESSION['me']) && !empty($_SESSION['me']);
  }

}
