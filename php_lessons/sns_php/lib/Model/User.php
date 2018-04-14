<?php

namespace MyApp\Model;

/* ユーザーモデル */
class User extends \MyApp\Model {
  // ユーザーの作成
  public function create($values) {
    $stmt = $this->db->prepare("insert into users (email, password, created, modified) values (:email, :password, now(), now())");
    /*
      ■execute()で変数に名前付きパラメータを使う方法
        $stmt = $db->prepare("insert into テーブル名 (カラム1名, カラム2名) values (:カラム1の名前付きパラメータ, :カラム2の名前付きパラメータ)");
        $stmt->execute([':カラム1の名前付きパラメータ'=>カラム1の値, ':カラム1の名前付きパラメータ'=>カラム2の値]);
    */
    $res = $stmt->execute([
      ':email' => $values['email'],
      /*
        ■前提
          ハッシュ化とは？
            元のデータから一定の計算手順に従ってハッシュ値と呼ばれる規則性のない固定長の値を求め、その値によって元のデータを置き換えること。パスワードの保管などでよく用いられる手法
        ■password_hash()
          強力な一方向ハッシュアルゴリズムを使って新しいパスワードハッシュを作る。第一引数にハッシュ化したいパスワード、第二引数にパスワードハッシュに使うアルゴリズムを表すパスワードアルゴリズム定数を指定する。
          パスワードアルゴリズム定数は以下の二つ。
            ・PASSWORD_DEFAULT ... bcryptアルゴリズム()を使う。新しくてより強力なアルゴリズムがPHPに追加されれば、この定数もそれに合わせて変化する。そのため、これを指定した時の結果の長さは、変わる可能性がある。したがって、結果をデータベースに格納する時にはカラム幅を60文字以上にできるようなカラムを使うこと(255文字くらいが適切)。
            ・PASSWORD_BCRYPT ... CRYPT_BLOWFISHアルゴリズムを使ってハッシュを作る。これは標準のcrypt()互換のハッシュで、識別子"$2y$"を使った場合の結果を作る。その結果は常に60文字の文字列になる。失敗した場合はfalseを返す。
      */
      ':password' => password_hash($values['password'], PASSWORD_DEFAULT)
    ]);
    // emailが重複していた場合、emailにはユニークキーがついているため$resにはfalseが返ってくる。これを利用して例外を返す
    if($res === false) {
      throw new \MyApp\Exception\DuplicateEmail();
    }
  }

  // ログイン処理
  public function login($values) {
    // 該当するレコードを抽出
    $stmt = $this->db->prepare("select * from users where email = :email");
    $stmt->execute([
      ':email' => $values['email']
    ]);
    // 抽出結果をオブジェクトで取得する
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass'); // setFetchMode() ... この文に対するデフォルトのフェッチモードを設定する。第一引数にフェッチモード、第二引数にオブジェクトを指定する。
    $user = $stmt->fetch(); // fetch() ... 結果セットから次の行を取得する

    // メールがマッチしなかった場合
    if(empty($user)) {
      throw new \MyApp\Exception\UnmatchEmailOrPassword();
    }

    // パスワードがマッチしなかった場合
    if(!password_verify($values['password'], $user->password)) { // password_verify() ... パスワードがハッシュにマッチするかどうかを調べる。第一引数にユーザーのパスワード、第二引数にpassword_hash()が作ったハッシュを指定する。
      throw new \MyApp\Exception\UnmatchEmailOrPassword();
    }

    return $user;
  }

  public function findAll() {
    $stmt = $this->db->query("select * from users order by id");
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll();
  }
}
