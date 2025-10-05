<?php
	session_start();
	if(($_SESSION['Admin']=='')||(!isset($_SESSION['Admin']))){
    	header("Location:logout.php");
    	exit();
    }else{
		require '../db/db.php';
		require '../db/functions.php';
		$location=$_POST['location'];
		$name_game=$_POST['name_game'];
		$chk=0;
		if($name_game==''){
			$_SESSION['msg']="Please Submit a Game Name";
			header("Location: $location");
			exit();
		}
		$imghh=$_FILES['game_icon']['name'];
		$Tmpimghh=$_FILES['game_icon']['tmp_name'];
		if($name_game!=''){
			$_POST['icon_game']=$imghh;
			$gfd=InsertInfo("game_name", $_POST);
			if($gfd==1){
				move_uploaded_file($Tmpimghh, "../gameIcon/$imghh");
				$_SESSION['msg1']="Game Submit Successfully";
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