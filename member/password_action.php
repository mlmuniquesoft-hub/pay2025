<?php
    session_start(); 
    if(!isset($_SESSION['roboMember'])){
    	header("Location:logout.php");
    	exit();
    }else{
		require '../db/db.php';
		$memberid=$_SESSION['roboMember'];
		$oldPassword = $_POST["oldPassword"];
		$newPassword1 = $_POST["newPassword1"];
		$newPassword2 = $_POST["newPassword2"];	
		$location = $_POST["location"];	
		$mpass =md5($oldPassword);
		$newpass =md5($newPassword1);
		
		$check_pass=strlen($newPassword1);
		if($check_pass<=5){
			$_SESSION['msg']="Enter At Least 6 Character Password";
			header("Location:$location");
			exit();
		}
		
		if($newPassword1==$newPassword2){
			$query = "select user,password from member where user='".$memberid."' and password='".$mpass."' ";
			$result=$mysqli->query($query);
			$row = mysqli_fetch_array($result);
			$check = mysqli_num_rows($result);		
			if(($check==1)&&($newPassword1!='')){
				$q="UPDATE `member` SET `password`='".$newpass."' WHERE `user`='".$memberid."'";
				$mysqli->query($q);
				$query2 = "select * from `profile` where `user`='".$memberid."' ";
				$result2=$mysqli->query($query2);
				$row2 = mysqli_fetch_array($result2);
				$to=$row2['email'];
				$userName = $row2['name'];
				$date0=date("Y-m-d");
				$message = "
				<!DOCTYPE html>
				<html lang='en'>
				<head>
					<meta charset='UTF-8'>
					<meta name='viewport' content='width=device-width, initial-scale=1.0'>
					<title>Capitol Money Pay - Password Changed</title>
				</head>
				<body style='margin:0; padding:0; font-family: Arial, sans-serif; background-color: #f4f4f4;'>
					<div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);'>
						
						<!-- Header with Logo -->
						<div style='background: linear-gradient(135deg, #059669, #10B981); padding: 30px; text-align: center;'>
							<img src='https://capitolmoneypay.com/assets/images/cmp-logo.svg' alt='Capitol Money Pay' style='height: 60px; width: auto; margin-bottom: 20px;'>
							<h1 style='color: #ffffff; margin: 0; font-size: 28px; font-weight: bold;'>Password Changed</h1>
							<p style='color: #E5E7EB; margin: 10px 0 0 0; font-size: 16px;'>Security Update Successful</p>
						</div>
						
						<!-- Content Body -->
						<div style='padding: 40px 30px;'>
							<h2 style='color: #1F2937; font-size: 24px; margin: 0 0 20px 0;'>Hello $userName,</h2>
							
							<div style='background-color: #ECFDF5; border-left: 4px solid #10B981; padding: 20px; margin: 20px 0; border-radius: 5px;'>
								<p style='margin: 0; color: #065F46; font-size: 16px; font-weight: 500;'>
									✅ <strong>Success!</strong> Your login password has been changed successfully.
								</p>
							</div>
							
							<div style='background-color: #F3F4F6; padding: 20px; border-radius: 8px; margin: 20px 0;'>
								<h3 style='color: #374151; margin: 0 0 15px 0; font-size: 18px;'>Change Details:</h3>
								<table style='width: 100%; border-collapse: collapse;'>
									<tr>
										<td style='padding: 8px 0; color: #6B7280; font-weight: 500;'>New Password:</td>
										<td style='padding: 8px 0; color: #1F2937; font-family: monospace; background: #F9FAFB; padding: 5px; border-radius: 4px;'>$newPassword1</td>
									</tr>
									<tr>
										<td style='padding: 8px 0; color: #6B7280; font-weight: 500;'>Changed Date:</td>
										<td style='padding: 8px 0; color: #1F2937;'>$date0</td>
									</tr>
								</table>
							</div>
							
							<div style='background-color: #FEF3C7; border: 1px solid #F59E0B; padding: 15px; border-radius: 6px; margin: 25px 0;'>
								<p style='margin: 0; color: #92400E; font-size: 14px;'>
									🔒 <strong>Security Tip:</strong> Keep your new password safe and don't share it with anyone.
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
				
				$subject="🔐 Capitol Money Pay - Password Changed Successfully";
				$from = "info@capitolmoneypay.com";
				$headers = "From:" . $from . "\r\n";
				$headers .= 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
				$headers .= 'From: Capitol Money Pay Security <info@capitolmoneypay.com>' . "\r\n";
				$headers .= "Reply-To: support@capitolmoneypay.com" . "\r\n";
				mail($to,$subject,$message,$headers);

				$_SESSION['msg1'] = "Your Login Password Has Been Changed";       
				header("Location:$location");
				exit;
			}else{
				$_SESSION['msg'] = "Invalid / Blank Current Password !!!";
				header("Location:$location");
				exit;
			}
		}else{
			$_SESSION['msg'] = "Both New Password Does Not Match";
			header("Location:$location");
			exit;				
		}  	

	}
?>