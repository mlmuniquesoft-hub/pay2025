<?php
	session_start();
	if(($_SESSION['Admin']=='')||(!isset($_SESSION['Admin']))){
    	header("Location:logout.php");
    	exit();
    }else{
		require '../db/db.php';
		$user=$_SESSION['Admin'];	           
		$gameSerial=$mysqli->real_escape_string($_GET['gam']);	           
		$rettt=array();
		
		if($gameSerial==''){
			$rettt[0]=0;
			$rettt[1]="Your Connection Not Secure Try Latter";
			echo json_encode($rettt);
			die();
		}
		$gameQuery=$board_game->query("SELECT * FROM `games` WHERE `serial`='".$gameSerial."'");
		$gameCheck=mysqli_num_rows($gameQuery);
		if($gameCheck<1){
			$rettt[0]=0;
			$rettt[1]="Your Connection Not Secure Try Latter";
			echo json_encode($rettt);
			die();
		}
		$gameInfo=mysqli_fetch_assoc($gameQuery);
		
		$playQuery=$board_game->query("SELECT * FROM `play` WHERE `gameid`='".$gameInfo['serial']."' ");
		while($playInfo=mysqli_fetch_assoc($playQuery)){
			$gameInvest2=$playInfo['amount'];
			$investReturnToCurrentLose=$gameInvest2;
			$board_game->query("UPDATE `play` SET `win`='3' WHERE `serial`='".$playInfo['serial']."' ");
			$board_game->query("UPDATE `game_configure` SET `remain_play`='0' WHERE `serial`='".$playInfo['config_id']."' ");
			//$returnInsInfo2=mysqli_fetch_assoc($board_game->query("SELECT * FROM `game_configure` WHERE `serial`='".$playInfo['config_id']."'"));
			
		}
		
		$board_game->query("UPDATE `games` SET `active`='2' WHERE `serial`='".$gameInfo['serial']."'");
		
		$_SESSION['msg1']="Your Game Cancel Successful";
		$rettt[0]=1;
		$rettt[1]="$gameInvest > $investReturn > $gameProfit > $profitToCurrent > $profitToBonus > $returnCurrent > $returnBonus";
		echo json_encode($rettt);
		die();
		
	}
?>	