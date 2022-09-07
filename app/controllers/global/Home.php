<?php

namespace app\controllers\global;

use app\interfaces\ControllerInterface;

class Home implements ControllerInterface {

    public array $data = []; 
    public string $view = "global/home.latte";

    public function index() {

        $this->data = [
            "title" => "Barbearia",
            "thereIsFooter" => false,
        ];

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