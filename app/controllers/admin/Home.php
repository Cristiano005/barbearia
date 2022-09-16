<?php

namespace app\controllers\admin;

use app\models\Select;

class Home {

    public array $data;
    public string $view = "admin/home.latte";

    public function index(array $args) {

        $this->data = [
            "title" => "Home - Admin",
            "pagination" => (isset($_GET['page'])) ? $_GET['page'] : $_GET['page'] = 1,
            "limit" => (new Select)->findLimit($args[0], ($_GET['page'] - 1) * 5),
            "data" => array_values((new Select)->findAll($args[0])),
        ];

    }

    public function update() {
        echo "oi";
    }

    public function destroy(array $args) {

    }
    
}