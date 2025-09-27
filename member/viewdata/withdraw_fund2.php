<?php
	session_start();
	$_SESSION['token']='123asda';
	require_once("../../db/db.php");
	require_once("../../db/functions.php");
	$conn=$mysqli;
	$serial=$_GET['serial'];
	$dfgjkdf=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `widraw_req` WHERE `serial`='".$serial."'"));
	$userID=$dfgjkdf['user'];

	$ueyuer=base64_decode($dfgjkdf['withdraw_que']);
	$uiyeri=explode(",",$ueyuer);
	
	$hsgf=count($uiyeri[11]);
	$Amount=substr($uiyeri[11],1,$hsgf-2);
	$NumberOfToken=$Amount;
	$BalanceSts=remainAmn22($userID);
	
	$rett=array();
	
	
	if($NumberOfToken>$BalanceSts['final']){
		array_push($rett,0);
		array_push($rett,"Insufficient Balance");
		echo json_encode($rett);
		die();
		
		
	}
	
	
	$countU=count($rett);
	$tax=0;
	$comm=0;
	if($countU==0){
		//$UserInf=mysqli_fetch_assoc($djfgh);
		//$AssIgnTo=$UserInf['user'];
		
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
		
		$mysqli->query($ueyuer);
				 
		$mysqli->query("INSERT INTO `view`(`user`, `date`, `description`, `amount`, `types`) VALUES ('".$userID."', '".$date."', '".$description."', '".$NumberOfToken."','Debit')");
		
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