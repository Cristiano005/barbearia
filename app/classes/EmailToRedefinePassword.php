<?php 

namespace app\classes;

use app\classes\Email;
use app\interfaces\EmailRedefinePasswordInterface;
use Exception;

class EmailToRedefinePassword extends Email {

    public function from($email, $name) {
        $this->mailer->setFrom($email, $name);
    }

    public function to($email, $name) {
        $this->mailer->addAddress($email, $name);
    }

    public function isHtml($isHtml = true)
    {
        $this->mailer->isHTML($isHtml);
    }

    public function subject($subject)
    {
        $this->mailer->Subject = $subject;
    }

    public function message($message, $DoesNotSupportHtmlMessage)
    {
        $this->mailer->Body = $message;
        $this->mailer->AltBody = $DoesNotSupportHtmlMessage;
    }

    public function send() {
        return $this->mailer->send();
    }
    
}