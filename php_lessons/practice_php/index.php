<?php
// 終了タグはその後に何かを出力する必要がなければ省略することが推奨されている
// <?=は<?php echoと同じ
/*
  ■変数とデータ型
    ▼変数:
    「$」と変数名で表現
    ▼データ型:
      ※変数を定義するときにデータ型を宣言する必要はない。phpが文脈に応じて自走てきに判断する。
        文字列 string
        数値 integer float
        論理値 boolean / true false
        配列
        オブジェクト
        null
    var_dump ... 変数の型と値をしる命令
  ■定数
    プログラム上で変更されない値につけるラベル。
      定義方法: define("定義名", "値");
    ※自動的に定義される定数がある。以下参考。
    http://php.net/manual/ja/language.constants.predefined.php
  ■数値演算
    ▼演算子
      + - * / % **(べき乗, PHP5.6から)
    ▼単項演算子
      ++ --
    代入を伴う演算子
      += -=
  ■文字列
    ▼"" ... 特殊文字(\n, \t)、変数の展開ができる
      変数を展開するときは変数であることを明示的にするために{}で囲う
        {$name} ${name} どちらでも良い
    ▼'' ... 特殊文字、変数の展開ができない
    ▼文字列の連結
      「.」を使う
  ■条件分岐
    ▼if文
    if (...) {
      ...
    } elseif (...) {
      ...
    } else {
      ...
    }
    ▼比較演算子
      > < >= <= ==(値の比較) ===(値とデータ型の比較) !=(値の比較) !==(値とデータ型の比較)
    ▼論理演算子
      and && , or ||, !
    ▼データの値自体で真偽値を判定
      falseになる場合
        文字列: 空, "0"
        数値: 0, 0.0
        論理値: false
        配列: 要素の数が0
        null
    ▼三項演算子
      if ($bool) {
        func1();
      } else {
        func2();
      }
      → $bool ? func1() : func2();
      ※厳密に比較したい場合は===を追加する必要がある
      if($cond === true) {
        func1();
      } else {
        func2();
      }
      → $cond === true ? func1() : func2();
    ▼switch文
      switch (変数) {
        case 値:
          func1();
          break;
        case 値:
        case 値: // 並べて書くこともできる
          func2();
          break;
        case 値:
          func3();
          break;
        default:
          func4();
          break;
      }
  ■ループ処理
    ▼while文(前判定、処理が必ず実行されるとは限らない)
      while (条件) {
        func1();
      }
    ▼do ... while文(後判定、必ず一回は処理が実行される)
      do {
        func1();
      } while (条件);
    ▼for文
      for (初期化処理; ループ終了条件; ループの処理が終わるごとに行う処理) {
        func1();
      }
    ▼break文
      ループを抜ける
    ▼continue文
      それ以降の処理を実行せずに次のループに移る
  ■配列
    keyとvalueがペアになったデータ構造
    ※Rubyで言うハッシュ
    ▼定義方法
      array(
        "変数名" => 値,
        "変数名" => 値,
        "変数名" => 値,
      );
      ※PHP5.4以降は以下のようにも書ける
      [
        "変数名" => 値,
        "変数名" => 値,
        "変数名" => 値,
      ]
    ※keyを省略することができる。その場合はRubyの配列と同義
    ▼foreach文(配列のループ処理)
      foreach (変数 as keyの変数 => valueの変数) {
        処理;
      }
  ■関数
    ▼定義方法
      ♦︎引数なし
      function 関数名() {
        処理
      }
      関数名();
      ♦︎引数あり
      function 関数名(引数) {
        処理
      }
      関数名(引数);
      ♦︎引数に初期値をつける
      function 関数名(変数 = 初期値) {
        処理
      }
      関数名();
      ♦︎返り値あり
      function 関数名(変数 = 初期値) {
        return 処理
      }
      変数 = 関数名();
      var_dump(変数);
    ▼ローカル変数
      関数内で定期した変数はその関数内でのみ有効
    ▼組み込み関数
      ♦︎数値に使う関数
        ceil() ... 小数点以下を切り上げる
        floor() ... 小数点以下を切り捨てる
        round() ... 四捨五入をする
        rand() ... 乱数を生成する
      ♦︎文字列に使う関数
        strlen() ... 文字数をカウントする
        mb_strlen() ... 日本語の文字列をカウントする。日本語はマルチバイトなので、mb_で始まる。
        printf() ... 書式を指定して値を表示する
      ♦︎配列に使う関数
        count() ...  配列の要素数をカウントする
        implode() ... 配列の要素をある区切り文字で連結して文字列を返す
  ■クラスとインスタンス
    ▼クラス
      複雑なデータ構造を自分で作る時に使える仕組み。
      クラスが持つ変数をプロパティ(データを表す)、クラスが持つ関数のことをメソッド(動作を表す)と呼ぶ。
    ▼インスタンス
      クラスをもとに実際にデータを持たせたオブジェクトのことをインスタンスと呼ぶ。
      クラスがインスタンス化されるときに必ず呼ばれるコンストラクタと言う命令がある。
    ▼クラスの継承
      あるクラスをもとに新しいクラスを作りたい場合に便利な仕組み。
      親クラスのメソッドやプロパティを保持しつつ、新しく独自にメソッドやプロパティを追加したクラスを作ることができる。
      子クラスで親クラスのメソッドやプロパティを上書きすることもできる。これをオーバーライドと呼ぶ。
      親クラスのメソッドでオーバーライドしてもらいたくない場合は、メソッド名の前でfinalというキーワードをつけると子クラスでオーバーライドができなくなる。
    ▼プロパティやメソッドのアクセス権
      private ... そのクラス内からのみアクセス可能
      protected ... そのクラスと親子クラスからのみアクセス可能
      public ... どこからでもアクセス可能
    ▼クラスをインスタンス化しなくても使えるメソッドやプロパティを定義する
      staticキーワードを使用する。
      書き方
        public static function getMessage() {

        }
      ※インスタンスを作らないので、インスタンス化されるときに設定されるプロパティは使うことができない。
    ▼抽象クラス
      他のクラスで継承してもらうことを前提にしたクラス。それ自身をインスタンス化することはできない。
      抽象クラスを作るにはabstractと言うキーワードを使う。
    ▼インターフェース
      このクラスではこのメソッドを必ず実装するというルールを定義する仕組み。これにより実装漏れを防ぐことができる。
      interfaceというキーワードを使う。
      ※インターフェースの特性上必ずアクセス権はpublicになる。
      インターフェースで定義したメソッドを実装したいクラスにはimplementsというキーワードを使う。implementsは継承のextendsと違い複数のインターフェースを指定することができる。
      ♦︎抽象クラスとの違い
        ①抽象クラスでは抽象メソッド以外のメソッドやプロパティの実装ができるのに対して、インターフェースでは実装できない
        ②抽象クラスは一つしか継承できないのに対して、インターフェースは複数実装できる。
  ■外部ファイルの読み込み
    require ... これを書いたところにファイルを読み込む。ただし、 エラーが出た場合にfatal errorを発生させてその場で処理が終了する。
    require_once ... requireとの違いは、PHPが自動的にそのファイルが読み込まれているかをチェックし、もし読み込まれている場合はそれをスキップする。
    include ... これを書いたところにファイルを読み込む。ただし、エラーが出た場合にwarningを発生させて処理は続行する。
    include_once ... includeとの違いは、PHPが自動的にそのファイルが読み込まれているかをチェックし、もし読み込まれている場合はそれをスキップする。
    autoload ... クラスが出てきた時にもしクラスが未定義だったら自動的に実行される仕組み。
    spl_autoload_register()と書く。
    ▼名前空間
      ファイルを分割した時に、他の人が作ったファイルとクラス名などがバッティングしてしまうと大きな問題になる。そこで自分が作ったクラスや関数、インターフェースなどには名前空間をつけて他の人と被らないようにする。
      名前空間を使用するには、namespaceと書いた後に他の人と被らないような名前空間をつける。名前空間は階層的に管理できて、バックスラッシュ(\)をつけてフォルダのように適当な階層をつける。
      ※名前空間はファイルの先頭に必ず書くルールとなっている。
      名前空間には別名をつけることができ、useというキーワードを使う。
  ■例外処理
    方法
      例外を発生させたい箇所をtryで囲い、例外を投げたい条件を書く(if文など)。例外を投げるにはthrowという命令を使う。例外が投げられた時の処理をcatch()の後に書く。
  ■フォームからのデータ送信
    formのメソッドをGETとした場合、送信された値は$_GETに配列で入ってくる。formのメソッドをPOSTとした場合、送信された値は$_POSTに配列で入ってくる。共にキーはinputのname属性の値。
    htmlspecialchars ... フォームから送られてきた値や、データベースから取り出した値をブラウザ上に表示する場合に使用する。主に、悪意のあるコードの埋め込みを防ぐために使われる(エスケープと呼ばれる)。
    引数は以下の3つ。
    第一引数: 文字列
    第二引数: "または'を変換するかどうか。主な取り得る値は以下の三つ。
      ENT_CONPAT(初期値) ... ダブルクオートは変換するが、シングルクオートは変換しない。
      ENT_QUOTES ... シングルクオートとダブルクオートを共に変換する。
      ENT_NOQUOTES ... シングルクオートとダブルクオートを共に変換しない。
    第三引数: 文字コード
  ■Cookie
    アクセスしてきたブラウザに対してブラウザ側ににデータを保存できる仕組み。
    ▼追加方法
      setcookie()と言う命令を使う。使い方は以下。
        setcookie('キー', '値', '有効期限');
        ※有効期限を設定しない場合は、ブラウザを閉じるまでという有効期限になる
    ▼削除方法
      setcookie('キー', '値', '過去の時間');
      ※過去の時間はtime()-...のようにして指定することができる
    Cookieの値はブラウザに保存されるので、設定したページからだけでなく、他のページからも引っ張ってこれる。
    ▼利点
      ・気軽に使える
    ▼欠点
      ・ブラウザ側にデータを保存するので、改竄される可能性がある
      ・やろうと思えば中身が見える
  ■セッション
    アクセスしてきたブラウザに対してサーバ側にデータを保存できる仕組み。
    ▼追加方法
      セッションを使う前に
        session_start();
        を記述する。これにより値をセットすることができるようになる。
    ▼削除方法
      unset();
    Cookieと同じようにアクセスしてきたブラウザごとにデータをサーバー側で保持してくれるので、他のファイルからアクセスすることもできる。
    ▼利点
      ・大きなデータを保存できる
      ・改ざんされない
      ・中身が見られない

*/

