<?php

namespace app\classes;

class Block {

    private static array $blockedMethods = [
        "store", "update", "destroy"
    ];

    public static function block(string $method) {
        return in_array($method, self::$blockedMethods);
    }

}