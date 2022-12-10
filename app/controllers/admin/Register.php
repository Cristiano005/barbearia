<?php

namespace app\controllers\admin;

use app\controllers\Controller;
use app\classes\Validate;

class Register extends Controller {

    public array $data;
    public string $view = "admin/home.latte";

    public function __construct()
    {
        parent::__construct();

        if(!$_SESSION['admin']) {
            return redirect('/login');
        } 
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
            die;
        } 
    
        $existName = $this->select->findBy("admin", "name", "name", $validated["values"]["name"]);
        $existEmail = $this->select->findBy("admin", "email", "email", $validated["values"]["email"]);

        if($existName) {
            echo json_encode([array_keys($fields)[0] => "Sorry, but this name already exist"]);
            die;
        }

        if($existEmail) {
            echo json_encode([array_keys($fields)[1] => "Sorry, but this email already exis"]);
            die;
        }

        $validated['values']['password'] = password_hash($validated['values']['password'], PASSWORD_BCRYPT);

        $insert = $this->insert->insert('admin', $validated['values']);

        if($insert) {
            echo json_encode('success');
            die;
        }
       
    }

    public function create() {

        $this->view = "admin/register.latte";

        $this->data = [
            "title" => "Register a new admin",
            "thereIsNavbar" => false,
            "existClassInMain" => true,
        ];
    }
}