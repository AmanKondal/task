<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

function sendEmail($email, $token)
{
    $mail = new PHPMailer(true);
    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->SMTPAuth = true;
        $mail->Username = "amandavid9956@gmail.com";
        $mail->Password = "athi gbhj zguq oroa";
        // Sender and recipient settings
        $mail->setFrom('amandavid9956@gmail.com');
        $mail->addAddress($email);
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'passwordReset';
        $mail->Body    = "Click <a href='http://localhost/php-Pratice/twig/controler/newPassword.php?token=$token'>here</a> to reset your password.";

        $mail->send();
        return 1;
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }

}
