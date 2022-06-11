<?php

namespace app\classes\validation;

use app\classes\messages\Message;
use app\core\Method;

class Validate {

    public static function validate(array $fields): array|bool {

        $filteredValues = [];
        $messages = [];

        foreach($fields as $field => $type) {

            switch($type) {

                case "s":

                    if(empty((request()[$field]))) {
    
                        $messages[$field] = "Empty {$field} field";
                    } 

                    $filteredValues[$field] = filter_input(INPUT_POST, $field, FILTER_SANITIZE_SPECIAL_CHARS);    

                break;

                case "e":
                    
                     if(!filter_var(request()[$field], FILTER_VALIDATE_EMAIL)) {
                        $messages[$field] = "Invalid {$field}";
                     }

                     $filteredValues[$field] = filter_input(INPUT_POST, $field, FILTER_SANITIZE_EMAIL);

                break;

                case "d": 

                    $filteredValues[$field] = date("Y-m-d H:i:s", strtotime(filter_input(INPUT_POST, $field, FILTER_SANITIZE_FULL_SPECIAL_CHARS)));

                break;
            }
            
        }

        if(!empty($messages)) {

            foreach($messages as $field => $messages) {
                Message::set("{$field}", $messages);
            }

            foreach($filteredValues as $field => $value) {

                if(!empty($value)) {
                    PersistedData::set($field, $value);
                }

            }
          
            return false;
        }

        return $filteredValues;
    }

}