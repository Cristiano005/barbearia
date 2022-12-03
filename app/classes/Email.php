<?php

namespace app\classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

abstract class Email {

    public function __construct(protected $mailer = new PHPMailer(true)) { 

        if($_ENV['MAIL_SMTP_DEBUG']) {
            $mailer->SMTPDebug = SMTP::DEBUG_SERVER;
        }

        if($_ENV['MAIL_IS_SMTP']) {
            $mailer->isSMTP();
        }

        $mailer->Host = $_ENV['MAIL_HOST'];
        $mailer->username = $_ENV['MAIL_USERNAME'];
        $mailer->password = $_ENV['MAIL_PASSWORD'];
        $mailer->port = intval($_ENV['MAIL_PORT']);
        $mailer->CharSet = $_ENV['MAIL_CHARSET'];
        $mailer->SMTPAuth = $_ENV['MAIL_SMTP_AUTH'];
        $mailer->SMTPSecure = $_ENV['MAIL_SECURE'];
    }
 
    abstract function send();
}


        // <<<HTML

        //     <p>Olá {$this->nameTo}</p>
        //     <p>Você pediu para redefinir sua senha do site tal, clique no link abaixo</p>
        //     <p><a href="http://localhost:8000/password/redefine/{$token}">Redefinir sua senha</a></p>

        // HTML;