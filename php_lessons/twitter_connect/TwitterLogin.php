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
    if(!isset($_GET['oauth_token']) || !isset($_GET['oauth_verifier'])) {
      $this->_redirectFlow();
    } else {
      $this->_callbackFlow();
    }
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

    $tokens = $connection->oauth('oauth/access_token', [
      'oauth_verifier' => $_GET['oauth_verifier']
    ]);

    $user = new User();
    $user->saveTokens();

    $_SESSION['me'] = $user->getUser($tokens['user_id']);

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
