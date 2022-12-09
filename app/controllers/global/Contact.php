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
            "hourly" => $this->select->findAll("hourly"),
            "existClassInMain" => false,
        ];

    }

    public function store() {

        $fields = [
            'name' => 's',
            'email' => 'e',
            'subject' => 's',
            'message' => 's',
        ];

        $validated = Validate::validate($fields);

        if(!$validated['isValidated']) {
            echo json_encode($validated['values']);
            die;
        }

        $emailContact = new EmailToContact();
        $emailContact->from($validated['values']['email'], $validated['values']['name']);
        $emailContact->to('erisvaldosilvadesousa38@gmail.com', 'Barber Shop');
        $emailContact->isHtml();
        $emailContact->subject($validated['values']['subject']);
        $emailContact->message($validated['values']['message'], 'This message is only for Programs what reads HTML');
        
        
        if($emailContact->send()) { 
            echo json_encode('success');
            die;
        }  
    }

}