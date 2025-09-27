<?php
    session_start(); 
	$_SESSION['token']="gfhfg123412";
	require '../db/db.php';
	require '../db/functions.php';
	$mfghfg=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `hacker` ORDER BY `serial` DESC LIMIT 1"));
	echo $mfghfg['date'] ."<br/>";
	$etye=GMTtmeConvert($mfghfg['date'],"-2 hours");
	$werwerwe=SeverToLocalTime($mysqli, $etye,"-0 hours");
	echo $etye ."<br/>";
	echo $werwerwe ."<br/>";
	echo date("Y-m-d H:i:s") ."<br/>";
?>