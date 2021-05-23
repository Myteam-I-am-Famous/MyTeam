<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Instantiation and passing `true` enables exceptions

sendVerificationMail('abdoudu78130@gmail.com', '1234');

function sendVerificationMail($to, $code)
{
    $mail = new PHPMailer(true);

try{
    $mail->isSMTP();
    $mail->SMTPAuth = false;
    $mail->SMTPSecure = false;
    $mail->SMTPAutoTLS = false;

    $mail->Host = 'localhost';
    $mail->Port = 25;

    $mail->isHTML(true);
    $mail->SetFrom('no-reply@myteam.fr','[MyTeam]');
    $mail->Subject = "Confirmation d'inscription";
    $mail->Body = 'Votre code de vérification est :' . $code;
    $mail->CharSet = 'utf-8';

    $mail->AddAddress($to);

    $mail->Send();
    echo 'Mail sent';
}catch(Exception $e) {
    echo 'Message could not be sent. Mail Error: ' . $mail->ErrorInfo;
}
}
