<?php

namespace App\Models;

use App\Models\Admin\User as Admin;
use App\Models\Usuario\User;

class Validation {

    public static function validarLoad() {

        try {
            require load();
        } 
        
        catch(\Exception $e) {
            echo "<p> {$e->getMessage()} </p>";
        }

    }

    public static function validFields($name, $hour, $payment): User {

        if(empty($dices)) {
            message("Preencha todos os campos");
            exit();
        }

        return new User($name, $hour, $payment);
    }
    
}