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
	$paytransid=$_POST['pay_trans_id'];
	$paywallet=$_POST['pay_wallet'];
	$TransCode=$_POST['code'];
	$Qtyr=$_POST['Qtyr'];
	$user=$_SESSION['roboMember'];

	$rett=array();
	
	settype($Qtyr, 'integer');
	if($Qtyr<=0){
		$rett['sts']=0;
		$rett['mess']="Invalid Product Quantity";
		die(json_encode($rett));
	}
	if($TransCode==''){
		$rett['sts']=0;
		$rett['mess']="Submit Transaction Code";
		die(json_encode($rett));
	}
	if($Qtyr==''){
		$rett['sts']=0;
		$rett['mess']="Invalid Product Quantity";
		die(json_encode($rett));
	}
	
	$kjhgd=$mysqli->query("SELECT * FROM `member` WHERE `user`='".$user."' AND `pin`='".$TransCode."'");
	
	$CheckUs=mysqli_num_rows($kjhgd);
	if($CheckUs>0){
		$packfg=$mysqli->query("SELECT * FROM `product` WHERE `serial`='".$Pacsdf[2]."'");
		$CheckRecei=mysqli_num_rows($packfg);
		if($CheckRecei<1){
			$rett['sts']=0;
			$rett['mess']=" Product Not Valid";
			die(json_encode($rett));
		}
		$PackAInfo=mysqli_fetch_assoc($packfg);
		$MemberInfo=mysqli_fetch_assoc($kjhgd);
		
		$dfgKKj=TtalShopping($user); 
		$totalPrice = $PackAInfo['sale_price'] * $Qtyr;
		$require_amn=$totalPrice * 0.3;
			
		if($require_amn>$dfgKKj){
			$rett['sts']=0;
			$rett['mess']="Insufficient Fund";
			die(json_encode($rett));
		}
		$Chhfgd=count($rett);
		
		if($Chhfgd==0){
			$ActivaDate=date("Y-m-d H:i:s");
			
			$mysqli->query("INSERT INTO `order`( `invoice`, `pay_wallet`, `pay_trans_id`, `user_id`, `product_id`, `price`, `qty`,`adj_bal`, `total`) VALUES 
			('".$Invoice."','".$paywallet."','".$paytransid."','".$user."','".$Pacsdf[2]."','".$PackAInfo['sale_price']."','".$Qtyr."','".$require_amn."','".$totalPrice."')");
			
			
			$ProfileInfo=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$MemberInfo['log_user']."' OR `user`='".$user."'"));
			$name=$ProfileInfo['name'];
			$to=$ProfileInfo['email'];
			$code=str_shuffle(substr(time(),3));
			$jkhf=$PackAInfo['name'];
			$gjkdfhg=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$MemberInfo['log_user']."' OR `user`='".$MemberInfo['user']."'"));
			$name0=$gjkdfhg['name'];
			include('../../login/invoice_mail_product.php');
			
			$subject="NZ Product Order Invoice";
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