<?php
	session_start();
	require_once("../../db/db.php");
	$serial=base64_decode($_POST['sers']);
	//echo "DELETE FFROM `widraw_req` WHERE `serial`='".$serial."'";//$serial;
	$mysqli->query("DELETE FROM `widraw_req` WHERE `serial`='".$serial."'");
?>