<?php

ini_set('display_errors', 1);

session_start(); // セッションを用いることでCookieが発行されてリロードしても$_SESSIONの値が保持される

require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/autoload.php');
