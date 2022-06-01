<?php

namespace app\models;

use PDO;
use PDOException;

class Select extends Model {

    // public function findBy(string $table, string $field = "*", string $value) {

    //    try {

    //         $findBy = $this->connection->prepare("SELECT {$field} FROM {$table} WHERE {$field} = :{$field}");
    //         $findBy->bindValue(":{$field}", $value);

    //         return $findBy->execute();
    //    }

    //    catch(PDOException $e) {
    //         echo "<span> {$e->getMessage()} </span>";
    //    }
 
    // } por enquanto ficará assim.

    public function findAll(string $table, string $fields = '*') {

        try {

            $findAll = $this->connection->query("SELECT {$fields} FROM {$table}");
            $findAll->execute();

            return $findAll->fetchAll(PDO::FETCH_ASSOC);
        }

        catch(PDOException $e) {
            echo "<span> {$e->getMessage()} </span>";
        }

    }

}