<?php

namespace MyApp\Exception;

/* 英数字以外の文字列がパスワードに含まれていた場合のエラークラス */
class InvalidPassword extends \Exception {
  protected $message = 'Invalid Password!';
}
