<?php
	session_start();
	if(($_SESSION['Admin']=='')||(!isset($_SESSION['Admin']))){
    	header("Location:logout.php");
    	exit();
    }else{
		require '../db/db.php';
		$user=$_SESSION['Admin'];	           
		$gameSerial=$mysqli->real_escape_string($_GET['gam']);	           
		$winCriteria=$mysqli->real_escape_string($_GET['ww']);
		$LastcountTime=$mysqli->real_escape_string($_GET['LastcountTime']);
		$rettt=array();
		if($gameSerial==''){
			$rettt[0]=0;
			$rettt[1]="Your Connection Not Secure Try Latter ";
			echo json_encode($rettt);
			die();
		}
		
		if($winCriteria==''){
			$rettt[0]=0;
			$rettt[1]="Your Connection Not Secure Try Latter ";
			echo json_encode($rettt);
			die();
		}
		$gameQuery=$mysqli->query("SELECT * FROM `games` WHERE `serial`='".$gameSerial."'");
		$gameCheck=mysqli_num_rows($gameQuery);
		if($gameCheck<1){
			$rettt[0]=0;
			$rettt[1]="Your Connection Not Secure Try Latter ";
			echo json_encode($rettt);
			die();
		}
		
		$gameInfo=mysqli_fetch_assoc($gameQuery);
		$avilCriteria=explode("/", $gameInfo['criteria_active']);
		$avilReturn=explode("/", $gameInfo['criteria_amn']);
		/*if(!in_array($winCriteria, $avilCriteria)){
			$rettt[0]=0;
			$rettt[1]="Your Connection Not Secure Try Latter ";
			echo json_encode($rettt);
			die();
		}*/
		$returnPosition=array_search($winCriteria, $avilCriteria);
		$winReturn=$avilReturn[$returnPosition];
		
		$gameTypeInfo=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `gamesetup` WHERE `serial`='".$gameInfo['type']."'"));
		$returnCurrent=$gameTypeInfo['current_welt'];
		$returnBonus=$gameTypeInfo['bounes_wallet'];
		$return_amount=explode("/", $gameTypeInfo['return_amount']);
		
		$Trade_fixed=$gameTypeInfo['fix_trade'];
		
		$playQuery=$mysqli->query("SELECT * FROM `play` WHERE `gameid`='".$gameInfo['serial']."' AND `choice`='".$winCriteria."'");
		while($WinInfo=mysqli_fetch_assoc($playQuery)){
			usleep(10);
			$gameInvest=$WinInfo['amount'];
			 $winReturn=$WinInfo['return_amn'];
			$investReturn=($gameInvest * $winReturn);
			$gameProfit=($investReturn - $gameInvest);
			$profitToCurrent=(($gameProfit * $returnCurrent)/100);
			$investReturnToCurrent=(($gameInvest*$return_amount[0])/100);
			if($LastcountTime!=''){
				$uyttr=mysqli_num_rows($mysqli->query("SELECT * FROM `play` WHERE `user`='".$WinInfo['user']."' AND `gameid`='".$gameInfo['serial']."' AND `choice`='".$winCriteria."' AND `date`<'".$LastcountTime."'"));
			}else{
				$uyttr=1;
			}
			
			if($uyttr>0){
				/*$returnInsInfo=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `game_configure` WHERE `serial`='".$WinInfo['config_id']."'"));
				if($returnInsInfo['count_c']==1){
					$ffr1=mysqli_num_rows($mysqli4->query("SELECT * FROM `trade_win_reward` WHERE `play_id`='".$WinInfo['serial']."'"));
					if($ffr1>0){
						$mysqli4->query("UPDATE `trade_win_reward` SET `amount`='".$profitToCurrent."' WHERE `play_id`='".$WinInfo['serial']."'");
					}else{
						$mysqli4->query("INSERT INTO `trade_win_reward`(`user`, `play_id`, `amount`) VALUES ('".$WinInfo['user']."','".$WinInfo['serial']."','".$profitToCurrent."')");
					}
				}elseif($returnInsInfo['count_c']==2){*/
					$checkRetuunn=mysqli_num_rows($mysqli->query("SELECT * FROM `game_return` WHERE `user`='".$WinInfo['user']."' AND `play_id`='".$WinInfo['serial']."'"));
					if($checkRetuunn>0){
						$mysqli->query("UPDATE `game_return` SET `curent_bal`='".$profitToCurrent."', `bonus_bal`='".$profitToBonus."' WHERE `user`='".$WinInfo['user']."' AND `play_id`='".$WinInfo['serial']."'");
					}else{
						$mysqli->query("INSERT INTO `game_return`(`user`, `play_id`, `curent_bal`, `bonus_bal`) VALUES ('".$WinInfo['user']."','".$WinInfo['serial']."','".$profitToCurrent."','".$profitToBonus."')");
					}
				//}
			}else{
				//$mysqli->query("DELETE FROM `play` WHERE `gameid`='".$gameInfo['serial']."' AND `choice`='".$winCriteria."' AND `serial`='".$WinInfo['serial']."'");
				//$mysqli->query("DELETE FROM `game_configure` WHERE `serial`='".$WinInfo['config_id']."'");
			}
			$mysqli4->query("DELETE FROM `deposit_out` WHERE `play_id`='".$WinInfo['serial']."'");
			$mysqli->query("DELETE FROM `lose_invest` WHERE `play_id`='".$WinInfo['serial']."'");
			
			$mysqli->query("UPDATE `play` SET `win`='1' WHERE `gameid`='".$gameInfo['serial']."' AND `choice`='".$winCriteria."' AND `serial`='".$WinInfo['serial']."'");
			//$returnInsInfo=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `game_configure` WHERE `serial`='".$WinInfo['config_id']."'"));
			$mysqli->query("UPDATE `game_configure` SET `remain_play`='0' WHERE `serial`='".$WinInfo['config_id']."'");
			
		}
		$loseQuery=$mysqli->query("SELECT * FROM `play` WHERE `gameid`='".$gameInfo['serial']."' AND `choice`!='".$winCriteria."' ");//AND `win`='0'
		while($loseInfo=mysqli_fetch_assoc($loseQuery)){
			usleep(10);
			$gameInvest2=$loseInfo['amount'];
			$investReturnToCurrentLose=($gameInvest2-(($gameInvest2*$return_amount[1])/100));
			$mysqli->query("UPDATE `play` SET `win`='2' WHERE `serial`='".$loseInfo['serial']."' AND `choice`!='".$winCriteria."'"); // AND `win`='0'
			$returnInsInfo2=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `game_configure` WHERE `serial`='".$loseInfo['config_id']."'"));
			$profitToCurrent2=0;
			$profitToBonus2=0;
			$checkRetuunn2=mysqli_num_rows($mysqli->query("SELECT * FROM `game_return` WHERE `user`='".$loseInfo['user']."' AND `play_id`='".$loseInfo['serial']."'"));
			if($checkRetuunn>0){
				$mysqli->query("UPDATE `game_return` SET `curent_bal`='".$profitToCurrent2."', `bonus_bal`='".$profitToBonus2."' WHERE `user`='".$loseInfo['user']."' AND `play_id`='".$loseInfo['serial']."'");
			}
			if($LastcountTime!=''){
				$uyttr=mysqli_num_rows($mysqli->query("SELECT * FROM `play` WHERE  `user`='".$loseInfo['user']."' AND `gameid`='".$gameInfo['serial']."' AND `choice`!='".$winCriteria."' AND `date`<'".$LastcountTime."'"));
			}else{
				$uyttr=1;
			}
			
			if($uyttr>0){
				if($returnInsInfo2['count_c']==1){
					$mysqli->query("UPDATE `game_configure` SET `remain_play`='0' WHERE `serial`='".$loseInfo['config_id']."'");
					if($investReturnToCurrentLose>0){
						$ffr11=mysqli_num_rows($mysqli4->query("SELECT * FROM `deposit_out` WHERE `play_id`='".$loseInfo['serial']."'"));
						if($ffr11>0){
							$mysqli4->query("UPDATE `deposit_out` SET `amount`='".$investReturnToCurrentLose."' WHERE `play_id`='".$loseInfo['serial']."'");
						}else{
							$mysqli4->query("INSERT INTO `deposit_out`(`user`, `game_type`, `gameid`, `play_id`, `amount`) VALUES ('".$loseInfo['user']."','".$loseInfo['type_id']."','".$loseInfo['gameid']."','".$loseInfo['serial']."','".$investReturnToCurrentLose."')");
						}
					}
					
				}elseif($returnInsInfo2['count_c']==2){
					$mysqli->query("UPDATE `game_configure` SET `remain_play`='0' WHERE `serial`='".$loseInfo['config_id']."'");
					if($investReturnToCurrentLose>0){
						$ffr22=mysqli_num_rows($mysqli->query("SELECT * FROM `lose_invest` WHERE `play_id`='".$loseInfo['serial']."'"));
						if($ffr22>0){
							$mysqli->query("UPDATE `lose_invest` SET `amount`='".$investReturnToCurrentLose."' WHERE `play_id`='".$loseInfo['serial']."'");
						}else{
							$mysqli->query("INSERT INTO `lose_invest`(`user`, `game_type`, `gameid`, `play_id`, `amount`) VALUES ('".$loseInfo['user']."','".$loseInfo['type_id']."','".$loseInfo['gameid']."','".$loseInfo['serial']."','".$investReturnToCurrentLose."')");
						}
					}
					
				}
			}else{
				//$mysqli->query("DELETE FROM `play` WHERE `gameid`='".$gameInfo['serial']."' AND `serial`='".$loseInfo['serial']."'");
				//$mysqli->query("DELETE FROM `game_configure` WHERE `serial`='".$loseInfo['config_id']."'");
			}
			
		}
		
		$mysqli->query("UPDATE `games` SET `active`='0',`win_team`='".$winCriteria."' WHERE `serial`='".$gameSerial."'");
		
		$_SESSION['msg1']="Your Game Win Successful";
		$rettt[0]=1;
		$rettt[1]="$gameInvest > $investReturn > $gameProfit > $profitToCurrent > $profitToBonus > $returnCurrent > $returnBonus";
		echo json_encode($rettt);
		die();
		
	}
?>	