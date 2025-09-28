<?php
	session_start();
	$_SESSION['token']='123asda';
	require_once("db/db.php");
	require_once("phpmailer/vendor/autoload.php");
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	$InfoKey=explode("/", base64_decode($_GET['key']));
	$counrty=strlen($InfoKey[0]);
	$user=substr($InfoKey[0],5,$counrty-10);
	$indgfd=explode(".",$user);
	$user=trim($indgfd[0]);
	$serial=trim($indgfd[1]);
	$TimLen=strlen($InfoKey[1]);
	
	if($TimLen<10){
		echo "<script>javascript:history.back();</script>";
		die();
	}
	
	$CheckUser=mysqli_num_rows($mysqli->query("SELECT * FROM `member` WHERE `user`='".$user."'"));
	$recentTime=time();
	$LastTime=$InfoKey[1];
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Capitol Money Pay</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="https://capitolmoneypay.com/signup/fonts/material-icon/css/material-design-iconic-font.min.css">
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Main css -->
    <link rel="stylesheet" href="https://capitolmoneypay.com/signup/css/style.css">
    <link rel="stylesheet" href="https://capitolmoneypay.com/signup/css/style2.css">
    <link rel="stylesheet" href="https://capitolmoneypay.com/signup/css/jquery.ccpicker.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
