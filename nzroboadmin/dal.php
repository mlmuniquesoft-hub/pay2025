<?php
	session_start();
	require '../db/db.php';
	if(isset($_GET['id'])){
		$get=$_GET['id'];
		$mysqli->query("DELETE FROM `inquiry` WHERE `id`='".$get."'");
		header("location: inquiry.php");
		exit();
	}
	
	if(isset($_GET['ser'])){
		$get=$_GET['ser'];
		$mysqli->query("DELETE FROM `problem` WHERE `id`='".$get."'");
		header("location: problem.php");
		exit();
	}
?>