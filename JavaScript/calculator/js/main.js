(function() {
  'use strict';

  var price = document.getElementById('price');
  var num = document.getElementById('num');
  var unit = document.getElementById('unit');
  var btn = document.getElementById('btn');
  var result = document.getElementById('result');
  var reset = document.getElementById('reset');

  function checkInput() {
    // 正規表現を使って1桁目には1~9のどれか、2桁目以降には0~9のどれかが来るようにパターンチェックする。^[1-9][0-9]*$。マッチしなかったらnullを返す
    if (
      price.value.match(/^[1-9][0-9]*$/) !== null &&
      num.value.match(/^[1-9][0-9]*$/)
    ) {
      btn.classList.remove('disabled'); // 正規表現にマッチしたらdisabledを外す
    } else {
      btn.classList.add('disabled'); // 正規表現にマッチしなかったらdisabledをつける
    }
  }

  btn.addEventListener('click', function() {
    var payLess, short, payMore, over;
    var str;
    if (this.classList.contains('disabled') === true) {
      return;
    }
    /* 1000円を3人で割り勘する場合 */
    // 場合A. 300/人 (payLess) ... 100円不足 (short)
    // 場合B. 400/人 (payMore) ... 200円余り (over)
    // payLess = 1000 / 3; // 333.3333....
    // payLess = 1000 / 3 / 100; // 3.3333... 100円の位で切り捨てをするために100で割って小数点を100の位まで持ってくる
    payLess = Math.floor(price.value / num.value / unit.value) * unit.value // 300 小数点以下を切り捨てて、割り勘の単位である100をかける
    short = price.value - (payLess * num.value); // 100(不足)
    payMore = Math.ceil(price.value / num.value / unit.value) * unit.value // 400 小数点以下を切り上げて、割り勘の単位である100をかける
    over = Math.abs(price.value - (payMore * num.value)); // 200(余り)
    /* 割り切れた場合 */
    if (over === 0 && short === 0) {
      str = '一人' + (price.value / num.value) + '円ちょうどです！';
    } else {
      str =
        '一人' + payLess + '円だと' + short + '円足りません。' +
        '一人' + payMore + '円だと' + over + '円余ります。'
    }
    result.textContent = str;
    reset.classList.remove('hidden');
  });

  price.addEventListener('keyup', checkInput);
  num.addEventListener('keyup', checkInput);

  reset.addEventListener('click', function() {
    result.textContent = 'ここに結果を表示します';
    price.value = '';
    num.value = '';
    unit.value = 100;
    btn.classList.add('disabled');
    this.classList.add('hidden');
    price.focus();
  });

  price.focus();
})();
