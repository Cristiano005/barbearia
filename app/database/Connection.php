<?php

namespace App\Database;

use PDO;
use PDOException;

class Connection {

    public static function connection() {

        try {
            return new PDO("mysql:host={$_ENV['DATABASE_HOST']}; 
                            dbname={$_ENV['DATABASE_NAME']}", 
                            $_ENV['DATABASE_ROOT'], $_ENV['DATABASE_PASSWORD']);
        } 
        
        catch(PDOException $e) {
            echo "Erro: {$e->getMessage()}";
        }
    
    }
}
   