<?php

namespace app\controllers\global;

use app\classes\messages\Message;
use app\models\Delete;
use app\models\Insert;
use app\models\Select;

class Contact {

    public array $data = [];
    public string $template = 'global/template.php';
    public string $view = 'global/contact.php';

    public function index() {

        $payments = (new Select)->findAll("payment", "name");
        $hourly = (new Select)->findAll("hourly", "hours");

        $this->data = [
            "title" => "Contato",
            "payments" => $payments,
            "hourly" => $hourly
        ];

    }

    public function store() {
     
        $fields = [
            "name" => "s",
            "payment" => "s",
            "hourly" => "s"
        ];

        if((new Insert)->Insert("clients",$fields)) {
            redirect("/destroy/{$fields}");
        }

    }

    public function destroy(array $fields) {

        (new Delete)->delete("hourly", "hours", $fields['hourly']);

        Message::set("register", "Seu horário está agendado, volte sempre");
        return redirect("/contact");
    }

}