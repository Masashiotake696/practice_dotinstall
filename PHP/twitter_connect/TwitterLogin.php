<?php

namespace MyApp;

use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterLogin {
  /*
    ユーザーが連携認証画面で認証するとツイッター側で色々処理をして、承認済みのrequest token(oauth_token)とverifier(oauth_verifier)という情報をつけてCALLBACK_URLに飛ばす。これを利用して処理を以下の二つに分ける。
      1. oauth_tokenがツイッター側から送られてきている場合
        →_callbackFlow()メソッドを実行。
      2. oauth_tokenがツイッター側から送られてきていない場合
        →_redirectFlow()メソッドを実行
  */
  public function login() {
    // ログイン時に既にログイン状態であったらホームに飛ばす
    if($this->isLoggedIn()) {
      goHome();
    }

    if(!isset($_GET['oauth_token']) || !isset($_GET['oauth_verifier'])) {
      $this->_redirectFlow();
    } else {
      $this->_callbackFlow();
    }
  }

  public function isLoggedIn() {
    return isset($_SESSION['me']) && !empty($_SESSION['me']);
  }

  /*
    ■ユーザーが連携認証画面で承認後からアクセストークンの取得までの流れ
      1. twitterから送られてきたリクエストトークン(oauth_token)と連携認証画面にリダイレクトするまでの流れで保存したリクエストトークンが一致するかを確認(セキュリティのため)
      2. 承認されたリクエストトークン(oauth_tokenとoauth_token_secret)を使用してTwitterOAuthインスタンスを作成する
      3.TwitterOAuthインスタンスとoauth_verifierを使用してアクセストークンを取得する
  */
  private function _callbackFlow() {
    if($_GET['oauth_token'] !== $_SESSION['oauth_token']) {
      throw new \Exception('invalid oauth_token');
    }

    // request tokenが認証されているので、oauth_tokenとoauth_token_secretを引数に入れる
    $connection = new TwitterOAuth(
      CONSUMER_KEY,
      CONSUMER_SECRET,
      $_SESSION['oauth_token'],
      $_SESSION['oauth_token_secret']
    );

    /*
      ■$tokensの中身
        ・oauth_token
        ・oauth_token_secret
        ・user_id
        ・screen_name
    */
    $tokens = $connection->oauth('oauth/access_token', [
      'oauth_verifier' => $_GET['oauth_verifier']
    ]);

    $user = new User();
    $user->saveTokens($tokens);

    /*
      ■セッションハイジャック
        ▼内容
          他人のセッションIDを盗聴などで盗み、そのセッションIDを使って、その人になりすまして操作を行うこと。
        ▼対策
          ・セッションIDの漏えいを防ぐ(URLにセッションIDを含めない、SSLによる暗号化でネットワーク盗聴を防ぐ)。
          ・セッションIDを切り替える
        ▼session_regenerate_id()
          session_regenerate_id()が呼ばれるごとにセッションIDを新しく書き換える。これをアクセス毎に呼び出すようにするとセッションハイジャック対策になる。
          ♦︎使用方法
            第一引数に関連づけられた古いセッションを削除するかどうかを指定する(true, false)
          ♦︎session_regenerate_id()の問題点
            session_regenerate_id()を使用するとよくセッションが切れてしまうようになる。session_regenerate_id(true)とすると旧セッションデータを削除する設定になるので、セッションがより切れやすくなる。また、同時にアクセスされた場合に同時にsession_regenerate_id()が走ってしまい、セッションデータを上手く引き継げない場合がある。
          ♦︎session_regenerate_id()の対策
            同一のタイミングでsession_regenerate_id()の発動が起きないようにする。
    */
    session_regenerate_id(true);

    $_SESSION['me'] = $user->getUser($tokens['user_id']); // ユーザー情報をオブジェクトで$_SESSION['me']に格納

    unset($_SESSION['oauth_token']);
    unset($_SESSION['oauth_token_secret']);

    goHome();
  }

  /*
    ■連携認証画面にリダイレクトするまでの流れ
      1. CONSUMER_KEYとCONSUMER_SECRETを用いてTwitterOAuthインスタンスの作成
      2. TwitterOAuthインスタンスを用いてリクエストトークン(oauth_tokenとoauth_token_secret)を取得
      3. リクエストトークン(oauth_tokenとoauth_token_secret)をセッションに保存
      4. リクエストトークンを使用して連携認証画面のURLを取得
      5. 連携認証画面にリダイレクト
  */
  private function _redirectFlow() {
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

    $tokens = $connection->oauth('oauth/request_token', [
      'oauth_callback' => CALLBACK_URL
    ]);

    $_SESSION['oauth_token'] = $tokens['oauth_token'];
    $_SESSION['oauth_token_secret'] = $tokens['oauth_token_secret'];

    $authorizeUrl = $connection->url('oauth/authorize', [
      'oauth_token' => $tokens['oauth_token']
    ]);

    header('Location: ' . $authorizeUrl);
    exit;
  }
}
