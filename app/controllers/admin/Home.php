<?php

namespace app\controllers\admin;

use app\classes\UploadImage;
use app\controllers\Controller;
class Home extends Controller {

    public array $data;
    public string $view = "admin/home.latte";

    public function __construct() {}
   
    public function index(array $args) {

        $id = $_SESSION['admin']['id'];

        if(!$_SESSION['admin']) {
            return redirect('/login');
        }

        $this->data = [
            "title" => "Home - Admin",
            "thereIsNavbar" => true,
            "admin" => $this->select->findBy('admin', 'id, name, email, photo', 'id', $id)[0],
            "pagination" => (isset($_GET['page'])) ? $_GET['page'] : $_GET['page'] = 1,
            "limit" => $this->select->findLimit($args[0], ($_GET['page'] - 1) * 5),
            "data" => array_values($this->select->findAll($args[0])),
        ];

    }

    public function update(array $args) {

        $file = $_FILES['file'];
        $temp = $_FILES['file']['tmp_name'];
 
        $image = new UploadImage;
        
        if(!$image->validation($file)) {
            return;
        }

        $image->delete($file);
        $image->folder('/assets/img/admin');
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