<?php
	session_start();
	require_once("../../db/db.php");
	$UserID=$_SESSION['roboMember'];
	$Wallet=$_POST['Wallet'];
	$AssIgnTo=$_POST['AssIgnTo'];
	$rett=array();
	if($AssIgnTo==''){
		array_push($rett, 0);
		array_push($rett, "Submit Wallet ID");
		echo json_encode($rett);
		die();
	}
	
	$jkdfhgk=mysqli_num_rows($mysqli->query("SELECT * FROM `wallet_address` WHERE `user`='".$UserID."' AND `wallet`='".$AssIgnTo."' AND `wallet_type`='".$Wallet."'"));
	if($jkdfhgk>0){
		array_push($rett, 0);
		array_push($rett, "Wallet ID Already Exist");
		echo json_encode($rett);
		die();
	}
	$error=count($rett);
	if($error==0){
		$mysqli->query("INSERT INTO `wallet_address` (`user`,`wallet`,`wallet_type`) VALUES ('".$UserID."','".$AssIgnTo."','".$Wallet."')");
		array_push($rett, 1);
		array_push($rett, "Wallet ID Added Successfully");
		echo json_encode($rett);
		die();
	}else{
		array_push($rett, 0);
		array_push($rett, "Network Error, Try Later");
		echo json_encode($rett);
		die();
	}
	
?>