<?php

namespace app\controllers\admin;

use app\controllers\Controller;

class Home extends Controller {

    public array $data;
    public string $view = "admin/home.latte";
    private array $tables = [
        "appointments_scheduled", "available_schedules"
    ];
    private ?string $table = null;

    public function __construct()
    {
        parent::__construct();

        if(!isset($_SESSION['admin'])) {
            return redirect('/auth');
        } 

        $this->table = filter_input(INPUT_GET, "table", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(!isset($this->table) || !in_array($this->table, $this->tables)) {
            $this->table = "appointments_scheduled";
        }

    }

    public function index() {

        $id = $_SESSION['admin']['id'];

        $data = $this->select->findAll($this->table);

        $this->data = [
            "title" => "Home - Admin",
            "thereIsNavbar" => true,
            "admin" => $this->select->findBy('admins', 'id, name, email, photo', 'id', $id)[0],
            "options" => ["schdueles"],
            "columns" => $data ? array_keys($data[0]) : null,
            "values" => $data,
            "table" => $this->table,
        ];

    }

    public function edit() {

        $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $table = filter_input(INPUT_GET, "table", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(!$table) {
            $table = 'appointments_scheduled';
        }

        $findRegister = $this->select->findBy($table, "*", "id", $id);

        echo json_encode($findRegister);
        die;
    }

    public function update() { 
        // update here 
    }

    public function destroy() { 

        $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_SPECIAL_CHARS);

        $table = filter_input(INPUT_GET, "table", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(!$table) {
            $table = 'appointments_scheduled';
        }

        $delete = $this->delete->delete($table, "id", $id);

        if($delete) {
            echo json_encode($delete);
            die;
        }

    }
    
}