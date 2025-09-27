<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';
		$admin = $_SESSION['OriginalAdmin']; 	             
		$oldPassword = $_POST["oldPassword"];					
		$newPassword1 = $_POST["newPassword1"];
		$newPassword2 = $_POST["newPassword2"];

		$query = "select * from admin where user_id='".$admin."' and tr_password='".$oldPassword."' ";
		$result=$mysqli->query($query);
		$row = mysqli_fetch_array($result);
		$check = mysqli_num_rows($result);
		
		if($newPassword1 != $newPassword2){
			$msg = "Please Enter both New Tr-password Same!!!";
			header("Location: profile.php?msg=$msg");
			exit;				
		}
		
		if($check != 1){
			$msg = "Invalid Admin Tr-Password Please Enter Currect Password!!!";
			header("Location: profile.php?msg=$msg");
			exit;				
		}	
		
		if($check == 1){	
			$query = "UPDATE admin SET tr_password= '".$newPassword1."' WHERE user_id= '".$admin."' ";
			$mysqli->query($query);
			$msg="Tr-Password Changed Successfully for $admin";
			header("Location:profile.php?msg=$msg");
			exit;
		}else{
			$msg="Your Tr-Password Can not be change this time Try later!!!";
			header("Location:profile.php?msg=$msg");
			exit;
		}
		
	}
?>