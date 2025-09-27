<?php
	$amount=$_GET['amount']*0.92;
	
	function RetunExchane($Exchange,$Amount){
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
		return $yyruie->data->quote->$Exchange->price;
	}
	
	$curencg=array("BTC","ETH","LTC");
	$rett=array();
	$i=0;
	$BTC=10000;
	$ETH=230;
	$LTC=75;
	foreach($curencg as $Infoc){
		if(RetunExchane($Infoc,$amount)<0){
		$mmnbv=$amount/$$Infoc;
		$sdfsd=strlen($mmnbv);
		while($sdfsd<=18){
			$mmnbv=$mmnbv.'0';
			$sdfsd++;
		}
			$rett[$Infoc]=$mmnbv;
		}else{
			$rett[$Infoc]=RetunExchane($Infoc,$amount);
		}
		
		$i++;
	}
	echo json_encode($rett);
	die();
?>