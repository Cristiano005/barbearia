<?php

namespace app\controllers\admin;

use app\classes\UploadImage;
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
            "limit" => $this->select->findLimit($args[0] , ($_GET['page'] - 1) * 5),
            "data" => array_values($this->select->findAll($args[0])),
        ];

    }

    public function show(array $args) {

        if(empty($args[0]) || !in_array($args[0], $this->tables)) {
            $args[0] = 'clients';
        }

        
        echo json_encode($this->select->findBy($args[0], "name,payment,hourly", "id", $_GET['id']));
    }

    public function update(array $args) {

        $file = $_FILES['file'];
        $temp = $_FILES['file']['tmp_name'];
 
        $image = new UploadImage;
        
        if(!$image->validation($file)) {
            return;
        }

        $image->delete($file);
        $image->folder('assets/img/admin');
        $image->rename($file);

        $upload = $image->upload($temp);

        if($upload) {
            $this->update->updateWithWhere('admin', 'photo', $upload, ['id', '=', $args[0]]);
            return redirect("/admin/home/clients");
        }

    }

    public function destroy(array $args) { 
        dd('deleted');
    }
    
}