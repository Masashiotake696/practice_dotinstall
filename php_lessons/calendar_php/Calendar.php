<?php

  namespace MyApp; // 名前空間を使った場合は、PHPに標準に用意されているException()やDateTime()のようなクラスに関しては、1番上位の名前空間から呼び出さないといけない。そのため、これらのクラスの前に名前空間の区切り文字である\を入れるようにする。

  class Calendar {
    public $prev;
    public $next;
    public $yearMonth;
    private $_thisMonth;

    public function __construct() {
      // URLパラメータからDateTimeオブジェクトを作る時のエラー処理
      try {
        // isset() ... 変数がセットされていること、そしてNULL出ないことを検査する
        // preg_match ... 正規表現によるマッチングを行う。正規表現では完全一致に関しては「\A\z」で囲むことが推奨されている(\Aは文字列の先頭, \zは文字列の末尾)。
        if(!isset($_GET['t']) || preg_match('/\A\d(4)-\d(2)\z/', $_GET['t'])) {
          throw new \Exception();
        }
        $this->_thisMonth = new \DateTime($_GET['t']);
      } catch (\Exception $e) {
        $this->_thisMonth = new \DateTime('first day of this month');
      }
      $this->prev = $this->_createPrevLink();
      $this->next = $this->_createNextLink();
      $this->yearMonth = $this->_thisMonth->format('F Y');
    }

    private function _createPrevLink() {
      $dt = clone $this->_thisMonth; // $thisMonthに対して直接modify()メソッドを呼ぶと$thisMonthの値が変わってしまうので、一旦$thisMonthのコピーオブジェクトを作成する。この時、オブジェクトは参照型なので、代入先でプロパティを変更した時に代入元と共通のものを操作してしまう。これを回避するためcloneメソッドを使って中身のデータだけを渡すようにする。
      return $dt->modify('-1 month')->format('Y-m');
    }

    private function _createNextLink() {
      $dt = clone $this->_thisMonth;
      return $dt->modify('+1 month')->format('Y-m');
    }

    public function show() {
      $tail = $this->_getTail();
      $body = $this->_getBody();
      $head = $this->_getHead();
      $html = '<tr>' . $tail . $body . $head . '</tr>';
      echo $html;
    }

    private function _getTail() {
      $tail = '';
      $lastDayOfPrevMonth = new \DateTime('last day of' . $this->yearMonth . '-1 month');
      while($lastDayOfPrevMonth->format('w') < 6) {
        $tail = sprintf('<td class=gray>%d</td>', $lastDayOfPrevMonth->format('d')) . $tail;
        $lastDayOfPrevMonth->sub(new \DateInterval('P1D')); // DateTime::sub() ... 年月日時分秒の値をDateTimeオブジェクトから引く。引数にはDateIntervalオブジェクトを指定する。
      }
      return $tail;
    }

    private function _getBody() {
      $body = '';
      /*
        ■DatePeriod
          特定の期間の日付オブジェクトを作るためのクラス。
          ▼使用方法
            ①DatePeriod($start, $interval, $recurrences, $options)
            ②DatePeriod($start, $interval, $end, $options)
            ③DatePeriod($isostr, $options)
              $start .. 期間の開始日の指定
              $interval ... 期間内での発生間隔の指定
              $recurrences ... 反復回数の指定
              $end ... 期間の終了日の指定。終わりは含まない。
              $isostr ... ISO 8601(日付と時刻の表記に関する国際規格)による繰り返しの間隔の指定
              $options ... DatePeriod::EXCLUDE_START_DATEを指定すれば、開始日を期間内の発生日から除外できる。
      */
      $period = new \DatePeriod( // 一ヶ月の曜日と時刻を取得
        /*
          ■DateTime
            日付と時刻を表す。
            ▼使用方法
              new DateTime();
              上記で現在時刻を作成する。
              引数には柔軟にいろんな文字列で日時を指定することができる。
          ■DateInterval
            新しいDateIntervalオブジェクトを作成する。
            ▼使用方法
              new DateInterval($interval_spec);
                ♦︎$interval_spec ... 間隔を指定する。最初はPから始まる。これはPeriodを表す。間隔の単位は整数値の後に間隔指示子をつけて表す。時間の要素を含む場合は時間部分の前に文字Tを入れる。
                ♦︎間隔指示子
                  Y ... 年
                  M ... 月
                  D ... 日
                  W ... 週。日付に変換されるのでDと組み合わせて使うことはできない。
                  H ... 時間
                  M ... 分
                  S ... 秒
        */
        new \DateTime('first day of' . $this->yearMonth),
        new \DateInterval('P1D'),
        new \DateTime('first day of' . $this->yearMonth . '+1 month') // first day of next monthとすると1日からこれを含まない、つまり末日までという形になる。
      );
      $today = new \DateTime('today');
      foreach ($period as $day) {
        /*
          ■format()
            DateTimeオブジェクトを好きな書式で表示する。
            ▼いくつかのformatの種類(参考: http://jp2.php.net/manual/ja/function.date.php )
              ♦︎d
                日。2桁の数字(一桁の場合は先頭にゼロがつく)
                例) 01 から 31
              ♦︎w
                曜日。数値。
                例) 0(日曜) から 6(土曜)
              ♦︎F
                月。フルスペルの文字。
                例) January から December
              ♦︎Y
                年。4桁の数字。
              ♦︎m
                月。数字。先頭にゼロをつける。
                例) 01 から 12
              ♦︎D
                曜日。3文字のテキスト形式。
                例) Mon から Sun
              ♦︎j
                日。先頭にゼロをつけない。
                例) 1 から 31
              ♦︎l
                曜日。フルスペル形式。
                例) Sunday から Saturday
              ♦︎N
                ISO-8601形式の曜日の数値表現。
                例) 1(月曜日) から 7(日曜日)
        */
        if($day->format('w') === '0') {
          $body .= '</tr><tr>';
        }
        $todayClass = ($day->format('Y-m-d') === $today->format('Y-m-d')) ? 'today' : '';
        $body .= sprintf('<td class="youbi_%d %s">%d</td>', $day->format('w'), $todayClass, $day->format('d'));
      }
      return $body;
    }

    private function _getHead() {
      $head = '';
      $firstDayOfNextMonth = new \DateTime('first day of' . $this->yearMonth . '+1 month');
      while($firstDayOfNextMonth->format('w') > 0) {
        $head .= sprintf('<td class="gray">%d</td>', $firstDayOfNextMonth->format('d'));
        $firstDayOfNextMonth->add(new \DateInterval('P1D')); // DateTime::add() ... 年月日時分秒の値をDateTimeオブジェクトに加える。引数にはDateIntervalオブジェクトを指定する。
    }
    return $head;
  }
}
