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
			$message=" Dear ".$jhdjfk['name']."<br/>".$message;
			$subject="System Upgrade";
			$from = "info@capitolmoneypay.com";
			$headers = "From:" . $from;
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= "From: Capitol Money Pay <info@capitolmoneypay.com>" . "\r\n";
			mail($to,$subject,$message,$headers);
		}
		
	}
?>