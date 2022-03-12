<?php

namespace App\Models;

class Validation {

    public static function validarLoad() {

        try {
           
            require load();

        } catch(\Exception $e) {
            "<p> {$e->getMessage()} </p>";
            "<a href='home.php'> Voltar para página inicial </a>";
        }

    }

}