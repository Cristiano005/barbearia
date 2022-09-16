<?php

namespace app\classes;

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

                    $filteredValues[$field] = strip_tags(filter_input(INPUT_POST, $field));    

                break;

                case "e":

                     if(!filter_var(request()[$field], FILTER_VALIDATE_EMAIL)) {
                        $messages[$field] = "Invalid {$field}";
                     }

                     if(empty((request()[$field]))) {
                        $messages[$field] = "Empty {$field} field";
                     }
                    
                     $filteredValues[$field] = filter_input(INPUT_POST, $field, FILTER_SANITIZE_EMAIL);

                break;

                case "d": 

                    $filteredValues[$field] = date("Y-m-d H:i:s", strtotime(filter_input(INPUT_POST, $field, FILTER_SANITIZE_FULL_SPECIAL_CHARS)));

                break;
            }
            
        }

        if(!empty($messages)) {
            
            return [
                'isValidated' => false,
                'values'=> $messages,
            ]; 

        }

        return [
            'isValidated' => true,
            'values' => $filteredValues,
        ];
    }

}