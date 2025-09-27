<?php
// Suppress error reporting to prevent warnings from corrupting JSON output
error_reporting(0);
ini_set('display_errors', 0);

session_start();
$_SESSION['token']="jksh sdjf h";
require_once '../db/db.php';
require_once '../phpmailer/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$Accv = isset($_GET['Asd']) ? $_GET['Asd'] : '';
$user = isset($_GET['user_id']) ? $_GET['user_id'] : '';
$code = isset($_GET['password']) ? md5($_GET['password']) : '';
$rett=array();
$kjhgd=$mysqli->query("SELECT * FROM `member` WHERE `user`='".$user."' AND `password`='".$code."'");
$CheckUs=mysqli_num_rows($kjhgd);
if($CheckUs>0){
	$Infsdf=mysqli_fetch_assoc($kjhgd);
	if($Infsdf['active']==1){
		$hgfs=$mysqli->query("SELECT * FROM `auth_set` WHERE `user`='".$user."' AND `active`='1'");
		$kjhfgf=mysqli_num_rows($hgfs);
		if($kjhfgf>0){
			$rett['sts']=1;
			$rett['mess']="Submit Your Authenticator Code";
			die(json_encode($rett));
		}else{
			// Direct login without OTP - bypass email verification
			session_start();
			$_SESSION['roboMember'] = $user;
			$_SESSION['user_data'] = $Infsdf;
			
			$rett['sts']=1;
			$rett['mess']="Login Successful";
			$rett['redirect'] = true; // Add redirect flag for frontend
			die(json_encode($rett));
		}
	}else{
		$rett['sts']=0;
		$rett['mess']="Please Verify Your Email";
		die(json_encode($rett));
	}
}else{
	$rett['sts']=0;
	$rett['mess']="Invalid User ID Or Password";
	die(json_encode($rett));
}

?>