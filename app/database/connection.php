<?php

namespace App\Database;

use PDO;
use PDOException;

class Connection {

    public static function connection() {

        try {
            return new PDO("mysql:host=127.0.0.1; dbname=barbearia; charset=utf8", "root", "");
        } 
        
        catch(PDOException $e) {
            echo "Erro: {$e->getMessage()}";
        }
    
    }
}
   