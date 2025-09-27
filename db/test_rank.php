<?php
	$timing_start = explode(' ', microtime());
	error_reporting(-1);
	set_time_limit(0);
	ini_set('memory_limit','512M');
	$_SESSION['token']='12345gh';	
	require 'db.php';
	//require 'functions.php';
	$eruitier=$mysqli->query("SELECT DISTINCT `user` FROM `binary_income`");
	while($jkdfgh=mysqli_fetch_assoc($eruitier)){
		$jkhdf=mysqli_num_rows($mysqli->query("SELECT * FROM `member` WHERE `user`='".$jkdfgh['user']."' AND `paid`='1'"));
		if($jkhdf<1){
			$hjgs=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `binary_income` WHERE `user`='".$jkdfgh['user']."' ORDER BY `serial` DESC"));
			echo $hjgs['cary']." >> ".$jkdfgh['user'] ."<br/>";
			$mysqli->query("DELETE FROM `binary_income` WHERE `user`='".$jkdfgh['user']."'");
		}
	}
	
?>