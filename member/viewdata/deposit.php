<?php
	session_start();
	require_once '../../phpmailer/vendor/autoload.php';
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	$rett=array();
	function RetunExchane($Exchange,$Amount){
		$url = 'https://pro-api.coinmarketcap.com/v1/tools/price-conversion';
		$parameters = [
			'symbol' => 'BTC',
			'amount' => $Amount,
			'convert' => $Exchange
		];
		$headers = [
			'Accepts: application/json',
			'X-CMC_PRO_API_KEY: 05488dcd-935f-45df-a43b-6be90591454a'
		];
		$qs = http_build_query($parameters);
		$request = "{$url}?{$qs}"; // create the request URL


		$curl = curl_init(); // Get cURL resource
		// Set cURL options
		curl_setopt_array($curl, array(
			CURLOPT_URL => $request,            // set the request URL
			CURLOPT_HTTPHEADER => $headers,     // set the headers 
			CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
		));

		$response = curl_exec($curl); // Send the request, save the response
		$yyruie=json_decode($response);
		curl_close($curl);
		return $yyruie->data->quote->$Exchange->price;
	}
	
	if(isset($_SESSION['roboMember'])){
		if($_SESSION['roboMember']!=''){
			require_once("../../db/db.php");
			$user=$_SESSION['roboMember'];
			
			$CheckUser=$mysqli->query("SELECT * FROM `member` WHERE `user`='".$user."'");
			$validateUser=mysqli_num_rows($CheckUser);
			if($validateUser>0){
				$hdfd=$mysqli->query("SELECT * FROM `generate_btc` WHERE `user`='".$user."'");
				$Checksdf=mysqli_num_rows($hdfd);
				$StandardFee=json_decode(file_get_contents("https://bitcoinfees.earn.com/api/v1/fees/recommended"));
				
				if($Checksdf>0){
					$inFoAds=mysqli_fetch_assoc($hdfd);
					$BTcInfo="https://coopcrowds.uk/merchant/4dff5870-0a2e-4321-8d66-df4138ba4ace/address_balance?password=16DJkuF3SMTVCd519WycRF3zkjDoYoT5V1&address=".$inFoAds['btc_address'];
					$ere=json_decode(file_get_contents($BTcInfo));
					$addREss=$ere->total_received;
					$rECEIVEDaMOUNT=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amn_satoshi) as tolkj FROM `req_fund` WHERE `receiver`='".$inFoAds['btc_address']."'"));
					
					if($addREss>$rECEIVEDaMOUNT['tolkj']){
						$baseUrl="https://blockchain.info/rawaddr/".$inFoAds['btc_address'];
						$ere=json_decode(file_get_contents($baseUrl));
				
						foreach($ere->txs as $sdfsdf){
							$TrxHash=$sdfsdf->hash;
							$TrxHashSize=$sdfsdf->size;
							$chargeJK=$TrxHashSize*$StandardFee->fastestFee;
							$Times=date("Y-m-d H:i:s",$sdfsdf->time);
							foreach($sdfsdf->out as $adds){
								$ddress=$adds->addr;
								if($ddress==$inFoAds['btc_address']){
									$Amount=$adds->value-$chargeJK;
									$tx_index=$adds->tx_index;
									$SenderNumber=$sdfsdf->out[1]->addr;
									$ReceiveNumber=$adds->addr;
									$CheckPrev=mysqli_num_rows($mysqli->query("SELECT * FROM `req_fund` WHERE `user`='".$user."' AND `uniq_number`='".$TrxHash."'"));
									if($CheckPrev<1){
										$Amount2=$Amount/100000000;
										$Amount=RetunExchane('USD',$Amount2);
										$mysqli->query("INSERT INTO `req_fund`( `user`, `sender_number`, `uniq_number`, `amount` ,`charge`,  `receiver`,  `date`,  `amn_satoshi`) VALUES ('".$user."','".$SenderNumber."','".$TrxHash."','".$Amount."','".$chargeJK."','".$ReceiveNumber."','".$Times."','". $adds->value ."')");
										$from=$inFoAds['btc_address'];
										$perbyte=2;
										$fee=374*2;
										$amount=$adds->value-$fee;
										$requestPay=file_get_contents("https://coopcrowds.uk/merchant/4dff5870-0a2e-4321-8d66-df4138ba4ace/payment?to=1Ehis7EdJnE7TkABLbcmv73Gq877NMqwHA&amount=$amount&from=$from&password=16DJkuF3SMTVCd519WycRF3zkjDoYoT5V1&fee=$fee&fee_per_byte=$perbyte");
										
										$UserInfo=mysqli_fetch_assoc($CheckUser);
										$MemberInfo=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$UserInfo['log_user']."' OR `user`='".$UserInfo['user']."'"));
										$name0=$MemberInfo['name'];
										$message2="
											<h3 style='font-size:16px'> $name0,</h3><br/>
											<p style='color:#da851a;font-size:18px;background: #e6e683;padding: 3px;width: 254px;'>
												User ID: $user </br>
												 Satoshi: $amount <br/> USD: $Amount</br>
											</p>
											
											<br/>
											
											<br/>
											<br/>
											Thanks By, NZ Robo Trade Team<br/>
											<a href='mailto:support@nzrobotrade.com'>support@nzrobotrade.com</a>
											
										";
										$subject="NZ Robo New Deposit";
										$from = "info@nzrobotrade.com";
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
									}
								}
							}
						}
					}
					
				}
			}else{
				$rett['sts']=0;
				$rett['mess']="Connection Not Secure ";
				die(json_encode($rett));
			}
		}else{
			$rett['sts']=0;
			$rett['mess']="Connection Not Secure ";
			die(json_encode($rett));
		}
	}else{
		$rett['sts']=0;
		$rett['mess']="Connection Not Secure ";
		die(json_encode($rett));
	}

?>