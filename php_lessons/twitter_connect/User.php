<?php

namespace MyApp;

class User {
  private $_db;

  public function __construct() {
    $this->_connectDB();
  }

  private function _connectDB() {
    try {
      $this->_db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
      $this->_db->setAttribute(\PDO::ATTR_ERROMODE, \PDO::ERRMODE_EXCEPTION);
    } catch(\Exception $e) {
      throw new \Exception('Faild to connect DB');
    }
  }

  public function getUser($twUserid) {

  }

  public function saveToken($tokens) {
    if($this->_exists())
  }
}
