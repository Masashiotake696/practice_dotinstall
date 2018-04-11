<?php

namespace MyApp;

class ImageUploader {
  private $_imageFileName;
  private $_imageType;

  public function upload() {
    try {
      // 画像のエラーチェック
      $this->_validateUpload();

      // 画像タイプのチェック
      $ext = $this->_validateImageType();

      // 画像の保存
      $savePath = $this->_save($ext);

      // 必要に応じてサムネイルの作成
      $this->_createThumbnail($savePath);

      $_SESSION['success'] = 'Upload Done!';
    } catch(\Exception $e) {
      $_SESSION['error'] = $e->getMessage();
    }
    // リダイレクト(上記の処理が終わった後に再読み込みがされないようにするため)
    header('Location: http://' . $_SERVER['HTTP_HOST']);
    exit;
  }

  public function getResults() {
    $success = null;
    $error = null;
    if(isset($_SESSION['success'])) {
      $success = $_SESSION['success'];
      unset($_SESSION['success']); // unset() ... 指定した変数の割り当てを解除する
    }
    if(isset($_SESSION['error'])) {
      $error = $_SESSION['error'];
      unset($_SESSION['error']); // unset() ... 指定した変数の割り当てを解除する
    }
    return [$success, $error];
  }

  public function getImages() {
    $images = [];
    $files = [];
    $imageDir = opendir(IMAGES_DIR); // opendir() ... ディレクトリハンドルをオープンする。引数にオープンするディレクトリのパスを指定する。返り値は、成功した場合にディレクトリハンドルのリソース、失敗した場合にfalseとなる。
    while(false !== ($file = readdir($imageDir))) { // readdir() ... ディレクトリハンドルからエントリ(個々のデータ)を読み込む。返り値は成功した場合にエントリ名、失敗した場合にfalseとなる。
      if($file === '.' || $file === '..') { // カレントディレクトリを表す「.」、親ディレクトリを示す「..」の場合はループを次に回す
        continue;
      }
      $files[] = $file; // ディレクトリ名を排除したファイル名の配列
      if(file_exists(THUMBNAIL_DIR . '/' . $file)) {
        $images[] = basename(THUMBNAIL_DIR) . '/' . $file;
      } else {
        $images[] = basename(IMAGE_DIR) . '/' . $file;
      }
    }
    array_multisort($files, SORT_DESC, $images); // array_multisort() ... 複数または多次元の配列をソートする。第一引数にソートする配列の要素の順番、第二引数ソート方法(SORT_ASCはアイテムを昇順にソート、SORT_DESCはアイテムを降順にソート)、第三引数にソートしたい配列を指定する。
    return $images;
  }

  # アップロードされた画像のエラーチェック
  private function _validateUpload() {
    /*
      ■確認項目
        ・そもそも$_FILESに値が入っているか
        ・改ざんされたフォームからデータが飛んできていないか
      ※投稿されたファイルの情報は定義済みの$_FILESに入っている
    */
    if (!isset($_FILES['image']) || !isset($_FILES['image']['error'])) {
      throw new \Exception('Upload Error!');
    }

    switch($_FILES['image']['error']) {
      case UPLOAD_ERR_OK: // 処理がうまくった場合
        return true;
      case UPLOAD_ERR_INI_SIZE: // PHPの設定ファイルで設定されたファイルサイズを超えている場合
      case UPLOAD_ERR_FORM_SIZE: // フォームで指定されたサイズを超えている場合
        throw new \Exception('File too large!');
      default:
        throw new \Exception('Err: ' . $_FILES['image']['error']);
    }
  }

  # 画像タイプのチェック
  private function _validateImageType() {
    // exif_imagetype() ... イメージの型を定義する。引数には調べる画像を指定する。
    $this->_imageType = exif_imagetype($_FILES['image']['tmp_name']); // tmpフォルダ(一時ファイル保存空間)にアップロードしたファイルをとりあえずPHPの方でコピーしてくれる
    switch($this->_imageType) {
      case IMAGETYPE_GIF:
        return 'gif'; // returnしているのでbreakは不要
      case IMAGETYPE_JPEG:
        return 'jpg';
      case IMAGETYPE_PNG:
        return 'png';
      default:
        throw new \Exception('PNG/JPEG/GIF only!');
    }
  }

  private function _save($ext) {
    $this->_imageFileName = sprintf(
      '%s_%s.%s',
      time(), // time() ... 現在のUnixタイムスタンプを返す。
      /*
        ■sha1()
          文字列のsha1ハッシュ(入力されたデータに対して特定のルールに沿った長さ160ビットの値)を計算する
          ▼使用方法
            sha1($str, $raw_output = false)
              $str ... 入力文字列
              $raw_output ... オプションのraw_outputにTRUEが指定された場合、sha1ダイジェストは20バイト長のバイナリ形式で返される。それ以外の場合は、返り値は40文字の16進数となる。
        ■uniqid()
          マイクロ秒単位の現在時刻に基づいた接頭辞つきの一意なIDを取得する。
          ▼使用方法
            uniqid($prefix, $more_entropy = false)
              prefix ... これが有用なのは例えば複数のホストで同時にIDを生成するような場合。このような場合、同じマイクロ秒で同じIDが生成されてしまう可能性がある。空のprefixを指定すると、返される文字列は13文字となる。more_entropyがTRUEの場合は23文字となる。
            more_entropy ... TRUEにするとuniqid()は返り値の最後にさらに別のエントロピー(乱雑さ)を追加する。これにより、結果が一位になる可能性を高める。
        ■mt_rand()
          mt_rand() ... メルセンヌ・ツイスター乱数生成器を介して乱数値を生成する。
          ▼使用方法
            mt_rand(void)
            mt_rand($min, $max)
              $min ... オプションで指定する、返される値の最小値(デフォルトは0)
              $max ... オプションで指定する、返される値の最大値(デフォルトはmt_getrandmax())
      */
      sha1(uniqid(mt_rand(), true)),
      $ext
    );
    $savePath = IMAGES_DIR . '/' . $this->_imageFileName;
    $res = move_uploaded_file($_FILES['image']['tmp_name'], $savePath); // move_uploaded_file ... アップロードされたファイルを新しい位置に移動する。第一引数にアップロードしたファイルのファイル名、第二引数にファイルの移動先を指定する。
    if($res === false) {
      throw new \Exception('Could not upload!');
    }
    return $savePath;
  }

