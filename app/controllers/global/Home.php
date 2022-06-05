<?php

namespace app\controllers\global;

use app\interfaces\ControllerInterface;

class Home implements ControllerInterface {

    public array $data = [];
    public string $template = "global/template.php";
    public string $view = "global/home.php";

    public function index() {
        $this->data = ["title" => "Barbearia"];
    }

    public function edit(array $args) {
        dd($args);
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