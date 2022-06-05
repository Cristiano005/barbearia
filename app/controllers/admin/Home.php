<?php

namespace app\controllers\admin;

class Home {

    public array $data;
    public string $template = "admin/template.php";
    public string $view = "admin/home.php";

    public function index() {
        
        $this->data = [
            "title" => "Home - Admin",
            "name" => session("admin", "name"),
            "email" => session("admin", "email")
        ];

    }

    public function edit(array $args) {
        dd($args);
    }

    public function store() {

    }

    public function destroy(array $args) {

    }
    
}