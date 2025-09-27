<?php
	session_start();
	$_SESSION['token']="kjdhfkjhds jkf";
	
	
	# This example requires curl is enabled in php.ini
	$url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
	$parameters = [
		'start' => '1',
		'limit' => '17',
		'convert'=> 'USD',
	];

	$headers = [
		'Accepts: application/json',
		'X-CMC_PRO_API_KEY: 59f0bf9e-40e9-4128-8199-96e799643a90'
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
	
	function cloert($data){
		if($data<0){
			$cok1='<i class="cancelled fa fa-arrow-down ml-10"></i>';
		}else{
			$cok1='<i class="complete fa fa-arrow-up ml-10"></i>';
		}
		return $cok1;
	}
	function cloert2($data){
		if($data<0){
			$cok1='red';
		}else{
			$cok1='green';
		}
		return $cok1;
	}
	
?>
<marquee behavior="scroll" direction="up">
<?php	
	foreach($yyruie->data as $info){ 
?>
	
	<div class="coin-box2 mb-0 flex align-items-center">
		<div class="coin-icon mr-10">
			<img src="https://s2.coinmarketcap.com/static/img/coins/32x32/<?php echo $info->id; ?>.png" alt="">
		</div>
		<h5 class="coin-name boldy"><?php echo $info->name; ?></h5>
		<h5 class="coin-price boldy">$<?php echo number_format($info->quote->USD->price,2 ,'.',''); ?></h5>
		<p class="mb-0 <?php echo cloert2($info->quote->USD->percent_change_1h); ?>-text" style="font-size:13px;"><?php echo number_format($info->quote->USD->percent_change_1h, 2, '.', ','); ?>%<?php echo cloert($info->quote->USD->percent_change_1h); ?></p>
	</div>
	
<?php } ?>		
</marquee>