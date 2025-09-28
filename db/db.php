<?php
	// PHP 8.2 compatibility: Only check session if not already in member context
	$in_member_context = (strpos($_SERVER['PHP_SELF'], '/member/') !== false) || 
	                     (isset($_SESSION['roboMember']));
	
	if (!$in_member_context) {
		// Admin area session check
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		
		if(!isset($_SESSION['token'])) {
			if (!headers_sent()) {
				header("Location:../index.html");
				exit();
			}
		}
	}
	
	$host="localhost";
	$database="robo_adminMlm2";
	$user="robo_adminMlm2";
	$password='sPdt~j^tw1p5lIV8';
	//$port="3306";		
	$mysqli = new mysqli("$host","$user","$password","$database");	//,"$port"
	
	//$host='54.36.123.12';
	//$database="dcryto_ssgf";
	//$user="dcryto_ssgf";
	//$password='sPdt~j^tw1p5lIV8';
	//$port="3306";
	
		
		
	

	if (mysqli_connect_errno()) 
	{
	  echo "Failed to connect to MySQL Database " . mysqli_connect_error();
	  exit();
	}
		
	$timezone = "Pacific/Auckland"; // Asia/Dacca
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);	
	//$date=date("Y-m-d"); 
	
	if(!empty($_SERVER['HTTP_CLIENT_IP'])){$ip=$_SERVER['HTTP_CLIENT_IP'];}
	elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];}
	else{$ip=$_SERVER['REMOTE_ADDR'];}
	
	//$_POST = array_map('strip_tags', json_decode(stripslashes(json_encode($_POST, JSON_HEX_APOS)), true));
	$_GET = array_map('strip_tags', json_decode(stripslashes(json_encode($_GET, JSON_HEX_APOS)), true));
	$_COOKIE = array_map('strip_tags', json_decode(stripslashes(json_encode($_COOKIE, JSON_HEX_APOS)), true));
	$_REQUEST = array_map('strip_tags',json_decode(stripslashes(json_encode($_REQUEST, JSON_HEX_APOS)), true));
	
	if(isset($_GET['limit'])){
		$limit=$mysqli->real_escape_string($_GET['limit']);
	}
	if(isset($_GET['type'])){
		$type=$mysqli->real_escape_string($_GET['type']);
	}
	if(isset($_GET['page'])){
		$page=$mysqli->real_escape_string($_GET['page']);
	}
	
	
	

	$titel="";
	
	function RetunExchane22($Exchange,$Amount){
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

?>