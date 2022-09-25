<?php 

namespace app\classes;

use app\classes\Email;
use app\interfaces\EmailRedefinePasswordInterface;
use Exception;

class EmailToRedefinePassword extends Email implements EmailRedefinePasswordInterface {

    public function from($email, $name) {
        $this->mailer->setFrom($email, $name);
    }

    public function to($email, $name) {
        $this->mailer->addAddress($email, $name);
    }

    public function content(string $token, bool $isHtml = true) {

        $this->mailer->isHTML($isHtml);    
        
        $message = <<<HTML

            <p>Olá {$this->nameTo}</p>
            <p>Você pediu para redefinir sua senha do site tal, clique no link abaixo</p>
            <p><a href="http://localhost:8000/password/redefine/{$token}">Redefinir sua senha</a></p>

        HTML;

        $this->mailer->Subject = 'Reset your password!';
        $this->mailer->Body = $message;
    }

    public function send() {

        try {
            return $this->mailer->send();
        } 
        
        catch (Exception) {
            echo "<span> Oops, some error occurred {$this->mailer->ErrorInfo} </span>";
        }

    }
    
}