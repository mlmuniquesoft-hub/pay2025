<?php
	$timing_start = explode(' ', microtime());
	error_reporting(-1);
	set_time_limit(0);
	ini_set('memory_limit','512M');
	$_SESSION['token']='12345gh';	
	require 'db.php';
	$date=date("Y-m-d");
	$uut=array();
	$query=$mysqli->query("SELECT `user` FROM `play` WHERE `type`='Special' AND `date`='2016-12-31'");
	while($rrr=mysqli_fetch_object($query)){
		usleep(20);
		$uty=$rrr->user;
		array_push($uut, $uty);
	}
	$ingo=array();
	foreach($uut as $ret){
		usleep(20);
		$yyyt=mysqli_fetch_assoc($mysqli->query("SELECT `mobile`,`user` FROM `profile` WHERE `user`='".$ret."'"));
		$num=$yyyt['mobile'];
		$qwe=$mysqli->query("SELECT `mobile`,`user` FROM `profile` WHERE `mobile`='".$num."'");
		$rti=array();
		while($userd=mysqli_fetch_assoc($qwe)){
			array_push($rti, $userd['user']);
			$ingo[$ret]=$rti;
		}
	}
	foreach($ingo as $ing){
		$num=0;
		usleep(20);
		foreach($ing as $userd){
			usleep(20);
			$jjj=$mysqli->query("SELECT `user`,`type`,`date` FROM `play` WHERE `type`='Special' AND `date`='2016-12-31' AND `user`='".$userd."'");
			//$tryy=mysqli_num_rows($jjj);
			//if($tryy>0){
				//$num++;
			//}
		}
		echo $num . "<br/>";
	}
?>

