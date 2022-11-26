<?php

namespace app\controllers\admin;

class Redeem {

    public array $data = [];
    public string $view = "admin/redeem.latte";

    public function index() {
       
        $this->data = [
            "title" => "Admin - Mudar senha"
        ];

        if(!$_SESSION['admin']) {
            return redirect('/login');
        }

    }

}