<?php

namespace app\core;

use app\classes\Uri;
use app\core\Folder;
use Exception;

class Controller {

    public static function extract() {

        $uri = Uri::uri();

        $folder = Folder::extract($uri);
      
        if($folder) {
            $controller = Uri::exist($uri, 1);
            $namespaceAndController = "app\\controllers\\{$folder}\\";
        } else {
            $controller = Uri::exist($uri, 0);
            $namespaceAndController = "app\\controllers\\".CONTROLLER_FOLDER_DEFAULT."\\";
        }

        if(!$controller) {
            $controller = CONTROLLER_DEFAULT;
        }

        $controller = $namespaceAndController.ucfirst($controller); 

        if(class_exists($controller)) {
           return $controller; 
        }

        throw new Exception("Page not found");
        die;
    }

}