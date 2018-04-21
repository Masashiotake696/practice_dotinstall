<?php

namespace MyApp;

use Abraham\TwitterOAuth\TwitterOAuth;
use Abraham\TwitterOAuth\TwitterOAuthException; // TwitterOAuthが例外を返す可能性があるので、TwitterOAuthExceptionも追加する

class Twitter {
  private $_connection; // コネクションを管理するプライベートプロパティ

  public function __construct($accessToken, $accessTokenSecret) {
    $this->_connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $accessToken, $accessTokenSecret); // 連携したユーザーの情報が取れるようになる
  }

  public function getTweets() {
    try {
      $tweets = $this->_connection->get('statuses/home_timeline'); // タイムラインを取得
    } catch(TwitterOAuthException $e) {
      echo 'Failed to load timeline';
      exit;
    }
    return $tweets;
  }
}
