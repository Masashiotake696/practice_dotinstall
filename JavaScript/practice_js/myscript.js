/* コンソールの表示 */
// console.log("Hello from Script");

/*
  変数: データにつけるラベル
  var msg;
  msg = "Hello World";
  一気に宣言
    var msg = "Hello World";
  複数宣言
    var msg = "Hello World", x = 20, y = 10;
  データ型
    - 文字列
      表現方法
        "", ''で囲む
      特殊文字
        \の後に文字をつけて表現
        Ex.) \n (改行), \t (タブ), \' (')
      演算子
        + (文字列の連結)
        ※「+」は、数値同士の演算の場合は数値、文字列同士の演算の場合は連結になる。ただし、片方が文字列の場合は連結になる。
    - 数値
      - 整数値
      - 実数値
      - マイナス値
      演算子
        +, -, *, /, %
        += (代入を伴う演算子)
        ++, -- (単項演算子)
    - 真偽値
        文字列: 空文字以外だったらtrue
        数値: 0かNaN以外だったらtrue
        true / false
        object: null以外だったらtrue
        undefined, null -> false
    - オブジェクト
      - 配列
      - 関数
      - 組み込みオブジェクト
    - undefined ... 定義されていない
    - null ... 何もない
  条件分岐
    if文
      if (条件) {

      } else if (条件) {

      } else {

      }
    三項演算子
      var a, b, c;
      if (条件) {
        a = b;
      } else {
        a = c;
      }
      書き換えると...
      a = (条件) ? b : c;
    switch文
      var signal = "red";
      switch (signal) {
        case "red":
          console.log("stop");
          break;
        case "green":
          console.log("go");
          break;
        case "yellow":
          console.log("slow down");
          break;
        default:
          console.log("wrong signal");
          break;
      }
      続けて書くことも可能
      switch (signal) {
        case "red":
          console.log("stop");
          break;
        case "green":
        case "blue": // 続けて記述
          console.log("go");
          break;
        case "yellow":
          console.log("slow down");
          break;
        default:
          console.log("wrong signal");
          break;
      }
  比較演算子
    >, < ... より大きい、より小さい
    >=. <= ... 以上、以下
    ===, !== ... 等しい、等しくない
      == (等価演算子) ... 文字列と数値の比較の場合は、文字列を数値に変換してくれる
      === (厳密等価演算子) ... 文字列は数値に変換されないので、falseが返る
  論理演算子
    AND &&
    OR ||
    NOT !
  ループ処理
    while文
      var i = 0;
      while (i < 10) {
        console.log(i);
        i++;
      }
    do ... while文
      var i = 0;
      do  {
        console.log(i);
        i++;
      } while (i < 10);
    for文
      for(var i = 0; i < 10; i++) {
        console.log(i);
      }
    break文
      ループを抜ける
    continue文
      ループ処理を一回スキップする
  ユーザーに情報を提示、ユーザーの確認を求める
    alert
      alert("hello");
    confirm
      var answer = confirm("Are you sure?");
      OK ... true
      キャンセル ... false
    prompt
      var name = prompt("お名前は?");
      入力があったらその値(空もある)が、キャンセルが押されたらnullが返る
      初期値の設定は第二引数で行う
        var name = prompt("お名前は?", "名無しさん");
  関数
    複数の処理をまとめて名前をつけたもの
    書き方
      function 関数名() {
        処理
      }
      Ex.)
      function hello() {
        console.log("hello");
      }
      引数あり
        function hello(name) {
          console.log("hello " + name);
        }
        hello("Tom");
        hello("Bob");
      返り値あり
        function hello(name) {
          return "hello " + name;
        }
        var greet_1 = hello("Tom");
        console.log(greet_1);
        var greet_2 = hello("Bob");
        console.log(greet_2);
      関数内の変数
        function hello(name) {
          var msg = "hello" + name; // ローカル変数
          return msg;
        }
        var greet = hello("Tom");
        console.log(greet);
        console.log(msg); // エラーが出る
    関数を変数に入れる(関数もデータ型であるため)
      var hello = function hello(name) {
        var msg = "hello" + name; // ローカル変数
        return msg;
      }; // 最後にセミコロンをつける
      var greet = hello("Tom");
      console.log(greet);
      関数名の省略が可能
      var hello = function(name) { // 無名関数、匿名関数
        var msg = "hello" + name; // ローカル変数
        return msg;
      }; // 最後にセミコロンをつける
      var greet = hello("Tom");
      console.log(greet);
    即時関数
      function hello() {
        console.log("hello");
      }
      hello();
      上記を定義してすぐ実行する場合は以下のように書く(即時関数)
      関数を()で囲った後に();を末尾につける。
      (function hello() {
        console.log("hello");
      })();
      引数あり
      (function hello(name) {
        console.log("hello " + name);
      })("Tom");
      関数名の省略が可能
      (function(name) {
        console.log("hello " + name);
      })("Tom");
      即時関数は自分が書いたプログラムの変数が、他の人の書いたプログラムから影響を受けたり、他の人の書いたプログラムの変数に影響を与えたりしないようにローカル変数にするためによく使われる。
        (function() {
          var x = 10,
              y = 20;
          console.log(x + y);
        })();
  タイマー処理
    setInterval
      ある一定時間ごとにある処理を繰り返す。前の処理が終わったかどうかを考えずに次の処理を始めるため、あまりにも処理が重い場合には、次々に新しい処理が実行されてブラウザがクラッシュする(繰り返し処理には向かない)。
      書き方
        setInterval(関数, ミリ秒);
      Ex.)
        var i = 0;
        function show() {
          console.log(i++); // コンソールを表示しつつ、iをカウントアップする
        }
        // 1秒ごとに0から数値がカウントアップする
        setInterval(function() {
          show();
        }), 1000);
    setTimeout
      ある一定時間後にある処理を一回だけ実行する。前の処理が終わったかどうかを考慮するので、繰り返し処理に向いている。
      書き方
        setInterval(関数, ミリ秒);
      Ex.)
        var i = 0;
        function show() {
          console.log(i++); // コンソールを表示しつつ、iをカウントアップする
        }
        // 1秒後にshow()を実行する
        setTimeout(function() {
          show();
        }), 1000);
      setTimeoutを繰り返し処理に用いる
        var i = 0;
        function show() {
          console.log(i++);
          setTimeout(function() { // タイマーIDを変数の中に入れる
            show(); // 再帰関数にする
          }), 1000);
        }
        show(); // 最初の一回だけ呼び出す
      タイマーを止める方法
        var i = 0;
        function show() {
          console.log(i++);
          var tid = setTimeout(function() { // タイマーIDを変数の中に入れる
            show();
          }), 1000);
          if (i > 3) {
            clearTimeout(tid); // タイマーIDを指定してタイマーを止める
          }
        }
        show();
  配列
    値がグループ化されたデータ
    Ex.)
      var score = [100, 300, 500];
      console.log(score[0]); // 添字 0, 1, 2, ...
      score[2] = 400; // score[2]の値を書き換える
      console.log(score); // score配列の中身をすべて表示
    配列の中に配列(行列)
      var m = [
        [1, 2, 3],
        [4, 5, 6]
      ];
      console.log(m[1][1]);
  オブジェクト
    名前と値のペアがグループ化されたデータ
    Ex.)
      var user = {
        email: "taguchi@gmail.com", // プロパティ
        score: 80
      };
      console.log(user["email"]); // どちらでもいい
      console.log(user.email); // どちらでもいい
      user.score = 100; // 値の書き換え
      console.log(user);
    メソッド(プロパティの値に関数を持たせる)
      var user = {
        email: "taguchi@gmail.com",
        score: 80,
        greet: function(name) { // メソッド
          console.log("hello, " + name);
        }
      };
      user.greet("Tom");
    「this」(メソッドの中で使える特別なキーワード)
      「this」を使うと今自分がいるオブジェクトを参照することができる。
      var user = {
        email: "taguchi@gmail.com",
        score: 80,
        greet: function(name) { // メソッド
          console.log("hello, " + name + " from " + this.email); // thisを使用
        }
      };
      user.greet("Tom");
  組み込みオブジェクト
    あらかじめJSが用意してくれているオブジェクト。色んなメソッドやプロパティが使えるようになる。
    String (文字列オブジェクト)
      var s = new String("taguchi");
      console.log(s.length); // 文字列の長さを返す
      console.log(s.replace("t", "T")); // "t"を"T"に置換する
      console.log(s.substr(1, 3)); // 1~3文字分を取得する
      ※ var s = "taguchi";とやっても同じ結果が返ってくる。これは文字列リテラル。
      文字列オブジェクトと文字列リテラルは全く違うものだが、文字列リテラルにメソッドやプロパティをつけるとJSの方でオブジェクトを使いたいと解釈して、一瞬文字列オブジェクトに変換してくれるので、実行結果が同じになっている。
    Array (配列オブジェクト)
      var a = new Arrya(100, 300, 200);
      // var a = [100, 300, 200];
      console.log(a.length);
      // unshift -> array <- push (要素の追加)
      // shift <- array  -> pop (要素の削除)
      a.push(500); 要素の末尾に500を追加 [100, 300, 200, 500]
      console.log(a);
      // splice 第一引数：追加や削除したい要素の場所を指定、第二引数：削除したい要素の数
      //a.splice(1, 2); // 添え字が1の要素から連続した二つの要素を削除 [100, 500]
      console.log(a);
      a.splice(1, 2, 800, 1000); [100, 800, 1000, 500]
    Math
      console.log(Math.PI); // 円周率を表示
      console.log(Math.ceil(5.3)); // 切り上げ 6
      console.log(Math.floor(5.3)); // 切り上げ 5
      console.log(Math.round(5.3)); // 四捨五入 5
      console.log(Math.random()); // 0から1今んの実数をランダムに生成
    Date
      var d = new Date(); // 現在時刻のオブジェクト
      var d = new Date(2014, 1, 11, 10, 20, 30); // 特定の日付オブジェクトを取得 2014年2月11日10時20分30秒 ※JavaScriptでは月は0から始まる
      console.log(d.getFullYear());
      console.log(d.getMonth());
      console.log(d.getTime()); // 1970年1月1日からの経過ミリ秒
    window // ブラウザの色々なものにJavaScriptからアクセスできる
      console.dir(); // オブジェクトのプロパティを表示
      console.dir(window);
      console.log(window.outerHeight); // windowの高さを取得
      window.location.href = 'http://dotinstall.com' // ドットインストールに移動
      window.document ... 今開いているページ。windowは省略可能(document)
      document object model (DOM) ... ドキュメントにアクセスするための色々な命令。命令がブラウザによってまちまち。
    DOM
      // 既存の要素の書き換え
      var e = document.getElementById('msg'); // idがmsgの要素の値を取得
      e.textContent = 'hello'; // テキストを書き換える
      e.style.color = 'red'; // スタイルを書き換える
      e.className = 'myStyle'; // スタイルを適応する
      // 新しい要素の作成
      // body要素の中にp要素を追加して、そのp要素の中にtextを仕込む
      var greet = document.createElement('p'); // 要素の作成。タグネームを指定する
      var text = document.createTextNode('hello world'); // テキストの作成。テキストを指定する。
      document.body.appendChild(greet).appendChild(text); // bodyに対して子要素を追加する。bodyの下にgreetを、greetの下にテキストを追加する。
  イベントの設定
    addEventListener() ... 第一引数にイベントの種類を割り当てる。第二引数に函数を与える。
    document.getElementById('add').addEventListener('click, function() {
      var greet = document.createElement('p');
      var text = document.createTextNode('hello world');
      document.body.appendChild(greet).appendChild(text);
    }');


  ■追加説明(CodeCampより)
    ▼DOM
      DOM(Document Object Model)は「HTML文書をオブジェクトとして扱えるようにしたもの」で、これによりJavaScriptからHTMLを操作する事ができる。
      HTML文書がブラウザに読み込まれると、JavaScript内でDOMオブジェクトとして複数のオブジェクトが自動生成される。生成されたDOMオブジェクトにはメソッドやプロパティが定義されており、これを利用する事ができる。
      DOMのツリー構造は以下のようになっている。
        window
          location
          history
          document など
            html
              head
                meta
                title など
              body
                h1
                p など
        ※各要素のオブジェクトはツリー構造により親子関係となっており、windowオブジェクトが最上位の親となる
      documentオブジェクトはDOMのなかで最も頻繁に利用するオブジェクトで、Webページに関するあらゆる情報を持っている。DOMはHTMLのhtml要素・body要素・p要素などの要素全てに対してオブジェクトとプロパティ、メソッドを定義する。
      DOMは全ての要素をオブジェクトとして定義するが、一つ一つ独立しているわけではなく、windowオブジェクトの一部として各要素が定義されている。
      このため、DOMを利用して各HTML要素の操作を行う場合、windowオブジェクトの中から必要な要素を指定する必要がある。しかし、windowオブジェクトはJavaScript内で省略可能。

*/

