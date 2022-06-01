<?php

namespace app\models;

use app\models\database\Connection;

abstract class Model {

    protected $connection;

    public function __construct() {
        $this->connection = Connection::connection();
    }
  
}