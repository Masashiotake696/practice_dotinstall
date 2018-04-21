<?php

namespace MyApp\Controller;

/* 新しいユーザーを登録するためのコントローラー */
class Signup extends \MyApp\Controller {
  public function run() {
    if($this->isLoggedIn()) {
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
      // emailのバリデーションエラーをセット
      $this->setErrors('email', $e->getMessage());
    } catch(\MyApp\Exception\InvalidPassword $e) {
      // passwordのバリデーションエラーをセット
      $this->setErrors('password', $e->getMessage());
    }

    // パスワードエラーが出た時にも入力したemailの値を保持するためにemailの値をセット
    $this->setValues('email', $_POST['email']);

    if($this->hasError()) {
      return;
    } else {
      // ユーザーの作成
      try {
        $userModel = new \MyApp\Model\User();
        $userModel->create([
          'email' => $_POST['email'],
          'password' => $_POST['password']
        ]);
      } catch(\MyApp\Exception\DuplicateEmail $e) { // emailが既に存在している場合にエラー出力する
        $this->setErrors('email', $e->getMessage());
        return;
      }

      // ログインページにリダイレクト
      header('Location: ' .SITE_URL . '/login.php');
      exit;
    }
  }

  private function _validate() {
    if(!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo 'Invalid Token!';
      exit;
    }
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
