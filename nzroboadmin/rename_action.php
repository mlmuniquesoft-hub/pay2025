<?php
    session_start(); 
    if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';
		require '../db/functions.php';
		$ip= $_SERVER['REMOTE_ADDR'];
		$asda=array(
			"robo_adminMlm2"=>"mysqli"
		);

		$userabc =	$_POST["pastID"];
		$location =	$_POST["location"];
		
		$pastID = mb_convert_case($userabc, MB_CASE_LOWER, "UTF-8"); 
		if($pastID==''){
			$_SESSION['rename']="Blank Current User ID";
			header("Location: $location");
			exit;	
		}
		$userabc1 =	$_POST["newID"];
		$newID = mb_convert_case($userabc1, MB_CASE_LOWER, "UTF-8"); 
		if($newID==''){
			$_SESSION['rename']="Blank Current User ID";
			header("Location: $location");
			exit;	
		}	
		$query="select * from member where user ='$pastID'";
		$result=$mysqli->query($query);
		$row = mysqli_fetch_array($result);
		$check = mysqli_num_rows($result);	

		if($check == 0){
			$_SESSION['rename']="Please Enter a Valid Current User ID!!";
			header("Location: $location");
			exit;				
		}	
		$query1 = "select * from member where user ='$newID'";	
		$result1=$mysqli->query($query1);	
		$row1 = mysqli_fetch_array($result1);
		$check1 = mysqli_num_rows($result1);	
		if($check1 > 0){
			$_SESSION['rename']="New User ID already Exist in Database!!";
			header("Location: $location");
			exit;				
		}
		if($check1 == 0){
			RenameID($pastID,$newID, $asda);
			$_SESSION['rename1']="New User ID Rename Successfully!!";
			header("Location: $location");
			exit;				
		}
	}
?>	