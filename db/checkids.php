<?php
	session_start();
	$timing_start = explode(' ', microtime());
	error_reporting(-1);
	set_time_limit(0);
	ini_set('memory_limit','4096M');
	$_SESSION['token']='12345gh';	
	require 'db.php';
	require 'functions.php';
	
$timert=time();
$eamilList=array();
	$jkdhf=$mysqli->query("SELECT * FROM `member`");
	while($jkss=mysqli_fetch_assoc($jkdhf)){
		$message="<p>New Crypto Trade System Is Upgrading 
So You May Face Some Trouble, 
We Are Sorry For That.</p>
<small>Thanks To All</small>";
		$mysqli->query("INSERT INTO `message2`( `ticket_id`, `user_id`, `message`) VALUES ('".$timert."','".$jkss['log_user']."','".$message."')");
		//$mysqli->query("DELETE FROM `message2` WHERE `user_id`='".$jkss['user']."' ORDER BY `serial` DESC LIMIT 1");
		$jhdjfk=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$jkss['log_user']."'"));
		if(!in_array($jhdjfk['email'],$eamilList)){
			array_push($eamilList,$jhdjfk['email']);
			$to=$jhdjfk['email'];
			$userName = $jhdjfk['name'];
			$emailMessage="
			<!DOCTYPE html>
			<html lang='en'>
			<head>
				<meta charset='UTF-8'>
				<meta name='viewport' content='width=device-width, initial-scale=1.0'>
				<title>Capitol Money Pay - System Upgrade</title>
			</head>
			<body style='margin:0; padding:0; font-family: Arial, sans-serif; background-color: #f4f4f4;'>
				<div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);'>
					
					<!-- Header with Logo -->
					<div style='background: linear-gradient(135deg, #1E3A8A, #3B82F6); padding: 30px; text-align: center;'>
						<img src='https://capitolmoneypay.com/assets/images/cmp-logo.svg' alt='Capitol Money Pay' style='height: 60px; width: auto; margin-bottom: 20px;'>
						<h1 style='color: #ffffff; margin: 0; font-size: 28px; font-weight: bold;'>System Upgrade</h1>
						<p style='color: #E5E7EB; margin: 10px 0 0 0; font-size: 16px;'>Important System Notification</p>
					</div>
					
					<!-- Content Body -->
					<div style='padding: 40px 30px;'>
						<h2 style='color: #1F2937; font-size: 24px; margin: 0 0 20px 0;'>Dear $userName,</h2>
						
						<div style='background-color: #EFF6FF; border-left: 4px solid #3B82F6; padding: 20px; margin: 20px 0; border-radius: 5px;'>
							<div style='color: #1E40AF; font-size: 16px; line-height: 1.6;'>
								$message
							</div>
						</div>
					</div>
					
					<!-- Footer -->
					<div style='background-color: #F9FAFB; padding: 30px; text-align: center; border-top: 1px solid #E5E7EB;'>
						<img src='https://capitolmoneypay.com/assets/images/logos/cmp-logo-small.svg' alt='CMP' style='height: 30px; width: auto; margin-bottom: 15px;'>
						<p style='color: #6B7280; margin: 0 0 10px 0; font-size: 14px;'>
							Thanks by <strong style='color: #1F2937;'>Capitol Money Pay Team</strong>
						</p>
						<p style='color: #9CA3AF; margin: 0; font-size: 12px;'>
							Need help? Contact us at 
							<a href='mailto:support@capitolmoneypay.com' style='color: #3B82F6; text-decoration: none;'>support@capitolmoneypay.com</a>
						</p>
					</div>
				</div>
			</body>
			</html>";
			$subject="🔔 Capitol Money Pay - System Upgrade Notification";
			$from = "info@capitolmoneypay.com";
			$headers = "From:" . $from . "\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
			$headers .= "From: Capitol Money Pay System <info@capitolmoneypay.com>" . "\r\n";
			$headers .= "Reply-To: support@capitolmoneypay.com" . "\r\n";
			mail($to,$subject,$emailMessage,$headers);
		}
		
	}
?>