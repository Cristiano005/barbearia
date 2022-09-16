<?php

namespace app\controllers\global;

// use app\classes\messages\Message;
use app\classes\Validate;
use app\models\Select;

class Login {

    public array $data = [];
    public string $view = "global/login.latte";

    public function index() {

        $this->data = [
            "title" => "Barbearia - Login/Admin",
            "thereIsFooter" => false,
        ];
        
    }

    public function store() {

        $fields = [
            "email" => "e",
            "password" => "s"
        ];

        $validated = Validate::validate($fields);
        
        if(!$validated['isValidated']) {
            redirect("/login");
        }
        
        $findBy = (new Select)->findBy("admin", "name,email,password", "email", $validated['values']['email']); 
    
        if(!$findBy) {
            // Message::set("email", "Seu e-mail não existe");
            return redirect("/login");
        }

        $data = (object) $findBy[0]; 
    
        if($data->password !== $validated['values']['password']) {
            // Message::set("password", "Sua senha está incorreta");
            return redirect("/login");
        }

        $_SESSION['admin'] = [
            "name" => $data->name,
            "email" => $data->email
        ];
     
        return redirect("/admin/home/clients");
    }

    public function destroy() {

        session_destroy();

        return redirect("/login");
    }

}