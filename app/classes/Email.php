<?php

namespace app\classes;

use PHPMailer\PHPMailer\PHPMailer;

abstract class Email {

    public function __construct(protected $mailer = new PHPMailer(true)) { 
        $mailer->isSMTP();
        $mailer->Host = 'smtp.mailtrap.io';
        $mailer->Username = 'bed95d1208e12a';
        $mailer->Password = '956a16512381cb';
        $mailer->Port = 2525;
        $mailer->CharSet = 'utf-8';
        $mailer->SMTPAuth = true;
    }
 
    abstract function from($email, $name);
    abstract function to($email, $name);
    abstract function isHtml($isHtml = true);
    abstract function subject($subject);
    abstract function message($message, $DoesNotSupportHtmlMessage);
    abstract function send();
}