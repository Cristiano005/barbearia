<?php

session_start();

date_default_timezone_set('America/Sao_Paulo');

require_once "../vendor/autoload.php";

use app\core\App;
use app\core\MyApp;

try {

    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__FILE__, 2));
    $dotenv->load();

    $myApp = new MyApp(new App);
    $myApp->controller();
  
    $myApp = new MyApp(new App);
    $myApp->controller();
    $myApp->view();

} catch (Throwable $th) {
    $latte = new \Latte\Engine;
    $latte->render("../app/views/global/pageNotFound.latte", [
        "isInPageNotFound" => true, 
        "message" => $th->getMessage(),
    ]);
}
