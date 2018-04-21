<?php

/*
  ■CSRF対策
    ▼概要
      CSRF(Cross-site Request Forgery, リクエスト強要)とは、Webアプリケーションに存在する脆弱性、もしくはその脆弱性を利用した攻撃方法のこと。掲示板や問い合わせフォームなどを処理するWebアプリケーションが、本来拒否すべき他サイトからのリクエストを受信し処理してしまう。
    ▼攻撃の手法・特徴
      攻撃者は攻撃用Webページを準備し、ユーザーがアクセスするよう誘導する。ユーザが攻撃用Webページにアクセスすると、攻撃用Webページ内にあらかじめ用意されていた不正なリクエストが攻撃対象サーバに送られる。攻撃対象サーバ上のWebアプリケーションは不正なリクエストを処理し、ユーザが意図していない処理が行われてしまう。
    ▼影響と被害
      攻撃者は自身が直接攻撃対象サーバへアクセスすることなく、攻撃対象のWebアプリケーションに任意の処理を行わせることができる。CSRFを利用して行われる主な攻撃としては以下がある。
        ・いたずら的書き込み、不正サイトへの誘導、犯罪予告といった掲示板やアンケートフォームへの不正な書き込み
        ・不正な書き込みを大量に行うことによるDoS攻撃
      攻撃Webページに誘導された一般ユーザには直接的な被害はないが、攻撃対象サーバへの不正なリクエストを送信した攻撃者として認識されてしまう。
    ▼方法
      推測されにくい文字列をToken(一定時間だけ有効なパスワード、もしくは一回使うと使えなくなるパスワードを払い出す機会やソフト)として発行してSessionに格納しつつ、フォームからもTokenを発行し送信する。その後、処理の中でSessionの中のTokenフォームから送られたTokenが同じかどうかをチェックすることで対策を施す。
*/

namespace MyApp;

class Todo {
  private $_db;

  public function __construct() {
    $this->_createToken();
    try {
      $this->_db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
      $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION); // 例外をスローする
    } catch (\PDOException $e) {
      echo $e->getMessage();
      exit;
    }
  }

  // tokenを作成して、$_SESSIONに格納
  private function _createToken() {
    if(!isset($_SESSION['token'])) {
      /*
        ■bin2hex()
          バイナリデータを16進数表現に変換する。
          引数を16進数表現い変換したASCII文字列(ASCIIに含まれる文字列のこと。いわゆる半角の英字(a~z, A~Z)やアラビア数字(0~9)、記号、空白文字、制御文字(文字コードなどで規定された文字のうち、通信制御や周辺機器の制御などに用いる特殊な文字のこと。制御文字に割り当てられたコード(番号)のことを制御コードという)など128文字が規定されている)を返す。
        ■openssl_random_pseudo_bytes()
          擬似乱数のバイト文字列(普通の文字列で指定された)を生成する。この時、引数で長さを指定する。
      */
      $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16)); // 1バイトの数字がちょうど2桁の16進数で表せるので、32桁の文字列ができる
    }
  }

  public function getAll() {
    $stmt = $this->_db->query("select * from todos order by id desc");
    return $stmt->fetchAll(\PDO::FETCH_OBJ); // 抽出結果をオブジェクトで返す
  }

  public function post() {
    $this->_validateToken();

    if(!isset($_POST['mode'])) {
      throw new \Exception('mode not set');
    }

    switch($_POST['mode']) {
      case 'update':
        return $this->_update();
      case 'create':
        return $this->_create();
      case 'delete':
        return $this->_delete();
    }
  }

  private function  _validateToken() {
    if(
      !isset($_SESSION['token']) ||
      !isset($_POST['token']) ||
      $_SESSION['token'] !== $_POST['token']
    ) {
      throw new \Exception('invalid token');
    }
  }

  private function _update() {
    if(!isset($_POST['id'])) {
      throw new \Exception('[update] id not set');
    }

    $this->_db->beginTransaction();

    // 更新処理
    $sql = sprintf('update todos set state = (state + 1) %% 2 where id = %d', $_POST['id']); // 余りを求める%はエスケープしたいので%%とする
    $stmt = $this->_db->prepare($sql);
    $stmt->execute();

    // 更新後のステータスを取得
    $sql = sprintf('select state from todos where id = %d', $_POST['id']);
    $stmt = $this->_db->query($sql);
    $state = $stmt->fetchColumn(); // fetchColumn() ... 結果セットの次行から単一カラムを返す。行がもうない場合にはfalseを返す。引数には行から処理したい0で始まるカラム番号を指定する。引数がない場合には、最初のカラムをフェッチする。

    $this->_db->commit();
    return [
      'state' => $state
    ];
  }

  private function _create() {
    if(!isset($_POST['title']) || $_POST['title'] === '') {
      throw new \Exception('[delete] id not set');
    }

    // 作成処理
    $stmt = $this->_db->prepare("insert into todos (title) values (:title)");
    $stmt->execute([':title' => $_POST['title']]);

    return [
      'id' => $this->_db->lastInsertId() // 挿入されたレコードのidを返す
    ];
  }

  private function _delete() {
    if(!isset($_POST['id'])) {
      throw new \Exception('[delete] id not set');
    }

    // 削除処理
    $sql = sprintf('delete from todos where id = %d', $_POST['id']);
    $stmt = $this->_db->prepare($sql);
    $stmt->execute();

    return [];
  }
}