</head>
<body style=" background: #fffcfc;padding:0;">
        <section class="banner_section container-fluid">
		<div class="banner_section_inr">
			<div class="container">			
				<div class="banner_top_cnt">
					<h2 class="wow fadeInUp" data-wow-delay="0.3s">Transaction Confirm</h2>
				</div>
			</div>
			<div class="container banner_main_content">
				<div class="row">
					<div class="col-md-6 offset-md-3 col-lg-4 offset-lg-4">
						<?php 
						if($recentTime <= $LastTime) {
							if($CheckUser > 0) {
						?>
						<section class="banner_btm_sec">
							<div class="row">			
								<div class="col-md-12 donor_form new_donor_form login-form" id="login-form">
									<div class="donor_form_inr">
										
										<?php
											$kdjghfd=$mysqli->query("SELECT * FROM `widraw_req` WHERE `serial`='".$serial."' ");
											$checl=mysqli_num_rows($kdjghfd);
											if($checl>0){
												$mysqli->query("UPDATE `widraw_req` SET `pending`='1' WHERE `serial`='".$serial."'");
												$hgdfd=mysqli_fetch_assoc($kdjghfd);
												if($hgdfd['type']=='mail'){
													echo '<h3 class="alert alert-success">Your Email Change Approved</h3>';
												}else{
													if($hgdfd['type']=='Withdraw'){
														$ueyuer=base64_decode($hgdfd['withdraw_que']);
														$uiyeri=explode(",",$ueyuer);
														
														$hsgf=strlen($uiyeri[11]);
														$Amount=substr($uiyeri[11],1,$hsgf-2);
														$BTScdf=$uiyeri[16];
														$NumberOfToken=$Amount*0.92;
														
														echo '<div class="alert alert-success" style="text-align: center; margin: 20px 0;">';
														echo '<h3><i class="fas fa-check-circle"></i> Withdrawal Approved Successfully!</h3>';
														echo '<p>Your withdrawal request has been verified and approved.</p>';
														echo '<p><strong>Amount:</strong> $'.$NumberOfToken.'</p>';
														echo '<p>The transaction is now pending admin payment.</p>';
														echo '</div>';
														
														$user=$hgdfd['user'];
														$jkdfhd=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `user`='".$user."'"));
														$jkdfhd2=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$jkdfhd['log_user']."' OR `user`='".$user."'"));
														$name=$jkdfhd2['name'];
														$mobile=$jkdfhd2['mobile'];
														$email=$jkdfhd2['email'];
														$datrsd=date("d-F-Y");
														
														$urtye="power";
														$iiuu=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member_total` WHERE `user`='".$urtye."'"));
														$leftall=explode(",", strtolower($iiuu['totalLeftId']));
														$rightall=explode(",", strtolower($iiuu['totalrightId']));
														$ttt=array_merge($leftall,$rightall);
														$mailSend='';
														$Chedfg=strtolower($user);
														if(in_array($Chedfg,$leftall)){
															$mailSend="naharul";
														}elseif(in_array($Chedfg,$rightall)){
															$mailSend="ashraful";
														}
														$to2='';
														if($mailSend!=''){
															$Infgg=mysqli_fetch_assoc($mysqli->query("SELECT `user`,`log_user` FROM `member` WHERE `user`='".$mailSend."'"));
															$InfggMail=mysqli_fetch_assoc($mysqli->query("SELECT `email` FROM `profile` WHERE `user`='".$Infgg['log_user']."' OR `user`='".$mailSend."'"));
															$to2=$InfggMail['email'];
														}
														
												$message="
												<!DOCTYPE html>
												<html lang='en'>
												<head>
													<meta charset='UTF-8'>
													<meta name='viewport' content='width=device-width, initial-scale=1.0'>
													<title>Capitol Money Pay - Admin Notification</title>
												</head>
												<body style='margin:0; padding:0; font-family: Arial, sans-serif; background-color: #f4f4f4;'>
													<div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);'>
														
														<!-- Header -->
														<div style='background: linear-gradient(135deg, #DC2626, #EF4444); padding: 30px; text-align: center;'>
															<img src='https://capitolmoneypay.com/assets/images/cmp-logo.svg' alt='Capitol Money Pay' style='height: 50px; width: auto; margin-bottom: 15px;'>
															<h1 style='color: #ffffff; margin: 0; font-size: 24px; font-weight: bold;'>New Withdrawal Request</h1>
															<p style='color: #E5E7EB; margin: 10px 0 0 0; font-size: 14px;'>Admin Notification</p>
														</div>
														
														<!-- Content -->
														<div style='padding: 30px;'>
															<h2 style='color: #1F2937; font-size: 20px; margin: 0 0 20px 0;'>Withdrawal Request Details</h2>
															
															<div style='background-color: #F3F4F6; padding: 20px; border-radius: 8px; margin: 20px 0;'>
																<table style='width: 100%; border-collapse: collapse;'>
																	<tr>
																		<td style='padding: 8px 0; color: #6B7280; font-weight: 500;'>Date:</td>
																		<td style='padding: 8px 0; color: #1F2937;'>$datrsd</td>
																	</tr>
																	<tr>
																		<td style='padding: 8px 0; color: #6B7280; font-weight: 500;'>User ID:</td>
																		<td style='padding: 8px 0; color: #DC2626; font-weight: bold;'>$user</td>
																	</tr>
																	<tr>
																		<td style='padding: 8px 0; color: #6B7280; font-weight: 500;'>Amount:</td>
																		<td style='padding: 8px 0; color: #059669; font-weight: bold; font-size: 18px;'>$$NumberOfToken</td>
																	</tr>
																	<tr>
																		<td style='padding: 8px 0; color: #6B7280; font-weight: 500;'>Wallet Address:</td>
																		<td style='padding: 8px 0; color: #1F2937; font-family: monospace; font-size: 12px; word-break: break-all;'>$BTScdf</td>
																	</tr>
																	<tr>
																		<td style='padding: 8px 0; color: #6B7280; font-weight: 500;'>Email:</td>
																		<td style='padding: 8px 0; color: #1F2937;'>$email</td>
																	</tr>
																</table>
															</div>
														</div>
														
														<!-- Footer -->
														<div style='background-color: #F9FAFB; padding: 20px; text-align: center; border-top: 1px solid #E5E7EB;'>
															<p style='color: #6B7280; margin: 0; font-size: 14px;'>Capitol Money Pay Admin Panel</p>
															<p style='color: #9CA3AF; margin: 5px 0 0 0; font-size: 12px;'>support@capitolmoneypay.com</p>
														</div>
													</div>
												</body>
												</html>";
												
												// Send admin notification emails using PHPMailer
												$adminEmails = array("yennavajo@gmail.com");
												if($to2!=''){
													$adminEmails[] = $to2;
												}
												
												foreach($adminEmails as $adminEmail){
													$mail = new PHPMailer(true);
													try {
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
														
														$mail->setFrom('info@capitolmoneypay.com', 'Capitol Money Pay System');
														$mail->addAddress($adminEmail);
														$mail->addReplyTo('support@capitolmoneypay.com', 'Capitol Money Pay Support');
														
														$mail->isHTML(true);
														$mail->Subject = "💰 Capitol Money Pay - New Withdrawal Request ($user)";
														$mail->Body = $message;
														
														$mail->send();
													} catch (Exception $e) {
														// Log error but don't stop processing
													}
												}																										
												// Process withdrawal fund with better error handling
												try {
													$withdrawResult = file_get_contents("https://capitolmoneypay.com/member/viewdata/withdraw_fund2.php?serial=$serial");
													$resultData = json_decode($withdrawResult, true);
													
													if($resultData && isset($resultData[0]) && $resultData[0] == 1) {
														echo '<div class="alert alert-info" style="margin-top: 15px;">';
														echo '<p><i class="fas fa-info-circle"></i> Transaction record created successfully in database.</p>';
														echo '</div>';
													} else {
														echo '<div class="alert alert-warning" style="margin-top: 15px;">';
														echo '<p><i class="fas fa-exclamation-triangle"></i> Withdrawal approved but there may have been a database issue.</p>';
														echo '</div>';
													}
												} catch (Exception $e) {
													echo '<div class="alert alert-warning" style="margin-top: 15px;">';
													echo '<p><i class="fas fa-exclamation-triangle"></i> Withdrawal approved but could not verify database update.</p>';
													echo '</div>';
												}
												} else { 
													echo '<div class="alert alert-info" style="text-align: center; margin: 20px 0;">';
													echo '<h3><i class="fas fa-check-circle"></i> Request Approved Successfully!</h3>';
													echo '<p>Your request has been verified and approved.</p>';
													echo '</div>';
												}
											}
										?>										<?php 
											} else { 
										?>
										<h3 class="alert alert-danger">There Is No More Transaction Initiated By You</h3>
										<?php 
											}
										?>
									</div>
								</div>
							</div>
						</section>
						<?php 
						}
						}
						if($CheckUser <= 0) {
							echo "<h3 class='alert alert-warning'>Your ID Not Valid</h3>";
						}
						if($recentTime > $LastTime) {
							echo "<h3 class='alert alert-warning'>Your Approve Time Expired</h3>";
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</section>
    </div>
    <!-- JS -->
    <script src="https://capitolmoneypay.com/signup/js/jquery.min.js"></script>
    <script src="https://capitolmoneypay.com/signup/js/main.js"></script>
	 <script src="https://capitolmoneypay.com/signup/js/jquery.validate.min.js"></script>
	 <script src="https://capitolmoneypay.com/signup/js/signup.js"></script>
	</body>
</html>