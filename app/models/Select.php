<?php

namespace app\models;

use PDO;
use PDOException;

class Select extends Model {

    public function findBy(string $table, string $fields = "*", string $field, string $value): array {

       try {

            $findBy = $this->connection->prepare("SELECT {$fields} FROM {$table} WHERE {$field} = :{$field}");
            $findBy->bindValue(":{$field}", $value);
            $findBy->execute();

            return $findBy->fetchAll(PDO::FETCH_OBJ);
       }

       catch(PDOException $e) {
            echo "<span> {$e->getMessage()} </span>";
       }
 
    } 

    public function findAll(string $table, string $fields = '*') {

        try {

            $findAll = $this->connection->query("SELECT {$fields} FROM {$table}");
            $findAll->execute();

            return $findAll->fetchAll(PDO::FETCH_OBJ);
        }

        catch(PDOException $e) {
            echo "<span> {$e->getMessage()} </span>";
        }

    }

    public function findLimit(string $table, int $offset, string $fields = '*', int $limit = 5) {

        try {

            $findLimit = $this->connection->prepare("SELECT {$fields} FROM {$table} LIMIT $offset, $limit");
            $findLimit->execute();
         
            return $findLimit->fetchAll(PDO::FETCH_OBJ);
        }

        catch(PDOException $e) {
            echo "<span> {$e->getMessage()} </span>";
        }
      
    }

}