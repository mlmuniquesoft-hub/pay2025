<?php
	session_start();
	if(($_SESSION['Admin']=='')||(!isset($_SESSION['Admin']))){
    	header("Location:logout.php");
    	exit();
    }else{
		require '../db/db.php';
		$serial=$_GET['gam'];
		$winCri=$_GET['ww'];
		$mm=$multichallenge->query("SELECT * FROM `game_play` WHERE `gameId`='".$serial."' AND `active`='2' AND `user_opsite`!=''");
	
		$multichallenge->query("UPDATE `game_question` SET `active`='2' WHERE `serial`='".$serial."'");
		$multichallenge->query("DELETE FROM `game_play` WHERE `gameId`='".$serial."'");
		$multichallenge->query("ALTER TABLE `game_play` DROP `serial`");
		$multichallenge->query("ALTER TABLE `game_play` ADD `serial` BIGINT(255) NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`serial`)");
		die();
	}
?>