<?php
	session_start();
	require_once("../../db/db.php");
	$serial=base64_decode($_POST['sers']);
	$jkfghk=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `widraw_req` WHERE `serial`='".$serial."'"));
	$rett=array();
	if($jkfghk['pending']==0){
		$user=$jkfghk['user'];
		$Transtype=$jkfghk['type'];
		$ueyuer=base64_decode($jkfghk['withdraw_que']);
		$uiyeri=explode(",",$ueyuer);
	
		$hsgf=count($uiyeri[11]);
		$Amount=substr($uiyeri[11],1,$hsgf-2);
		$UserInfo=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `user`='".$user."'"));
		$ProfileInfo=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$user."' OR `user`='".$UserInfo['log_user']."'"));
		$to=$ProfileInfo['email'];
		$name=$ProfileInfo['name'];
		$remainTime=strtotime("+1 hours");
		$tii1=substr(time(),0,5);
		$tii2=substr(time(),5,10);
		$key=$tii2.$user.".".$jkfghk['serial'].$tii1;
		$ResetLink="?key=" . base64_encode($key."/".$remainTime);
		$Tittle=$tii2.$tii1;
		//include("mail.php");
		$message="
			<h3 style='font-size:22px'>Hello $name,</h3><br/>
			<p style='font-size:16px'>
			This is a fund $Transtype request  for <a href='https://nzrobotrade.com/'>nzrobotrade.com </a>- amount: $$Amount someone try to $Transtype your fund. If you have not initiated this request, nothing needs to be done.
			<br/>
			<br/>
			If you have initiated this, please <br/>
			</p>
			<a style='margin:12px 0px;display:block;text-decoration:none;background: #ffad46!important;border-color: #ffad46!important;color: #fff!important;padding:10px;font-size:32px;text-align:center;' href='https://nzrobotrade.com/update_withdraw.php$ResetLink'>Click Here</a> 
			<br/>
			<p style='font-size:16px'>
			to proceed your $Transtype. This link will work for ONE hour from the time of receipt.
			<p>
			<br/>
			<br/>
			Thanks By, Coop Crowds Team<br/>
			<a href='mailto:support@nzrobotrade.com'>support@nzrobotrade.com</a>
			
		";
		$subject="Transaction Request (CF-$Tittle)";
		$from = "info@nzrobotrade.com";
		$headers = "From:" . $from;
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "From: NZ Robo Trade (CF-$Tittle) <info@nzrobotrade.com>" . "\r\n";
		mail($to,$subject,$message,$headers);
		
		array_push($rett, 1);
		array_push($rett, "Confirmation Mail Send To $to, Please Confirm To Proceed");
		array_push($rett, $jkfghk['serial']);
		echo json_encode($rett);
		die();
	}else{
		array_push($rett,0);
		array_push($rett,"No Pending Transaction");
		echo json_encode($rett);
		die();
	}
?>