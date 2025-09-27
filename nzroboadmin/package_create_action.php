<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';
		$admin = $_SESSION['Admin'];
		$package=$_POST["package"];
		$charge=$_POST["charge"];
		$sponsor_com=$_POST["sponsor_com"];
		$min_slot=$_POST["min_slot"];
		$max_slot=$_POST["max_slot"];
		$clor=$_POST["clor"];
		$location=$_POST["location"];
		$check=1;
		if($package==''){
			$check=0;
			$_SESSION['msg']="Please Enter A Package!!!";
			header("Location: $location");
			exit();
		}
		if($charge==''){
			$check=0;
			$_SESSION['msg']="Please Enter Charge Amount!!!";
			header("Location: $location");
			exit();
		}
		if($sponsor_com==''){
			$check=0;
			$_SESSION['msg']="Please Enter Sponsor Comission!!!";
			header("Location: $location");
			exit();
		}
		if($min_slot==''){
			$check=0;
			$_SESSION['msg']="Please Enter Min Game Slot!!!";
			header("Location: $location");
			exit();
		}
		if($max_slot==''){
			$check=0;
			$_SESSION['msg']="Please Enter Max Game Slot!!!";
			header("Location: $location");
			exit();
		}
		
		if($check==1){	
			$query = "INSERT INTO `package`(`pack`, `pack_amn`, `color`, `direct_com`,`min_slot`,`max_slot`) VALUES ('".$package."','".$charge."','".$clor."','".$sponsor_com."','".$min_slot."','".$max_slot."')";
			$mysqli->query($query);
			//echo $query;
			//die();
			$_SESSION['msg1']="Your New Package Created Successfully!!";
			header("Location: $location");
			exit();
		}else{
			$_SESSION['msg']="Try Latter";
			header("Location: $location");
			exit();
		} 
	}
?>