<?php
    session_start(); 
    if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';
		require '../db/functions.php';
		$location=$_POST['location'];
		$check=0;
		$pinWithAmn=array();
		$tetew=count($_POST['pacPin']);
		
		foreach($_POST['pacPin'] as $piAmn){
			$werwe="pinAmn".$piAmn;
			$masdnd=$_POST[$werwe];
			if($masdnd!=''){
				$qwertyU=$piAmn ."/". $masdnd;
				array_push($pinWithAmn, $qwertyU);
			}
		}
		$weew=implode(",", $pinWithAmn);
		
		if($_POST['rank_name']==''){
			$check=1;
			$_SESSION['msg']="Please Submit Rank Name";
			header("Location: $location");
			exit();
		}
		if($_POST['rank_duration']==''){
			$check=1;
			$_SESSION['msg']="Please Submit Rank Duaration";
			header("Location: $location");
			exit();
		}
		$cjhkjs=mysqli_num_rows($mysqli->query("SELECT * FROM `rank_duration` WHERE `rank_name` ='".$_POST['rank_name']."'"));
		if($cjhkjs>0){
			$check=1;
			$_SESSION['msg']="This Rank Already In List Please Edit Your Requirement";
			header("Location: $location");
			exit();
		}
		if($check==0){
			$_POST['pin_bonus']=$weew;
			$cherSA=InsertInfo("rank_duration", $_POST);
			if($cherSA>0){
				$_SESSION['msg1']="Your Rank Added To List";
				header("Location: $location");
				exit();
			}else{
				$_SESSION['msg']="Your Connection Not Secure";
				header("Location: $location");
				exit();
			}
		}else{
			$_SESSION['msg']="Your Connection Not Secure, Try Later";
			header("Location: $location");
			exit();
		}
	}
?>	