/* 変数とデータ型 */
// $msg = "hello from the TOP";
// echo $msg;
// var_dump($msg);

/* 定数 */
// define("MY_EMAIL", "masashi.otake696@gmail.com");
// echo MY_EMAIL;
// var_dump(__LINE__); // 行数を表示
// var_dump(__FILE__); // ファイル名を表示
// var_dump(__DIR__); // ディレクトリ名を表示

/* 数値演算 */
// $x = 10 % 3; // 1
// $y = 30.2 /4; // 7.55
// var_dump($x);
// var_dump($y);
// $z = 5;
// $z++;
// var_dump($z);
// $z--;
// var_dump($z);
// $x = 5;
// $x += 2;
// var_dump($x);

/* 文字列 */
// $name = "taguchi";
// $s1 = "hello {$name}!\nhello again!"; // 特殊文字や変数が展開される
// $s1 = "hello ${name}!\nhello again!"; // 特殊文字や変数が展開される
// $s2 = 'hello $name!\nhello again!'; // 特殊文字や変数が展開されない
// var_dump($s1);
// var_dump($s2);
// $s = "hello" . "world";
// var_dump($s);

/* 条件分岐 */
// $score = 30;
// if ($score > 80) {
//   echo "great!";
// } elseif ($score > 60) {
//   echo "good!";
// } else {
//   echo "so so ...";
// }

