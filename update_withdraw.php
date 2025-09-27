<?php
	session_start();
	$_SESSION['token']='123asda';
	require_once("db/db.php");
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
    <link rel="stylesheet" href="https://coop-crowds.com/signup/fonts/material-icon/css/material-design-iconic-font.min.css">
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Main css -->
    <link rel="stylesheet" href="https://coop-crowds.com/signup/css/style.css">
    <link rel="stylesheet" href="https://coop-crowds.com/signup/css/style2.css">
    <link rel="stylesheet" href="https://coop-crowds.com/signup/css/jquery.ccpicker.css">
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
							if($recentTime<=$LastTime){
							if($CheckUser>0){
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
														
														$hsgf=count($uiyeri[11]);
														$Amount=substr($uiyeri[11],1,$hsgf-2);
														$BTScdf=$uiyeri[16];
														$NumberOfToken=$Amount*0.92;
														
														echo '<h3 class="alert alert-success">Your Transaction Approved</h3>';
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
															<h3 style='font-size:22px'>Request From: $user,</h3><br/>
															<p style='font-size:16px'>
															Date: $datrsd<br/>
															New Withdraw Request 
															<br/>
															<br/>
															User ID: $user<br/>
															Amount: $NumberOfToken<br/>
															Address: $BTScdf<br/>
															Email: $email<br/>
															</p>
															<br/>
															<br/>
												Thanks By, Capitol Money Pay Team<br/>
												<a href='mailto:support@capitolmoneypay.com'>support@capitolmoneypay.com</a>														";
														$to="yennavajo@gmail.com";
														
														$subject="Withdraw Request";
														$from = "info@capitolmoneypay.com";
														$headers = "From:" . $from;
														$headers  = 'MIME-Version: 1.0' . "\r\n";
														$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
														$headers .= "From: Capitol Money Pay <info@capitolmoneypay.com>" . "\r\n";
														mail($to,$subject,$message,$headers);
														if($to2!=''){
															mail($to2,$subject,$message,$headers);
														}
														
														$erter=file_get_contents("https://capitolmoneypay.com/member/viewdata/withdraw_fund2.php?serial=$serial");
													}
												}
										?>
										
										<?php }else{ ?>
										<h3 class="alert alert-danger">There Is No More Transaction Initiated By You</h3>
										<?php } ?>
									</div>
								</div>
							</div>
						</section>
						<?php }else{
							echo "<h3 class='alert alert-warning'>Your ID Not Valid</h3>";
							} }else{
								echo "<h3 class='alert alert-warning'>Your Approve Time Expired</h3>";
							}?>
					</div>
				</div>
			</div>
		</div>
	</section>
    </div>
    <!-- JS -->
    <script src="https://coop-crowds.com/signup/js/jquery.min.js"></script>
    <script src="https://coop-crowds.com/signup/js/main.js"></script>
	 <script src="https://coop-crowds.com/signup/js/jquery.validate.min.js"></script>
	 <script src="https://coop-crowds.com/signup/js/signup.js"></script>
	</body>
</html>