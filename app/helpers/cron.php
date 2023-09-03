<?php

use app\database\Connection;

function deletePastRegisters() {

    try {
        $query = "DELETE FROM  WHERE horario > DATE_ADD(NOW(), INTERVAL 1 HOUR)";
        $delete = Connection::connection()->prepare($query);
        return $delete->execute();
    } 
    
    catch(PDOException $e) {
        echo "<span> {$e->getMessage()} </span>";
    }

}