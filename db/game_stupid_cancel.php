<?php
	session_start();
	$_SESSION['token']="sdjhfgjsdhg^%&^%";
	require '../db/db.php';
	//$user=$_SESSION['Admin'];	           
	$gameSerial=201;//$mysqli->real_escape_string($_GET['gam']);	           
	$kdfjgkfdj=$board_game->query("SELECT * FROM `play` WHERE `gameid`='".$gameSerial."'");
	while($allGame=mysqli_fetch_assoc($kdfjgkfdj)){
		echo $allGame['user']. "<br/>";
		$mysqli4->query("DELETE FROM `trade_win_reward` WHERE `user`='".$allGame['user']."' AND `play_id`='".$allGame['serial']."'");
		$board_game->query("DELETE FROM `game_return` WHERE `user`='".$allGame['user']."' AND `play_id`='".$allGame['serial']."'");
		$board_game->query("DELETE FROM `game_configure` WHERE `serial`='".$allGame['config_id']."'");
		$board_game->query("DELETE FROM `play` WHERE `serial`='".$allGame['serial']."'");
		$mysqli4->query("DELETE FROM `deposit_out` WHERE `play_id`='".$allGame['serial']."'");
		$board_game->query("DELETE FROM `lose_invest` WHERE `play_id`='".$allGame['serial']."'");
	}

?>	