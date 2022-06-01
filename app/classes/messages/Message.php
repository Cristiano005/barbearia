<?php

namespace app\classes\messages;

class Message {

    public static function get(string $key) {

        if(isset($_SESSION['messages'][$key])) {
            
            $message = $_SESSION['messages'][$key];
            unset($_SESSION['messages'][$key]);

            return $message;
        }
      
    }

    public static function set($key, $message) {

        if(!isset($_SESSION['messages'][$key])) {
            $_SESSION['messages'][$key] = [
                'message' => $message,
            ];
        }
        
    }

}