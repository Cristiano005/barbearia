<?php

namespace app\controllers\admin;

use app\classes\UploadImage;
use app\controllers\Controller;

class Image extends Controller {

    public function update(array $args) {

        $file = $_FILES['file'];
        $temp = $_FILES['file']['tmp_name'];
 
        $image = new UploadImage;

        if(!$image->validation($file)) {
            die;
        }

        $image->delete($file);
        $image->folder('assets/img/profile_admin');
        $image->rename($file);

        $upload = $image->upload($temp);

        if($upload) {
            $this->update->updateWithWhere('admins', 'photo', $upload, ['id', '=', $args[0]]);
            return redirect("/admin/home");
        }

    }


}