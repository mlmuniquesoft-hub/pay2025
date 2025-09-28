<?php
	session_start();
	$_SESSION['token']='123asda';
	require_once("../../db/db.php");
	require_once("../../db/functions.php");
	$conn=$mysqli;
	
	if(!isset($_GET['serial'])){
		echo json_encode([0, "Invalid request"]);
		die();
	}
	
	$serial=$_GET['serial'];
	$dfgjkdf=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `widraw_req` WHERE `serial`='".$serial."'"));
	
	if(!$dfgjkdf){
		echo json_encode([0, "Withdrawal request not found"]);
		die();
	}
	
	$userID=$dfgjkdf['user'];

	// For withdrawals, withdraw_que now contains transaction ID instead of base64 query
	if($dfgjkdf['type']=='Withdraw'){
		$transactionId = $dfgjkdf['withdraw_que'];
		
		// Get transaction details from trans_receive table
		$transQuery = $mysqli->query("SELECT * FROM `trans_receive` WHERE `serialno`='".$transactionId."' AND `user_trans`='".$userID."' AND `status`='Pending'");
		
		if(mysqli_num_rows($transQuery) == 0){
			echo json_encode([0, "Transaction not found or already processed"]);
			die();
		}
		
		$transData = mysqli_fetch_assoc($transQuery);
		$NumberOfToken = $transData['ammount'];
		$method = $transData['method'];
		$description = "$NumberOfToken Withdraw via " . $method;
		$messager = "Withdraw Confirmed - Pending Admin Payment";
		
	}else{
		// For transfers, keep the original base64 approach
		$ueyuer=base64_decode($dfgjkdf['withdraw_que']);
		$uiyeri=explode(",",$ueyuer);
		
		$hsgf=strlen($uiyeri[11]);
		$Amount=substr($uiyeri[11],1,$hsgf-2);
		$NumberOfToken=$Amount;
		$method=$uiyeri[15];
		$hfgsd=strlen($method);
		$AssIgnTo=substr($method,1,$hfgsd-2);
		$description="$NumberOfToken Transfer To $AssIgnTo";
		$messager="Transfer Successful";
	}
	
	// Since balance was already checked when withdrawal was requested,
	// and the withdrawal is marked as Pending (already deducted),
	// we just need to complete the transaction
	
	$rett=array();
	
	// Double check balance to prevent overdraft
	$currentBalance=remainAmn($userID);
	if($currentBalance < 0){
		array_push($rett,0);
		array_push($rett,"Insufficient Balance - Transaction cannot be completed");
		echo json_encode($rett);
		die();
	}
	
	
	$countU=count($rett);
	$tax=0;
	$comm=0;
	if($countU==0){
		$date=date("Y-m-d");
		
		if($dfgjkdf['type']=='Withdraw'){
			// Update the existing transaction status from 'Pending' to 'Complete'
			$updateQuery = "UPDATE `trans_receive` SET `status`='Complete' WHERE `serialno`='".$transactionId."' AND `user_trans`='".$userID."'";
			$updateResult = $mysqli->query($updateQuery);
			
			if(!$updateResult){
				array_push($rett,0);
				array_push($rett,"Database error: Could not update transaction status - " . $mysqli->error);
				echo json_encode($rett);
				die();
			}
			
		}else{
			// For transfers, execute the base64 encoded query as before
			$decodedQuery = base64_decode($dfgjkdf['withdraw_que']);
			$finalQuery = str_replace("'Pending'", "'Complete'", $decodedQuery);
			
			$insertResult = $mysqli->query($finalQuery);
			
			if(!$insertResult){
				array_push($rett,0);
				array_push($rett,"Database error: Could not create transaction record - " . $mysqli->error);
				echo json_encode($rett);
				die();
			}
		}
		
		// Add transaction to view table for user's transaction history
		$mysqli->query("INSERT INTO `view`(`user`, `date`, `description`, `amount`, `types`) VALUES ('".$userID."', '".$date."', '".$description."', '".$NumberOfToken."','Debit')");
		
		// Remove the withdrawal request from pending queue
		$mysqli->query("DELETE FROM `widraw_req` WHERE `serial`='".$serial."'");
		
		array_push($rett,1);
		array_push($rett,$messager);
		array_push($rett,$userID);
		echo json_encode($rett);
		die();
	}else{
		array_push($rett,0);
		array_push($rett,"Insufficient Balance");
		echo json_encode($rett);
		die();
	}
	
?>