/* データの値自体で真偽値を判定 */
// $x = 5;
// if ($x) { // $xは0あるいは0.0以外なのでtrue
//   echo "great!";
// }

/* 三項演算子 */
// $max = ($a > $b) ? $a : $b;
// if ($a > $b) {
//   $max = $a;
// } else {
//   $max = $b;
// }

/* switch文 */
// $signal = "red";
// switch ($signal) {
//   case "red":
//     echo "stop!";
//     break;
//   case "blue":
//   case "green":
//     echo "go!";
//     break;
//   case "yellow":
//     echo "caution!";
//     break;
//   default:
//     echo "wrong signal";
//     break;
// }

/* ループ処理 */
// while文
// $i = 100;
// while ($i < 10) {
//   echo $i;
//   $i++;
// }
// do while文
// $i = 100;
// do {
//   echo $i;
//   $i++;
// } while ($i < 10);
// for文
// for ($i = 0; $i < 10; $i++) {
//   echo $i;
// }

/* 配列 */
// $sales = [
//   "taguchi" => 200,
//   "fkoji" => 800,
//   "dotinstall" => 600,
// ];
// var_dump($sales["fkoji"]);
// $sales["fkoji"] = 900;
// var_dump($sales["fkoji"]);
//
// $colors = ["red", "blue", "pink"];
// var_dump($colors[1]);

