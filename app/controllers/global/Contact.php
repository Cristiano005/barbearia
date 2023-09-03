<?php

namespace app\controllers\global;

use app\classes\Email;
use app\classes\PHPMailerService;
use app\classes\Validate;
use app\controllers\Controller;

class Contact extends Controller {

    public array $data = [];
    public string $view = 'global/contact.latte';

    public function index() {

        $this->data = [
            "title" => "Contact",
            "thereIsFooter" => true,
            // "payments" => $this->select->findAll("payment", "name"),
            // "hourly" => $this->select->findAll("hourly"),
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
            return;
        }

        $validated = (object) $validated['values'];

        $mailer = new Email(new PHPMailerService());

        $mailer->emailService->from($validated->email, $validated->name);
        $mailer->emailService->to('erisvaldosilvadesousa38@gmail.com', 'Barber Shop');
        $mailer->emailService->subject($validated->subject);
        $mailer->emailService->message($validated->message);
           
        $result = $mailer->emailService->send();

        if(!$result) {
            return;
        }
        
        echo json_encode('success');
        return;
    }

}