<?php

namespace app\controllers\global;

class About {

    public array $data = [];
    public string $view = "global/about.latte";

    public function index() {

        $this->data = [
            "title" => "About - Barbearia",
            "thereIsFooter" => true,
        ];

    }

}