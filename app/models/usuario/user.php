<?php

namespace App\Models\Usuario;

class User {

    private $msg;
    private $dices = [$name, $hour, $payment];

    public function __construct($name, $hour, $payment) {
        $this->setFields($name, $hour, $payment);
    }

    public function getFields() {
        return $this->dices;
    }

    private function setFields($name, $hour, $payment) {
    }

    public function getMessage(): string {
        return "{$this->msg}";
    }
    
}