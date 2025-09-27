<?php
    session_start();
	if((isset($_SESSION['num_login_fail']))||(!isset($_SESSION['token']))){
		if($_SESSION['num_login_fail'] == 4){
			if(time() - $_SESSION['last_login_time'] < 10*60 ){    
				$ErrorMessage="Hacking Suspect Please wait for 10 minutes Then Try again .";
				header("Location: login.php?ErrorMessage=$ErrorMessage");
				exit();

			}else{
				//after 10 minutes
				$_SESSION['num_login_fail'] = 0;
			}
		}      
	}
		      
	if($_SESSION['num_login_fail']<4){
		include ("../db/db.php"); 
			
		$user = $_POST['userid'];
		$dpass = $_POST['userPassOne'];
		
		$query = "select * from admin where user_id='".$user."' and password='".$dpass."'";	
		$result=$mysqli->query($query);
		$check = mysqli_num_rows($result);
		
		if($check == 1){
			$_SESSION['OriginalAdmin'] = strtolower($user);
			$_SESSION['Admin'] ="admin";
			if($_SESSION['OriginalAdmin']=="message"){
				header("Location: ../nzroboadmin/send_message.php");
				exit;
			}else{
				header("Location: ../nzroboadmin/home.php");
				exit;
			}
			
		}else{
			session_destroy();
			$ErrorMessage = "Invalid ID or Password";
			header("Location: ../nzroboadmin/index.php?ErrorMessage=$ErrorMessage");
			exit;
		}
	}
?>