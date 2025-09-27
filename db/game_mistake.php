<?php
	session_start();
	
	$_SESSION['token']="sdjhfgjsdhg^%&^%";
	require '../db/db.php';
	//$user=$_SESSION['Admin'];	           
	$gameSerial=1382;//$mysqli->real_escape_string($_GET['gam']);	           
	$kdfjgkfdj=$mysqli->query("SELECT * FROM `play` WHERE `gameid`='".$gameSerial."'");
	while($allGame=mysqli_fetch_assoc($kdfjgkfdj)){
		echo $allGame['user']. "<br/>";
		$mysqli->query("DELETE FROM `game_return` WHERE `play_id`='".$allGame['serial']."'");
		$mysqli->query("DELETE FROM `lose_invest` WHERE `play_id`='".$allGame['serial']."'");
		$mysqli4->query("DELETE FROM `deposit_out` WHERE `play_id`='".$allGame['serial']."'");
	}
	$mysqli->query("UPDATE `play` SET `win`='0' WHERE `gameid`='".$gameSerial."'");
?>	