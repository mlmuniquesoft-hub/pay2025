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
	
	// Auto-detect environment (local vs live server)
	$is_local = (
		$_SERVER['HTTP_HOST'] === 'localhost' || 
		$_SERVER['HTTP_HOST'] === '127.0.0.1' || 
		strpos($_SERVER['HTTP_HOST'], 'localhost:') === 0 ||
		$_SERVER['SERVER_NAME'] === 'localhost' ||
		isset($_SERVER['XAMPP_ROOT'])
	);
	
	if ($is_local) {
		// Local development settings
		$host = "localhost";
		$database = "robo_adminMlm2";  // Local database name
		$user = "root";              // Default XAMPP MySQL user
		$password = "";              // Default XAMPP MySQL password (empty)
		$port = "3306";
	} else {
		// Live server settings
		$host = "localhost";  // or use '54.36.123.12' if needed
		$database = "robo_adminMlm2";
		$user = "robo_adminMlm2";
		$password = 'sPdt~j^tw1p5lIV8';
		$port = "3306";
	}
	
	$mysqli = new mysqli($host, $user, $password, $database, $port);
	
		
		
	

	if (mysqli_connect_errno()) 
	{
	  echo "Failed to connect to MySQL Database " . mysqli_connect_error();
	  exit();
	}
	
	// // Auto-create required tables for manual deposit system
	// function createRequiredTables($mysqli) {
	// 	// Create manual_deposits table
	// 	$manual_deposits_sql = "CREATE TABLE IF NOT EXISTS `manual_deposits` (
	// 		`id` int(11) NOT NULL AUTO_INCREMENT,
	// 		`user_id` varchar(50) NOT NULL,
	// 		`crypto_type` varchar(10) NOT NULL,
	// 		`amount` decimal(10,2) NOT NULL,
	// 		`usd_amount` decimal(10,2) NOT NULL,
	// 		`transaction_hash` varchar(255) DEFAULT NULL,
	// 		`wallet_address` varchar(255) DEFAULT NULL,
	// 		`screenshot` varchar(255) DEFAULT NULL,
	// 		`status` enum('pending','approved','rejected') DEFAULT 'pending',
	// 		`admin_note` text DEFAULT NULL,
	// 		`created_at` timestamp NOT NULL DEFAULT current_timestamp(),
	// 		`updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
	// 		PRIMARY KEY (`id`),
	// 		KEY `user_id` (`user_id`),
	// 		KEY `status` (`status`),
	// 		KEY `created_at` (`created_at`)
	// 	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
		
	// 	// Create manual_wallets table  
	// 	$manual_wallets_sql = "CREATE TABLE IF NOT EXISTS `manual_wallets` (
	// 		`id` int(11) NOT NULL AUTO_INCREMENT,
	// 		`crypto_type` varchar(10) NOT NULL,
	// 		`wallet_address` varchar(255) NOT NULL,
	// 		`qr_code` varchar(255) DEFAULT NULL,
	// 		`is_active` tinyint(1) DEFAULT 1,
	// 		`created_at` timestamp NOT NULL DEFAULT current_timestamp(),
	// 		`updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
	// 		PRIMARY KEY (`id`),
	// 		UNIQUE KEY `crypto_type` (`crypto_type`)
	// 	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
		
	// 	// Execute table creation queries
	// 	$mysqli->query($manual_deposits_sql);
	// 	$mysqli->query($manual_wallets_sql);
		
	// 	// Insert default wallet addresses if they don't exist
	// 	$default_wallets = [
	// 		['BTC', 'bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh'],
	// 		['ETH', '0x8ba1f109551bD432803012645Hac136c'],
	// 		['USDT', 'TQn9Y2khEsLJW1ChVWFMSMeGdSBp1eTa4'],
	// 		['LTC', 'LQ4KvEGP8T5dVbUv3j9j8fTnx8VJZgCzQz']
	// 	];
		
	// 	foreach($default_wallets as $wallet) {
	// 		$check_sql = "SELECT id FROM manual_wallets WHERE crypto_type = ?";
	// 		$check_stmt = $mysqli->prepare($check_sql);
	// 		$check_stmt->bind_param("s", $wallet[0]);
	// 		$check_stmt->execute();
	// 		$result = $check_stmt->get_result();
			
	// 		if($result->num_rows == 0) {
	// 			$insert_sql = "INSERT INTO manual_wallets (crypto_type, wallet_address) VALUES (?, ?)";
	// 			$insert_stmt = $mysqli->prepare($insert_sql);
	// 			$insert_stmt->bind_param("ss", $wallet[0], $wallet[1]);
	// 			$insert_stmt->execute();
	// 		}
	// 	}
	// }
	
	// // Create tables on both local and live server
	// createRequiredTables($mysqli);
		
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
	
	// Initialize pagination variables with defaults
	$limit = 100;
	$page = 1;
	$type = '';
	
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
	
	if (!function_exists('RetunExchane22')) {
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
	}

?>