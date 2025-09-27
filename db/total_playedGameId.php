<?php
	$timing_start = explode(' ', microtime());
	error_reporting(-1);
	//set_time_limit(0);
	//ini_set('memory_limit','512M');
	$_SESSION['token']='12345gh';	
	require 'db.php';
	require 'functions.php';
	
	
	$i=0;
	$secureTT=finSecure();
	$mmmii=$mysqli->query("SELECT DISTINCT `user` FROM `play` ");
	while($jjj=mysqli_fetch_assoc($mmmii)){
		$AllplayGame=PlayedGame($jjj['user'],$secureTT);
		$cHECKsTUPID=mysqli_num_rows($mysqli->query("SELECT * FROM `stupid_user` WHERE `user`='".$jjj['user']."'"));
		if($AllplayGame>=50){
			//echo $i++ ." >> ".$jjj['user'] . "\n";
			//$cHECKsTUPID=mysqli_num_rows($mysqli->query("SELECT * FROM `stupid_user` WHERE `user`='".$jjj['user']."'"));
			if($cHECKsTUPID<1){
				$cheTre=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `renew_game` WHERE `user`='".$jjj['user']."' ORDER BY `serial` DESC"));
				$mysqli->query("INSERT INTO `stupid_user`( `user`, `played_game`, `last_renew`) VALUES ('".$jjj['user']."','".$AllplayGame."','".$cheTre['date']."')");
			}else{
				$mysqli->query("UPDATE `stupid_user` SET  `played_game`='".$AllplayGame."' WHERE `user`='".$jjj['user']."'");
			}
			
		}else{
			if($cHECKsTUPID>0){
				$mysqli->query("DELETE FROM `stupid_user` WHERE `user`='".$jjj['user']."'");
			}
		}
	}
	
?>