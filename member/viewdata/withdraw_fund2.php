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

	// Decode the withdrawal queue to get transaction details
	$ueyuer=base64_decode($dfgjkdf['withdraw_que']);
	$uiyeri=explode(",",$ueyuer);
	
	$hsgf=strlen($uiyeri[11]);
	$Amount=substr($uiyeri[11],1,$hsgf-2);
	$NumberOfToken=$Amount;
	
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
			$method=$uiyeri[16];
			$hfgsd=strlen($method);
			$method=substr($method,1,$hfgsd-2);
			$uietyer=explode(":", $method);
			$method=$uietyer[0];
			$description="$NumberOfToken Withdraw To $method";
			$messager="Withdraw Successful";
		}else{
			$method=$uiyeri[15];
			$hfgsd=strlen($method);
			$AssIgnTo=substr($method,1,$hfgsd-2);
			$description="$NumberOfToken Transfer To $AssIgnTo";
			$messager="Transfer Successful";
		}
		
		// Execute the base64 encoded withdrawal query but modify it to set status as 'Complete'
		$decodedQuery = base64_decode($dfgjkdf['withdraw_que']);
		
		// Replace 'Pending' with 'Complete' in the query before executing
		$finalQuery = str_replace("'Pending'", "'Complete'", $decodedQuery);
		
		$insertResult = $mysqli->query($finalQuery);
		
		if(!$insertResult){
			array_push($rett,0);
			array_push($rett,"Database error: Could not create transaction record - " . $mysqli->error);
			echo json_encode($rett);
			die();
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