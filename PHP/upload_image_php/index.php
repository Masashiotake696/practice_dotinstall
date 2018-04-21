<?php

  session_start(); // session_start() ... 新しいセッションを開始、あるいは既存のセッションを再開する。session_start()がコールされたりセッションが自動的に開始したりするときに、PHPはセッションのopenハンドラおよびreadハンドラをコールする。readコールバックは既存のセッションデータ(独自のシリアライズフォーマット(ソフトウェア内部で扱っているデータを丸ごとファイルで保存したりネットワークで送受信できる用に変換されたフォーマット)で保存されているもの)を読み込み、それを復元して自動的にスーパーグローバル$_SESSIONに格納する。返り値はセッションが正常に開始した場合にtrue、それ以外の場合にfalseとなる。

  ini_set('display_errors', 1); // HTMLにエラーを表示する
  define('MAX_FILE_SIZE', 1 * 1024 * 1024); // 1MB
  define('THUMBNAIL_WIDTH', 400);
  define('IMAGES_DIR', __DIR__ . '/images');
  define('THUMBNAIL_DIR', __DIR__ . '/thumbs');

  # 画像処理の際に必要なGDプラグインがあるか確認
  if(!function_exists('imagecreatetruecolor')) { // imagecreatetruecolor関数があるかどうか調べることでGDがインストールされているか確かめる
    echo 'GD not instaled';
    exit;
  }

  function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
  }

  require_once 'ImageUploader.php';

  $uploader = new \MyApp\ImageUploader();
  if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploader->upload();
  }
  list($success, $error) = $uploader->getResults(); // list() ... 配列と同様の形式で、複数の変数への代入を行う。
  $images = $uploader->getImages();
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>Image Uploader</title>
    <style>
      body {
        text-align: center;
        font-family: Arial, sans-serif;
      }
      ul {
        list-style: none;
        margin: 0;
        padding: 0;
      }
      li {
        margin-bottom: 5px;
      }
      input[type="file"] {
        /* 親要素の左上を基準点として幅と高さをいっぱいにする(実際の位置はopacity を0にしているので見えない)。幅と高さをいっぱいにすることでボタンをクリックすることでファイル選択ができるようになる */
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
        opacity: 0;
      }
      .btn {
        position: relative;
        display: inline-block;
        width: 300px;
        padding: 7px;
        border-radius: 5px;
        margin: 10px auto 20px;
        color: #fff;
        box-shadow: 0 4px #0088cc;
        background-color: #00aaff;
      }
      .btn:hover {
        opacity: 0.8;
      }
      .msg {
        margin: 0 auto 15px;
        width: 400px;
        font-weight: bold;
      }
      .msg.success { /* msgクラスかつsuccessクラス */
        color: #4caf50;
      }
      .msg.error { /* msgクラスかつerrorクラス */
        color: #f44336;
      }
    </style>
  </head>
  <body>
    <!--
      enctypeはエンコード(符号化)タイプを指定する。multipart/form-dataはMIME Type(データの種類を指定するための形式)の一つ。multipartとは複合データ型であることを表す。つまり、1回のHTTP通信で複数の種類のデータ(テキストやファイルなど)を一度に扱うことができる。
      enctypeでmultipart/form-dataを指定すると、添付ファイルに関する情報とともにファイルの本文の情報がHTTPリクエストパラメータに含まれる。逆にenctypeを指定しないと、ファイル名の情報のみがHTTPリクエストパラメータに含まれるため、添付ファイルの情報は含まれない。
    -->
    <div class="btn">
      Upload!
      <form action="" method="post" enctype="multipart/form-data" id="my_form">
         <!-- ファイルの最大サイズを指定するための隠し項目を入れる。これは必ず「input type="file"」の前に入れるようにする。 -->
        <input type="hidden" name="MAX_FILE_SIZE" value="<?= h(MAX_FILE_SIZE); ?>">
        <input type="file" name="image" id="my_file">
      </form>
    </div>
    <?php if (isset($success)) : ?>
      <div class="msg success">
        <?= h($success); ?>
      </div>
    <?php endif; ?>
    <?php if (isset($error)) : ?>
      <div class="msg error">
        <?= h($error); ?>
      </div>
    <?php endif; ?>
    <ul>
      <?php foreach ($images as $image) : ?>
        <li>
          <a href="<?= h(basename(IMAGES_DIR)) . '/' . h(basename($image)); ?>"> <!-- basename() ... ファイルあるいはディレクトリへのパスを含む文字列を受け取って、パスの最後にある名前の部分を返す。 -->
            <img src="<?= h($image); ?>">
          </a>
        </li>
      <?php endforeach ?>
    </ul>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
      $(function() {
        $('.msg').fadeOut(3000); // msgをフェードアウトする
        $('#my_file').on('change', function() { // ファイルが選択されたら自動的に送信する。読み込まれた時に存在しない要素に対してイベントを作るにはonを使う
          $('#my_form').submit();
        });
      });
    </script>
  </body>
</html>
