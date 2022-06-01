<?php

use app\classes\messages\Message;

function message(string $key, string $alert = "danger") {
    
    $message = Message::get($key);

    if(isset($message['message'])) {
        return "<span class='text-{$alert}'> {$message['message']}. </span>";
    }

}