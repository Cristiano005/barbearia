<?php

namespace app\classes;

class Validate
{

    public static function validate(array $fields): array|bool
    {

        $filteredValues = [];
        $messages = [];

        $valuesFromFrontEnd = json_decode(file_get_contents('php://input'));

        foreach ($fields as $field => $type) {

            switch ($type) {

                case "s":

                    if (!isset($valuesFromFrontEnd->$field) || empty($valuesFromFrontEnd->$field)) {
                        $messages[$field] = "Empty {$field} field";
                    }

                    else {
                        $filteredValues[$field] = filter_var($valuesFromFrontEnd->$field, FILTER_SANITIZE_SPECIAL_CHARS);
                    }

                    break;

                case "e":

                    if (!isset($valuesFromFrontEnd->$field) || empty($valuesFromFrontEnd->$field)) {
                        $messages[$field] = "Empty {$field} field";
                    }

                    else if (!filter_var($valuesFromFrontEnd->$field, FILTER_VALIDATE_EMAIL)) {
                        $messages[$field] = "Invalid {$field}";
                    }

                    else {
                        $filteredValues[$field] = filter_var($valuesFromFrontEnd->$field, FILTER_SANITIZE_SPECIAL_CHARS);
                    }

                    break;

                case "d":

                    $pattern = "/[0-9]{2}\/(0[1-9]|1[0-2])\/[0-9]{4}/";
                    $data = $valuesFromFrontEnd->$field;

                    $match = preg_match($pattern, $data);

                    if (!$match) {
                        $messages[$field] = "Invalid {$field}";
                    }

                    else {
                        $filteredValues[$field] = filter_var($valuesFromFrontEnd->$field, FILTER_SANITIZE_SPECIAL_CHARS);
                    }

                    break;

                case "t":

                    $pattern = "/(1?[0-9]):[0-5][0-9]/";

                    $data = $valuesFromFrontEnd->$field;

                    $match = preg_match($pattern, $data);

                    if (!$match) {
                        $messages[$field] = "Invalid {$field}";
                    }

                    else {
                        $filteredValues[$field] = filter_var($valuesFromFrontEnd->$field, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
            }
        }

        if (!empty($messages)) {

            return [
                'isValidated' => false,
                'values' => $messages,
            ];
        }

        return [
            'isValidated' => true,
            'values' => $filteredValues,
        ];
    }
}
