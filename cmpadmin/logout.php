<?php
	session_start();
    require '../db/db.php';
    $timezone = "Asia/Dacca";
    if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
 
    $date0=date("d F Y h:i:s:A ");	
	$memberid = $_SESSION["Admin"];
    $mysqli->query("UPDATE admin SET last_login='$date0'  WHERE user_id='".$memberid."'");	
	session_destroy();
	
	header("Location: ../cmpadmin/index.php");
	exit;
?>
