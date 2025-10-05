<?php
	session_start();
	if(($_SESSION['Admin']=='')||(!isset($_SESSION['Admin']))){
    	header("Location:logout.php");
    	exit();
    }else{
		require '../db/db.php';
		$sdsf=$mysqli->query("SELECT * FROM `games` WHERE `active`='1'");
		$i=0;
		while($alactiveGame=mysqli_fetch_assoc($sdsf)){
			$mysqli->query("UPDATE `games` SET `criteria_inactive`='".$alactiveGame['criteria_active']."' WHERE `serial`='".$alactiveGame['serial']."'");
			$i++;
		}
		echo $i;
	}
?>