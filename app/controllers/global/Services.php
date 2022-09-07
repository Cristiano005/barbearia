<?php

namespace app\controllers\global;

class Services {

    public array $data = [];
    public string $view;

    public function index() {

        $this->data = [
            "title" => "Serviços",
            "thereIsFooter" => true,
        ];

        $this->view = "global/services.latte";
    }

}