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
    $myApp->view();

    // $faker = Faker\Factory::create();

    // for ($i = 0; $i < 5; $i++) {
        
    //    $connection = new PDO("mysql:host={$_ENV['DATABASE_HOST']}; 
    //                         dbname={$_ENV['DATABASE_NAME']}; charset={$_ENV['DATABASE_CHARSET']}", 
    //                         $_ENV['DATABASE_ROOT'], $_ENV['DATABASE_PASSWORD']);


    //     $insert = $connection->prepare("INSERT INTO admin (name, email, password, created_up) VALUES(
    //         :name, :email, :password, :created_up
    //     )");

    //     $insert->bindValue(":name", $faker->name);
    //     $insert->bindValue(":email", $faker->email);
    //     $insert->bindValue(":password", password_hash('123', PASSWORD_BCRYPT));
    //     $insert->bindValue(":created_up", date('d-m-Y'));

    //     $insert->execute();
    // }

} catch (Throwable $th) {
    echo "<span> Error {$th->getMessage()} </span>";
}
