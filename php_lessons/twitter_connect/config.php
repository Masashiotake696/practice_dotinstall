<?php

ini_set('display_errors', 1);

require_once(__DIR__ . '/vendor/autoload.php');

define('CONSUMER_KEY', 'X7D9RP5iNSPN3PDFjA6rEnH5w');
define('CONSUMER_SECRET', 'HbjSjzE854MRw1Xozc8x7SKZEr2kmp5AHrIp6Cowf92lklElmy');
define('CALLBACK_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/login.php');

define('DSN', 'mysql:host=localhost,dbname=dotinstall_tw_connect_php');
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', 'testtest');

session_start();

require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/autoload.php');
