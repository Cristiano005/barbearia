<?php

namespace App\Models;

class Validation {

    public static function validarLoad() {

        try {
            require load();
        } catch(\Exception $e) {
            echo "<p> {$e->getMessage()} </p>";
        }

    }

}