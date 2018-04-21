<?php

namespace MyApp\Exception;

/* 英数字以外の文字列がパスワードに含まれていた場合のエラークラス */
class UnmatchEmailOrPassword extends \Exception {
  protected $message = 'Email/Password do not match!';
}
