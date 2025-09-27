<?php
	session_start();
	$_SESSION['token']="sdgjgshkj ";
	require_once("../db/db.php");
	$myII=$_GET["keyK"];
	echo $myII;
	$mysqli->query("INSERT INTO `regular`( `user`, `gameid`) VALUES ('mainur','".$myII."')");
?>