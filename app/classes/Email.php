<?php

namespace app\classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class Email
{

    public function send($name, $email, $subject, $content)
    {

        $mail = new PHPMailer(true);

        try {
       
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER; 
            $mail->isSMTP();                                               
            $mail->Host = $_ENV['MAIL_HOST'];                    
            $mail->SMTPAuth = $_ENV['MAIL_SMTP_AUTH'];
            $mail->CharSet = $_ENV['MAIL_CHARSET'];                                
            $mail->Username = $_ENV['MAIL_USERNAME'];                    
            $mail->Password = $_ENV['MAIL_PASSWORD'];                               
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           
            $mail->Port = $_ENV['MAIL_PORT'];                                    

            $mail->setFrom($email, $name);
            $mail->addAddress('erisvaldosilvadesousa38@gmail.com', 'Erisvaldo');   

            $mail->isHTML(true);                                  
            $mail->Subject = $subject;
            $mail->Body    = $content;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            return $mail->send();

        } catch (Exception) {
             echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    }

    // Antigo

    // protected $mail;

    // protected function config()
    // {

    //     $this->mail = new PHPMailer(true);

    //     $this->mail->host = $_ENV['MAIL_HOST'];
    //     $this->mail->username = $_ENV['MAIL_USERNAME'];
    //     $this->mail->password = $_ENV['MAIL_PASSWORD'];
    //     $this->mail->port = intval($_ENV['MAIL_PORT']);
    //     $this->mail->CharSet = $_ENV['MAIL_CHARSET'];
    //     $this->mail->SMTPAuth = $_ENV['MAIL_SMTP_AUTH'];
    //     $this->mail->SMTPSecure = $_ENV['MAIL_SECURE'];

    //     $this->mail->isSMTP();
    //     $this->mail->isHTML(true);
    // }

    // protected function send(array|object $setFrom = ['name' => '', 'email' => ''], string $subject, string $content)
    // {

    //     try {

    //         $name =  $setFrom['name'];
    //         $email =  $setFrom['email'];

    //         $this->config();

    //         $this->mail->setFrom($setFrom['email'], $setFrom['name']); 
    //         $this->mail->addAddress('erisvaldosilvadesousa61@gmail.com'); 

    //         $this->mail->Subject = $subject;
    //         $this->mail->Body    = $content;
    //         $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    //         dd('oii');

    //         return $this->mail->send();

    //     } catch (PHPMailerException) {
    //         echo "<span> Oops, some error occurred {$this->mail->ErrorInfo} </span>";
    //     }
    // }
}
