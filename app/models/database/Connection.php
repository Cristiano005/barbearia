<?php

namespace app\models\database;

use PDO;
use PDOException;

class Connection {

    public static function connection() {

        try {
            return new PDO("mysql:host=127.0.0.1; dbname=barber_shop; charset=utf8", "root", "erisvaldo123");
        }

        catch(PDOException $e) {
            echo "Erro: {$e->getMessage()}";
        }


    }

}