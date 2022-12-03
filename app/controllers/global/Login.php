<?php

namespace app\controllers\global;

use app\classes\EmailToRedefinePassword;
use app\classes\Validate;
use app\controllers\Controller;
use DateTime;

class Login Extends Controller {

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
    
        $findBy = $this->select->findBy("admin", "id,name,email,password", "email", $validated["values"]["email"]); 
        
        if(!$findBy) {
            echo json_encode([array_keys($fields)[0] => "E-mail not found"]);
            die;
        }
    
        $data = (object) $findBy[0]; 
        
        if(!password_verify($validated["values"]["password"], $data->password)) {
            echo json_encode([array_keys($fields)[1] => "Password incorrect"]);
            die;
        }
       
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

    public function update() {

        $form = [
            "email" => "e",
        ];

        $validated = Validate::validate($form);

        $findBy = $this->select->findBy("admin", "id,name,email,password", "email", $validated["values"]["email"])[0];

        if(!$findBy) {
            dd("This email is not registered in our database");
        }

        $token = md5(uniqid());

        $date = new DateTime();
        $date->modify("+1 day");

        // $deleteOldSolicitation = $this->delete->delete("reset", "user_id", $findBy->id);

        $email = new EmailToRedefinePassword();

        $email->from("barbershop@gmail.com", "Barbearia");
        $email->to($findBy->email, $findBy->name);
        $email->content($token);

        $email->send();
    }

    public function destroy() {
        setcookie("remember", "", time() - 1, "/", "", false, true);
        session_destroy();
        return redirect("/login");
    }

}