<?php
	session_start();
	$_SESSION['token']="KJHKJHw";
	require '../db/db.php';
	$jkdghkd=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member_total` WHERE `user`='bigbos10'"));
	$LeftH=explode(",", $jkdghkd['totalLeftId']);
	$RightH=explode(",", $jkdghkd['totalrightId']);
	$jkhs=array_merge($LeftH,$RightH);
	//var_dump($LeftH);
	$total=0;
	foreach($RightH as $usert){
		//echo $usert;
		
		$jkhfs=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `upgrade` WHERE `user`='".$usert."'"));
		$jkhfs22=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) as dfgd FROM `upgrade` WHERE `user`='".$usert."'"));
		if($jkhfs['user']!=''){
			$total=$total+$jkhfs22['dfgd'];
			echo $jkhfs['user'] ." >> ". $jkhfs['date'] ." >> ". $jkhfs22['dfgd'] ."<br/>";
		}
	}
	echo $total;

?>	