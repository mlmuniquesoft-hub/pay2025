<?php
	session_start();
	require_once("../../db/db.php");
	$user='crowdfund';//$_SESSION['CrowdMember'];
	$serial=$_GET['serial'];
	$hsgs=$mysqli->query("SELECT * FROM `widraw_req` WHERE `serial`='".$serial."' AND `pending`='0' ORDER BY `serial` DESC LIMIT 1");
	$ChekcUI=mysqli_num_rows($hsgs);
	echo $ChekcUI;
?>