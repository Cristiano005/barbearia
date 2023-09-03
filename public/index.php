<?php

session_start();

date_default_timezone_set('America/Sao_Paulo');

use app\core\App;
use app\core\MyApp;

require_once "../vendor/autoload.php";

try {

    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__FILE__, 2));
    $dotenv->load();
      
    $myApp = new MyApp(new App);
    $myApp->controller();
    $myApp->view();

} catch (Throwable $th) {
    echo $th->getfile().$th->getMessage().$th->getLine();
    // $latte = new \Latte\Engine;
    // $latte->render("../app/views/global/pageNotFound.latte", [
    //     "isInPageNotFound" => true, 
    //     "message" => $th->getMessage(),
    // ]);
}
