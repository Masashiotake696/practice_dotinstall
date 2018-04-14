<?php

namespace MyApp\Controller;

class Signup extends \MyApp\Controller {
  public function run() {
    if(!$this->isLoggedIn()) {
      // ログインしていたらホームに飛ばす
      header('Location: ' . SITE_URL);
      exit;
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->postProcess();
    }
  }

  protected function postProcess() {
    /*
      ■バリデーション
        今回発生する例外は、エラーメッセージを分かりやすくするために、Exceptionクラスを継承して独自の例外クラスを作りそれをcatchする
        ▼考えうる例外
          ・メールアドレスの形式が正しくない
            → \MyApp\Exception\InvalidEmail
          ・英数字以外のパスワード
            → \MyApp\Exception\InvalidPassword
    */
    try {
      $this->_validate();
    } catch(\MyApp\Exception\InvalidEmail $e) {
      // echo $e->getMessage();
      // exit;
      $this->setErrors('email', $e->getMessage());
    } catch(\MyApp\Exception\InvalidPassword $e) {
      // echo $e->getMessage();
      // exit
      $this->setErrors('password', $e->getMessage());
    }

    // echo "Success";
    // exit;

    if($this->hasError()) {
      return;
    } else {
      // ユーザーの作成

      // ログインページにリダイレクト
    }
  }

  private function _validate() {
    /*
      ■filter_var()
        指定したフィルタでデータをフィルタリングする。
        第一引数にフィルタリングする値(値をフィルタリングする前に、内部的に文字列への変換が行われることに注意)、第二引数に適用するフィルタIDを指定する。フィルタの型に利用できるフィルタの一覧がある。
        ▼フィルタの型
          FILTER_VALIDATE_EMAIL ... 値が妥当なemailアドレスであるかどうかを検証する。この検証はemailアドレスがRFC822(メッセージの構造や記述すべき情報、記述できる情報などを規定)に沿った形式であるかどうかを確かめる。ただし、コメント、空白の折り返し、およびドットなしドメイン名には対応しない。
    */
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      throw new \MyApp\Exception\InvalidEmail();
    }

    if(!preg_match('/\A[a-zA-Z0-9]+\z/', $_POST['password'])) {
      throw new \MyApp\Exception\InvalidPassword();
    }
  }
}
