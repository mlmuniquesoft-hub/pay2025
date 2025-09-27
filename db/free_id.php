<?php
	session_start();
	$timing_start = explode(' ', microtime());
	error_reporting(-1);
	set_time_limit(0);
	ini_set('memory_limit','512M');
	$_SESSION['token']=4368098775524;	
	require_once('db.php');
	$hjfd=$mysqli->query("SELECT DISTINCT `user` FROM `binary_income`");
	while($kdjfhg=mysqli_fetch_assoc($hjfd)){
		$jhdfgd=mysqli_num_rows($mysqli->query("SELECT * FROM `member` WHERE `user`='".$kdjfhg['user']."' AND `paid`='1'"));
		if($jhdfgd<1){
			echo $kdjfhg['user'] ."<br/>";
		}
	}
?>