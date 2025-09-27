<?php
    session_start();
	if(isset($_SESSION['Admin'])){
		require '../db/db.php';
		$admin = $_SESSION['OriginalAdmin']; 	             
		$oldPassword = $_POST["oldPassword"];					
		$newPassword1 = $_POST["newPassword1"];
		$newPassword2 = $_POST["newPassword2"];

		$query = "select * from admin where user_id='".$admin."' and password='".$oldPassword."' ";
		$result=$mysqli->query($query);
		$row = mysqli_fetch_array($result);
		$check = mysqli_num_rows($result);
		
		if($newPassword1 != $newPassword2){
			$_SESSION['msg'] = "Please Enter both New password Same!!!";
			header("Location:profilepassw.php");
			exit;				
		}	
		
		if($check != 1){
			$_SESSION['msg']  = "Invalid Admin Password Please Enter Currect Password!!!";
			header("Location:profilepassw.php");
			exit;				
		}
		
		if($check == 1){
			$query = "UPDATE admin SET `password`='".$newPassword1."' WHERE user_id= '".$admin."' ";
			$mysqli->query($query);
			$_SESSION['msg1']="Password Changed Successfully for $admin";
			header("Location: profilepassw.php");
			exit;
		}else{
			$_SESSION['msg'] ="Your Password Can not be change this time Try later!!!";
			header("Location: profilepassw.php");
			exit;
		}
		
	} 
	 
	
	
	 
	
	
?>