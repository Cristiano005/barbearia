<?php

namespace app\controllers\global;

use app\classes\messages\Flash;

class About {

    public array $data = [];
    public string $view;

    public function index() {

        $this->data = [
            "title" => "Sobre",
        ];

        $this->view = "about.php";
    }

}