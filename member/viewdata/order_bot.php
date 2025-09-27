<?php
	session_start();
	require_once '../../db/db.php';
	require_once '../../db/functions.php';
	require_once '../../phpmailer/vendor/autoload.php';
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	$timezone = "Pacific/Auckland"; // Asia/Dacca
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);	
	$Invoice=$_POST['Asd'];
	$Pacsdf=explode("/", base64_decode($_POST['AccF']));
	
	$date=date("Y-m-d");
	
	$TransCode=$_POST['code'];
	$user=$_SESSION['roboMember'];

	$rett=array();
	
	
	
	if($TransCode==''){
		$rett['sts']=0;
		$rett['mess']="Submit Transaction Code";
		die(json_encode($rett));
	}
	
	$kjhgd=$mysqli->query("SELECT * FROM `member` WHERE `user`='".$user."' AND `pin`='".$TransCode."'");
	
	$CheckUs=mysqli_num_rows($kjhgd);
	if($CheckUs>0){
		$packfg=$mysqli->query("SELECT * FROM `package` WHERE `serial`='".$Pacsdf[2]."'");
		$CheckRecei=mysqli_num_rows($packfg);
		if($CheckRecei<1){
			$rett['sts']=0;
			$rett['mess']=" Robot Not Valid";
			die(json_encode($rett));
		}
		$PackAInfo=mysqli_fetch_assoc($packfg);
		$MemberInfo=mysqli_fetch_assoc($kjhgd);
		if($MemberInfo['pack']>=$PackAInfo['serial']){
			$rett['sts']=1;
			$rett['mess']="Your NZ Robo Plan Already Active";
			die(json_encode($rett));
		}
		
		$dfgKKj=remainAmn($user);
		$HHjk=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) as prevAmn FROM `upgrade` WHERE `user`='".$user."'"));
		$charge=0;
		if($HHjk['prevAmn']>0){
			$require_amn=$PackAInfo['pack_amn']-$HHjk['prevAmn'];
		}else{
			$require_amn=$PackAInfo['pack_amn'];
			$charge=10;
		}
		
		
		if($require_amn+$charge>$dfgKKj){
			$rett['sts']=0;
			$rett['mess']="Insufficient Fund";
			die(json_encode($rett));
		}
		$Chhfgd=count($rett);
		if($Chhfgd==0){
			$SponsorBonus=((($require_amn*$PackAInfo['direct_com'])/100)*0.60);
			$Shopping=((($require_amn*$PackAInfo['direct_com'])/100)*0.40);
			/*$remailKj=RemainingReturn($MemberInfo['sponsor']);
			if($remailKj>0){
				
				if($SponsorBonus>=$remailKj){
					$SponsorBonus=$remailKj;
				}
			}else{
				$SponsorBonus=0;
			}
			*/
			$ActivaDate=date("Y-m-d H:i:s");
			$mysqli->query("INSERT INTO `upgrade`( `user`, `package`, `amount`, `bonus`, `shopping`, `sponsor`, `upline`,  `invoice`,  `charge`,  `date`) VALUES ('".$user."','".$PackAInfo['pack']."','".$require_amn."','".$SponsorBonus."','".$Shopping."','".$MemberInfo['sponsor']."','".$MemberInfo['upline']."','".$Invoice."','".$charge."','".$ActivaDate."')");
			$mysqli->query("UPDATE `member` SET `paid`='1',`pack`='".$PackAInfo['serial']."' WHERE `user`='".$user."'");
			
			$description="$$SponsorBonus Sponsor Bonus and $$Shopping Shopping Bonus Added";
			$mysqli->query("INSERT INTO `view`(`user`, `date`, `description`, `amount`, `types`) VALUES ('".$MemberInfo['sponsor']."', '".$date."', '".$description."', '".$SponsorBonus."','credit')");
			
			$description=$PackAInfo['pack']."($$require_amn) D.Bot Purchase Completed";
			$mysqli->query("INSERT INTO `view`(`user`, `date`, `description`, `amount`, `types`) VALUES ('".$user."', '".$date."', '".$description."', '".$SponsorBonus."','debit')");
			
			
			$ProfileInfo=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$MemberInfo['log_user']."' OR `user`='".$user."'"));
			$name=$ProfileInfo['name'];
			$to=$ProfileInfo['email'];
			$code=str_shuffle(substr(time(),3));
			$jkhf=$PackAInfo['pack'];
			$gjkdfhg=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$MemberInfo['log_user']."' OR `user`='".$MemberInfo['user']."'"));
			$name0=$gjkdfhg['name'];
			include('../../login/invoice_mail.php');
			
			$subject="NZ Robo Bot Order Invoice";
			$from = "info@nzrobotrade.com";
			/*$headers = "From:" . $from;
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= "From: NZ Robo Trade $Invoice <info@nzrobotrade.com>" . "\r\n";
			mail($to,$subject,$message2,$headers);*/
			$mail = new PHPMailer;
			$mail->isSMTP();
			//$mail->SMTPDebug = 3; 
			$mail->CharSet  = 'UTF-8';
			$mail->Host = 'localhost';
			$mail->Port = 25;
			$mail->SMTPSecure = 'tls'; 
			$mail->SMTPOptions = array(
			   'ssl' => array(
			   'verify_peer' => false,
			   'verify_peer_name' => false,
			   'allow_self_signed' => true
			  )
			);
			$mail->SMTPAuth = true;
			$mail->Username = $from;
			$mail->Password = 'Mm123678@#';
			$mail->setFrom($from, "NZ Robo Trade $Invoice");
			$mail->addAddress($to, $name0);
			$mail->Subject = $subject;
			$mail->msgHTML($message2);
			$mail->send();
			if($SponsorBonus==0){
				$jkhfks=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `user`='".$MemberInfo['sponsor']."'"));
				$jkhfks2=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$jkhfks['log_user']."' OR `user`='".$jkhfks['user']."'"));
				$name=$jkhfks2['name'];
				$to=$jkhfks2['email'];
				$message="
				<h3 style='font-size:22px'>Hello $name,</h3><br/>
				<p style='font-size:16px'>
					Thanks, For Being With Robo Trade.
				<br/>
				<br/>
					New D-Bot Purchased On Your Team. You Miss This Opportunity. Be Care About Future. Purchase Your Product Don't Miss Next.
				</p>
				
				
				<br/>
				<br/>
				Thanks By, NZ Robo Trade Team<br/>
				<a href='mailto:support@nzrobotrade.com'>support@nzrobotrade.com</a>
				
			";
			$subject="Activation Alert";
			$from = "info@nzrobotrade.com";
			$headers = "From:" . $from;
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= "From: New D-Bot Purchased <info@nzrobotrade.com>" . "\r\n";
			mail($to,$subject,$message,$headers);
			}
			
			
			$dfdsfds=file_get_contents("https://nzrobotrade.com/member/viewdata/update_score.php?Usfd=$user");
			
			$rett['sts']=1;
			$rett['mess']="Order Submitted Successfully";
			die(json_encode($rett));
		}
	}else{
		$rett['sts']=0;
		$rett['mess']="Invalid Transaction Code";
		die(json_encode($rett));
	}

?>