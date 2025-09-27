<?php
    session_start(); 
    if(!isset($_SESSION['roboMember'])){
    	header("Location:logout.php");
    	exit();
    }else{
		require '../db/db.php';  

		$mobile=$_POST['mobile'];
		$category=$_POST['country'];
		$name=$_POST['Name'];	
		$email=$_POST['email'];	
		$contact00=$_POST['contact'];	
		
		$postal=$_POST['postal'];	
		$state=$_POST['state'];	
		
		$location=$_POST['location'];	
		if($name==''){
			
		}
		
		$mnb=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `user`='".$_SESSION["roboMember"]."'"));
		//contact_num='".$contact00."',mobile='".$mobile."',
		$q="UPDATE profile SET 
		name='".$name."',
		country='".$category."',
		state='".$state."',
		postal='".$postal."'
		WHERE user='".$mnb['user']."' OR user='".$mnb['log_user']."' ";	       
	
		$mysqli->query($q);	

		$_SESSION['msg3'] = "Profile Updated Successfully !!!";
		header("Location:$location");
		exit;
	}		
?>