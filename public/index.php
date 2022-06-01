<?php

session_start();

require_once "../vendor/autoload.php";

use app\core\App;
use app\core\MyApp;

try {
    $myApp = new MyApp(new App); 
    $myApp->controller();
    $myApp->view();
} 

catch(Throwable $th) {
    echo "<span> {$th->getMessage()} </span>";
}