<?php
	session_start();
	if(($_SESSION['Admin']=='')||(!isset($_SESSION['Admin']))){
    	header("Location:logout.php");
    	exit();
    }else{
		require '../db/db.php';
		require '../db/functions.php';
		$location=$_POST['location'];
		$game_title=$_POST['game_title'];
		$game_details=$_POST['game_details'];
		$gameName=$_POST['gameName'];
		
		$chk=0;
		if($game_title==''){
			$_SESSION['msg']="Please Submit a Game Title";
			header("Location: $location");
			exit();
		}
		if($game_details==''){
			$_SESSION['msg']="Please Submit a Game Details";
			header("Location: $location");
			exit();
		}
		if($gameName==''){
			$_SESSION['msg']="Please Submit a Game Name";
			header("Location: $location");
			exit();
		}
		
		if(($game_title!='')&&($game_details!='')){
			
			$gfd=InsertInfo("game_details", $_POST);
			if($gfd==1){
				//move_uploaded_file($Tmpimghh, "../gameIcon/$imghh");
				$_SESSION['msg1']="Game Details Submit Successfully";
				header("Location: $location");
				exit();
			}else{
				$_SESSION['msg']="Your Connection Not Secure";
				header("Location: $location");
				exit();
			}
		}
		
	}
?>