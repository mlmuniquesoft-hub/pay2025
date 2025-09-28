<?php
	session_start();
	require_once '../../db/db.php';
	require_once '../../db/functions.php';
	$Accv=$_GET['Asd'];
	$receiveID=$_POST['receiveID'];
	$amount=$_POST['amount'];
	$TransCode=$_POST['TransCode'];
	$user=$_SESSION['roboMember'];

	$rett=array();
	if($receiveID==''){
		$rett['sts']=0;
		$rett['mess']="Submit Receiver ID";
		die(json_encode($rett));
	}
	
	if($TransCode==''){
		$rett['sts']=0;
		$rett['mess']="Submit Transaction Code";
		die(json_encode($rett));
	}
	
	
	
	$kjhgd=$mysqli->query("SELECT * FROM `member` WHERE `user`='".$user."' AND `pin`='".$TransCode."'");
	//$rett['df']="SELECT * FROM `member` WHERE `user`='".$user."' AND `pin`='".$TransCode."'";
	$CheckUs=mysqli_num_rows($kjhgd);
	if($CheckUs>0){
		
		$hgfs=$mysqli->query("SELECT * FROM `auth_set` WHERE `user`='".$user."' AND `active`='1'");
		$kjhfgf=mysqli_num_rows($hgfs);
		if($kjhfgf>0){
			$rett['sts']=1;
			$rett['mess']="Submit Your Authenticator Code";
			die(json_encode($rett));
		}else{
			$Infsdf=mysqli_fetch_assoc($kjhgd);
			$ProfileInfo=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$Infsdf['log_user']."' OR `user`='".$user."'"));
			$name=$ProfileInfo['name'];
			$to=$ProfileInfo['email'];
			$code=str_shuffle(substr(time(),3));
			$message="
			<!DOCTYPE html>
			<html lang='en'>
			<head>
				<meta charset='UTF-8'>
				<meta name='viewport' content='width=device-width, initial-scale=1.0'>
				<title>Capitol Money Pay - Transaction Verification</title>
			</head>
			<body style='margin:0; padding:0; font-family: Arial, sans-serif; background-color: #f4f4f4;'>
				<div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);'>
					
					<!-- Header with Logo -->
					<div style='background: linear-gradient(135deg, #DC2626, #EF4444); padding: 30px; text-align: center;'>
						<img src='https://capitolmoneypay.com/assets/images/cmp-logo.svg' alt='Capitol Money Pay' style='height: 60px; width: auto; margin-bottom: 20px;'>
						<h1 style='color: #ffffff; margin: 0; font-size: 28px; font-weight: bold;'>Security Verification</h1>
						<p style='color: #E5E7EB; margin: 10px 0 0 0; font-size: 16px;'>Transaction Authorization Required</p>
					</div>
					
					<!-- Content Body -->
					<div style='padding: 40px 30px;'>
						<h2 style='color: #1F2937; font-size: 24px; margin: 0 0 20px 0;'>Hello $name,</h2>
						
						<div style='background-color: #FEF2F2; border-left: 4px solid #EF4444; padding: 20px; margin: 20px 0; border-radius: 5px;'>
							<p style='margin: 0; color: #DC2626; font-size: 16px; font-weight: 500;'>
								🔐 <strong>Security Alert:</strong> Someone is trying to commit a transaction from your account.
							</p>
						</div>
						
						<div style='background-color: #F3F4F6; padding: 20px; border-radius: 8px; margin: 20px 0;'>
							<h3 style='color: #374151; margin: 0 0 15px 0; font-size: 18px;'>Transaction Details:</h3>
							<table style='width: 100%; border-collapse: collapse;'>
								<tr>
									<td style='padding: 8px 0; color: #6B7280; font-weight: 500;'>From Account:</td>
									<td style='padding: 8px 0; color: #DC2626; font-weight: bold;'>$user</td>
								</tr>
								<tr>
									<td style='padding: 8px 0; color: #6B7280; font-weight: 500;'>To Account:</td>
									<td style='padding: 8px 0; color: #DC2626; font-weight: bold;'>$receiveID</td>
								</tr>
							</table>
						</div>
						
						<p style='color: #4B5563; line-height: 1.6; font-size: 16px; margin: 25px 0;'>
							We need to verify that this is you. Please use the verification code below to confirm this transaction:
						</p>
						
						<!-- Verification Code -->
						<div style='text-align: center; margin: 30px 0;'>
							<div style='display: inline-block; 
									   background: linear-gradient(135deg, #10B981, #059669); 
									   color: #ffffff; 
									   padding: 20px 40px; 
									   border-radius: 12px; 
									   font-size: 32px; 
									   font-weight: bold;
									   letter-spacing: 3px;
									   box-shadow: 0 4px 6px rgba(0,0,0,0.1);
									   font-family: monospace;'>
								$code
							</div>
						</div>
						
						<div style='background-color: #FEF3C7; border: 1px solid #F59E0B; padding: 15px; border-radius: 6px; margin: 25px 0;'>
							<p style='margin: 0; color: #92400E; font-size: 14px;'>
								⏰ <strong>Important:</strong> This code is valid only for a few hours. Please use it promptly.
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
					</div>
				</div>
			</body>
			</html>";
			$subject="🔐 Capitol Money Pay - Transaction Security Code";
			$from = "info@capitolmoneypay.com";
			$headers = "From:" . $from . "\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
			$headers .= "From: Capitol Money Pay Security <info@capitolmoneypay.com>" . "\r\n";
			$headers .= "Reply-To: support@capitolmoneypay.com" . "\r\n";
			mail($to,$subject,$message,$headers);
			$_SESSION['LogCode']=$code;
			$rett['sts']=1;
			$rett['mess']="Transaction Verify Code Send To Your Mail ($to)";
			die(json_encode($rett));
		}
	}else{
		$rett['sts']=0;
		$rett['mess']="Invalid Transaction Code";
		die(json_encode($rett));
	}

?>