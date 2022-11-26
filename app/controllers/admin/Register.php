<?php

namespace app\controllers\admin;

use app\classes\Validate;
use app\controllers\Controller;

class Register extends Controller {

    public array $data;
    public string $view = "admin/register.latte";

    public function index() {

        $this->data = [
            "title" => "Register a new admin",
            "thereIsNavbar" => false,
            "existClassInMain" => true,
        ];

    }

    public function store() {

        $fields = [
            "name" => "s",
            "email" => "e",
            "password" => "s"
        ];

        $validated = Validate::validate($fields);

        if(!$validated["isValidated"]) {
            echo json_encode($validated["values"]);
            return;
        } 
    
        $existName = $this->select->findBy("admin", "name", "name", $validated["values"]["name"]);
        $existEmail = $this->select->findBy("admin", "email", "email", $validated["values"]["email"]);

        if($existName) {
            echo json_encode("Sorry, but this name already exist");
            return;
        }

        if($existEmail) {
            echo json_encode("Sorry, but this email already exist");
            return;
        }

        $hash = password_hash($validated['values']['password'], PASSWORD_BCRYPT);

        // dd($hash);

        echo json_encode('success');
    }

}