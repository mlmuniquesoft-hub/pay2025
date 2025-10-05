<?php
    session_start(); 
	if((!isset($_SESSION['Admin']))&&(!isset($_SESSION['token']))){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';
		$location=$_POST["location"];
		$pack=$_POST["pack"];
		$dts=base64_decode($_POST["dts"]);
		if($pack!=''){
			$mysqli4=$$dts;
			$mysqli4->query("INSERT INTO `gametype` (`type_name`) VALUES ('".$pack."') ");
			$_SESSION['msg2']='Game Type Name Create Successfuly';
			header("Location: $location");
			exit();
		}else{
			$_SESSION['msg']='Please Select Game Type Name';
			header("Location: $location");
			exit();
			
			
		}
	}
?>