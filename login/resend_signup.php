<?php
	require_once '../phpmailer/vendor/autoload.php';
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	
	$user0=strtoupper($_GET['user']);
	$to=$_GET['email'];
	$name0=strtoupper($_GET['name']);

	include("mail2.php");
	$message=$message;
	$from = "info@capitolmoneypay.com";
	
	$subject = "Thanks for Sign up Process ";
	$mail = new PHPMailer;
	$mail->isSMTP();
	//$mail->SMTPDebug = 3; 
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
	$mail->Username = $from;
	$mail->Password = 'Mm123678@#';
	$mail->setFrom($from, 'NZ Robo Trade ');
	$mail->addAddress($to, $name0);
	$mail->Subject = $subject;
	$mail->msgHTML($message);
	if($mail->send()){
		$rett['url']='#';
		$rett['sts']='success';
		$rett['mess']="Please Verify Your Mail <span id='countr'></span>";
		die(json_encode($rett));
	}else{
		$rett['sts']='error';
		$rett['mess']="Invalid Mail";
		die(json_encode($rett));
	}
	
?>