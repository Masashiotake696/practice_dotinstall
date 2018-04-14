<?php

// ユーザーの一覧

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Index();
$app->run();
