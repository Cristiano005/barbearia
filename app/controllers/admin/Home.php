<?php

namespace app\controllers\admin;

use app\classes\UploadImage;
use app\controllers\Controller;
use app\classes\Validate;

class Home extends Controller {

    public array $data;
    public string $view = "admin/home.latte";
    private array $tables = [
        "clients", "hourly", "payment"
    ];

    public function __construct()
    {
        parent::__construct();

        if(!$_SESSION['admin']) {
            return redirect('/login');
        } 
    }

    public function index(array $args) {

        $id = $_SESSION['admin']['id'];

        if(empty($args[0]) || !in_array($args[0], $this->tables)) {
            $args[0] = 'clients';
        }

        $this->data = [
            "title" => "Home - Admin",
            "thereIsNavbar" => true,
            "admin" => $this->select->findBy('admin', 'id, name, email, photo', 'id', $id)[0],
            "pagination" => (isset($_GET['page'])) ? $_GET['page'] : $_GET['page'] = 1,
            "limit" => 
                    $this->select->findLimit($args[0] , ($_GET['page'] - 1) * 5)
                    
                    ,
            "data" => array_values($this->select->findAll($args[0])),
        ];

    }

    public function store() {

        $fields = [
            "name" => "s",
            "email" => "e",
            "password" => "s"
        ];

        $validated = Validate::validate($fields);

        if(!$validated["isValidated"]) {
            echo json_encode($validated["values"]);
            die;
        } 
    
        $existName = $this->select->findBy("admin", "name", "name", $validated["values"]["name"]);
        $existEmail = $this->select->findBy("admin", "email", "email", $validated["values"]["email"]);

        if($existName) {
            echo json_encode([array_keys($fields)[0] => "Sorry, but this name already exist"]);
            die;
        }

        if($existEmail) {
            echo json_encode([array_keys($fields)[1] => "Sorry, but this email already exis"]);
            die;
        }

        $validated['values']['password'] = password_hash($validated['values']['password'], PASSWORD_BCRYPT);

        $insert = $this->insert->insert('admin', $validated['values']);

        if($insert) {
            echo json_encode('success');
            die;
        }
       
    }

    public function show(array $args) {

        if(empty($args[0]) || !in_array($args[0], $this->tables)) {
            $args[0] = 'clients';
        }

        $findBy = $this->select->findBy($args[0], "*", "id", $_GET['id'], true);

        echo json_encode($findBy);
        die;
    }

    public function create() {

        $this->view = "admin/register.latte";

        $this->data = [
            "title" => "Register a new admin",
            "thereIsNavbar" => false,
            "existClassInMain" => true,
        ];
    }

    public function update(array $args) {

        $fields = [
            "name" => "s",
            "email" => "e",
            "password" => "s",
        ];

    }

    public function destroy(array $args) { 

        if(empty($args[0]) || !in_array($args[0], $this->tables)) {
            $args[0] = 'clients';
        }

        if(empty($args[1])) {
            echo json_encode('Dado inexistente');
            die;
        }

        echo json_encode($args[1]);
        die;
    }
    
}