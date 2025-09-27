<?php
	session_start();
	require_once("../../db/db.php");
	$rett=array();
	$userDf=$_GET['userdf'];
	if($userDf!=''){
		$kjhsd=mysqli_num_rows($mysqli->query("SELECT `serial` FROM `member` WHERE `user`='".$userDf."'"));
		if($kjhsd>0){
			$kjhdsfsd=mysqli_fetch_assoc($mysqli->query("SELECT `log_user` FROM `member` WHERE `user`='".$userDf."'"));
			$kjhpROFILE=mysqli_fetch_assoc($mysqli->query("SELECT `name`,`email` FROM `profile` WHERE `user`='".$userDf."' OR `user`='".$kjhdsfsd['log_user']."'"));
			$to=$kjhpROFILE['email'];
			$name=$kjhpROFILE['name'];
			$remainTime=strtotime("+1 hours");
			$tii1=substr(time(),0,5);
			$tii2=substr(time(),5,10);
			$key=$tii2.$userDf.".".$serial.$tii1;
			$Tittle=$tii2.$tii1;
			$ResetLink="?key=" . base64_encode($key."/".$remainTime);
			
			$message="
				<h3 style='font-size:22px'>Hello $name,</h3><br/>
				<p style='font-size:16px'>
				This is a fund Password Change request  for <a href='https://nzrobotrade.com/'>nzrobotrade.com </a>- User ID: $userDf someone try to Change your Login Password. If you have not initiated this request, nothing needs to be done.
				<br/>
				<br/>
				If you have initiated this, please <br/>
				</p>
				<a style='margin:12px 0px;display:block;text-decoration:none;background: #ffad46!important;border-color: #ffad46!important;color: #fff!important;padding:10px;font-size:32px;text-align:center;' href='https://nzrobotrade.com/member/update_pass.php$ResetLink'>Click Here</a> 
				<br/>
				<p style='font-size:16px'>
				to proceed your Password Change. This link will work for ONE hour from the time of receipt.
				<p>
				<br/>
				<br/>
				Thanks By, NZ Robo Trade Team<br/>
				<a href='mailto:support@nzrobotrade.com'>support@nzrobotrade.com</a>
				
			";
			$subject="Password Change Request (PC-$Tittle)";
			$from = "info@nzrobotrade.com";
			$headers = "From:" . $from;
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= "From: NZ Robo Trade PC $Tittle  <info@nzrobotrade.com>" . "\r\n";
			mail($to,$subject,$message,$headers);
			array_push($rett,1);
			array_push($rett,"Password Reset Link Send To Your Mail ($to)");
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