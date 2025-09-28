<?php
	session_start();
	require_once("../../db/db.php");
	require_once("../../db/functions.php");
	require_once("../../phpmailer/vendor/autoload.php");
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	$rett=array();
	if(isset($_GET['req'])){
		$userID=$_GET['req'];
	}else{
		$userID=$_SESSION['roboMember'];
	}
	$userID=strtolower($userID);
	// $jhdfg=mysqli_num_rows($mysqli->query("SELECT * FROM `member` WHERE `user`='".$userID."' AND `pack`>'0'"));
	// if($jhdfg<1){
	// 	array_push($rett,0);
	// 	array_push($rett,"Please, Purchase One Bot & Try Again.");
	// 	echo json_encode($rett);
	// 	die();
	// }
	
	// $urtye="power";
	// $iiuu=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member_total` WHERE `user`='".$urtye."'"));
	// $leftall=explode(",", strtolower($iiuu['totalLeftId']));
	// $rightall=explode(",", strtolower($iiuu['totalrightId']));
	// $ttt=array_merge($leftall,$rightall);
	// if(!in_array($userID,$ttt)){
	// 	array_push($rett,0);
	// 	array_push($rett,"Sorry For Inconvenience, Withdrawal Process Is Under Construction. Advance Phase Appearing Soon.");
	// 	echo json_encode($rett);
	// 	die();
	// }
	
	
	// $SuspendUser=array("bdboss01","bdboss02","bdboss03","bdboss04","bdboss05","bdboss06","bdboss07","bdboss08","murad","rural","haider01","aileronbd","airwing","rangpurbd","kingbd");
	// $Chedfg=strtolower($userID);
	// if(in_array($Chedfg,$SuspendUser)){
	// 	array_push($rett,0);
	// 	array_push($rett,"Withdrawal System Upgrading....., Try Later");
	// 	echo json_encode($rett);
	// 	die();
	// }
	
	
	// $ghfdhs=date("D");
	// if($ghfdhs=='Mon'){
	// 	array_push($rett,0);
	// 	array_push($rett,"Withdrawal Request Received From Sunday To Tuesday, Which Will Be Paid On Monday");
	// 	echo json_encode($rett);
	// 	die();
	// }
	
	$AssIgnTo=$_GET['AssIgnTo'];
	$curencyAmn=$_GET['curencyAmn'];
	$method=$_GET['method'];
	$WithdrawType=$_GET['type'];
	$NumberOfToken=$_GET['NumberOfToken'];
	//$mysqli=$mysqli;
	$date=date("Y-m-d");
	$BalanceSts=remainAmn($userID);//ReaminBalance($userID, $mysqli,$mysqli,1);
	$remark="";
	$comm="";
	
	if($WithdrawType=="withdraw"){
		$TransType="Withdraw";
	}else{
		$TransType="Transfer";
	}
	
	// Commented out withdraw_cons check as table doesn't exist
	// $HJGF=$mysqli->query("SELECT * FROM `withdraw_cons` WHERE `active`='1' AND (`trns_type`='".$TransType."' OR `trns_type`='Both')");
	// $ChecjK=mysqli_num_rows($HJGF);
	// if($ChecjK>0){
	// 	$mfgfd=mysqli_fetch_assoc($HJGF);
	// 	array_push($rett, 0);
	// 	array_push($rett, $mfgfd['mess']);
	// 	echo json_encode($rett);
	// 	die();
	// }
	
	if($AssIgnTo==''){
		array_push($rett, 0);
		if($WithdrawType=="withdraw"){
			array_push($rett, "Submit Wallet ID");
		}else{
			array_push($rett, "Submit Donor ID");
		}
		echo json_encode($rett);
		die();
	}
	if($NumberOfToken==''){
		array_push($rett, 0);
		array_push($rett, "Submit $TransType Amount");
		echo json_encode($rett);
		die();
	}
	
	
	if($NumberOfToken>$BalanceSts){
		array_push($rett, 0);
		array_push($rett, "Insufficient Balance ");
		echo json_encode($rett);
		die();
	}
	//var_dump($NumberOfToken);
	if($NumberOfToken<10){
		array_push($rett,0);
		array_push($rett,"Minimum $10");
		echo json_encode($rett);
		die();
	}
	
	if($NumberOfToken>500){
		array_push($rett,0);
		array_push($rett,"Maximum $500");
		echo json_encode($rett);
		die();
	}
	
	/*$jhgjkdf=mysqli_num_rows($mysqli->query("SELECT * FROM `trans_receive` WHERE `user_trans`='".$userID."' AND `date`='".$date."'"));
	if($jhgjkdf>1){
		array_push($rett,0);
		array_push($rett,"Todays Limit Exceed");
		echo json_encode($rett);
		die();
	}*/
	
	
	$countU=count($rett);
	if($countU==0){
		$user=$_SESSION['roboMember'];
		$hsgs=$mysqli->query("SELECT * FROM `widraw_req` WHERE `user`='".$userID."' AND `pending`='0' ORDER BY `serial` DESC LIMIT 1");
		$ChekcUI=mysqli_num_rows($hsgs);
		if($ChekcUI<1){
			if($WithdrawType=="withdraw"){
				$mmfgh=$method.": ".$AssIgnTo;
				$tax=$NumberOfToken*0.08;
				// Store withdrawal details as base64 for processing after email verification
				$reter=base64_encode("INSERT INTO trans_receive(`user_trans`,`ammount`,`tax`,`c_wallet`,date,user_receive,method,status,remark,type,account)
				VALUES ('".$userID."','".$NumberOfToken."','".$tax."','".$curencyAmn."','".$date."','Office','".$mmfgh."','Pending','".$remark."','Withdraw','Admin')");
				
			}else{
				$reter=base64_encode("INSERT INTO trans_receive(`user_trans`,`ammount`,`tax`,`comm`,date,user_receive,method,status,remark,type,account)
				VALUES ('".$userID."','".$NumberOfToken."','".$tax."','".$comm."','".$date."','".$AssIgnTo."','Transter','Complete','".$remark."','Transfer','Member')");
				
			}
			
			$mysqli->query("INSERT INTO `widraw_req`(`user`,`pending`,`withdraw_que`,`type`) VALUES ('".$userID."','0','".$reter."','".$TransType."')");
			$jfdf=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `widraw_req` WHERE `user`='".$userID."' AND `pending`='0' ORDER BY `serial` DESC LIMIT 1"));
			$serial=$jfdf['serial'];
		}else{
			$hjkd=mysqli_fetch_assoc($hsgs);
			$serial=$hjkd['serial'];
		}
		$UserInfo=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `user`='".$user."'"));
		$ProfileInfo=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$user."' OR `user`='".$UserInfo['log_user']."'"));
		$to=$ProfileInfo['email'];
		$name=$ProfileInfo['name'];
		$remainTime=strtotime("+1 hours");
		$tii1=substr(time(),0,5);
		$tii2=substr(time(),5,10);
		$key=$tii2.$user.".".$serial.$tii1;
		$Tittle=$tii2.$tii1;
		$ResetLink="?key=" . base64_encode($key."/".$remainTime);
		
		$message="
		<!DOCTYPE html>
		<html lang='en'>
		<head>
			<meta charset='UTF-8'>
			<meta name='viewport' content='width=device-width, initial-scale=1.0'>
			<title>Capitol Money Pay - Transaction Request</title>
		</head>
		<body style='margin:0; padding:0; font-family: Arial, sans-serif; background-color: #f4f4f4;'>
			<div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);'>
				
				<!-- Header with Logo -->
				<div style='background: linear-gradient(135deg, #1E3A8A, #3B82F6); padding: 30px; text-align: center;'>
					<img src='https://capitolmoneypay.com/assets/images/cmp-logo.svg' alt='Capitol Money Pay' style='height: 60px; width: auto; margin-bottom: 20px;'>
					<h1 style='color: #ffffff; margin: 0; font-size: 28px; font-weight: bold;'>Transaction Request</h1>
					<p style='color: #E5E7EB; margin: 10px 0 0 0; font-size: 16px;'>Security Verification Required</p>
				</div>
				
				<!-- Content Body -->
				<div style='padding: 40px 30px;'>
					<h2 style='color: #1F2937; font-size: 24px; margin: 0 0 20px 0;'>Hello $name,</h2>
					
					<div style='background-color: #FEF3C7; border-left: 4px solid #F59E0B; padding: 20px; margin: 20px 0; border-radius: 5px;'>
						<p style='margin: 0; color: #92400E; font-size: 16px; font-weight: 500;'>
							⚠️ <strong>Security Alert:</strong> Someone is requesting to $TransType funds from your account.
						</p>
					</div>
					
					<div style='background-color: #F3F4F6; padding: 20px; border-radius: 8px; margin: 20px 0;'>
						<h3 style='color: #374151; margin: 0 0 15px 0; font-size: 18px;'>Transaction Details:</h3>
						<table style='width: 100%; border-collapse: collapse;'>
							<tr>
								<td style='padding: 8px 0; color: #6B7280; font-weight: 500;'>Platform:</td>
								<td style='padding: 8px 0; color: #1F2937;'><a href='https://capitolmoneypay.com/' style='color: #3B82F6; text-decoration: none;'>capitolmoneypay.com</a></td>
							</tr>
							<tr>
								<td style='padding: 8px 0; color: #6B7280; font-weight: 500;'>Amount:</td>
								<td style='padding: 8px 0; color: #059669; font-weight: bold; font-size: 18px;'>$$NumberOfToken</td>
							</tr>
							<tr>
								<td style='padding: 8px 0; color: #6B7280; font-weight: 500;'>Transaction Type:</td>
								<td style='padding: 8px 0; color: #1F2937; text-transform: capitalize;'>$TransType</td>
							</tr>
						</table>
					</div>
					
					<p style='color: #4B5563; line-height: 1.6; font-size: 16px; margin: 25px 0;'>
						If you <strong>did not</strong> initiate this request, please ignore this email - no action is needed.
					</p>
					
					<p style='color: #4B5563; line-height: 1.6; font-size: 16px; margin: 25px 0;'>
						If you <strong>did</strong> initiate this transaction, please click the button below to proceed:
					</p>
					
					<!-- CTA Button -->
					<div style='text-align: center; margin: 30px 0;'>
						<a href='https://capitolmoneypay.com/update_withdraw.php$ResetLink' 
						   style='display: inline-block; 
								  background: linear-gradient(135deg, #F59E0B, #D97706); 
								  color: #ffffff; 
								  padding: 15px 40px; 
								  text-decoration: none; 
								  border-radius: 8px; 
								  font-size: 18px; 
								  font-weight: bold;
								  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
								  transition: all 0.3s ease;'>
							🔐 Verify & Proceed
						</a>
					</div>
					
					<div style='background-color: #EFF6FF; border: 1px solid #DBEAFE; padding: 15px; border-radius: 6px; margin: 25px 0;'>
						<p style='margin: 0; color: #1E40AF; font-size: 14px;'>
							⏰ <strong>Important:</strong> This verification link will expire in <strong>1 hour</strong> from the time of receipt for security reasons.
						</p>
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
					<div style='margin-top: 20px; padding-top: 15px; border-top: 1px solid #E5E7EB;'>
						<p style='color: #9CA3AF; margin: 0; font-size: 11px;'>
							© 2024 Capitol Money Pay. All rights reserved.<br>
							This is an automated security email. Please do not reply to this message.
						</p>
					</div>
				</div>
			</div>
		</body>
		</html>
		";
		// Use PHPMailer for reliable email delivery
		$mail = new PHPMailer(true);
		try {
			//Server settings
			$mail->isSMTP();
			$mail->CharSet = 'UTF-8';
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
			
			//Recipients
			$mail->setFrom('info@capitolmoneypay.com', 'Capitol Money Pay Security');
			$mail->addAddress($to, $name);
			$mail->addReplyTo('support@capitolmoneypay.com', 'Capitol Money Pay Support');
			
			//Content
			$mail->isHTML(true);
			$mail->Subject = "🔐 Capitol Money Pay - Transaction Verification Required (CF-$Tittle)";
			$mail->Body = $message;
			
			$mail->send();
			$emailStatus = "sent successfully.";
		} catch (Exception $e) {
			$emailStatus = "failed: " . $mail->ErrorInfo;
		}
		
		array_push($rett, 1);
		array_push($rett, "Confirmation Mail $emailStatus to $to, Please Confirm To Proceed");
		array_push($rett, $serial);
		echo json_encode($rett);
		die();
	}
?>