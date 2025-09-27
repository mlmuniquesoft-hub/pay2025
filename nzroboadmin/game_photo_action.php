<?php
//echo "kk";
	session_start(); 
	if(!isset($_SESSION['Admin'])){
		header("Location:logout.php");
		exit();
	} 
	else{
		//require '../db/db.php';
		$type=$_POST['type'];
		$team_a=$_FILES["team_a"]["name"];
		$tempa=$_FILES["team_a"]["tmp_name"];
		$team_b=$_FILES["team_b"]["name"];
		$tempb=$_FILES["team_b"]["tmp_name"];
		$name1=$type."1.jpg";
		$name2=$type."2.jpg";
		if(@file_get_contents("../game_img/".$name1)){
			unlink("../game_img/".$name1);
		}
		if(@file_get_contents("../game_img/".$name2)){
			unlink("../game_img/".$name2);
		}
		move_uploaded_file($tempa, "../game_img/".$name1);
		move_uploaded_file($tempb, "../game_img/".$name2);
		$check=1;
		if($check){
			$_SESSION['msg']="upload Successfully";
			header("Location: game.php");
			exit();
		}else{
			$_SESSION['msg']="Try latter";
			header("Location: game.php");
			exit();
		}
	}
?>