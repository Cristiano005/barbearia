<?php

namespace app\controllers\admin;

class Register {

    public array $data;
    public string $template = "admin/template.php";
    public string $view = "admin/register.php";

    public function index() {

        $this->data = [
            "title" => "Cadastree novos dados"
        ];

    }

    public function store() {

    }

}