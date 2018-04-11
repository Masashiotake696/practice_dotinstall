<?php

  require_once 'Calendar.php';

  // 出力をエスケープするための関数
  function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
  }

  $cal = new \MyApp\Calendar();
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>Calendar</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <table>
      <thead>
        <tr>
          <th><a href="/?t=<?= h($cal->prev); ?>">&laquo;</a></th>
          <th colspan="5"><?= h($cal->yearMonth); ?></th>
          <th><a href="/?t=<?= h($cal->next); ?>">&raquo;</a></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Sun</td>
          <td>Mon</td>
          <td>Tue</td>
          <td>Wed</td>
          <td>Thu</td>
          <td>Fri</td>
          <td>Sat</td>
        </tr>
        <?php $cal->show(); ?>
      </tbody>
      <tfoot>
        <tr>
          <th colspan="7"><a href="/">Today</a></th>
        </tr>
      </tfoot>
    </table>
  </body>
</html>
