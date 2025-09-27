<?php
	session_start();
	$_SESSION['token']="wwerwe";
	require_once("../../db/db.php");
	$User=$_GET['Usfd'];
	
	function CountUserss($user,$table, &$sess,&$score){
		global $mysqli;
		if(!in_array($user,$sess)){
			array_push($sess, $user);
			$jkdf=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) as erUY FROM `upgrade` WHERE `user`='".$user."'"));
			$Csocre=$jkdf['erUY']*0.10;
			array_push($score,$Csocre);
		}
		$users=$mysqli->query("SELECT `user` FROM `$table` WHERE `upline`='".$user."'");
		while($user=mysqli_fetch_assoc($users)){
			array_push($sess, $user['user']);
			$jkdf=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) as erUY FROM `upgrade` WHERE `user`='".$user['user']."'"));
			$Csocre=$jkdf['erUY']*0.10;
			
			array_push($score,$Csocre);
			CountUserss($user['user'], $table, $sess,$score);
		}
	}
	
	
	function leftRightww($usse, $table){
		global $mysqli;
		$eer=array();
		$left=array();
		$right=array();
		$ScoreR=array();
		$ScoreL=array();
		$mmm=$mysqli->query("SELECT * FROM `$table` WHERE `upline`='".$usse."'");
		while($uuui=mysqli_fetch_assoc($mmm)){
			if($uuui['position']==1){
				//array_push($left, $uuui['user']);
				CountUserss($uuui['user'],"member", $left,$ScoreL);
				$eer['left']=$left;
				$eer['leftS']=$ScoreL;
			}elseif($uuui['position']==2){
				//array_push($right, $uuui['user']);
				CountUserss($uuui['user'],"member", $right,$ScoreR);
				$eer['right']=$right;
				$eer['rightS']=$ScoreR;
			}
		}
		return $eer;
	}
	
	function TreeCount($user){
		global $mysqli;
		$table="member";
		$usekk=leftRightww($user, $table);
		$leftt=implode(",",$usekk['left']);
		$rightt=implode(",",$usekk['right']);
		$LEftSS=array_sum($usekk['leftS']);
		$RIghtSS=array_sum($usekk['rightS']);
		$uygfd=mysqli_num_rows($mysqli->query("SELECT `serial` FROM `member_total` WHERE `user`='".$user."'"));
		if($uygfd<1){
			$mysqli->query("INSERT INTO `member_total` (`user`) VALUES ('".$user."')");
		}
		$mysqli->query("UPDATE `member_total` SET 
		`totalLeftId`='".$leftt."',
		`totalrightId`='".$rightt."',
		`left_score`='".$LEftSS."',
		`right_score`='".$RIghtSS."'
		WHERE `user`='".$user."'");
		
		//return $usekk;
	}
	while(true){
		if($User==''){
			break;
		}
		$kjhffs=mysqli_fetch_assoc($mysqli->query("SELECT `upline` FROM `member` WHERE `user`='".$User."'"));
		TreeCount($User);
		
		$User=$kjhffs['upline'];
	}
	
?>