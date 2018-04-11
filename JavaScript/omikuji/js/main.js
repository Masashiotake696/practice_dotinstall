// 全体を即時関数で囲む
(function() {
  // キーワードで厳密なエラーチェックをする
  'use strict';

  // idをもとにボタン情報を変数に入れる
  var btn = document.getElementById('btn');
  // ボタンクリック時に文字を変える
  btn.addEventListener('click', function() {
    // var n = Math.floor(Math.random() * 3);
    /* swith文を使う場合s */
    // switch (n) {
    //   case 0:
    //     this.textContent = '大吉';
    //     break;
    //   case 1:
    //     this.textContent = '中吉';
    //     break;
    //   case 2:
    //     this.textContent = '凶';
    //     break;
    // }
    /* if...else文を使う場合 */
    // if (n === 0) {
    //   this.textContent = '大吉';
    // } else if (n === 1) {
    //   this.textContent = '中吉';
    // } else {
    //   this.textContent = '凶';
    // }
    //this.textContent = n; // thisはクリックした要素を指す

    /* 配列を使う場合 */
    var results = ['大吉', '中吉', '凶'];
    var n = Math.floor(Math.random() * results.length);
    this.textContent = results[n];

    /* 配列の中身を変更した確率の変更 */
    // var results = ['大吉', '大吉', '大吉', '大吉', '凶']; // 大吉が出る確率を80%,凶が出る確率を20%とする
    // var n = Math.floor(Math.random() * results.length);
    // this.textContent = results[n];

    /* if文を使った確率の変更 */
    var n = Math.random();
    if (n < 0.05) { // 5%の確率で大吉が出る
      this.textContent = '大吉';
    } else if (n < 0.2) { // 15%の確率で中吉が出る
      this.textContent = '中吉';
    } else { // 残りの80%の確率で凶が出る
      this.textContent = '凶';
    }
  });
  // ボタン押下中にクラスを当てる
  btn.addEventListener('mousedown', function() {
    this.className = 'pushed';
  });
  // ボタン開放中にクラスを無くす
  btn.addEventListener('mouseup', function() {
    this.className = '';
  });

  /*
    Math.random() ... ０から1を含まない1未満までのランダムな数値を出力する
    Math.floor(Math.random() * (n + 1)) ... 0からnまでのランダムな整数値を出力する
  */
})();
