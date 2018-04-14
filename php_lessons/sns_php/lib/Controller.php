<?php

namespace MyApp;

class Controller {

  protected function isLoggedIn() {
    // セッションにログイン情報が入っているかどうかでログイン状態を確認
    return isset($_SESSION['me']) && !empty($_SESSION['me']);
  }

}
