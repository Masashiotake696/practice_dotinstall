$(function() {
  'use strict';

  ('.answer').on('click', function() {
    var $selected = $(this); // jQueryのオブジェクトの場合は変数名に$マークをつける
    var answer = $selected.text();

    $.post('/_answer.php', {

    })
  })
});
