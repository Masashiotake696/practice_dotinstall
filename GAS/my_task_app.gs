// 回答内容をメールで通知する
function sendTask(e) {
  Logger.log(e);
  MailApp.sendEmail('m_otake@innovation.co.jp', 'タスクが追加されました', e.namedValues['Task']);
}

// プロジェクトをWebで公開する
// GASではスクリプトがGETでアクセスされた時の処理をdoGet()で書くことができる
function doGet() {
  var template = HtmlService.createTemplateFromFile('index');

  template.title = 'MyTaskApp';
  template.tasks = getTasks();

  return template.evaluate();
  // return HtmlService.createHtmlOutput('<h1>MyTask</h1>');
}

// タスクを取得する
function getTasks() {
  var sheet = SpreadsheetApp.getActiveSheet();

  return sheet.getRange(2, 2, sheet.getLastRow() - 1, 1).getValues();
}

// 登録したタスクの一覧が毎朝メールで届くようにする
function sendReport() {
  var to = 'm_otake@innovation.co.jp';
  var subject = 'タスク一覧';
  var url = 'https://script.google.com/a/innovation.co.jp/macros/s/AKfycbyg3wn_Ahty6Ng9yI6jKTvDn-8Id10TvnsJzHp5y7mBdr8OW0Ck/exec';
  var body = getTasks().join('\n') + '\n\n' + url;

  MailApp.sendEmail(to, subject,body);

}