  private function _createThumbnail($savePath) {
    /*
      ■getimagesize()
        画像の大きさを取得する。
        ▼使用方法
          getimagesize($filename, $imageinfo);
            $filename ... 情報を取得したいファイルの名前を指定する。ローカルファイルへの参照、あるいはストリームを用いたリモートファイルへの参照を指定できる
            $imageinfo ... オプションのパラメータで、画像ファイルから何らかの拡張子を引き出すことが可能。この変数にはJPGファイルについて異なった複数のAPPマーカーが連想配列として返される。いくつかのプログラムは、これらのAPPマーカー(JPEGファイルはマーカーによって各情報を区切り、そこに画像情報や圧縮データを保存する。APPというマーカーがアプリケーションセグメントとしてアプリケーション利用のために予約されている。)を画像の中の埋め込みテキストの情報として使用する。
        ▼返り値
          最大7つの要素からなる配列。
          0番目は画像の幅(width)、1番目は画像の高さ(height)
          2番目は画像の形式
          3番目はIMGタグで直接利用できる文字列 height="yyy" width="xxx"
    */
    $imageSize = getimagesize($savePath);
    $width = $imageSize[0];
    $height = $imageSize[1];
    if($width > THUMBNAIL_WIDTH) {
      $this->_createThumbnailMain($savePath, $width, $height);
    }
  }

  private function _createThumbnailMain($savePath, $width, $height) {
    # サムネイルを作るには元画像の画像リソースを作り、それを元にサムネイルを作り保存する
    switch($this->_imageType) {
      case IMAGETYPE_GIF:
        $srcImage = imagecreatefromgif($savePath); // imagecreatefromgif() ... 新しい画像をファイルあるいはURLから作成する。返り値は指定したファイル名の画像を表す画像ID
        break;
      case IMAGETYPE_JPEG:
        $srcImage = imagecreatefromjpeg($savePath); // imagecreatefromjpeg() ... 新しい画像をファイルあるいはURLから作成する。返り値は指定したファイル名の画像を表す画像ID
        break;
      case IMAGETYPE_PNG:
        $srcImage = imagecreatefrompng($savePath); // imagecreatefrompng() ... 新しい画像をファイルあるいはURLから作成する。返り値は指定したファイル名の画像を表す画像ID
        break;
    }
    $thumHeight = round($height * THUMBNAIL_WIDTH / $width);
    $thumImage = imagecreatetruecolor(THUMBNAIL_WIDTH, $thumHeight); // imagecreatetruecolor() ... TrueColor(コンピュータが扱う色情報の種類・範囲やその表現方法の一つで、24ビットまたは32ビットの値で色を識別する方式)イメージを新規に作成する。第一引数に画像の幅(width)、第二引数に画像の高さ(height)を指定する。返り値は成功した場合に画像リソースのID、エラー時にfalse
    imagecopyresampled($thumImage, $srcImage, 0, 0, 0, 0, THUMBNAIL_WIDTH, $thumHeight, $width, $height); // imagecopyresampled() ... 再サンプリングを行いイメージの一部をコピー、伸縮する。第一引数にコピー先の画像リンクリソース、第二引数にコピー元の画像リンクリソース、第三引数にコピー先のx座標、第四引数にコピー先のy座標、第五引数にコピー元のx座標、第六引数にコピー元のy座標、第七引数にコピー先の幅、第八引数にコピー先の高さ、第九引数にコピー元の幅、第十引数にコピー元の高さを指定する。
    switch($this->_imageType) {
      case IMAGETYPE_GIF:
        imagegif($thumImage, THUMBNAIL_DIR . '/' . $this->_imageFileName); // imagegif() ... 画像をブラウザあるいはファイルに出力する。第一引数に画像リソース、第二引数にファイル保存先のパスあるいはオープン中のリソースを指定する。
        break;
      case IMAGETYPE_JPEG:
        imagejpeg($thumImage, THUMBNAIL_DIR . '/' . $this->_imageFileName); // imagejpeg() ... 画像をブラウザあるいはファイルに出力する。第一引数に画像リソース、第二引数にファイル保存先のパスあるいはオープン中のリソースを指定する。
        break;
      case IMAGETYPE_PNG:
        imagepng($thumImage, THUMBNAIL_DIR . '/' . $this->_imageFileName); // imagepng() ... 画像をブラウザあるいはファイルに出力する。第一引数に画像リソース、第二引数にファイル保存先のパスあるいはオープン中のリソースを指定する。
        break;
    }
  }
}
