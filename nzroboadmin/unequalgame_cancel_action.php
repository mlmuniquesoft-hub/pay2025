<?php
	session_start();
	if(($_SESSION['Admin']=='')||(!isset($_SESSION['Admin']))){
    	header("Location:logout.php");
    	exit();
    }else{
		require '../db/db.php';
		$user=$_SESSION['Admin'];
		$memberid= $_GET['user'];
		$teama= $_GET['teama'];
		$teamb= $_GET['teamb'];
		function userlist($user){
			global $mysqli;
			$mobile=mysqli_fetch_assoc($mysqli->query("SELECT `mobile`,`user` FROM `profile` WHERE `user`='".$user."'"));
			$rtt=$mysqli->query("SELECT `mobile`,`user` FROM `profile` WHERE `mobile`='".$mobile['mobile']."'");
			$ttt=array();
			while($uss=mysqli_fetch_assoc($rtt)){
				array_push($ttt,$uss['user']);
			}
			return $ttt;
		}
		
		function teamcalc($team){
			global $mysqli;
			$uuu=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `games` WHERE `type`='Special' AND `active`='1'"));
			$teama=$mysqli->query("SELECT * FROM `play` WHERE `gameid`='".$uuu['serial']."' AND `draw`='".$uuu[$team]."'");
			$teama_user=array();
			$teama_amn=array();
			while($tteama=mysqli_fetch_assoc($teama)){
				$teama_amn[$tteama['user']]=$tteama['slot'];
				$myyy=mysqli_fetch_assoc($mysqli->query("SELECT `mobile`,`user` FROM `profile` WHERE `user`='".$tteama['user']."'"));
				array_push($teama_user, $myyy['mobile']);
			}
			return $teama_amn;
		}
		$teama=teamcalc("team_a");
		$teamb=teamcalc("team_b");
		$teamaa=array();
		$teambb=array();
		$userll=userlist($memberid);
		foreach($userll as $users){
			if(array_key_exists($users,$teama)){
				$teamaa[$users]=$teama[$users];
			}
			if(array_key_exists($users,$teamb)){
				$teambb[$users]=$teamb[$users];
			}
		}
		if($teama>$teamb){
			$matching=array_values(array_intersect($teambb,$teamaa));
		}elseif($teamb>$teama){
			$matching=array_values(array_intersect($teamaa,$teambb));
		}
		
		foreach($matching as $match){
			$keya=array_search($match,$teamaa);
			$keyb=array_search($match,$teambb);
			unset($teamaa[$keya]);
			unset($teambb[$keyb]);
		}
		$newarr=array_merge($teambb,$teamaa);
		$newkeys=array_keys($newarr);
		foreach($newkeys as $remov){
			$load=$mysqli->query("UPDATE `bcpp` SET active='1' WHERE `user`='".$remov."' and `type`='Special' and `amount`='".$newarr[$remov]."' ORDER BY serial DESC LIMIT 1");	
			if($load==1){
				$mysqli->query("DELETE FROM `play` WHERE `user`='".$remov."' and `type`='Special' and `slot`='".$newarr[$remov]."' ORDER BY serial DESC LIMIT 1");
			}
		}
		$msg = "Cancel Unequal Slot Successfull";       
		header("Location:game_disable.php?msg=$msg"); 
		exit();
	}	


?>	