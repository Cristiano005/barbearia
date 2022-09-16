<?php

namespace app\controllers\global;

use app\classes\Email;
use app\classes\Validate;
use app\models\Select;

class Contact {

    public array $data = [];
    public string $view = 'global/contact.latte';

    public function index() {

        $this->data = [
            "title" => "Contact",
            "thereIsFooter" => true,
            "payments" => (new Select)->findAll("payment", "name"),
            "hourly" => (new Select)->findAll("hourly")
        ];

    }

    public function store() {

        $send = new Email;

        $form = [
            'name' => 's',
            'email' => 'e',
            'subject' => 's',
            'comment' => 's',
        ];

        $validated = Validate::validate($form);
        
        if(!$validated['validated']) {
            echo json_encode($validated['values']);
            return;
        }

        // if($send->send($validated['values'])) {
        //     echo json_encode($validated['values']);
        // }

    }

}