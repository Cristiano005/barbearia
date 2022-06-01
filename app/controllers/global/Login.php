<?php

namespace app\controllers\global;

use app\classes\validation\ValidateLogin;

class Login {

    public array $data = [];
    public string $view;

    public function index() {

        $this->data = [
            "title" => "Barbearia - Login/Admin"
        ];

        $this->view = "login.php";
    }

    public function store() {
        
        var_dump($_POST);

        // if(!ValidateLogin::validate()) {
        //     return;
        // }

        // return $this->view = "admin.php";
    }

}