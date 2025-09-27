<?php
	session_start();
	require_once("../../db/db.php");
	$rett=array();
	$userDf=$_GET['userdf'];
	$pass1=$_GET['pass1'];
	$pass2=$_GET['pass2'];
	if($pass1==''){
		array_push($rett,0);
		array_push($rett,"Submit Your Password");
		die(json_encode($rett));
	}
	if($pass2==''){
		array_push($rett,0);
		array_push($rett,"Submit Your Confirm Password");
		die(json_encode($rett));
	}
	if($pass2!=$pass1){
		array_push($rett,0);
		array_push($rett,"Password Does Not Match");
		die(json_encode($rett));
	}
	$hjdf=strlen($pass2);
	if($hjdf<8){
		array_push($rett,0);
		array_push($rett,"Password Minimum 8 Digit");
		die(json_encode($rett));
	}
	if($userDf!=''){
		$kjhsd=mysqli_num_rows($mysqli->query("SELECT `serial` FROM `member` WHERE `user`='".$userDf."'"));
		if($kjhsd>0){
			$Pasda=md5($pass2);
			$mysqli->query("UPDATE `member` SET `password`='".$Pasda."' WHERE `user`='".$userDf."'");
			
			$kjhdsfsd=mysqli_fetch_assoc($mysqli->query("SELECT `log_user` FROM `member` WHERE `user`='".$userDf."'"));
			$kjhpROFILE=mysqli_fetch_assoc($mysqli->query("SELECT `name`,`email` FROM `profile` WHERE `user`='".$userDf."' OR `user`='".$kjhdsfsd['log_user']."'"));
			$to=$kjhpROFILE['email'];
			$name=$kjhpROFILE['name'];
			
			$message="
				<h3 style='font-size:22px'>Hello $name,</h3><br/>
				<p style='font-size:16px'>
				You Password Change request  for <a href='https://nzrobotrade.com/'>nzrobotrade.com </a>- User ID: $userDf Successfully Updated.
				<br/>
				<br/>
				New Password: $pass2 <br/>
				</p>
				
				<br/>
				
				<br/>
				<br/>
				Thanks By, NZ Robo Trade Team<br/>
				<a href='mailto:support@nzrobotrade.com'>support@nzrobotrade.com</a>
				
			";
			$subject="Password Change Success (PC-$Tittle)";
			$from = "info@nzrobotrade.com";
			$headers = "From:" . $from;
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= "From: NZ Robo Trade PC $Tittle  <info@nzrobotrade.com>" . "\r\n";
			mail($to,$subject,$message,$headers);
			array_push($rett,1);
			array_push($rett,"Password Updated, Check Your Mail ($to)");
			die(json_encode($rett));
		}else{
			array_push($rett,0);
			array_push($rett,"Invalid User ID");
			die(json_encode($rett));
		}
	}else{
		array_push($rett,0);
		array_push($rett,"Submit Your User ID");
		die(json_encode($rett));
	}
?>