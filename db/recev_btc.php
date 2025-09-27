<?php
	session_start();
	require_once '../phpmailer/vendor/autoload.php';
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	$timing_start = explode(' ', microtime());
	error_reporting(-1);
	set_time_limit(0);
	ini_set('memory_limit','512M');
	$_SESSION['token']=4368098775524;	
	require_once('db.php');
	$BTcInfo="https://coopcrowds.uk/merchant/4dff5870-0a2e-4321-8d66-df4138ba4ace/address_balance?password=16DJkuF3SMTVCd519WycRF3zkjDoYoT5V1&address=1NfHJ1qvqTjM1jPvqemZ6QAwHvXCVHLDgC";
	$ere=json_decode(file_get_contents($BTcInfo));
	$addREss=$ere->total_received;
	$rECEIVEDaMOUNT=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amn_satoshi) as tolkj FROM `req_fund` WHERE `receiver`='1NfHJ1qvqTjM1jPvqemZ6QAwHvXCVHLDgC'"));
	$hjss=$rECEIVEDaMOUNT['tolkj'];
	if($addREss>$hjss){
		$baseUrl="https://blockchain.info/rawaddr/1NfHJ1qvqTjM1jPvqemZ6QAwHvXCVHLDgC";
		$ere=json_decode(file_get_contents($baseUrl));
		var_dump($ere);
	}
	$user="murad";
	$from="1NfHJ1qvqTjM1jPvqemZ6QAwHvXCVHLDgC";//$inFoAds['btc_address'];
	$perbyte=2;
	$fee=374*2;
	$amount=152379-$fee;
	$CheckUser=$mysqli->query("SELECT * FROM `member` WHERE `user`='".$user."'");
	$UserInfo=mysqli_fetch_assoc($CheckUser);
	$MemberInfo=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$UserInfo['log_user']."' OR `user`='".$UserInfo['user']."'"));
	$name0=$MemberInfo['name'];
	$message2="
		<h3 style='font-size:16px'> $name0,</h3><br/>
		<p style='color:#da851a;font-size:18px;background: #e6e683;padding: 3px;width: 254px;'>
			User ID: $user </br>
			 Satoshi: $amount <br/> USD: 10.72</br>
		</p>
		
		<br/>
		
		<br/>
		<br/>
		Thanks By, NZ Robo Trade Team<br/>
		<a href='mailto:support@capitolmoneypay.com'>support@capitolmoneypay.com</a>
		
	";
	$subject="NZ Robo New Deposit";
	$from = "info@capitolmoneypay.com";
	$to="yennavajo@gmail.com";
	$mail = new PHPMailer;
	$mail->isSMTP();
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
	$mail->setFrom($from, "NZ Robo Trade New Deposit");
	$mail->addAddress($to, $name);
	$mail->Subject = $subject;
	$mail->msgHTML($message2);
	$mail->send();
	//$requestPay=file_get_contents("http://coopcrowds.uk/merchant/4dff5870-0a2e-4321-8d66-df4138ba4ace/payment?to=1Ehis7EdJnE7TkABLbcmv73Gq877NMqwHA&amount=$amount&from=$from&password=16DJkuF3SMTVCd519WycRF3zkjDoYoT5V1&fee=$fee&fee_per_byte=$perbyte");
	var_dump("http://coopcrowds.uk/merchant/4dff5870-0a2e-4321-8d66-df4138ba4ace/payment?to=1Ehis7EdJnE7TkABLbcmv73Gq877NMqwHA&amount=$amount&from=$from&password=16DJkuF3SMTVCd519WycRF3zkjDoYoT5V1&fee=$fee&fee_per_byte=$perbyte");
	//$jkddf="https://coopcrowds.uk/merchant/4dff5870-0a2e-4321-8d66-df4138ba4ace/list?password=16DJkuF3SMTVCd519WycRF3zkjDoYoT5V1";
	//$ere=json_decode(file_get_contents($BTcInfo));
	/*$hjfd=$mysqli->query("SELECT DISTINCT `receiver` FROM `req_fund`");
	while($kdjfhg=mysqli_fetch_assoc($hjfd)){
		$jhdfgd=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `generate_btc` WHERE `btc_address`='".$kdjfhg['receiver']."'"));
		$BTcInfo="https://coopcrowds.uk/merchant/4dff5870-0a2e-4321-8d66-df4138ba4ace/address_balance?password=16DJkuF3SMTVCd519WycRF3zkjDoYoT5V1&address=".$kdjfhg['receiver'];
		$ere=json_decode(file_get_contents($BTcInfo));
		$addREss=$ere->total_received;
		//if($jhdfgd<1){
			echo $jhdfgd['user'] ." >> ". $kdjfhg['receiver'] ." >> $addREss<br/>";
			$mysqli->query("UPDATE `req_fund` SET `amn_satoshi`='".$addREss."' WHERE `receiver`='".$kdjfhg['receiver']."' ORDER BY `serial` DESC LIMIT 1");
		//}
	}*/
?>