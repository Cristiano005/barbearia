<?php

namespace app\controllers\global;

use app\classes\EmailToRedefinePassword;
use app\classes\Validate;
use app\controllers\Controller;
use DateTime;

class Login Extends Controller {

    public array $data = [];
    public string $view = "global/login.latte";

    public function index() {

        $this->data = [
            "title" => "Barbearia - Login/Admin",
            "thereIsFooter" => false,
        ];
        
    }

    public function store() {

        $fields = [
            "email" => "e",
            "password" => "s"
        ];

        $validated = Validate::validate($fields);
        
        if(!$validated['isValidated']) {
            redirect("/login");
        }
        
        $findBy = $this->select->findBy("admin", "id,name,email,password", "email", $validated['values']['email']); 
    
        if(!$findBy) {
            // Message::set("email", "Seu e-mail não existe");
            return redirect("/login");
        }

        $data = (object) $findBy[0]; 
    
        if($data->password !== $validated['values']['password']) {
            // Message::set("password", "Sua senha está incorreta");
            return redirect("/login");
        }

        $_SESSION['admin'] = [
            "id" => $data->id,
            "name" => $data->name,
            "email" => $data->email
        ];
     
        return redirect("/admin/home/clients");
    }

    public function update() {

        $form = [
            'email' => 'e',
        ];

        $validated = Validate::validate($form);

        $findBy = $this->select->findBy("admin", "id,name,email,password", "email", $validated['values']['email'])[0];

        if(!$findBy) {
            dd('This email is not registered in our database');
        }

        $token = md5(uniqid());

        $date = new DateTime();
        $date->modify('+1 day');

        $deleteOldSolicitation = $this->delete->delete('reset', 'user_id', $findBy->id);

        $email = new EmailToRedefinePassword();

        $email->from('barbershop@gmail.com', 'Barbearia');
        $email->to($findBy->email, $findBy->name);
        $email->content($token);

        $email->send();
    }

    public function destroy() {

        session_destroy();

        return redirect("/login");
    }

}