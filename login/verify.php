<?php
	session_start();
	require_once '../authenticator/ahh.php';
	require_once '../db/db.php';

	$user=$_GET['user_id'];
	$code=$_GET['secureCode'];
	$rett=array();
	$kjhgd=$mysqli->query("SELECT * FROM `member` WHERE `user`='".$user."' ");
	$CheckUs=mysqli_num_rows($kjhgd);
	if($CheckUs>0){
		$hgfs=$mysqli->query("SELECT * FROM `auth_set` WHERE `user`='".$user."' AND `active`='1'");
		$kjhfgf=mysqli_num_rows($hgfs);
		if($kjhfgf>0){
			$Indfgo=mysqli_fetch_assoc($hgfs);
			$secret=$Indfgo['secrate_code'];
			$ga = new PHPGangsta_GoogleAuthenticator();
			$checkResult = $ga->verifyCode($secret, $code, 2);
			if($checkResult){
				$rett['sts']=1;
				$rett['mess']="Success";
				die(json_encode($rett));
			} else {
				$rett['sts']=0;
				$rett['mess']="Incorrect Authenticator Code";
				die(json_encode($rett));
			}
			
		}else{
			$Infsdf=mysqli_fetch_assoc($kjhgd);
			$ProfileInfo=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$Infsdf['log_user']."' OR `user`='".$user."'"));
			if($_SESSION['LogCode']==$code){
				$rett['sts']=1;
				$rett['mess']="Success";
				die(json_encode($rett));
			}else{
				$rett['sts']=0;
				$rett['mess']="Invalid Security Code";
				die(json_encode($rett));
			}
		}
	}else{
		$rett['sts']=0;
		$rett['mess']="Invalid User ID ";
		die(json_encode($rett));
	}

?>