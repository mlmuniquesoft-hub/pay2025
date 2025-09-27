<?php
session_start();
require_once 'ahh.php';
require_once '../db/db.php';
$Accv=$_GET['Asd'];
$user=$_SESSION['roboMember'];
$code=$_GET['code'];
$rett=array();
$ga = new PHPGangsta_GoogleAuthenticator();

$CheckUs=mysqli_num_rows($mysqli->query("SELECT * FROM `member` WHERE `user`='".$user."'"));
if($CheckUs>0){
	if($Accv=="Set"){
		$secret = $ga->createSecret();
		$_SESSION['AuthSec']=$secret;
		$qrCodeUrl = $ga->getQRCodeGoogleUrl($user."@RoboTrade", $secret);
		$rett['sts']=1;
		$rett['mess']="Success";
		$rett['url']=$qrCodeUrl;
		die(json_encode($rett));
	}elseif($Accv=="Check"){
		$hgfs=$mysqli->query("SELECT * FROM `auth_set` WHERE `user`='".$user."' AND `active`='1'");
		$kjhfgf=mysqli_num_rows($hgfs);
		if($kjhfgf>0){
			$kjdghfd=mysqli_fetch_assoc($hgfs);
			$secret=$kjdghfd['secrate_code'];
		}else{
			$secret=$_SESSION['AuthSec'];
		}
		
		$checkResult = $ga->verifyCode($secret, $code, 2);    // 2 = 2*30sec clock tolerance
		if ($checkResult) {
			if($kjhfgf<1){
				$ResetCode=md5(str_shuffle(substr(time(),5)));
				$mysqli->query("INSERT INTO `auth_set`( `user`, `secrate_code`, `reset_code`) VALUES ('".$user."','".$secret."','".$ResetCode."')");
				$rett['sts']=1;
				$rett['mess']="Authenticator Turn On";
				$rett['secrate']=$ResetCode;
				die(json_encode($rett));
			}else{
				$rett['sts']=1;
				$rett['mess']="Success";
				die(json_encode($rett));
			}
			
		} else {
			$rett['sts']=0;
			$rett['mess']="Incorrect Authenticator Code";
			die(json_encode($rett));
		}
	}elseif($Accv=="Off"){
		$hgfs=$mysqli->query("SELECT * FROM `auth_set` WHERE `user`='".$user."' AND `reset_code`='".$code."'");
		$kjhfgf=mysqli_num_rows($hgfs);
		$rett['dfd']="SELECT * FROM `auth_set` WHERE `user`='".$user."' AND `reset_code`='".$code."'";
		if($kjhfgf>0){
			
			$AccF=$_GET['AccF'];
			if($AccF=="Off"){
				$ssdG=0;
			}elseif($AccF=="ON"){
				$ssdG=1;
			}else{
				$rett['sts']=0;
				$rett['mess']="Invalid Backup Code";
				die(json_encode($rett));
			}
			$mysqli->query("DELETE FROM `auth_set` WHERE `user`='".$user."' AND `reset_code`='".$code."'");
			$rett['sts']=1;
			$rett['mess']="Authenticator Turn Off";
			die(json_encode($rett));
		}else{
			$rett['sts']=0;
			$rett['mess']="Invalid Backup Code";
			die(json_encode($rett));
		}
		
	}elseif($Accv=="ReoN"){
		$hgfs=$mysqli->query("SELECT * FROM `auth_set` WHERE `user`='".$user."' AND `reset_code`='".$code."'");
		$kjhfgf=mysqli_num_rows($hgfs);
		if($kjhfgf>0){
			$mysqli->query("UPDATE `auth_set` SET `active`='0' WHERE `user`='".$user."' AND `reset_code`='".$code."'");
			$rett['sts']=1;
			$rett['mess']="Authenticator Turn Off";
			die(json_encode($rett));
		}else{
			$rett['sts']=0;
			$rett['mess']="Invalid Backup Code";
			die(json_encode($rett));
		}
		
	}
}else{
	$rett['sts']=0;
	$rett['mess']="Invalid User ID";
	die(json_encode($rett));
}





?>