/* foreach(配列のループ処理) */
// $sales = [
//   "taguchi" => 200,
//   "fkoji" => 800,
//   "dotinstall" => 600,
// ];
// foreach ($sales as $key => $value) {
//   echo "($key) $value ";
// }
// $colors = ["red", "blue", "pink"];
// foreach ($colors as $value) {
//   echo "$value ";
// }

/* foreach文, if文, while文, for文で使えるコロン構文 */
// htmlなどに埋め込む時にすっきりと書ける
// foreach ($colors as $value) :
//   echo "$value ";
// endforeach;

/* 関数 */
// function sayHi() {
//   echo "hi!";
// }
// sayHi();
// 引数をつける
// function sayHi($name) {
//   echo "hi! " . $name;
// }
// sayHi("Tom");
// sayHi("Bob");
// 引数に初期値をつける
// function sayHi($name = "taguchi") {
//   echo "hi! " . $name;
// }
// sayHi();
// 返り値あり
// function sayHi($name = "taguchi") {
//   return "hi! " . $name;
// }
// $s = sayHi();
// var_dump($s);
// ローカル変数
// function sayHi($name) {
//   $lang = 'php';
//   echo "hi!! $name from $lang";
// }
// sayHi("Tom");
// var_dump($lang); // NULLになる

/* 組み込み関数 */
// $x = 5.6;
// echo ceil($x); // 6
// echo floor($x); // 5
// echo round($x); // 6
// echo rand(1, 10); // 1~10のランダムな数値を生成する
// $s1 = "hello";
// $s2 = "ねこ";
// echo strlen($s1);
// echo mb_strlen($s2);
// printf("%s - %s - %.3f", $s1, $s2, $x);
// $colors = ["red", "blue", "pink"];
// echo count($colors);
// echo implode("@", $colors); // 第一引数に区切り文字、第二引数に配列を指定

/* クラスとインスタンス */
// class User { // クラス名の一文字目は必ず大文字。このクラスを継承したクラスを作成した場合、これは親クラス
//   // プロパティ(property)。動的メンバとも呼ぶ。
//   // public $name;
//   // private $name; // クラス内からはアクセスできる(「$this->name」は使える)が、インスタンスからは直接呼べなくなる
//   protected $name; // このクラスと親子クラスからは呼べる
//   public static $count = 0; // インスタンス化された数を数えるstaticプロパティ。静的メンバとも呼ぶ。
//
//   // コンストラクタ(constructor)
//   public function __construct($name) {
//     $this->name = $name; // クラスの中のプロパティやメソッドにアクセスするときには$thisと言う特殊なキーワードを使う
//     self::$count++; // このクラスを指定するにはselfと言うキーワードが使える
//   }
//
//   // メソッド(method)
//   public function sayHi() {
//     echo "Hi, I am $this->name!";
//   }
//
//   // メソッド(finalあり)
//   // final public function sayHi() { // finalキーワードを使うと子クラスでオーバーライドすることができなくなる
//   //   echo "Hi, I am $this->name!";
//   // }
//
//   // static
//   public static function getMessage() {
//     echo "Hello from User class!";
//   }
// }
// class AdminUser extends User { // Userクラスを継承しているので、これは子クラス
//   // 子クラス独自のメソッド
//   public function sayHello() {
//     echo "Hello from $this->name";
//   }
//
//   // オーバーライド(override)
//   public function sayHi() {
//     echo "[admin] Hi, I am $this->name!";
//   }
// }
// $tom = new User("Tom");
// $bob = new User("Bob");
// echo $tom->name; // Tom
// echo "\n";
// echo $bob->sayHi(); // Hi, I am Bob!
// echo $tom->sayHi();
// echo "\n";
// $steve = new AdminUser("Steve");
// echo $steve->name;
// echo "\n";
// echo $steve->sayHi();
// echo "\n";
// echo $steve->sayHello();
// User::getMessage("Tom");
// echo User::$count;

