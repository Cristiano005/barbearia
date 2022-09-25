<?php

namespace app\controllers\admin;

class Redeem {

    public array $data = [];
    public string $view = "admin/redeem.php";

    public function index() {
       
        $this->data = [
            "title" => "Admin - Mudar senha"
        ];


    }

}