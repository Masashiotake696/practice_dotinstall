<?php

namespace MyApp\Exception;

/* 英数字以外の文字列がパスワードに含まれていた場合のエラークラス */
class EmptyPost extends \Exception {
  protected $message = 'Please enter email/password!';
}
