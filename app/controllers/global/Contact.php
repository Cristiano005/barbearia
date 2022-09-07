<?php

namespace app\controllers\global;

use app\classes\messages\Message;
use app\classes\validation\Validate;
use app\models\Delete;
use app\models\Insert;
use app\models\Select;

class Contact {

    public array $data = [];
    public string $view = 'global/contact.latte';

    public function index() {

        $this->data = [
            "title" => "Contato",
            "thereIsFooter" => true,
            "payments" => (new Select)->findAll("payment", "name"),
            "hourly" => (new Select)->findAll("hourly")
        ];

    }

    public function store() {

        if(request() == $_GET) {
            return redirect("/contact"); // verifica se o usuário realmentre preencheu os campos do formulário...
        }
     
        $fields = [
            "name" => "s",
            "payment" => "s",
            "hourly" => "d"
        ];

        $validated = Validate::validate($fields);

        if(!$validated) {
            return redirect("/contact");
        }

        if((new Insert)->Insert("clients",$validated)) {

            $id = (new Select)->findBy("hourly", "id", 'hours', $validated['hourly']);

            return redirect("/contact/destroy/{$id[0]['id']}");
        }
    }

    public function destroy(array $id) {

        $id = implode($id);
        
        (new Delete)->delete("hourly", "id", $id);

        Message::set("register", "Seu horário está agendado, volte sempre");
        return redirect("/contact");
    }

}