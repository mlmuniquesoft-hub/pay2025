<?php
	session_start();
	require_once '../../db/db.php';
	require_once '../../db/functions.php';
	require_once '../../phpmailer/vendor/autoload.php';
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	$timezone = "Pacific/Auckland"; // Asia/Dacca
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);	
	$Invoice=$_POST['Asd'];
	$Pacsdf=explode("/", base64_decode($_POST['AccF']));
	$customAmount = isset($_POST['customAmount']) ? floatval($_POST['customAmount']) : 0;
	
	$date=date("Y-m-d");
	
	$TransCode=$_POST['code'];
	$user=$_SESSION['roboMember'];

	$rett=array();
	
	// Validate custom amount
	if($customAmount < 100) {
		$rett['sts']=0;
		$rett['mess']="Minimum investment amount is $100";
		die(json_encode($rett));
	}
	
	if($TransCode==''){
		$rett['sts']=0;
		$rett['mess']="Submit Transaction Code";
		die(json_encode($rett));
	}
	
	$kjhgd=$mysqli->query("SELECT * FROM `member` WHERE `user`='".$user."' AND `pin`='".$TransCode."'");
	
	$CheckUs=mysqli_num_rows($kjhgd);
	if($CheckUs>0){
		// Use custom amount instead of predefined package
		$investmentAmount = $customAmount;
		$activationFee = 10;
		$totalRequired = $investmentAmount + $activationFee;
		
		$MemberInfo=mysqli_fetch_assoc($kjhgd);
		
		// Check if user already has an active investment
		$existingInvestment = mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) as total_invested FROM `upgrade` WHERE `user`='".$user."'"));
		if($existingInvestment['total_invested'] > 0) {
			$rett['sts']=0;
			$rett['mess']="You already have an active investment. Multiple investments not allowed.";
			die(json_encode($rett));
		}
		
		$dfgKKj=remainAmn($user);
		
		if($totalRequired > $dfgKKj){
			$rett['sts']=0;
			$rett['mess']="Insufficient Fund. Required: $".number_format($totalRequired, 2)." | Available: $".number_format($dfgKKj, 2);
			die(json_encode($rett));
		}
		$Chhfgd=count($rett);
		if($Chhfgd==0){
			// Calculate returns based on investment range
			$dailyRate = 0;
			$packageName = "";
			if($investmentAmount >= 100 && $investmentAmount <= 999) {
				$dailyRate = 0.5;
				$packageName = "Basic Package";
			} elseif($investmentAmount >= 1000 && $investmentAmount <= 4999) {
				$dailyRate = 0.7;
				$packageName = "Premium Package";
			} else {
				$dailyRate = 1.0;
				$packageName = "VIP Package";
			}

			// Calculate sponsor bonus (10% of investment amount)
			$SponsorBonus = ($investmentAmount * 0.10);
			$Shopping = ($investmentAmount * 0.00); // 0% shopping bonus
			
			$ActivaDate=date("Y-m-d H:i:s");
			
			// Insert upgrade record
			$mysqli->query("INSERT INTO `upgrade`( `user`, `package`, `amount`, `bonus`, `shopping`, `sponsor`, `upline`, `invoice`, `charge`, `date`) VALUES ('".$user."','".$packageName."','".$investmentAmount."','".$SponsorBonus."','".$Shopping."','".$MemberInfo['sponsor']."','".$MemberInfo['upline']."','".$Invoice."','".$activationFee."','".$ActivaDate."')");
			
			// Update member status
			$mysqli->query("UPDATE `member` SET `paid`='1',`pack`='1' WHERE `user`='".$user."'");
			
			// Add sponsor bonus to sponsor's account
			$description="$".number_format($SponsorBonus, 2)." Sponsor Bonus from ".$user." (".$packageName.")";
			$mysqli->query("INSERT INTO `view`(`user`, `date`, `description`, `amount`, `types`) VALUES ('".$MemberInfo['sponsor']."', '".$date."', '".$description."', '".$SponsorBonus."','credit')");
			
			// Add debit record for user
			$description="$".number_format($investmentAmount, 2)." ".$packageName." Investment + $".number_format($activationFee, 2)." Activation Fee";
			$mysqli->query("INSERT INTO `view`(`user`, `date`, `description`, `amount`, `types`) VALUES ('".$user."', '".$date."', '".$description."', '".$totalRequired."','debit')");
			
			
			$ProfileInfo=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$MemberInfo['log_user']."' OR `user`='".$user."'"));
			$name=$ProfileInfo['name'];
			$to=$ProfileInfo['email'];
			$code=str_shuffle(substr(time(),3));
			
			// Send confirmation email using PHPMailer
			$mail = new PHPMailer(true);
			try {
				$mail->isSMTP();
				$mail->CharSet = 'UTF-8';
				$mail->Host = 'localhost';
				$mail->Port = 25;
				$mail->SMTPSecure = 'tls';
				$mail->SMTPAuth = true;
				$mail->Username = 'info@capitolmoneypay.com';
				$mail->Password = 'Mm123678@#';
				
				$mail->setFrom('info@capitolmoneypay.com', 'Capitol Money Pay');
				$mail->addAddress($to, $name);
				$mail->addReplyTo('support@capitolmoneypay.com', 'Capitol Money Pay Support');
				
				$mail->isHTML(true);
				$mail->Subject = "🎉 Investment Activated Successfully - Capitol Money Pay";
				$mail->Body = "
				<html>
				<body style='font-family: Arial, sans-serif; background-color: #f4f4f6; margin: 0; padding: 20px;'>
					<div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);'>
						<div style='background: linear-gradient(135deg, #1e3a8a, #3b82f6); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0;'>
							<h1 style='margin: 0; font-size: 28px;'>🎉 Investment Activated!</h1>
							<p style='margin: 10px 0 0 0; opacity: 0.9;'>Welcome to Capitol Money Pay</p>
						</div>
						<div style='padding: 30px;'>
							<h2 style='color: #1f2937; margin-top: 0;'>Hello $name,</h2>
							<p style='color: #374151; line-height: 1.6;'>Congratulations! Your investment has been successfully activated.</p>
							
							<div style='background: #f0f9ff; border-left: 4px solid #3b82f6; padding: 20px; margin: 20px 0; border-radius: 5px;'>
								<h3 style='margin: 0 0 15px 0; color: #1e40af;'>Investment Details:</h3>
								<table style='width: 100%;'>
									<tr><td><strong>Plan:</strong></td><td>$packageName</td></tr>
									<tr><td><strong>Investment:</strong></td><td>$".number_format($investmentAmount, 2)."</td></tr>
									<tr><td><strong>Activation Fee:</strong></td><td>$".number_format($activationFee, 2)."</td></tr>
									<tr><td><strong>Daily Rate:</strong></td><td>$dailyRate% (Mon-Fri)</td></tr>
									<tr><td><strong>Daily Return:</strong></td><td>$".number_format($investmentAmount * $dailyRate / 100, 2)."</td></tr>
								</table>
							</div>
							
							<p style='color: #374151;'>Your investment will start generating returns from the next business day. Returns are credited Monday through Friday.</p>
							<p style='color: #059669; font-weight: bold;'>Thank you for choosing Capitol Money Pay!</p>
						</div>
						<div style='background: #f9fafb; padding: 20px; text-align: center; border-radius: 0 0 10px 10px; border-top: 1px solid #e5e7eb;'>
							<p style='margin: 0; color: #6b7280; font-size: 14px;'>Capitol Money Pay Team</p>
							<p style='margin: 5px 0 0 0; color: #9ca3af; font-size: 12px;'>support@capitolmoneypay.com</p>
						</div>
					</div>
				</body>
				</html>";
				
				$mail->send();
			} catch (Exception $e) {
				// Log error but don't fail the transaction
			}
			
			$rett['sts']=1;
			$rett['mess']="🎉 Investment activated successfully! You invested $".number_format($investmentAmount, 2)." in the $packageName with $dailyRate% daily returns.";
			die(json_encode($rett));
		}else{
			$rett['sts']=0;
			$rett['mess']="Transaction processing failed. Please try again.";
			die(json_encode($rett));
		}
	}else{
		$rett['sts']=0;
		$rett['mess']="Invalid Transaction Code";
		die(json_encode($rett));
	}

?>