<?php
	session_start();
	$_SESSION['token']="kjdhfkjhds jkf";
	
	
	# This example requires curl is enabled in php.ini
	$url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
	$parameters = [
		'start' => '1',
		'limit' => '50',
		'convert'=> 'USD',
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
	shuffle($yyruie->data);
	
	$hgfsdf=array(0,1,2,3,4,5);
	$hgfsdf2=array("+","+","-");

	
	$text=rand(50,99999);
	$sfds=array("+:green-text","-:red-text");
	$dfgfdg3=array_rand($sfds);
	$Byertre3=explode(":", $sfds[$dfgfdg3]);
	$Byertre=explode(":", $Activirt[$dfgfdg]);
	$ActiStret=array("completed:success","Pending:warning","Canceled:danger");
	$dfgfdg2=array_rand($ActiStret);
	$Byertre2=explode(":", $ActiStret[$dfgfdg2]);
	$srereer=array(1,2,3,4,5,6,7,8,9);
	shuffle($srereer);
	$dfgfdg21=array_rand($srereer);
	$dfdfdg="+".$srereer[$dfgfdg21]." second";
	
?>
	<tr>
		<td>
			<div class="round img2">
				<img src="https://s2.coinmarketcap.com/static/img/coins/32x32/<?php echo $yyruie->data[0]->id; ?>.png" alt="">
			</div>
			<div class="designer-info">
				<h6><?php echo $yyruie->data[0]->symbol; ?></h6>
				
			</div>
		</td>
		<td><small class="text-muted"><?php echo date("H:i:s", strtotime($dfdfdg)); ?></small></td>
		<td><span class="badge w-70 round-<?php echo $Byertre2[1]; ?>"><?php echo $Byertre2[0]; ?></span></td>
		<td class="<?php echo $Byertre3[1]; ?> boldy"><?php echo $Byertre3[0]; ?><?php echo $text; ?> <?php echo $yyruie->data[0]->symbol; ?></td>
		
	</tr>