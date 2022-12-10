<?php

namespace app\controllers\global;

use app\controllers\Controller;
use app\classes\EmailToRedefinePassword;
use DateTime;
use app\classes\Validate;
use Exception;


class Password extends Controller {

    public $view = "global/redefinePassword.latte";

    public function index($args) {

        if(!$_SESSION['token']) {
            return redirect('/login');
        }

        $this->data = [
            "title" => "Solicitation for redefine password",
            "existClassInMain" => true,
            "token" => $args[0],
        ]; 

    }

    public function store() {

        $form = [
            "email" => "e",
        ];

        $validated = Validate::validate($form);

        if(!$validated['isValidated']) {
            echo json_encode($validated['values']);
            die;
        }

        $findBy = $this->select->findBy("admin", "id,name,email", "email", $validated["values"]["email"])[0];

        if(!$findBy) {
            echo json_encode("This email is not registered in our database");
            die;
        }

        $token = md5(uniqid());

        $date = new DateTime();
        $date->modify("+1 day");

        $this->delete->delete("reset", "user_id", $findBy->id);

        $this->insert->insert('reset', [
            "user_id" => $findBy->id,
            "time" => $date->format('Y-m-d H:i:s'),
            "token" => $token,
        ]);

        $message = <<<HTML

            <p>Hello {$findBy->name}</p>
            <p>You asked for redefine your password of website Barber Shop, click in link down</p>
            <p>
                <a href="http://localhost:9000/password/token/{$token}">Redefine password</a>
            </p>

            <span> 
                Warning: remembering that you have until tomorrow to change your password, 
                after that the request will no longer be valid.
            </span>

        HTML;

        $emailRedefinedPassword = new EmailToRedefinePassword();
        $emailRedefinedPassword->from("barbershop@gmail.com", "Barber Shop");
        $emailRedefinedPassword->to($findBy->email, $findBy->name);
        $emailRedefinedPassword->subject('Redefine password');
        $emailRedefinedPassword->message($message, 'This message is only for Programs what reads HTML');

        if($emailRedefinedPassword->send()) {
            echo json_encode('success');
            die;
        }
        
    }

    public function token($args) {

        if(!isset($args[0])) {
            throw new Exception("Token does not exist");
        }

        $token = $args[0];
        $findByToken = $this->select->findBy('reset', 'token,time', 'token', $token);

        $expiration = new DateTime($findByToken[0]->time);
        $dateNow = new DateTime('now');
        
        if($dateNow >= $expiration) {
            throw new Exception("Token invalid");
        }

        $_SESSION['token'] = $token;
        return redirect("/password/index/{$token}");
    }

    public function update($args) {
        
        $form = [
            "password" => "s"
        ];
        
        $validated = Validate::validate($form);

        if(!$validated["isValidated"]) {
            echo json_encode($validated["values"]);
            die;
        } 

        $token = $args[0];
        $findByToken = $this->select->findBy('reset', '*', 'token', $token);

        $expiration = new DateTime($findByToken[0]->time);
        $dateNow = new DateTime('now');
        
        if($dateNow >= $expiration) {
            echo json_encode([
                "password" => "Token expired"
            ]);
            die;
        }

        $update = $this->update->updateWithWhere('admin', 'password', 
        password_hash($validated['values']['password'], PASSWORD_BCRYPT),['id', '=', $findByToken[0]->user_id]);

        if($update) {
            echo json_encode('success');
            die;
        }
    
    }

}