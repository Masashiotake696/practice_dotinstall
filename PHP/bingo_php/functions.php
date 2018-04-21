<?php
// アプリの便利関数をまとめるファイル

function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
