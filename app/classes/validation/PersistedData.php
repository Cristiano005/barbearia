<?php

namespace app\classes\validation;

class PersistedData {

    public static function get(string $field): string {

        if(isset($_SESSION['persisted'][$field])) {

            $value = $_SESSION['persisted'][$field];
            unset($_SESSION['persisted'][$field]);

            return $value;
        }

    }

    public static function set(string $field, $value): void {

        if(!isset($_SESSION['persisted'][$field])) {
            $_SESSION['persisted'][$field] = $value;
        }

    }

}