// var msg = "Hello World";
// console.log(msg);

// var x;
// x = 10 * 2; // 20
// x = 10 % 3; // 1
// // x = x + 5;
// x += 5; // 6
// x++; // 7
// x--; // 6
// console.log(x);

// if (x) {
//   // 処理
// }
// // xが文字列の場合...
// if (x !== '') {
//
// }

// alert("hello");
// var answer = confirm("Are you sure?");
// console.log(answer);
// if (confirm("本当に削除しますか")) {
//   // 削除処理
// } else {
//   // 別の処理
// }

// var name = prompt("お名前は?");
// var name = prompt("お名前は?", "名無しさん");
// console.log(name);

// function hello() {
//   console.log("hello");
// }
// hello();
// function hello(name) {
//   console.log("hello " + name);
// }
// hello("Tom");
// hello("Bob");
// function hello(name) {
//   return "hello " + name;
// }
// var greet = hello("Tom");
// console.log(greet);
// greet = greet + "xxx";
// console.log(greet);

// var hello = function(name) { // 無名関数、匿名関数
//   var msg = "hello" + name; // ローカル変数
//   return msg;
// }; // 最後にセミコロンをつける
// var greet = hello("Tom");
// console.log(greet);

// (function hello() {
//   console.log("hello");
// })();

