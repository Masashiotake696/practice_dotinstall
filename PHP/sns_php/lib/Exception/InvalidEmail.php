<?php

namespace MyApp\Exception;

/* emailで入力された値がemail形式に反していた場合のエラークラス */
class InvalidEmail extends \Exception {
  protected $message = 'Invalid Email!';
}
