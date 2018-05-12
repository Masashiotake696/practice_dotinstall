// スプレッドシートに名前と点数を表示
function initSheet() {
  // アクティブなシートを取得
  var sheet = SpreadsheetApp.getActiveSheet();
  // 名前配列
  var names = ['masashi', 'yamada', 'taguchi'];
  // 名前と点数の二次元配列
  var scores = [];

  // 開始時間(時間計測用)
  // var startTime = new Date();

  // 確認のためのメッセージボックスを表示
//  if(Browser.msgBox('シートの初期化', 'シートを初期化してもいいですか？', Browser.Buttons.OK_CANCEL) === 'cancel') {
//     return;
//  }

  // シートを綺麗にする
  sheet.clear();

  for(var i = 1; i <= 10; i++) {
    // 名前と点数の配列を格納
    scores.push([
      names[Math.floor(Math.random() * names.length)],
      Math.floor(Math.random() * 101)
    ]);
  }

  // setValuesの引数は二次元配列
  sheet.getRange(1, 1, 10, 2).setValues(scores);

  // 開始時間と終了時間の差分を取得
  // Logger.log(new Date() - startTime);
}



// 点数に応じてPASSかFAILを表示
function showResults() {
  // アクティブなシートを取得
  var sheet = SpreadsheetApp.getActiveSheet();
  // 点数を格納する配列
  var scores = [];
  // 結果を格納する配列
  var results = [];

  // 点数を取得
  // scores = sheet.getRange(1, 2, 10, 1).getValues();
  scores = sheet.getRange(1, 2, sheet.getLastRow(), 1).getValues();

  // 結果が二次元配列になるように値を入れる
  for(var i = 0; i < scores.length; i++) {
    results.push([scores[i] >= 80 ? 'PASS' : 'FAIL']);
  }

  // setValuesの引数は二次元配列
  sheet.getRange(1, 3, results.length, 1).setValues(results);
}



// メニューを追加する
// 関数名をonOpenとすることで、シートが読み込まれた時に自動的に関数が処理される
function onOpen() {
  // アクティブなスプレッドシートを取得
  var spreadsheet = SpreadsheetApp.getActiveSpreadsheet();

  // メニューはオブジェクト形式で、　nameでメニュー名、functionNameで関数名を指定する決まり
  var items = [
    {name: '初期化', functionName: 'initSheet'},
    null,
    {name: '判定', functionName: 'showResults'}
  ];

  spreadsheet.addMenu('スコア管理', items);
}



//function initSheet() {
//  var sheet = SpreadsheetApp.getActiveSheet();
//  var names = ['masashi', 'yamada', 'taguchi'];
//  var scores = [];
//
//  var startTime = new Date();
//
//  sheet.clear();
//
////  2306.0ms
////  getRange()やsetValue()といったシートを読み書きする処理は時間がかかる
////  for(var i = 1; i <= 1000; i++) {
////    sheet.getRange(i, 1).setValue(names[Math.floor(Math.random() * names.length)]);
////    sheet.getRange(i, 2).setValue(Math.floor(Math.random() * 101));
////  }
//
//  // 先に入れるデータを作る
//  for(var i = 1; i <= 1000; i++) {
//    scores.push([
//      names[Math.floor(Math.random() * names.length)],
//      Math.floor(Math.random() * 101)
//    ]);
//  }
//
////  257.0ms
//// 書き込み処理を一度にすることで高速化ができる
//  sheet.getRange(1, 1, 1000, 2).setValues(scores);
//
//  Logger.log(new Date() - startTime);
//}



//function initSheet() {
//  var sheet = SpreadsheetApp.getActiveSheet();
//
//  sheet.clear();
//
//  sheet.getRange(1, 1).setValue('masashi');
//  sheet.getRange(1, 2).setValue(33).setBackground('tomato');
//}



/**
* スコアを判定
* @param array input スコア
* @return 'PASS' or 'FAIL'
*/
//function GETRESULT(input) {
//  if(input.map) {
//    return input.map(GETRESULT);
//  } else {
//    return input >= 80 ? 'PASS' : 'FAIL';
//  }
//}



/**
* スコアを判定
* @param int input スコア
* @return 'PASS' or 'FAIL'
*/
//function GETRESULT(input) {
//  if(input >= 80) {
//    return 'PASS';
//  } else {
//    return 'FAIL';
//  }
//}
