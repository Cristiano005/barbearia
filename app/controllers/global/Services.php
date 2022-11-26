<?php

namespace app\controllers\global;

use app\controllers\Controller;

class Services extends Controller {

    public array $data = [];
    public string $view;

    public function index() {

        $this->data = [
            "title" => "Services",
            "thereIsFooter" => true,
            "hourly" => $this->select->findAll('hourly', 'hours'),
            "payments" => $this->select->findAll('payment', 'name'),
        ];

        $this->view = "global/services.latte";
    }

    public function store() {

        // if($send) {
        //     return redirect('/contact');
        // }

        // if(request() == $_GET) {
        //     return redirect("/contact"); // verifica se o usuário realmentre preencheu os campos do formulário...
        // }
     
        // $fields = [
        //     "name" => "s",
        //     "payment" => "s",
        //     "hourly" => "d"
        // ];

        // $validated = Validate::validate($fields);

        // if(!$validated) {
        //     return redirect("/contact");
        // }

        // if((new Insert)->Insert("clients",$validated)) {

        //     $id = (new Select)->findBy("hourly", "id", 'hours', $validated['hourly']);

        //     return redirect("/contact/destroy/{$id[0]['id']}");
        // }

    }

    public function destroy($id) {

         // $id = implode($id);
        
        // (new Delete)->delete("hourly", "id", $id);

        // Message::set("register", "Seu horário está agendado, volte sempre");
        // return redirect("/contact");
        
    }
}