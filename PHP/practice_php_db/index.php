<?php
/*
PHPでデータベースを扱う場合、最近はPDO(PHP Data Object)を使うことが推奨されている。今回はPDOでMySQLを使う。
■PDOについて
  ♦︎今までのデータベース接続
    データベースへの接続方法の一つにmusql関数を使った方法がある。
    下記のように関数を使い引数を指定するだけで簡単に接続ができた。
      $db = mysql_connect('ホスト名', 'ユーザー名', 'パスワード');
    しかしこの接続方法はPHP5.0で非推奨になり、PHP7.0で削除された。
  ♦︎これからのデータベース接続
    mysql関数以外でデータベースに接続するには、PDOまたはMySQLiを使用する。
  ♦︎PDOとは?
    PHP Data Object(PDO)拡張モジュールは、PHPの中からデータベースにアクセスするための軽量で高性能なインターフェースを定義する。PDOインターフェースを実装する各データベースドライバは、正規表現関数のようなデータベース固有の機能を提供することができる。PDO拡張モジュールによりそのデータベースのすべてのデータベース関数を実行できるわけではない。データベースサーバにアクセスするには、データベース固有のPDOドライバ(PDO_MYSQL, PDO_SQLITE, PDO_PGSQLなど)を使用する必要がある。
    PDOはデータアクセスの抽象化レイヤを提供する。つまり、使用しているデータベースが何であるかに関わらず、同じ関数を使用してクエリの発行やデータの取得が行える。PDOはデータベースの抽象化を行うのではない。つまり、SQLを書き直したり存在しない機能をエミュレート(模倣ソフトウェアのこと)したりはしない。もしそのような機能が必要なら、全体を模倣する別の抽象化レイヤを使用するべき。
■DSN(Data Source Name)
  データベースに接続するために必要な情報のこと。各データベース製品に応じたDSNの書き方がある。
  MySQLの基本的な書き方は以下。
    mysql:dbname=データベース名;host=ホスト名;charset=文字コード
■データベースの接続
  $pdo = new PDO($dsn, $usrename, $password, $driver_options);
    $dsn
      上記で説明しているDSNのこと
    $username
      ユーザー名
    $password
      パスワード
    $driver_options
      接続時のオプションを連想配列で渡す。
      ▼データベース接続後にオプションを指定することもできる。
        その場合は、setAttributeメソッドを使用する。多くのオプションはコンストラクタの$driver_options(newした時の$dirver_options)で指定してもこちらで指定しても大差はないが、PDO::MYSQL_ATTR_INIT_COMMAND, PDO::ATTR_PERSISTENTなど一部のコンストラクタ専用のものがある。
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      ▼よく使われるドライバオプションとその値
        ♦︎PDO::ATTR_ERRMODE
          SQL実行でエラーが起こった際にどう処理するかを指定する。選択肢は以下。
            ・PDO::ERRMODE_EXCEPTION (例外をスローしてくれる。これが一番ポピュラー)
            ・PDO::ERRMODE_WARNING (発生したエラーをPHPのWarningとして報告する)
            ・PDO::ERRMODE_SILENT (何も報告しない。デフォルト値)
        ♦︎PDO::ATTR_DEFAULT_FETCH_MODE
          PDOStatement:fetchメソッドやPDOStatement::fetchAllメソッドで引数が省略された場合や、ステートメントがforeach分に直接かけられた場合のフェッチスタイルを設定する。
            ・PDO::FETCH_BOTH (カラム番号とカラム名の両方をキーとする連想配列で取得する。デフォルト値)
            ・PDO::FETCH_NUM (カラム番号をキーとする配列で取得する)
            ・PDO::FETCH_ASSOC (カラム名をキーとする連想配列で取得する。これが一番ポピュラー)
            ・PDO::FETCH_OBJ (カラム名をプロパティとする基本オブジェクトで取得する)
        ♦︎PDO::ATTR_EMULATE_PREPARES
          データベース側が持つ「プリペアドステートメント(実行したいSQLをコンパイルした一種のテンプレートのようなもので、パラメータ変数を使用することでSQLをカスタマイズすることが可能)」という機能のエミュレーション(あるソフトウェアの挙動を別のソフトウェアなどによって模倣し、代替として動作させること)をPDO側で行うかどうかを設定する。この設定でPDOのいくつかの挙動で違いが表れる。
            ・プリペアドステートメントのためにデータベースサーバと通信する必要がなくなるため、エミュレーションを行った方がパフォーマンスは向上する。
            ・存在しないテーブル名やカラム名をSQL文にもつプリペアドステートメントを発行した時、エミュレーションOFFの場合はすぐにエラーが発生するが、エミュレーションONの場合は実際にクエリを実行するまでエラーが発生するかどうかわからない
          ・エミュレーションがONの場合のみ、区切り文字(;)で複数のSQL文を一つのクエリで実行することができる
          ▼PDO::ATTR_PERSISTENT(コンストラクタ専用)
            trueを設定すると、スクリプトが終了してもデータベースへの接続を維持し次回に再利用する。規模が大きくなってくると設定する恩恵が大きくなる。
          ▼PDO::MYSQL_ATTR_USE_BUFFERED_QUERY(MySQL専用)
            trueの時、バッファクエリ(全ての情報をデータベースサーバから取得してきておいて、PHPに1件ずつ取り出させる)を使用する。デフォルトはtrue。falseの時は非バッファクエリ(1件ごとにデータベースサーバと通信を行って、PHPに取り出させる)
            取得してくる情報がメモリに収まりきらない膨大な量であるといった非常に特殊なケースを除けば、バッファクエリを選択しておく方が無難。サーバ負担も軽減され、途中までフェッチしたところで突然例外が発生するような事態も避けられる。また、非バッファクエリには複数同時にクエリを実行できないなどの大きな欠点もある。基本的にこれは、データベースから取得したデータでHTMLを表示する用途ではなく、コマンドラインからバッチ処理を実行する用途で使われる。
          ▼PDO::MYSQL_ATTR_INIT_COMMAND(MySQL専用)(コンストラクタ専用)
            接続した直後に実行されるクエリをここに書く。
■クエリの実行
  ♦︎PDO::query()
    ▼使用する場合
      ・ユーザー入力を伴わないクエリ(実行するSQL文が固定されている)、かつ、結果を返り値として欲しい場合
    ▼返り値
      PDOStatement
    ▼使用方法
      PDOインスタンス->query("SQL文");
  ♦︎PDO::exec()
    ▼使用する場合
      ユーザー入力を伴わないクエリ(実行するSQL文が固定されている)、かつ、insertやupdateなどで作用した件数を直接返り値に欲しい場合
    ▼使用方法
      PDOインスタンス->exec("SQL文");
  ♦︎PDO::prepare()
    execute()メソッドによって実行されるSQLステートメントを準備する。
    ▼使用する場合
      実行するSQL文の中に変数などがある場合や複数回実行されるSQLの場合
    ▼利点
      ユーザーからの入力を受け取ってSQLを組み立てたりする場合があるが、その際に悪意のあるコードの対策をしてくれる。
      また、SQLをキャッシュしてくれるので、複数回実行した時に高速。
    ▼返り値
      PDOStatement
    ▼使用方法
      PDOStatementにはexecute()メソッドがある。このメソッドに配列を渡すことで安全な形で変数に値を埋め込んで実行できる。
      ①変数に?を使う方法
        $stmt = $db->prepare("insert into テーブル名 (カラム1名, カラム2名) values (?, ?)");
        $stmt->execute(['カラム1の値', カラム2の値]);
      ②変数に名前付きパラメータを使う方法
        $stmt = $db->prepare("insert into テーブル名 (カラム1名, カラム2名) values (:カラム1の名前付きパラメータ, :カラム2の名前付きパラメータ)");
        $stmt->execute([':カラム1の名前付きパラメータ'=>カラム1の値, ':カラム1の名前付きパラメータ'=>カラム2の値]);
■メソッド
  ♦︎lastInsertId()
    最後に挿入された行のIDあるいはシーケンス(連番)の値を返す。
  ♦︎bindValue()
    ?と値にパラメータをバインドする。
    バインドとは、何かと何かを関連づけること。SQL文の中に変数を埋め込むことでベースのSQL文を使い回し、楽をしようとするテクニックを指して「SQL文に変数をバインドする」と言う。
    カラムごとに値をセットしていくことができる。
    ▼使用方法
      bindValue(parameter, value, data_type)
        parameter ... パラメータID。名前付きパラメータを使用する場合は、:名前付きパラメータを指定。?を使用する場合は、1から始まるパラメータの位置を指定。
        value ... パラメータにバインドする値。
        data_type ... パラメータに対して定義済み定数を使用した明示的なデータ型指定。以下いくつか紹介。
          PDO::PARAM_STR ... 文字列
          PDO::PARAM_INT ... 数値
          PDO::PARAM_NULL ... NULL
          PDO::PARAM_BOOL ... 論理値
        ※bindValue()を使用してexecute()の引数を指定しなかった場合は、bindした値で実行してくれる
  ♦︎bindParam()
    ?と変数にパラメータをバインドする。
    ▼使用方法
      bindParam(parameter, value, data_type, length, driver_options)
        parameter ... bindvaluに同じ
        variable ... SQLパラメータにバインドするPHP変数名を指定。
        data_type ... bindValueに同じ
        length ... データ型の長さを指定。
        driver_options ... ドライバオプションを指定。
    ※bindValue()とbindParam()の違いは変数を評価するタイミング。bindParam()はexecute()された時点で変数を評価する。bindValue()はすぐに変数を評価する。
  ♦︎fetch()
    結果セットから次の行を取得する。
    ▼使用方法
      $stmt->fetch($fetch_style, $cursor_orientation, $cursor_offset)
      ▼パラメータの説明
        $fetch_style ... 次のレコードを呼び出し元に返す方法を制御する。この値はPDO::FETCH_*定数のどれかで、デフォルトはPDO::ATTR_DEFAULT_FETCH_MODEの値(そのデフォルトはPDO::FETCH_BOTH)。
          PDO::FETCH_*定数の種類
            PDO::FETCH_ASSOC ... 結果セットに返された際のカラム名で添字をつけた配列を返す。
            PDO::FETCH_BOTH(デフォルト) ... 結果セットに返された際のカラム名と0で始まる絡む番号で添字をつけた配列を返す。
            PDO::FETCH_BOUND ... TRUEを返し、結果セットのカラムの値をPDOStatement::bindColumn()メソッドでバインドされたPHP変数に代入する
            PDO::FETCH_CLASS ... ここで指定したクラスのインスタンスを返す。各行のカラムがクラスのプロパティ名にマッピングされる
  ♦︎fetchAll()
    全ての結果行を含む配列を返す。
    ▼使用方法
      $stmt->fetchAll($fetch_style, $fetch_argument, $ctor_args)
      ▼パラメータの説明
        $fetch_style ... レコードを呼び出し元に返す方法を制御する。デフォルトはPDO::ATTR_DEFAULT_FETCH_MODEの値(そのデフォルトはPDO::FETCH_BOTH)。種類は以下。
            PDO::FETCH_ASSOC ... 結果セットに返された際のカラム名で添字をつけた配列を返す。
            PDO::FETCH_BOTH(デフォルト) ... 結果セットに返された際のカラム名と0で始まる絡む番号で添字をつけた配列を返す。
            PDO::FETCH_COLUMN ... 結果セットから単一カラムの全ての値を含む配列を返す。fetch_argumentパラメータにどのカラムを返すかを指定することができる。
            PDO::FETCH_UNIQUE ... 結果セットから単一カラムの一意な値を返す。
            PDO::FETCH_GROUP ... 指定したカラムの値によってグループ化した連想配列を返す。
            PDO::FETCH_OBJ ... 結果セットの現在の行をオブジェクトとして返す。
        $fetch_argument ... この引数はfetch_styleの値によって意味が異なる。種類は以下。
            PDO::FETCH_COLUMN ... ここで指定した0から始まる番号のカラムを返す
            PDO::FETCH_CLASS ... ここで指定したクラスのインスタンスを返す。各行のカラムがクラスのプロパティ名にマッピングされる
            PDO::FETCH_FUNC ... ここで指定した関数をコールした結果を返す。各行のカラムを関数コール時のパラメータとする。
  ♦︎rowCount()
    レコードの数を取得する。
    ▼使用方法
      $stmt->rowCount();
■データベースとの接続切断
  基本的にPHPのスクリプトが終了したら接続が切れるので明示的に書かなくても良い場合も多いが、明示的に切断したい場合は以下のようにする。
    $pdo = null; (インスタンスにnullを入れる)
■トランザクション
  ♦︎トランザクションのスタート
    $db->beginTransaction();
  ♦︎トランザクションの終了
    $db->commit();
  ♦︎トランザクションの安全終了(何らかの処理にエラーがあった場合)
    $db->rollback();
*/

