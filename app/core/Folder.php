<?php

namespace app\core;

class Folder {

    public static function extract($uri): string {

        if(isset($uri[0]) and $uri[0] !== '') {
            return is_dir(str_replace("downloads","Downloads",strtolower(ROOT.'/'.CONTROLLER_PATH.$uri[0]))) ? $uri[0] : '';
        }
        
        return CONTROLLER_FOLDER_DEFAULT;    
    }

}