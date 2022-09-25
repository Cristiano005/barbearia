<?php

namespace app\controllers\global;

class Home {

    public array $data = []; 
    public string $view = "global/home.latte";

    public function index() {

        $this->data = [
            "title" => "Barbearia",
            "thereIsFooter" => false,
        ];

    }

}