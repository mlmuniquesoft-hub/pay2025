<?php
	session_start();
	require_once '../../db/db.php';
	require_once '../../db/functions.php';
	$Accv=$_GET['Asd'];
	$receiveID=$_POST['receiveID'];
	$amount=$_POST['amount'];
	$TransCode=$_POST['TransCode'];
	$user=$_SESSION['roboMember'];

	$rett=array();
	if($receiveID==''){
		$rett['sts']=0;
		$rett['mess']="Submit Receiver ID";
		die(json_encode($rett));
	}
	if($amount==''){
		$rett['sts']=0;
		$rett['mess']="Submit Amount";
		die(json_encode($rett));
	}
	if($TransCode==''){
		$rett['sts']=0;
		$rett['mess']="Submit Transaction Code";
		die(json_encode($rett));
	}
	
	
	
	$kjhgd=$mysqli->query("SELECT * FROM `member` WHERE `user`='".$user."' AND `pin`='".$TransCode."'");
	//$rett['df']="SELECT * FROM `member` WHERE `user`='".$user."' AND `pin`='".$TransCode."'";
	$CheckUs=mysqli_num_rows($kjhgd);
	if($CheckUs>0){
		$CheckRecei=mysqli_num_rows($mysqli->query("SELECT * FROM `member` WHERE `user`='".$receiveID."'"));
		if($CheckRecei<1){
			$rett['sts']=0;
			$rett['mess']="Invalid Receiver ID";
			die(json_encode($rett));
		}
		
		$dfgKKj=remainAmn($user);
		if($amount>$dfgKKj){
			$rett['sts']=0;
			$rett['mess']="Insufficient Fund";
			die(json_encode($rett));
		}
		$user2=strtolower($user);
		$SkipUser=array("admin001","power001","kalroys");
		if(!in_array($user2, $SkipUser)){
			if($amount<50){
				$rett['sts']=0;
				$rett['mess']="Minimum Amount $50";
				die(json_encode($rett));
			}
			$BalanceSts=remainAmn22($user);
			$jhfdd=floor($BalanceSts['final']/50);
			$transable=$jhfdd*50;
			if($transable>$BalanceSts['final']){
				$transable=$BalanceSts['final']-50;
				if($transable<=0){
					$transable=0;
				}
			}
			$amount2=floor($amount/50);
			$amount=$amount2*50;
		}else{
			if($amount<10){
				$rett['sts']=0;
				$rett['mess']="Minimum Amount $10";
				die(json_encode($rett));
			}
			$transable=$amount;
			$amount=$amount;
		}
		if($amount>$transable){
			$rett['sts']=0;
			$rett['mess']="Insufficient Fund";
			die(json_encode($rett));
		}
		$hgfs=$mysqli->query("SELECT * FROM `auth_set` WHERE `user`='".$user."' AND `active`='1'");
		$kjhfgf=mysqli_num_rows($hgfs);
		if($kjhfgf>0){
			$rett['sts']=1;
			$rett['mess']="Submit Your Authenticator Code";
			die(json_encode($rett));
		}else{
			$Infsdf=mysqli_fetch_assoc($kjhgd);
			$ProfileInfo=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$Infsdf['log_user']."' OR `user`='".$user."'"));
			$name=$ProfileInfo['name'];
			$to=$ProfileInfo['email'];
			$code=str_shuffle(substr(time(),3));
			$message="
			<h3 style='font-size:22px'>Hello $name,</h3><br/>
			<p style='color:#da851a;font-size:18px;'>
				From ID: $user </br>
			</p>
			<p style='color:#da851a;font-size:18px;'>
				To ID: $receiveID </br>
			</p>
			<p style='color:#da851a;font-size:18px;'>
				Amount: $$amount </br>
			</p>
			
			<p style='font-size:16px'>
			
			Someone Try To Commit Transaction From Your Account, We Need To Verify Its You. 
			<br/>
			<br/>
			Please Give This Code Below For Confirmation<br/>
			</p>
			<a style='margin:12px 0px;display:block;text-decoration:none;background: #aeff46!important;border-color:#ffad46!important;color: #777171!important;padding:10px;font-size:32px;text-align:center;' href='#'>$code</a> 
			<br/>
			<p style='font-size:16px'>
				This Code Valid Only For Hours, Please Hurry Up
			<p>
			<br/>
			<br/>
			Thanks By, NZ Robo Trade Team<br/>
			<a href='mailto:support@capitolmoneypay.com'>support@capitolmoneypay.com</a>
			
			";
			$subject="Security Code";
			$from = "info@capitolmoneypay.com";
			$headers = "From:" . $from;
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= "From: Capitol Money Pay  <info@capitolmoneypay.com>" . "\r\n";
			mail($to,$subject,$message,$headers);
			$_SESSION['LogCode']=$code;
			$rett['sts']=1;
			$rett['mess']="Transaction Verify Code Send To Your Mail ($to), Amount: $$amount";
			die(json_encode($rett));
		}
	}else{
		$rett['sts']=0;
		$rett['mess']="Invalid Transaction Code";
		die(json_encode($rett));
	}

?>