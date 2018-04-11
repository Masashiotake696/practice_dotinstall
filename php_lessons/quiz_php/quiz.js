$(function() {
  'use strict';

  $('.answer').on('click', function() {
    var $selected = $(this); // jQueryのオブジェクトの場合は変数名に$マークをつける
    if($selected.hasClass('correct') || $selected.hasClass('wrong')) {
      return;
    }
    $selected.addClass('selected'); // 選択された回答を太字にする
    var answer = $selected.text();

    $.post('_answer.php', {
      answer: answer,
      token: $('#token').val()
    }).done(function(res) {
      $('.answer').each(function() { // $('セレクタ').each(function(index, element) { ~ }); $(this)で要素を取得できる
        if($(this).text() === res.correct_answer) {
          $(this).addClass('correct');
        } else {
          $(this).addClass('wrong');
        }
      });
      if(answer === res.correct_answer) {
        // correct!
        $selected.text(answer + ' ... CORRECT!');
      } else {
        // wrong!
        $selected.text(answer + ' ... WRONG!');
      }
      $('#btn').removeClass('disabled');
    });
  });

  $('#btn').click(function() {
    if(!$(this).hasClass('disabled')) {
      location.reload();
    }
  })
});