/* 抽象クラス */
// 抽象クラスで共通のメソッドやプロパティを定義しておけば、子クラスの実装をシンプルにしたり、子クラスの実装漏れを防ぐことができる。
// abstract class BaseUser {
//   // プロパティ
//   public $name;
//
//   /* 抽象メソッド
//     一部のメソッドを抽象メソッドにして、このクラスを継承したクラスで必ず実装されていることを保証することができる。これは必ず実装してくださいというルールだけなので、この時点では実装の中身を書く必要はない。
//   */
//   abstract public function sayHi();
// }
// class User extends BaseUser { // nameプロパティを引き継ぐ
//   // 抽象メソッドに関しては実装しないといけないので、何も書かないとエラーになる。実装する際には、必ず継承している抽象メソッドのアクセス権やメソッド名、引数の数を同じにしなくてはならない。
//   public function sayHi() {
//     echo "Hello from User";
//   }
// }

/* インターフェース */
// interface sayHi { // インターフェース名を定義
//   public function sayHi(); // 実装して欲しいメソッドを定義する。インターフェースの特性上必ずメソッドのアクセス権はpublicになる。実装の中身はインターフェースを実装するクラスで書くので、ここでは書かなくて良い。
// }
// interface sayHello {
//   public function sayHello();
// }
// class User implements sayHi, sayHello { // extendsと違いimplementsは複数のインターフェースを指定することができる。これにより、このクラスに対してインターフェースで定義したメソッドが実装されていることが保証されることになる。
//   public function sayHi() {
//     echo "hi!";
//   }
//
//   public function sayHello() {
//     echo "hello!";
//   }
// }

/* 外部ファイルの読み込み */
// ファイルの読み込み(requireの使用)
// require "User.class.php";
// ファイルの読み込み(autoload使用)
// spl_autoload_register(function($class) {
//   require $class . ".class.php";
// });
// インスタンス
// $bob = new User("Bob");
// $bob->sayHi();

/* 名前空間 */
// require "User.class.php"; // ファイルの読み込み(requireの使用)

// use Dotinstall\Lib as Lib; // 名前空間に別名をつけることができる
// use Dotinstall\Lib; // このように書くことでこの階層の最後の単語(この場合はLib)を使えば良いと言う意味になる。

// インスタンス
// $bob = new Dotinstall\Lib\User("Bob"); // 名前空間を指定する
// $bob = new Lib\User("Bob"); // 別名を使用した名前空間を指定する
// $bob->sayHi();

/* 例外処理 */
// function div($a, $b) {
//   try{ // 例外を発生させたい箇所をtryで囲う
//     if ($b === 0) { // 例外を投げたい場合を書く
//       throw new Exception("cannot divide by 0!"); // 例外を投げるにはthrowという命令を使う。PHPの中で例外の基底クラスであるExceptionクラスがあるので、そのインスタンスを投げる。Exceptionクラスではインスタンスを作るときにメッセージを指定することができる。
//     }
//     echo $a / $b;
//   } catch (Exception $e) { // 例外が投げられた時の処理をcatch()の後に書く。引数にException $eとするとthrowで投げられたインスタンスが$eに入る。
//     echo $e->getMessage(); // Exceptionクラスの中で定義されているgetMessage()メソッドを使うと、Exceptionインスタンスを作成するときに指定したメッセージを取得できる。
//   }
// }
// div(7, 2); // 問題なし
// div(5, 0); // warningになる

/* Cookie */
// setcookie("username", "taguchi");
// setcookie("username", "taguchi", time()+60*60); // time()で今の基準日からの経過描画取れるので、+60(秒)*60(分)とすることで1時間後に消えるcookieをセットする
// setcookie("username", "taguchi", time()-60*60); // time()-...にすることでCookieを削除する
// echo $_COOKIE['username'];

/* セッション */
// session_start();
// $_SESSION['username'] = "taguchi";
// unset($_SESSION['username']);
// echo $_SESSION['username'];
