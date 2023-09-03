<?php

namespace app\classes;

use Intervention\Image\ImageManager;

class UploadImage {

    private $manager;
    private string $newName;
    private string $folder;
    private array $extensions = ['jpg', 'jpeg', 'png'];

    public function __construct()
    {
        $this->manager = new ImageManager();
    }

    public function validation($file) {

        if(empty($file['name'])) {
            echo json_encode('Please, selected a image.');
            return false;
        }

        if($file['size'] > 2097152) {
            echo json_encode('Limit maximum of 2MB reached.');
            return false;
        }

        if(!in_array(pathinfo($file['name'], PATHINFO_EXTENSION), $this->extensions)) {
            echo json_encode('Extension of file not acepted.');
            return false;
        }

        echo json_encode('succes');
        return true;
    }

    public function folder($folder) {

        if(!file_exists($folder)) {
            throw new \Exception("This folder does not exist.", 1);
        }

        $this->folder = $folder;
    }

    public function rename($file) {
        $this->newName = md5(uniqid(true)) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
    }

    private function resize($width, $height, $target) {

        $percent = ($width > $height) ? ($target / $width) : ($target / $height);

        $width = round($width * $percent);
        $height = round($height * $percent);

        return [
            "width" => $width,
            "height" => $height,
        ];
    }

    public function upload($temp) {

        $dimensions = getimagesize($temp);

        $resize = $this->resize($dimensions[0], $dimensions[1], 640);
        $path = $this->folder . "/" . $this->newName;

        $background = $this->manager->canvas(400, 400);
        
        $image = $this->manager->make($temp)->resize($resize['width'], $resize['height'], function ($constrain) {
            $constrain->aspectRatio();
            $constrain->upsize();
        });

        $background->insert($image, 'center');
        $background->fit(190, 190);

        $imageSave = $background->save($path);
        
        if($imageSave) { // salva a imagem no caminho que eu indiquei.
            return "/" . $imageSave->dirname. "/" . $imageSave->basename;
        }

    }

    public function delete($file) {

        if(file_exists($file['name'])) {
            @unlink($file['name']);
            return true;
        }
        
    }
}
