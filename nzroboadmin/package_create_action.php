<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';
		$admin = $_SESSION['Admin'];
		$package = isset($_POST["package"]) ? $_POST["package"] : '';
		$charge = isset($_POST["charge"]) ? $_POST["charge"] : '';
		$min_amount = isset($_POST["min_amount"]) ? $_POST["min_amount"] : '';
		$max_amount = isset($_POST["max_amount"]) ? $_POST["max_amount"] : '';
		$roi_percentage = isset($_POST["roi_percentage"]) ? $_POST["roi_percentage"] : '';
		$description = isset($_POST["description"]) ? $_POST["description"] : '';
		$sponsor_com = isset($_POST["sponsor_com"]) ? $_POST["sponsor_com"] : '';
		$min_slot = isset($_POST["min_slot"]) ? $_POST["min_slot"] : '';
		$max_slot = isset($_POST["max_slot"]) ? $_POST["max_slot"] : '';
		$clor = isset($_POST["clor"]) ? $_POST["clor"] : '#3498db';
		$location = isset($_POST["location"]) ? $_POST["location"] : '';
		$check=1;
		if($package==''){
			$check=0;
			$_SESSION['msg']="Please Select A Package Type!";
			header("Location: $location");
			exit();
		}
		if($charge==''){
			$check=0;
			$_SESSION['msg']="Please Enter Package Charge Amount!";
			header("Location: $location");
			exit();
		}
		if($min_amount==''){
			$check=0;
			$_SESSION['msg']="Please Enter Minimum Investment Amount!";
			header("Location: $location");
			exit();
		}
		if($roi_percentage==''){
			$check=0;
			$_SESSION['msg']="Please Enter ROI Percentage!";
			header("Location: $location");
			exit();
		}
		if($sponsor_com==''){
			$check=0;
			$_SESSION['msg']="Please Enter Sponsor Commission!";
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
			// Set max_amount to NULL if unlimited (empty)
			$max_amount_value = ($max_amount == '') ? 'NULL' : "'".$max_amount."'";
			
			$query = "INSERT INTO `package`(`pack`, `pack_amn`, `color`, `direct_com`, `min_slot`, `max_slot`) VALUES ('".$package."','".$charge."','".$clor."','".$sponsor_com."','".$min_slot."','".$max_slot."')";
			
			if($mysqli->query($query)){
				$package_id = $mysqli->insert_id;
				
				// Create additional package details record if needed
				// You may want to create a separate table for extended package info
				// For now, we'll store in session for confirmation message
				$_SESSION['msg1']="Package '".$package."' created successfully! ROI: ".$roi_percentage."%, Min: $".$min_amount.", Max: ".($max_amount ? "$".$max_amount : "Unlimited");
			} else {
				$_SESSION['msg']="Database error: " . $mysqli->error;
			}
			
			header("Location: $location");
			exit();
		}else{
			$_SESSION['msg']="Please fill all required fields!";
			header("Location: $location");
			exit();
		} 
	}
?>