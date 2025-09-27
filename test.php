<?php
	//var_dump(base64_decode("SU5TRVJUIElOVE8gYG1lbWJlcmAoYHVzZXJgLGBsb2dfdXNlcmAsIGBwYXNzd29yZGAsIGBwaW5gLCBgcG9zaXRpb25gLCBgdXBsaW5lYCwgYHBhY2tgLGBwb2ludGAsIGBkaXJlY3RgLCBgc3BvbnNvcmAsIGBkYXRlYCxgYWN0aXZlYCkNCgkJCQkJCSAgVkFMVUVTKCd3ZXJxMTIzJywnNTE3NDAwMycsJzhjZTg3YjhlYzM0NmZmNGM4MDYzNWY2NjdkMTU5MmFlJywnMTIxMjEyJywnMScsJ3N1dm8nLCcwJywnMCcsJzAnLCdyb2JvdHJhZGUnLCcyMDE5LTExLTE4JywnMCcp"));
	//var_dump(base64_decode("SU5TRVJUIElOVE8gYG1lbWJlcmAoYHVzZXJgLGBsb2dfdXNlcmAsIGBwYXNzd29yZGAsIGBwaW5gLCBgcG9zaXRpb25gLCBgdXBsaW5lYCwgYHBhY2tgLGBwb2ludGAsIGBkaXJlY3RgLCBgc3BvbnNvcmAsIGBkYXRlYCxgYWN0aXZlYCkNCgkJCQkJCSAgVkFMVUVTKCdBYmlyMjAwMScsJzAyNTczMTQnLCdjNTFjZDhlNjRiMGFlYjc3ODM2NDc2NTAxM2RmOWViZScsJ3ExMjM0NTY3JywnMScsJ3N1dm8nLCcwJywnMCcsJzAnLCdyb2JvdHJhZGUnLCcyMDE5LTExLTE4JywnMCcp"));
	
	session_start();
	$_SESSION['token']="Hello";
	require_once("db/db.php");
	$timezone = "Pacific/Auckland"; // Asia/Dacca
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);	
	$jkhkjsd=$mysqli->query("SELECT * FROM `game_return`");
	$ExpDateP=array("Sun","Sat");
	while($jkhkjsd2=mysqli_fetch_assoc($jkhkjsd)){
		$ghsdfs=date("D", strtotime($jkhkjsd2['date']));
		$ghsdfs2=date("Y-m-d", strtotime($jkhkjsd2['date']));
		if(in_array($ghsdfs,$ExpDateP)){
			$jkhsfkjs=mysqli_num_rows($mysqli->query("SELECT * FROM `game_return` WHERE DATE(`date`)='".$ghsdfs2."'"));
			//$mysqli->query("DELETE FROM `game_return` WHERE DATE(`date`)='".$ghsdfs2."'");
			echo $ghsdfs." >> $ghsdfs2 >> $jkhsfkjs<br/>";
		}
	}

	/*
	$datrsd=base64_decode('SU5TRVJUIElOVE8gdHJhbnNfcmVjZWl2ZShgdXNlcl90cmFuc2AsYGFtbW91bnRgLGB0YXhgLGBjX3dhbGxldGAsZGF0ZSx1c2VyX3JlY2VpdmUsbWV0aG9kLHN0YXR1cyxyZW1hcmssdHlwZSxhY2NvdW50KQ0KCQkJCVZBTFVFUyAoJ3J1cmFsJywnNTAnLCc0JywnMC4wMDQ5NTQ2MzU3MTg5MzA3OTInLCcyMDIwLTAyLTAxJywnT2ZmaWNlJywnQlRDOiAxR3Q3aExhcVBFbnNTVXVtdzhldllnM3pmczR5MnJnNUVKJywnUGVuZGluZycsJycsJ1dpdGhkcmF3JywnQWRtaW4nKQ==');
	$hjgfs=explode(",", $datrsd);
	var_dump($datrsd);
	var_dump($hjgfs);
	*/
	//$erter=file_get_contents("https://nzrobotrade.com/member/viewdata/withdraw_fund2.php?serial=$serial");
	//var_dump($erter);
	/*$hjfgd=$mysqli->query("SELECT * FROM `profile` WHERE `email`='mainur22@gmail.com'");
	while($asda=mysqli_fetch_assoc($hjfgd)){
		$kjhs=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `user`='".$asda['user']."' OR `log_user`='".$asda['user']."'"));
		echo $kjhs['user']."<br/>";
		$mysqli->query("DELETE FROM `member` WHERE `user`='".$kjhs['user']."'");
		$mysqli->query("DELETE FROM `profile` WHERE `user`='".$kjhs['user']."'");
		$mysqli->query("DELETE FROM `balance` WHERE `user`='".$kjhs['user']."'");
		if($kjhs['date']=='2019-11-19'){
			echo $kjhs['user']."<br/>";
			//$mysqli->query("DELETE FROM `member` WHERE `user`='".$kjhs['user']."'");
		}
	}*/
	/*function count_user($user, &$rrr , $posiit){
		global $mysqli;
		if(!in_array($user, $rrr)){
			array_push($rrr, $user);
		}
		$exe2 = $mysqli->query("SELECT user,upline,`position` FROM member WHERE upline='".$user."' AND `position`='".$posiit."'");
		while($result2=mysqli_fetch_array($exe2)){
			if(!in_array($result2['user'], $rrr)){
				if($posiit==$result2['position']){
					//echo $result2['user'] ."<br/>";
					array_push($rrr, $result2['user']);
				}
			}
			count_user($result2['user'], $rrr, $posiit);
		}
	}
	function SearchPlace($user,$position){
		global $mysqli;
		$rett=array();
		$ereww=strlen($user);
		$user=substr($user, 1, $ereww-2);
		$sdffd=substr($position, 1,1);
		settype($sdffd, "integer");
		$position=$sdffd;
		
		$cgghh=$mysqli->query("SELECT * FROM `member` WHERE `upline`='".$user."' AND `position`='".$position."'");
		$CheckSponsor=mysqli_num_rows($cgghh);
		if($CheckSponsor>0){
			$nextId=mysqli_fetch_assoc($cgghh);
			count_user($nextId['user'], $rett, $position);
		}else{
			array_push($rett,$user);
		}
		
		return $rett;
	}
	
	
	$information=base64_decode("SU5TRVJUIElOVE8gYG1lbWJlcmAoYHVzZXJgLGBsb2dfdXNlcmAsIGBwYXNzd29yZGAsIGBwaW5gLCBgcG9zaXRpb25gLCBgdXBsaW5lYCwgYHBhY2tgLGBwb2ludGAsIGBkaXJlY3RgLCBgc3BvbnNvcmAsIGBkYXRlYCxgYWN0aXZlYCkNCgkJCQkJCSAgVkFMVUVTKCdmZ3MxMicsJzE4NDY3OTknLCc4Y2U4N2I4ZWMzNDZmZjRjODA2MzVmNjY3ZDE1OTJhZScsJzEyMTIxMicsJzEnLCdzZGZkczMnLCcwJywnMCcsJzAnLCdzZGZkczMnLCcyMDE5LTExLTIwJywnMCcp");
	$PartInfo=explode(",", $information);
	//var_dump(trim($PartInfo[15]));
	//var_dump(trim($PartInfo[16]));
	$referrence0=trim($PartInfo[16]);
	$poss=trim($PartInfo[15]);
	$InfoPlaceId=SearchPlace($referrence0,$poss);
	$iii=count($InfoPlaceId);
	var_dump($InfoPlaceId);
	$placement0 =strtolower($InfoPlaceId[$iii-1]);
	//var_dump($placement0);
	$PartInfo[16]=$placement0;
	$hdfgd=implode(",", $PartInfo);
	*/
	//var_dump($information);
	//var_dump($hdfgd);

		//$StandardFee=json_decode(file_get_contents("https://bitcoinfees.earn.com/api/v1/fees/recommended"));
		//var_dump($StandardFee);
		/*$baseUrl="https://blockchain.info/rawaddr/1D34PoC9N3meg5bUdhJc3GvfW2BRXKdU1y";
		$ere=json_decode(file_get_contents($baseUrl));
		foreach($ere->txs as $sdfsdf){
			foreach($sdfsdf->out as $adds){
				$ddress=$adds->addr;
				if($ddress=="1D34PoC9N3meg5bUdhJc3GvfW2BRXKdU1y"){
					var_dump($adds->value);
				}
			}
		}*/
		/*function RetunExchane($Exchange,$Amount){
			$url = 'https://pro-api.coinmarketcap.com/v1/tools/price-conversion';
			$parameters = [
				'symbol' => 'USD',
				'amount' => $Amount,
				'convert' => $Exchange
			];
			$headers = [
				'Accepts: application/json',
				'X-CMC_PRO_API_KEY: 5b6d4b10-d52a-46ca-8f63-946e2673e042'
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
			$HJgsds=$yyruie->data->quote->$Exchange->price;
			if($HJgsds<=0){
				$BTC=10000;
				$ETH=230;
				$LTC=75;
				$mmnbv=$amount/$$Exchange;
				$sdfsd=strlen($mmnbv);
				while($sdfsd<=18){
					$mmnbv=$mmnbv.'0';
					$sdfsd++;
				}
				
				return $mmnbv;
			}else{
				return $HJgsds;
			}
		}


$BaseUrl="https://coopcrowds.uk/merchant/4dff5870-0a2e-4321-8d66-df4138ba4ace/list?password=16DJkuF3SMTVCd519WycRF3zkjDoYoT5V1";
$DatS=json_decode(file_get_contents($BaseUrl));
//var_dump($DatS->addresses);
$i=0;
$amount=100;
$BTCHG=RetunExchane("BTC",$amount);
$fee_perByte=2;
$fee=374*$fee_perByte;
$Satoshi=($BTCHG*100000000)+$fee;
$CollectedAmount=0;
$Assd=array();
foreach($DatS->addresses as $dtss){
	$CollectedAmount=$CollectedAmount+$dtss->balance;
	if($CollectedAmount<=$Satoshi){
		$Assd[$dtss->address]=$dtss->balance;
	}else{
		break;
	}
	var_dump($dtss->balance);
	$i++;
}*/
?>