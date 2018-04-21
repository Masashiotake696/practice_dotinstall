<?php

  require_once(__DIR__ . '/config.php'); // __DIR__ ... 現在のディレクトリ
  require_once(__DIR__ . '/Bingo.php'); // ビンゴに関するクラス
  /*
  $nums[][]
  B: $name[0] 1-15
  I: $name[1] 16-30
  N: $name[2] 31-45
  G: $name[3] 46-60
  O: $name[4] 61-75

  $nums[$i]: $i*15+1 〜 $i*15+15
  */

  // $nums = [];
  // for($i = 0; $i < 5; $i++) {
  //   $col = range($i * 15 + 1,$i * 15 + 15); // range() ... ある範囲の整数を有する配列を作成する。range(最初の値, 最後の値);
  //   shuffle($col); // shuffle() ... 配列をシャッフルする
  //   $nums[$i] = array_slice($col, 0, 5); // array_slice(配列, 開始位置, 取得数) ... 第一引数の配列に対して開始位置から取得数分の配列を取得する
  // }
  // $nums[2][2] = "FREE";
  // var_dump($nums);
  // exit; // 現在のスクリプトを終了する

  # オブジェクト指向で組み替える
  $bingo = new \Myapp\Bingo(); // 名前空間をMyappにする
  $nums = $bingo->create();

  # 便利関数はfunctions.phpにまとめる
  // function h($s) {
  //   return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
  // }
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>BINGO!</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <div id="container">
      <table>
        <tr>
          <th>B</th><th>I</th><th>N</th><th>G</th><th>O</th>
        </tr>
        <?php for($i = 0; $i < 5; $i++) : ?>
        <tr>
          <?php for($j = 0; $j < 5; $j++) : ?>
          <td><?= h($nums[$j][$i]); ?></td>
          <?php endfor; ?>
        </tr>
        <?php endfor; ?>
    </div>
  </body>
</html>
