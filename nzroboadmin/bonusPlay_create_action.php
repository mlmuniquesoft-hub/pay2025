<?php
	session_start();
	if(($_SESSION['Admin']=='')||(!isset($_SESSION['Admin']))){
    	header("Location:logout.php");
    	exit();
    }else{
		require '../db/db.php';
		require '../db/functions.php';
		
		$pinQQ=$_POST['pinQQ'];
		$pin=$_POST['trPass'];
		$location=$_POST['location'];
		$chekk=1;
		
		
		$gghh=mysqli_num_rows($mysqli->query("SELECT * FROM `admin` WHERE `user_id`='".$_SESSION['Admin']."' AND `tr_password`='".$pin."'"));
		if($gghh<1){
			$chekk=0;
			$_SESSION['msg']="Please Insert Your Correct Transaction Pin";
			header("Location: $location");
			exit();
		}
		if($chekk==1){
			$rrtt=InsertInfo("bunus_play", $_POST);
			$_SESSION['msg']="Your Bonus Play Create Successfull";
			header("Location: $location");
			exit();
		
		}else{
			$_SESSION['msg']="Your Connection Not Secure Try Latter";
			header("Location: $location");
			exit();
		}
		
		
	}
?>