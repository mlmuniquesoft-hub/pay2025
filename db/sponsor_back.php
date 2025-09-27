<?php
	session_start();
	$_SESSION['token']='12345gh';	
	require 'db.php';
	$SDFS=$mysqli->query("SELECT * FROM `member` WHERE `pack`>'0' AND `direct`='0'");
	while($ertre=mysqli_fetch_assoc($SDFS)){
		echo $ertre['user'] ." >> ". $ertre['direct'] ." >> ". $ertre['pack'] . "<br/>";
		$PackAmn=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `package` WHERE `serial`='".$ertre['pack']."'"));
		//$mysqli->query("UPDATE `member` SET `direct`='".$PackAmn['direct_com']."',`point`='".$PackAmn['pack_amn']."' WHERE `user`='".$ertre['user']."'");
		var_dump($PackAmn['direct_com']);
	}
?>