<?php
	$timing_start = explode(' ', microtime());
	error_reporting(-1);
	//set_time_limit(0);
	//ini_set('memory_limit','512M');
	$_SESSION['token']='12345gh';	
	require 'db.php';
	require 'functions.php';
	 $allUsd=array("nahid20/10.00/TB","riya4/100.00/TB","riya3/100.00/TB","tofayel005/10.00/TB","riya2/100.00/TB","riya1/100.00/TB","shuvo1/100.00/TB","shshahed/10.00/TB","sharif10/50.00/CB","mahadibd/100.00/TB","tushar02/10.00/TB","samsul004/100.00/TB","mahadibd1/100.00/TB","sufian01/5.00/TB","samsul003/100.00/TB","samsul002/100.00/TB","tipu5001/100.00/TB","tipu5002/100.00/TB","samsul001/50.00/TB","mamun981/50.00/TB","hridoy01/10.00/TB","almamun00/5.00/TB","rizwan01/50.00/TB","suhrid01/10.00/TB","suhrid02/50.00/TB","raju10/10.00/TB","xiaomik/10.00/TB","polash23/50.00/TB","polash22/30.00/TB","ayon11/50.00/TB","ashik11/100.00/TB");
	 $iii=1;
	 foreach($allUsd as $Yyt){
		$GG=explode("/",$Yyt);
		if($GG[2]=="TB"){
			$mysqli4->query("INSERT INTO `deposit_out`(`user`, `game_type`, `gameid`, `play_id`, `amount`) VALUES ('".$GG[0]."','2','','','".$GG[1]."')");
				
		}elseif($GG[2]=="CB"){
			$mysqli->query("INSERT INTO `lose_invest`(`user`, `game_type`, `gameid`, `play_id`, `amount`) VALUES ('".$GG[0]."','2','1791','','".$GG[1]."')");
		}
	 }
	
?>