// (function hello(name) {
//   console.log("hello " + name);
// })("Tom");

// var score = [100, 300, 500];
// console.log(score[0]); // 添字 0, 1, 2, ...
// score[2] = 400; // score[2]の値を書き換える
// console.log(score); // score配列の中身をすべて表示

// var m = [
//   [1, 2, 3],
//   [4, 5, 6]
// ];
// console.log(m[1][1]);

// var user = {
//   email: "taguchi@gmail.com", // プロパティ
//   score: 80
// };
// console.log(user["email"]); // どちらでもいい
// console.log(user.email); // どちらでもいい
// user.score = 100;
// console.log(user);
// console.log(user.score);

// var user = {
//   email: "taguchi@gmail.com",
//   score: 80,
//   greet: function(name) { // プロパティに関数を持たせる。これは無名関数
//     console.log("hello, " + name);
//   }
// };
// user.greet("Tom");

// var user = {
//   email: "taguchi@gmail.com",
//   score: 80,
//   greet: function(name) { // メソッド
//     console.log("hello, " + name + " from " + this.email); // thisを使用
//   }
// };
// user.greet("Tom");

// 既存の要素の書き換え
// var e = document.getElementById('msg'); // idがmsgの要素の値を取得
// e.textContent = 'hello'; // テキストを書き換える
// e.style.color = 'red'; // スタイルを書き換える
// e.className = 'myStyle'; // スタイルを適応する
// // 新しい要素の作成
// // body要素の中にp要素を追加して、そのp要素の中にtextを仕込む
// var greet = document.createElement('p'); // 要素の作成。タグネームを指定する
// var text = document.createTextNode('hello world'); // テキストの作成。テキストを指定する。
// document.body.appendChild(greet).appendChild(text); // bodyに対して子要素を追加する。bodyの下にgreetを、greetの下にテキストを追加する。

// document.getElementById('add').addEventListener('click', function() {
//   var greet = document.createElement('p');
//   var text = document.createTextNode('hello world');
//   document.body.appendChild(greet).appendChild(text);
// });
