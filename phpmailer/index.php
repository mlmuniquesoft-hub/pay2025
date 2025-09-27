<?php
require("vendor/autoload.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$mail = new PHPMailer(true);                            
try {
    //Server settings
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 3; 
    $mail->CharSet  = 'UTF-8';
    $mail->Host = 'localhost';
    $mail->Port = 25;
    $mail->SMTPSecure = 'tls'; 
    $mail->SMTPOptions = array(
	   'ssl' => array(
	   'verify_peer' => false,
	   'verify_peer_name' => false,
	   'allow_self_signed' => true
	  )
	);
    $mail->SMTPAuth = true;
    $mail->Username = 'info@capitolmoneypay.com';
    $mail->Password = 'Mm123678@#';
    $mail->setFrom('info@capitolmoneypay.com', 'Name Surname');
    $mail->addAddress('mainur22@gmail.com', 'Name Surname');
    $mail->Subject = 'Email subject';
    $mail->msgHTML('Email content with <strong>html</strong>');
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Message sent!";
    }

        echo 'Message has been sent';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
	}