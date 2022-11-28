<?php

namespace app\controllers\global;

use app\classes\EmailToContact;
use app\classes\Validate;
use app\controllers\Controller;

class Contact extends Controller {

    public array $data = [];
    public string $view = 'global/contact.latte';

    public function index() {

        $this->data = [
            "title" => "Contact",
            "thereIsFooter" => true,
            "payments" => $this->select->findAll("payment", "name"),
            "hourly" => $this->select->findAll("hourly")
        ];

    }

    public function store() {

        $form = [
            'name' => 's',
            'email' => 'e',
            'subject' => 's',
            'comment' => 's',
        ];

        $validated = Validate::validate($form);

        if(!$validated['validated']) {
            echo json_encode($validated['values']);
            die;
        }

        // if($send->send($validated['values'])) {
        //     echo json_encode($validated['values']);
        // }

    }

}