<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';
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
		
		$reett=array();
		$memberid=$_SESSION["Admin"];
		$user_id = $_GET["ussd"];
		$serial = $_GET["sers"];
		$pinchk=$_GET["khh"];
		$vas=$_GET["vas"];
		$payOPtion=$_GET["payOPtion"];
		if($vas==1){
			$vals="Paid";
		}else{
			$vals="Cancel";
		}
		$query = "select * from admin where user_id='".$memberid."' ";
		$result=  $mysqli->query($query);
		$row =  mysqli_fetch_array($result);					 
		$pincode=$row['tr_password'];	
		
		
		$query3 = "select * from trans_receive where serialno='".$serial."' and status='Pending'";
		$result3=  $mysqli->query($query3);
		$row3 =  mysqli_fetch_array($result3);					 
		$check =  mysqli_num_rows($result3);


		if($check==1){
			if($pinchk==$pincode){
				if($payOPtion==2){
					if($vas==1){
						
					}
				}
				$q="UPDATE trans_receive SET status='".$vals."' where serialno='".$serial."'";	       
				$mysqli->query($q);	
				
				$reett[0]=1;
				$reett[1]="Successfully $vals This";
				echo json_encode($reett);
				die();
			}else{
				$reett[0]=0;
				$reett[1]="Wrong Transaction Password";
				echo json_encode($reett);
				die();
			}
		}else{
			$reett[0]=0;
			$reett[1]="Wrong Donor ID OR Pay ID";
			echo json_encode($reett);
			die();
		}
	}
?>

