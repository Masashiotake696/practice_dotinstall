<?php

namespace MyApp\Controller;

/* ユーザー一覧を表示するためのコントローラー */
class Index extends \MyApp\Controller {
  public function run() {
    // ログインしていない場合
    if(!$this->isLoggedIn()) {
      // ログイン処理
      header('Location: ' . SITE_URL . '/login.php');
      exit;
    }

    // ユーザー情報を取得
  }
}
