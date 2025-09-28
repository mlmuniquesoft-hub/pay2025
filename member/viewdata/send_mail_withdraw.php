<?php
	session_start();
	require_once("../../db/db.php");
	require_once("../../db/functions.php");
	$rett=array();
	if(isset($_GET['req'])){
		$userID=$_GET['req'];
	}else{
		$userID=$_SESSION['roboMember'];
	}
	$userID=strtolower($userID);
	$jhdfg=mysqli_num_rows($mysqli->query("SELECT * FROM `member` WHERE `user`='".$userID."' AND `pack`>'0'"));
	if($jhdfg<1){
		array_push($rett,0);
		array_push($rett,"Please, Purchase One Bot & Try Again.");
		echo json_encode($rett);
		die();
	}
	
	$urtye="power";
	$iiuu=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member_total` WHERE `user`='".$urtye."'"));
	$leftall=explode(",", strtolower($iiuu['totalLeftId']));
	$rightall=explode(",", strtolower($iiuu['totalrightId']));
	$ttt=array_merge($leftall,$rightall);
	if(!in_array($userID,$ttt)){
		array_push($rett,0);
		array_push($rett,"Sorry For Inconvenience, Withdrawal Process Is Under Construction. Advance Phase Appearing Soon.");
		echo json_encode($rett);
		die();
	}
	
	
	$SuspendUser=array("bdboss01","bdboss02","bdboss03","bdboss04","bdboss05","bdboss06","bdboss07","bdboss08","murad","rural","haider01","aileronbd","airwing","rangpurbd","kingbd");
	$Chedfg=strtolower($userID);
	if(in_array($Chedfg,$SuspendUser)){
		array_push($rett,0);
		array_push($rett,"Withdrawal System Upgrading....., Try Later");
		echo json_encode($rett);
		die();
	}
	
	
	// $ghfdhs=date("D");
	// if($ghfdhs=='Mon'){
	// 	array_push($rett,0);
	// 	array_push($rett,"Withdrawal Request Received From Sunday To Tuesday, Which Will Be Paid On Monday");
	// 	echo json_encode($rett);
	// 	die();
	// }
	
	$AssIgnTo=$_GET['AssIgnTo'];
	$curencyAmn=$_GET['curencyAmn'];
	$method=$_GET['method'];
	$WithdrawType=$_GET['type'];
	$NumberOfToken=$_GET['NumberOfToken'];
	//$mysqli=$mysqli;
	$date=date("Y-m-d");
	$BalanceSts=remainAmn($userID);//ReaminBalance($userID, $mysqli,$mysqli,1);
	
	if($WithdrawType=="withdraw"){
		$TransType="Withdraw";
	}else{
		$TransType="Transfer";
	}
	
	$HJGF=$mysqli->query("SELECT * FROM `withdraw_cons` WHERE `active`='1' AND (`trns_type`='".$TransType."' OR `trns_type`='Both')");
	$ChecjK=mysqli_num_rows($HJGF);
	if($ChecjK>0){
		$mfgfd=mysqli_fetch_assoc($HJGF);
		array_push($rett, 0);
		array_push($rett, $mfgfd['mess']);
		echo json_encode($rett);
		die();
	}
	
	if($AssIgnTo==''){
		array_push($rett, 0);
		if($WithdrawType=="withdraw"){
			array_push($rett, "Submit Wallet ID");
		}else{
			array_push($rett, "Submit Donor ID");
		}
		echo json_encode($rett);
		die();
	}
	if($NumberOfToken==''){
		array_push($rett, 0);
		array_push($rett, "Submit $TransType Amount");
		echo json_encode($rett);
		die();
	}
	
	
	if($NumberOfToken>$BalanceSts){
		array_push($rett, 0);
		array_push($rett, "Insufficient Balance ");
		echo json_encode($rett);
		die();
	}
	//var_dump($NumberOfToken);
	if($NumberOfToken<10){
		array_push($rett,0);
		array_push($rett,"Minimum $10");
		echo json_encode($rett);
		die();
	}
	
	if($NumberOfToken>500){
		array_push($rett,0);
		array_push($rett,"Maximum $500");
		echo json_encode($rett);
		die();
	}
	
	/*$jhgjkdf=mysqli_num_rows($mysqli->query("SELECT * FROM `trans_receive` WHERE `user_trans`='".$userID."' AND `date`='".$date."'"));
	if($jhgjkdf>1){
		array_push($rett,0);
		array_push($rett,"Todays Limit Exceed");
		echo json_encode($rett);
		die();
	}*/
	
	
	$countU=count($rett);
	if($countU==0){
		$user=$_SESSION['roboMember'];
		$hsgs=$mysqli->query("SELECT * FROM `widraw_req` WHERE `user`='".$userID."' AND `pending`='0' ORDER BY `serial` DESC LIMIT 1");
		$ChekcUI=mysqli_num_rows($hsgs);
		if($ChekcUI<1){
			if($WithdrawType=="withdraw"){
				$mmfgh=$method.": ".$AssIgnTo;
				$tax=$NumberOfToken*0.08;
				$reter=base64_encode("INSERT INTO trans_receive(`user_trans`,`ammount`,`tax`,`c_wallet`,date,user_receive,method,status,remark,type,account)
				VALUES ('".$userID."','".$NumberOfToken."','".$tax."','".$curencyAmn."','".$date."','Office','".$mmfgh."','Pending','".$remark."','Withdraw','Admin')");
				
			}else{
				$reter=base64_encode("INSERT INTO trans_receive(`user_trans`,`ammount`,`tax`,`comm`,date,user_receive,method,status,remark,type,account)
				VALUES ('".$userID."','".$NumberOfToken."','".$tax."','".$comm."','".$date."','".$AssIgnTo."','Transter','Complete','".$remark."','Transfer','Member')");
				
			}
			
			$mysqli->query("INSERT INTO `widraw_req`(`user`,`pending`,`withdraw_que`,`type`) VALUES ('".$userID."','0','".$reter."','".$TransType."')");
			$jfdf=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `widraw_req` WHERE `user`='".$userID."' AND `pending`='0' ORDER BY `serial` DESC LIMIT 1"));
			$serial=$jfdf['serial'];
		}else{
			$hjkd=mysqli_fetch_assoc($hsgs);
			$serial=$hjkd['serial'];
		}
		$UserInfo=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `user`='".$user."'"));
		$ProfileInfo=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$user."' OR `user`='".$UserInfo['log_user']."'"));
		$to=$ProfileInfo['email'];
		$name=$ProfileInfo['name'];
		$remainTime=strtotime("+1 hours");
		$tii1=substr(time(),0,5);
		$tii2=substr(time(),5,10);
		$key=$tii2.$user.".".$serial.$tii1;
		$Tittle=$tii2.$tii1;
		$ResetLink="?key=" . base64_encode($key."/".$remainTime);
		
		$message="
			<h3 style='font-size:22px'>Hello $name,</h3><br/>
			<p style='font-size:16px'>
			This is a fund $Transtype request  for <a href='https://capitolmoneypay.com/'>capitolmoneypay.com </a>- amount: $$NumberOfToken someone try to $Transtype your fund. If you have not initiated this request, nothing needs to be done.
			<br/>
			<br/>
			If you have initiated this, please <br/>
			</p>
			<a style='margin:12px 0px;display:block;text-decoration:none;background: #ffad46!important;border-color: #ffad46!important;color: #fff!important;padding:10px;font-size:32px;text-align:center;' href='https://capitolmoneypay.com/update_withdraw.php$ResetLink'>Click Here</a> 
			<br/>
			<p style='font-size:16px'>
			to proceed your $Transtype. This link will work for ONE hour from the time of receipt.
			<p>
			<br/>
			<br/>
			Thanks By, NZ Robo Trade Team<br/>
			<a href='mailto:support@capitolmoneypay.com'>support@capitolmoneypay.com</a>
			
		";
		$subject="Transaction Request (CF-$Tittle)";
		$from = "info@capitolmoneypay.com";
		$headers = "From:" . $from;
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "From: Capitol Money Pay $Tittle  <info@capitolmoneypay.com>" . "\r\n";
		mail($to,$subject,$message,$headers);
		
		array_push($rett, 1);
		array_push($rett, "Confirmation Mail Send To $to, Please Confirm To Proceed");
		array_push($rett, $serial);
		echo json_encode($rett);
		die();
	}
?>