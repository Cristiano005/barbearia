<?php

namespace app\controllers\admin;

class Register {

    public array $data;
    public string $view = "admin/register.latte";

    public function index() {

        $this->data = [
            "title" => "Cadastree novos dados"
        ];

    }

    public function store() {

    }

}