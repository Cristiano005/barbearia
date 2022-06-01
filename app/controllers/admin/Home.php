<?php

namespace app\controllers\admin;

use app\interfaces\ControllerInterface;

class Home implements ControllerInterface {

    public array $data;
    public string $template = "admin/template.php";
    public string $view = "admin/home.php";

    public function index(array $args) {
        
        $this->data = [
            "title" => "Home - Admin"
        ];

    }

    public function edit(array $args) {

    }

    public function show(array $args) {

    }

    public function update(array $args) {

    }

    public function store() {

    }

    public function destroy(array $args) {

    }
    
}