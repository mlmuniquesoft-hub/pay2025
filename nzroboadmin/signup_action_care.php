<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';

		$user_ID = $_POST['user_id'];       
		$name = $_POST['user_name'];	
		$email = $_POST['email'];
		$contact = $_POST['contact'];
		$password = $_POST['password'];					
		$tr_password = $_POST['tr_password'];
		
		$timezone = "Asia/Dacca";
		if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);	
		$date=date("Y-m-d"); 
			
			$query="SELECT * FROM agent where user_id='$user_ID'";
		$result=$mysqli->query($query);
		$row = mysqli_fetch_array($result);
		$check = mysqli_num_rows($result);

		
		if(($check ==1)&&($row !='')){
			$error = 1;
			$ErrorMessage = "This Coordinator ID Already Used !!! Try Another";
			header("Location:agent.php?ErrorMessage=$ErrorMessage");
			exit;
		}	
		
			
		if($check == 0){	
			$query = "INSERT INTO agent (user_id,password,epin_password,name,date,email,mobile_no)VALUES('".$user_ID."','".$password."','".$tr_password."','".$name."','".$date."','".$email."','".$contact."')";	
			$res =  $mysqli->query($query);

			$ErrorMessage = "Coordinator ID has been created successfully";
			header("Location:agent.php?ErrorMessage=$ErrorMessage");
			exit;
		}else{
			header("Location:agent.php?ErrorMessage=$ErrorMessage");
			exit;
		}
	}
		
			
		
?>


