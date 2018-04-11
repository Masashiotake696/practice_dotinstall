(function() {
  'use strict';

  var start = document.getElementById('start');
  var stop = document.getElementById('stop');
  var result = document.getElementById('result');
  var startTime;
  var isStarted = false;

  start.addEventListener('click', function() {
    /* すでにstartボタンが押されていたら処理をしない */
    if (isStarted === true) {
      return;
    }
    isStarted = true;
    startTime = Date.now(); // これはミリ秒
    /* ボタンが押された時にクラスを適応する */
    this.className = 'pushed';
    stop.className = ''; // stopのpushedクラスを外す
    result.textContent = '0.000'; // 値を初期値に戻す
    result.className = 'standby'; // resultのperfectクラスを外す
  });
  stop.addEventListener('click', function() {
    var elapsedTime;
    var diff;
    /* まだstartボタンが押されていたら処理をしない */
    if (isStarted === false) {
      return;
    }
    isStarted = false;
    elapsedTime = (Date.now() - startTime) / 1000; // ミリ秒を1000で割って秒にする
    result.textContent = elapsedTime.toFixed(3); // toFixed()メソッドは数を固定小数点表記を用いてフォーマットする。toFixed(3)とした場合は小数点3桁まで表示される

    /* stopボタンが押された時にクラスを適応する */
    this.className = 'pushed';
    start.className = ''; // startからpushedクラスを外す

    /* stopボタンが押された時に色を薄くしているクラスを外す */
    result.className = '';

    /* 結果に応じてスタイルを変更する */
    diff = elapsedTime - 5.0;
    // if (diff > -1.0 && diff < 1.0) {
    if (Math.abs(diff) < 1.0) {
      result.className = 'perfect';
    }
  });
})();
