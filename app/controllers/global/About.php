<?php

namespace app\controllers\global;

use app\classes\messages\Flash;

class About {

    public array $data = [];
    public string $template = "global/template.php";
    public string $view = "global/about.php";

    public function index() {

        $this->data = [
            "title" => "My History - Barbearia",
        ];

    }

    public function edit($args) {
        dd($args);
    }

}