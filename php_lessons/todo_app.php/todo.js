$(function() {
  'use strict';

  $('#new_todo').focus();

  // update
  $('#todos').on('click', '.update_todo', function() { // 読み込まれた時に存在しない要素に対してイベントを作るにはonを使う。第二引数でセレクタを指定
    // idを取得
    var id = $(this).parents('li').data('id');

    // ajax処理
    /*
      Ajaxでパラメータを渡したい場合は$.post()や$.get()を使う
        $.post() ... データを更新する場合
        $.get() ... データを単に取得する場合
          第一引数 ... サーバー側のファイル名
          第二引数 ... パラメータ
          第三引数 ... コールバック関数(読み込みが終わった後にどういう処理をしたいか)
    */
    $.post('_ajax.php', {
      id: id,
      mode: 'update',
      token: $('#token').val() // tokenの値を取得
    }, function(res) {
      if(res.state === '1') {
        $('#todo_' + id).find('.todo_title').addClass('done'); // find() ... 指定要素が持つ全子要素から、指定条件式に合致するものを取得する
      } else {
        $('#todo_' + id).find('.todo_title').removeClass('done');
      }
    });
  });

  // delete
  $('#todos').on('click', '.delete_todo', function() { // 読み込まれた時に存在しない要素に対してイベントを作るにはonを使う。第二引数でセレクタを指定
    // idを取得
    var id = $(this).parents('li').data('id');

    // ajax処理
    /*
      Ajaxでパラメータを渡したい場合は$.post()や$.get()を使う
        $.post() ... データを更新する場合
        $.get() ... データを単に取得する場合
          第一引数 ... サーバー側のファイル名
          第二引数 ... パラメータ
          第三引数 ... コールバック関数(読み込みが終わった後にどういう処理をしたいか)
    */
    if(confirm('Are you sure?')){
      $.post('_ajax.php', {
        id: id,
        mode: 'delete',
        token: $('#token').val() // tokenの値を取得
      }, function() {
        $('#todo_' + id).fadeOut(800);
      });
    }
  });

  // create
  $('#new_todo_form').on('submit', function() { // 読み込まれた時に存在しない要素に対してイベントを作るにはonを使う。第二引数でセレクタを指定
    // idを取得
    var title = $('#new_todo').val();

    // ajax処理
    /*
      Ajaxでパラメータを渡したい場合は$.post()や$.get()を使う
        $.post() ... データを更新する場合
        $.get() ... データを単に取得する場合
          第一引数 ... サーバー側のファイル名
          第二引数 ... パラメータ
          第三引数 ... コールバック関数(読み込みが終わった後にどういう処理をしたいか)
    */
    $.post('_ajax.php', {
      title: title,
      mode: 'create',
      token: $('#token').val() // tokenの値を取得
    }, function(res) {
      // liを追加
      var $li = $('#todo_template').clone(); // jQueryオブジェクトを作るときは変数名に$をつける
      $li
        .attr('id', 'todo_' + res.id)
        .data('id', res.id)
        .find('.todo_title').text(title); // find() ... 子要素を取得する
      $('#todos').prepend($li.fadeIn());
      $('#new_todo').val('').focus();
    });
    return false; // フォームをsubmitして画面の遷移が行われると困るので、return false;とすることで画面の遷移を防ぐ
  });
});
