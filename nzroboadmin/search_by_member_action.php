<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		include ("../db/db.php");
		$usertocheck = $_POST['userID'];
		$usertovar = $_POST['mee'];
		$_SESSION['userID'] =$usertocheck;     
		$query = "select * from member where user='".$usertocheck."' ";
		$result=$mysqli->query($query);
		$show=mysqli_fetch_array($result);
		$row=mysqli_num_rows($result);  
		if($row == 0){
			$msg="Invalid  User ID";
			echo "<script>javascript:history.back();</script>";
			die();
			//header("Location:member_edit.php?msg=$msg");        
		}else{
			if($usertovar=="member3"){
				header("Location:deduct_mem_balance.php?$usertovar=$usertocheck");
			}else{
				header("Location:member_edit.php?$usertovar=$usertocheck");
			}
			 	   
		}
	}
	
?>	