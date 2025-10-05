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
		$gameQuery=$mysqli->query("SELECT * FROM `games` WHERE `serial`='".$gameSerial."'");
		$gameCheck=mysqli_num_rows($gameQuery);
		if($gameCheck<1){
			$rettt[0]=0;
			$rettt[1]="Your Connection Not Secure Try Latter";
			echo json_encode($rettt);
			die();
		}
		$gameInfo=mysqli_fetch_assoc($gameQuery);
		
		$playQuery=$mysqli->query("SELECT * FROM `play` WHERE `gameid`='".$gameInfo['serial']."' ");
		while($playInfo=mysqli_fetch_assoc($playQuery)){
			$gameInvest2=$playInfo['amount'];
			$investReturnToCurrentLose=$gameInvest2;
			$mysqli->query("UPDATE `play` SET `win`='3' WHERE `serial`='".$playInfo['serial']."' ");
			$returnInsInfo2=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `game_configure` WHERE `serial`='".$playInfo['config_id']."'"));
			$mysqli->query("UPDATE `game_configure` SET `remain_play`='0' WHERE `serial`='".$playInfo['config_id']."'");
			if($returnInsInfo2['remain_play']<=0){
				if($returnInsInfo2['count_c']==1){
					
				}elseif($returnInsInfo2['count_c']==2){
					$ffr=mysqli_num_rows($mysqli->query("SELECT * FROM `return_invest` WHERE `play_id`='".$playInfo['serial']."'"));
					$mysqli->query("DELETE FROM `return_invest` WHERE `play_id`='".$playInfo['serial']."'");
					if($ffr>0){
						$mysqli->query("UPDATE `return_invest` SET `amount`='".$investReturnToCurrentLose."' WHERE `play_id`='".$playInfo['serial']."'");
					}else{
						$mysqli->query("INSERT INTO `return_invest`(`user`, `game_type`, `gameid`, `play_id`, `amount`) VALUES ('".$playInfo['user']."','".$playInfo['type_id']."','".$playInfo['gameid']."','".$playInfo['serial']."','".$investReturnToCurrentLose."')");
					}
				}
				
				
			}
		}
		
		$mysqli->query("UPDATE `games` SET `active`='2' WHERE `serial`='".$gameInfo['serial']."'");
		
		$_SESSION['msg1']="Your Game Cancel Successful";
		$rettt[0]=1;
		$rettt[1]="$gameInvest > $investReturn > $gameProfit > $profitToCurrent > $profitToBonus > $returnCurrent > $returnBonus";
		echo json_encode($rettt);
		die();
		
	}
?>	