<?php

namespace app\core;

use app\classes\Uri;

class Method {

    public static function extract($controller): array {

        $uri = Uri::uri();
        $folder = Folder::extract($uri);

        $method = 'index';
        $methodNotExist = 2;

        $method = (!$folder) ? strtolower(Uri::exist($uri, 1)) : strtolower(Uri::exist($uri, 2));

        if(empty($method)) {
            $method = 'index';
        } 

        if(!method_exists($controller, $method)) {
            $method = 'index';
            $methodNotExist = (!$folder) ? 1 : 2;
        } else {
            $methodNotExist = (!$folder) ? 2 : 3;
        }

        return [
            $method, $methodNotExist
        ];
        
    }
    
}