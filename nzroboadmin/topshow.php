<?php
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

?>
					<div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <a href="#">
                                <div class="card  summary-inline" style="background-color: #8abf2e;color:white;">
                                    <div class="card-body">
                                        <div class="content">
                                            <div class="title" style="font-size: 30px;">$<?php 
												//$baseUrl="https://coopcrowds.uk/merchant/4dff5870-0a2e-4321-8d66-df4138ba4ace/balance?password=16DJkuF3SMTVCd519WycRF3zkjDoYoT5V1";
												//$ere=json_decode(file_get_contents($baseUrl));
												echo 0;//number_format(RetunExchane("USD",$ere->balance/100000000), 2,'.','');
											?></div>
                                            <div class="sub-title" style="font-size: 1.3em;color: #0849da;">BTC Balance</div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <a href="#">
                                <div class="card  summary-inline" style="background-color: #f5b7f1;">
                                    <div class="card-body">
                                        <div class="content">
                                            <div class="title" style="font-size: 30px;">$ <?php 
												$kdfgdf21=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) AS tolk2 FROM `admin_trans_receive`"));
												$msdfsd=$kdfgdf21['tolk2'];
												if($msdfsd>0){
													echo $msdfsd;
												}else{
													echo '0.00';
												}
											?></div>
                                            <div class="sub-title" style="font-size: 1.3em;color: #0849da;">Send To Member</div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                       <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <a href="btc_fund.php">
                                <div class="card  summary-inline" style="background-color: #f79af1;">
                                    <div class="card-body">
                                        <div class="content">
                                            <div class="title" style="font-size: 30px;">$ 
											<?php 
												$kdfgdf2=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) AS tolk2 FROM `req_fund`"));
												$memberChagre=$kdfgdf2['tolk2'];
												if($memberChagre>0){
													echo $memberChagre-372.22;
												}else{
													echo '0.00';
												}
											?></div>
                                            <div class="sub-title" style="font-size: 1.3em;color: #0849da;">BTC Deposit</div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                       <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <a href="#">
                                <div class="card  summary-inline" style="background-color: #dc7bd6;">
                                    <div class="card-body">
                                        <div class="content">
                                            <div class="title" style="font-size: 30px;">$ <?php 
												$kdfgdf2=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) AS tolk2 FROM `upgrade`"));
												$memberBot=$kdfgdf2['tolk2'];
												if($memberBot>0){
													echo $memberBot;
												}else{
													echo '0.00';
												}
												
											?></div>
                                            <div class="sub-title" style="font-size: 1.3em;color: #0849da;">BOT Purchase</div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
						