<?php

namespace app\models;

use PDOException;

class Delete extends Model {

    public function delete(string $table, string $where, string $value) {

        try {

            $delete = $this->connection->prepare("DELETE FROM {$table} WHERE {$where} = :{$where}");
            $delete->bindValue(":{$where}", $value);

            return $delete->execute();
        }

        catch(PDOException $e) {
            echo "<span> {$e->getMessage()} </span>";
        }

    }

}