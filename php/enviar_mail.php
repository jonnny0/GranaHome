<?php

require_once ("../php/phpmailer/class.phpmailer.php");
require_once ("../php/phpmailer/class.smtp.php");

function enviarMail($receptor, $asunto, $mensaje) {

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->CharSet = 'UTF-8';
    $mail->SMTPAuth = 'true';
    $mail->SMTPSecure = 'ssl';
    $mail->SMTPKeepAlive = true;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->IsHTML(true);

    $mail->Username = "granahome@gmail.com";
    $mail->Password = "dgp_2015";
    $mail->SingleTo = true;

    $from = 'granahome@gmail.com';
    $fromname = 'Alojamientos GranaHome';
    $subject = $asunto;
    $message = $mensaje;
    $headers = "From: $from\n";
    $headers .= "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/html; charset=UTF-8\n";

    $mail->From = $from;
    $mail->FromName = $fromname;

    $mail->AddAddress($receptor);

    $mail->Subject = $subject;
    $mail->Body = $message;

    $options = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $mail->smtpConnect($options);

    if (!$mail->Send()) {
        return false;
    } else {
        return true;
    }
}

?>
