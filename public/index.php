<?php

session_start();

require_once "../vendor/autoload.php";

use app\core\App;
use app\core\MyApp;
use Tracy\Debugger;

try {

    // Debugger::enable();

    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__FILE__, 2));
    $dotenv->load();
    
    $myApp = new MyApp(new App);
    $myApp->controller();
    $myApp->view();

} catch (Throwable $th) {
    echo "<span> Error {$th->getMessage()} </span>";
}
