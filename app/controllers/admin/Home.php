<?php

namespace app\controllers\admin;

use app\core\Method;
use app\core\Parameter;
use app\models\Select;

class Home {

    public array $data;
    public string $template = "admin/template.php";
    public string $view = "admin/home.php";

    public function index(array $args) {

        $this->data = [
            "title" => "Home - Admin",
            "pagination" => (isset($_GET['page'])) ? $_GET['page'] : $_GET['page'] = 1,
            "limit" => (new Select)->findLimit($args[0], ($_GET['page'] - 1) * 5),
            "data" => array_values((new Select)->findAll($args[0])),
        ];

    }

    public function edit(array $args) {
        dd($args);
    }

    public function update() {
        echo "oi";
    }

    public function destroy(array $args) {

    }
    
}