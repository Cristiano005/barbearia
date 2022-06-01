<?php

namespace app\core;

use app\interfaces\AppInterface;

class App implements AppInterface {

    private int $methodNotExist;

    public function controller(): string {
        return Controller::extract();
    }

    public function method($controller): string {
        [$method, $methodNotExist] =  Method::extract($controller);
        $this->methodNotExist = $methodNotExist;
        return $method;
    }

    public function parameters(): array {
        return Parameter::extract($this->methodNotExist);
    }

}