$(function() {
  $('.delete').click(function(e) {
    e.preventDefault(); // aタグの規定の動き(リンク先に飛ぶ動き)を抑制する
    if(confirm('Are you sure?')) {
      $('#form_' + this.dataset.id).submit();
    }
  });
});


// (function() {
//   'use strict';
//   var commands = document.getElementsByClassName('delete');
//   for(var i = 0; i < commands.length; i++) {
//     commands[i].addEventListener('click', function(e) {
//       e.preventDefault(); // aタグの規定の動き(リンク先に飛ぶ動き)を抑制する
//       if(confirm('Are you sure?')) {
//         document.getElementById('form_' + this.dataset.id).submit();
//       }
//     });
//   }
// })();
