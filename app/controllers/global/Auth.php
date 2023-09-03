<?php

namespace app\controllers\global;

use app\classes\Validate;
use app\controllers\Controller;

class Auth Extends Controller {

    public array $data = [];
    public string $view = "global/login.latte";

    public function index() {

        $this->data = [
            "title" => "Barbearia - Login/Admin",
            "thereIsFooter" => false,
            "existClassInMain" => true,
            "emailRemember" => isset($_COOKIE["remember"]) ? $_COOKIE["remember"] : "",
        ]; 
        
    }

    public function store() {

        $fields = [
            "email" => "e",
            "password" => "s",
        ];

        $validated = Validate::validate($fields);

        if(!$validated["isValidated"]) {
            echo json_encode($validated["values"]);
            die;
        } 

        $findBy = $this->select->findBy("admins", "id,name,email,password", "email", $validated["values"]["email"]); 
        
        if(!$findBy) {
            echo json_encode([array_keys($fields)[0] => "Email not found", "status" => 401]);
            die;
        }
    
        $data = (object) $findBy[0]; 
        
        // if(!password_verify($validated["values"]["password"], $data->password)) {
        //     echo json_encode([array_keys($fields)[1] => "Password incorrect"]);
        //     die;
        // }
       
        $_SESSION["admin"] = [
            "id" => $data->id,
            "name" => $data->name,
            "email" => $data->email,
        ];
    
        if(isset($_POST["remember"])) {
            setcookie("remember", $data->email, strtotime("+1 year"), "/", "", false, true);
        }
      
        echo json_encode("success"); 
        die;
    }

    public function destroy() {
        setcookie("remember", "", time() - 1, "/", "", false, true);
        session_destroy();
        return redirect("/auth");
    }

}