<?php
	$timing_start = explode(' ', microtime());
	error_reporting(-1);
	set_time_limit(0);
	ini_set('memory_limit','512M');
	$_SESSION['token']='12345gh';	
	require 'db.php';
	
	
	function CountUserss($user,$table, &$sess,&$score){
		global $mysqli;
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
				array_push($left, $uuui['user']);
				CountUserss($uuui['user'],"member", $left,$ScoreL);
				$eer['left']=$left;
				$eer['leftS']=$ScoreL;
			}elseif($uuui['position']==2){
				array_push($right, $uuui['user']);
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
		//var_dump($usekk);
		$leftt=implode(",",$usekk['left']);
		$rightt=implode(",",$usekk['right']);
		$LEftSS=array_sum($usekk['leftS']);
		$RIghtSS=array_sum($usekk['rightS']);
		//var_dump();
		$mysqli->query("UPDATE `member_total` SET 
		`totalLeftId`='".$leftt."',
		`totalrightId`='".$rightt."',
		`left_score`='".$LEftSS."',
		`right_score`='".$RIghtSS."'
		WHERE `user`='".$user."'");
		return $usekk;
	}
	
	$query_10="select `user` from member ";
	$result_10=$mysqli->query( $query_10);		
	while($row_10=mysqli_fetch_array($result_10)){
		$u_id_tmp = $row_10['user'];
		$check=TreeCount($u_id_tmp);
		usleep(50);		
	}
?>