// データベース関連の情報は定数にしておく
define('DB_DATABASE', 'dotinstall_db');
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', 'masamasa');
define('PDO_DSN', 'mysql:dbhost=localhost;dbname=' . DB_DATABASE);

# PDO::FETCH_CLASSで使用するクラスを定義
class User {
  /* PDO::FETCH_CLASSモードではカラムを自動的にクラスのpublicプロパティにセットしてくれるので以下の定義は省略可能。privateなどにしたい場合は指定する。*/
  // public $id;
  // public $name;
  // public $score;

  public function show() {
    echo "$this->name ($this->score)";
  }
}

// PDOを使う準備
try {
  // データベースと接続
  $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
  // データベース接続後にオプションを指定
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  # exec()
  // $db->exec("insert into users (name, score) values ('taguchi', 55)");

  # ?を使用したprepare(), execute()
  // $stmt = $db->prepare("insert into users (name, score) values (?, ?)"); // 値を渡すときはとりあえず?とする
  // $stmt->execute(['taguchi', 44]); // executeに配列を渡すと?の部分に値を安全な形で埋め込んで実行してくれる

  # 名前付きパラメータを使用したprepare(), execute()
  // $stmt = $db->prepare("insert into users (name, score) values (:name, :score)"); // prepare()に渡すvalueは?ではなく名前付きパラメータにすることもできる。扱うカラムが多くなってきたときに便利
  // $stmt->execute([':name'=>'fkoji', ':score'=>'80']); // prepare()に渡すvalueを名前付きパラメータにした時はexecute()に渡す配列をkeyとvalueのペアにする
  // echo "inserted:" . $db->lastInsertId(); // 最後に挿入されたレコードのIDを表示

  # ?を使用したbindValue()
  // $stmt = $db->prepare("insert into users (name, score) value (?, ?)");
  // $name = 'taguchi';
  // $stmt->bindValue(1, $name, PDO::PARAM_STR); // valueの1番目の?にbindしたいので、第一引数を1とする
  // $score = 23;
  // $stmt->bindValue(2, $score, PDO::PARAM_INT); // valueの2番目の?にbindしたいので、第一引数を2とする
  // $stmt->execute();
  // $score = 44;
  // $stmt->bindValue(2, $score, PDO::PARAM_INT); // valueの2番目の?にbindしたいので、第一引数を2とする
  // $stmt->execute();

  # 名前付きパラメータを使用したbindValue()
  // $stmt = $db->prepare("insert into users (name, score) value (:name, :score)");
  // $name = 'taguchi';
  // $stmt->bindValue(':name', $name, PDO::PARAM_STR); // valueの1番目の?にbindしたいので、第一引数を1とする
  // $score = 23;
  // $stmt->bindValue(':score', $score, PDO::PARAM_INT); // valueの2番目の?にbindしたいので、第一引数を2とする
  // $stmt->execute();
  // $score = 44;
  // $stmt->bindValue(':score', $score, PDO::PARAM_INT); // valueの2番目の?にbindしたいので、第一引数を2とする
  // $stmt->execute();

  # ?を使用したbindParam()
  // $stmt = $db->prepare("insert into users (name, score) value (?, ?)");
  // $name = 'taguchi';
  // $stmt->bindValue(1, $name, PDO::PARAM_STR);
  // $stmt->bindParam(2, $score, PDO::PARAM_INT);
  // $score = 52;
  // $stmt->execute();
  // $score = 44;
  // $stmt->execute();

  # query()を使用したレコードの抽出
  // $stmt = $db->query("select * from users");
  // $users = $stmt->fetchAll(PDO::FETCH_ASSOC); // キーと値のペアの配列で返ってくるPDO::FETCH_ASSOCを指定
  // foreach ($users as $user) {
  //   var_dump($user);
  // }
  // echo $stmt->rowCount() . " records found.";

  # 条件付き抽出
  // $stmt = $db->prepare("select score from users where score > ?");
  // $stmt->execute([60]); // select文の結果が入る
  // $stmt = $db->prepare("select name from users where name like ?");
  // $stmt->execute(['%t%']);
  // $stmt = $db->prepare("select score from users order by score desc limit ?");
  // $stmt->execute([1]); // execute()で渡す配列データは基本的に文字列で渡される。where句に対して数値を渡すときはうまく解釈してくれるが、limit句だけはbindValue()あるいはbindParam()で渡さないといけない。
  // $stmt->bindValue(1, 1, PDO::PARAM_INT); // 1番目のパラメータに対して数値の1を渡す
  // $stmt->execute();
  // $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
  // foreach ($users as $user) {
  //   var_dump($user);
  // }
  // echo $stmt->rowCount() . " records found.";

  # PDO::FETCH_CLASS
  // $stmt = $db->query("select * from users");
  // $users = $stmt->fetchAll(PDO::FETCH_CLASS, User);
  // foreach ($users as $user) {
  //   $user->show();
  // }

  # レコードの更新と削除
  // $stmt = $db->prepare("update users set score = :score where name = :name");
  // $stmt->execute([
  //   ':score'=> 100,
  //   ':name' => 'test'
  // ]);
  // echo 'row updated' . $stmt->rowCount();
  // $stmt = $db->prepare("delete from users where name = :name");
  // $stmt->execute([
  //   ':name' => 'yamada'
  // ]);
  // echo 'row deleted' . $stmt->rowCount();

  # トランザクション
  // $db->beginTransaction();
  // $db->exec("update users set score = score - 10 where name = 'taguchi'");
  // $db->exec("update users set score = score + 10 where name = 'fkoji'");
  // $db->commit();

  // データベースとの接続切断
  $db = null;

} catch (PDOException $e) {
  $db->rollback();
  echo $e->getMessage();
  exit;
}
