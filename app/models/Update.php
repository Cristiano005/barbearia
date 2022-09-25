<?php

namespace app\models;

use app\models\Model;
use Throwable;

class Update extends Model {

    public function updateWithWhere(string $table, string $field, string $value, array $condition = ['id', '=', '1']) {

        try {
        
            $query = "UPDATE {$table} SET {$field} = :{$field} WHERE {$condition[0]} {$condition[1]} {$condition[2]}";

            $update = $this->connection->prepare($query);
            $update->bindValue(":{$field}", $value);

            return $update->execute();
        } 
        
        catch (Throwable $th) {
            echo "<span> Error: {$th->getMessage()} </span>";
        }

    }

}