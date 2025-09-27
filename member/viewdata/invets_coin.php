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
	shuffle($yyruie->data);
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
	$hgfsdf=array(0,1,2,3,4,5);
	$hgfsdf2=array("+","+","-");
?>
<marquee behavior="scroll" direction="left">
<div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px);">
<?php	
	$jkhgd=array_rand($hgfsdf);
	$jkhgd2=array_rand($hgfsdf2);
	$jshfsd=array_slice($yyruie->data,0,17 );
	foreach($jshfsd as $info){
		$jkhgd=array_rand($hgfsdf);
		$jkhgd2=array_rand($hgfsdf2);
?>

					
						<div class="swiper-slide swiper-slide-active" style="width: 248px; margin-right: 10px;">
							<div class="coin-box flex align-items-center">
								<div class="coin-icon mr-10">
									<img src="https://s2.coinmarketcap.com/static/img/coins/128x128/<?php echo $info->id; ?>.png" alt="">
								</div>
								<div class="coin-balance text-left">
									<h5 class="coin-name boldy"><?php echo $info->symbol; ?> Profit</h5>
									<p class="mb-0"><?php echo $hgfsdf2[$jkhgd2]." ".$hgfsdf[$jkhgd]; ?>%
										<?php if($hgfsdf2[$jkhgd2]=="+"){ ?>
										<i class="complete fa fa-arrow-up ml-10"></i>
										<?php }else{ ?>
										<i class="cancelled fa fa-arrow-down ml-10"></i>
										<?php } ?>
									</p>
								</div>
							</div>
						</div>
					
<?php } ?>
</div>
					</marquee>