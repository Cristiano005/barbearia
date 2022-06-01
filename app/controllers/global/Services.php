<?php

namespace app\controllers\global;

use app\classes\messages\Flash;

class Services {

    public array $data = [];
    public string $template;
    public string $view;

    public function index() {

        $this->data = [
            "title" => "Serviços"
        ];

        $this->template = "global/template.php";
        $this->view = "global/services.php";
    }

    public function store() {

    }
    
}