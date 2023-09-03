<?php

namespace app\controllers\global;

use app\classes\Validate;
use app\controllers\Controller;

class Services extends Controller {

    public array $data = [];
    public string $view;

    public function index() {

        $this->data = [
            "title" => "Services",
            "thereIsFooter" => true,
            "days" => [
                date('d/m/Y'),
                date('d/m/Y', strtotime("+ 1 day"))
            ],
            "services" => [
                "hair", "beard"
            ],
        ];

        $this->view = "global/services.latte";
    }

}