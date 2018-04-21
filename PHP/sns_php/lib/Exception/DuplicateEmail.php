<?php

namespace MyApp\Exception;

/* emailが重複している場合のエラークラス */
class DuplicateEmail extends \Exception {
  protected $message = 'Duplicate Email!';
}
