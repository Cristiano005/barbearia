<?php

namespace app\controllers\admin;

use app\classes\Validate;
use app\controllers\Controller;

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
            "data" => array_values($this->select->findAll($args[0])),
        ];

    }

    public function show($args) {

        $page = intval($_GET['page']);

        if(!isset($page) || empty($page) || !is_integer($page) || $page < 0) {
            $page = 1;
        }

        if(empty($args[0]) || !in_array($args[0], $this->tables)) {
            $args[0] = 'clients';
        }
       
        echo json_encode($this->select->findLimit($args[0] , ($page - 1) * 5));
        die;
    }

    public function edit($args) {

        if(empty($args[0]) || !in_array($args[0], $this->tables)) {
            $args[0] = 'clients';
        }

        $findBy = $this->select->findBy($args[0], "*", "id", $_GET['id']);

        echo json_encode($findBy);
        die; 
    }

    public function update(array $args) {

        $fields = [];

        if($args[0] === 'clients') {
            $fields = [
                "name" => "s",
                "payment" => "s",
                "date" => "d",
                "schedule" => "s",
            ];
        }

        if($args[0] === 'hourly') {
            $fields = [
                "schedule" => "s",
            ];
        }

        if($args[0] === 'payment') {
            $fields = [
                "payment" => "s",
            ];
        }

        $validated = Validate::validate($fields);

        if(!$validated['isValidated']) {
            echo json_encode($validated['values']);
            die;
        }

        $update = $this->update->updateWithWhere('admin', 'name,payment,date,schedule', $validated['values'], ['id', '=', 1]);

        if($update) {
            echo json_encode('success');
            die;
        }

    }

    public function destroy(array $args) { 

        $id = json_decode(file_get_contents('php://input'));

        // echo json_encode($id);
        // die;
        
        if(empty($args[0]) || !in_array($args[0], $this->tables)) {
            $args[0] = 'clients';
        }

        if(!$this->select->findBy($args[0], '*', 'id', $id)) {
            echo json_encode($id);
            die;
        }

        $delete = $this->delete->delete($args[0], 'id', $id);

        if($delete) {
            echo json_encode('success');
            die;
        }

    }
    
}