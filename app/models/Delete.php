<?php

namespace app\models;

use PDOException;

class Delete extends Model {

    public function delete(string $table, string $field, string $value) {

        try {

            $delete = $this->connection->prepare("DELETE FROM {$table} WHERE {$field} = :{$field}");
            $delete->bindValue(":{$field}", $value);

            return $delete->execute();
        }

        catch(PDOException $e) {
            echo "<span> {$e->getMessage()} </span>";
        }

    }

}