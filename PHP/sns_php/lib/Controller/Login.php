<?php

namespace MyApp\Controller;

/* ログインするためのコントローラー */
class Login extends \MyApp\Controller {
  public function run() {
    if($this->isLoggedIn()) {
      // ログインしていたらホームに飛ばす
      header('Location: ' . SITE_URL);
      exit;
    }

    //  POSTリクエストの場合
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->postProcess();
    }
  }

  // POSTリクエストの場合の具体的な処理
  protected function postProcess() {
    /*
      ■バリデーション
        今回発生する例外は、エラーメッセージを分かりやすくするために、Exceptionクラスを継承して独自の例外クラスを作りそれをcatchする
        ▼考えうる例外
          ・何も入力されなかった場合
            → \MyApp\Exception\EmptyPost
          ・英数字以外のパスワード
            → \MyApp\Exception\InvalidPassword
    */
    try {
      $this->_validate();
    } catch(\MyApp\Exception\EmptyPost $e) {
      // emailのバリデーションエラーをセット
      $this->setErrors('login', $e->getMessage());
    }

    // パスワードエラーが出た時にも入力したemailの値を保持するためにemailの値をセット
    $this->setValues('email', $_POST['email']);

    // エラーがあるかチェック
    if($this->hasError()) {
      return;
    } else {
      // ログイン処理
      try {
        $userModel = new \MyApp\Model\User();
        $user = $userModel->login([
          'email' => $_POST['email'],
          'password' => $_POST['password']
        ]);
      } catch(\MyApp\Exception\UnmatchEmailOrPassword $e) { // emailが既に存在している場合にエラー出力する
        $this->setErrors('login', $e->getMessage());
        return;
      }

      // PHPではセッションを管理する際にクッキーでセッションIDを保存していくが、それが特定されると問題なので、毎回新しい値をセットする
      session_regenerate_id(true);

      // ログイン処理
      $_SESSION['me'] = $user;

      // ログインページにリダイレクト
      header('Location: ' .SITE_URL);
      exit;
    }
  }

  private function _validate() {
    // CSRF対策(トークンのチェック)
    if(!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo 'Invalid Token!';
      exit;
    }
    /*
      メールアドレスとパスワードがセットされているかをチェック
      ■filter_var()
        指定したフィルタでデータをフィルタリングする。
        第一引数にフィルタリングする値(値をフィルタリングする前に、内部的に文字列への変換が行われることに注意)、第二引数に適用するフィルタIDを指定する。フィルタの型に利用できるフィルタの一覧がある。
        ▼フィルタの型
          FILTER_VALIDATE_EMAIL ... 値が妥当なemailアドレスであるかどうかを検証する。この検証はemailアドレスがRFC822(メッセージの構造や記述すべき情報、記述できる情報などを規定)に沿った形式であるかどうかを確かめる。ただし、コメント、空白の折り返し、およびドットなしドメイン名には対応しない。
    */
    if(!isset($_POST['email']) || !isset($_POST['password'])) {
      echo "Invalid Form!";
      exit;
    }

    // メールアドレスとパスワードが空文字じゃないかチェック
    if($_POST['email'] == '' || $_POST['password'] == '') {
      throw new \MyApp\Exception\EmptyPost();
    }
  }
}
