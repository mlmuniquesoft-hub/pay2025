<?php
	session_start(); 
	if(!isset($_SESSION['Admin'])){
		header("Location:logout.php");
		exit();
	}else{
		require '../db/db.php';

		$font=$_POST["body_font"];
		$color=$_POST["body_color"];
		$f_size=$_POST["body_size"];
		$text=$_POST["body_text"];
		$notice_for=$_POST["notice_for"];
		$location=$_POST["location"];

		if($notice_for=="annoucement"){
			$mysqli->query("UPDATE `notice` SET `body`='$text',`font`='$font',`color`='$color',`font_size`='$f_size' WHERE `user`='admin' ");
			$_SESSION['msg']="Announcement Changed Successfully";
			header("Location:$location");
			exit;
		}else{
			$mysqli->query("UPDATE `notice_member` SET `dessc`='$text' ");
			$_SESSION['msg']="Notice Changed Successfully";
			header("Location:$location");
			exit;
		}

	}
?>