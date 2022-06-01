<?php

namespace app\models;

use PDOException;

class Insert extends Model {

    public function insert(string $table, array $fields) {

        try {
            
            $insert = $this->connection->prepare("INSERT INTO {$table} (name, payment, hourly) VALUES(:name, :payment, :hourly) ");

            foreach($fields as $field => $value) {
                $insert->bindValue(":{$field}", "{$value}");
            }
            
            return $insert->execute();
        }

        catch(PDOException $e) {
            echo "<span> {$e->getMessage()} </span>";
        }

    }

}