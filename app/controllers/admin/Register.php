<?php

namespace app\controllers\admin;

class Register {

    public array $data;
    public string $view = "admin/register.latte";

    public function index() {

        $this->data = [
            "title" => "Register a new admin",
            "thereIsNavbar" => false,
        ];

    }

    public function store() {

    }

}