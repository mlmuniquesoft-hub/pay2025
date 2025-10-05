<?php
	session_start();
	if(($_SESSION['Admin']=='')||(!isset($_SESSION['Admin']))){
    	header("Location:logout.php");
    	exit();
    }else{
		require '../db/db.php';
		require '../db/functions.php';
		$user=$_SESSION['Admin'];	           
		$gameSerial=$board_game->real_escape_string($_GET['gam']);	           
		$winCriteria=$board_game->real_escape_string($_GET['ww']);
		$LastcountTime=$board_game->real_escape_string($_GET['LastcountTime']);
		$rettt=array();
		//var_dump($LastcountTime);
		
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
		$gameQuery=$board_game->query("SELECT * FROM `games` WHERE `serial`='".$gameSerial."'");
		$gameCheck=mysqli_num_rows($gameQuery);
		if($gameCheck<1){
			$rettt[0]=0;
			$rettt[1]="Your Connection Not Secure Try Latter ";
			echo json_encode($rettt);
			die();
		}
		
		
		
		$playQuery=$board_game->query("SELECT * FROM `play` WHERE `gameid`='".$gameSerial."' AND `choice`='".$winCriteria."'");
		
		while($WinInfo=mysqli_fetch_assoc($playQuery)){
			usleep(10);
			/*if($LastcountTime!=''){
				$uyttr=mysqli_num_rows($board_game->query("SELECT * FROM `play` WHERE `user`='".$WinInfo['user']."' AND `gameid`='".$gameSerial."' AND `choice`='".$winCriteria."' AND `date`<'".$LastcountTime."'"));
			}else{
				$uyttr=1;
			}
			
			if($uyttr>0){*/
				$profitToCurrent=BoardGameCalc($board_game, $WinInfo['serial']);
				$profitToBonus=0;
				$returnInsInfo=mysqli_fetch_assoc($board_game->query("SELECT * FROM `game_configure` WHERE `serial`='".$WinInfo['config_id']."'"));
				if($returnInsInfo['count_c']==1){
					$ffr1=mysqli_num_rows($mysqli4->query("SELECT * FROM `trade_win_reward` WHERE `play_id`='".$WinInfo['serial']."'"));
					if($ffr1>0){
						$mysqli4->query("UPDATE `trade_win_reward` SET `amount`='".$profitToCurrent."' WHERE `play_id`='".$WinInfo['serial']."'");
					}else{
						$mysqli4->query("INSERT INTO `trade_win_reward`(`user`, `play_id`, `amount`) VALUES ('".$WinInfo['user']."','".$WinInfo['serial']."','".$profitToCurrent."')");
					}
				}elseif($returnInsInfo['count_c']==2){
					$checkRetuunn=mysqli_num_rows($board_game->query("SELECT * FROM `game_return` WHERE `user`='".$WinInfo['user']."' AND `play_id`='".$WinInfo['serial']."'"));
					if($checkRetuunn>0){
						$board_game->query("UPDATE `game_return` SET `curent_bal`='".$profitToCurrent."', `bonus_bal`='".$profitToBonus."' WHERE `user`='".$WinInfo['user']."' AND `play_id`='".$WinInfo['serial']."'");
					}else{
						$board_game->query("INSERT INTO `game_return`(`user`, `play_id`, `curent_bal`, `bonus_bal`) VALUES ('".$WinInfo['user']."','".$WinInfo['serial']."','".$profitToCurrent."','".$profitToBonus."')");
					}
				}
				
				$board_game->query("UPDATE `play` SET `win`='1' WHERE `gameid`='".$gameSerial."' AND `choice`='".$winCriteria."' AND `serial`='".$WinInfo['serial']."'");
				$board_game->query("UPDATE `game_configure` SET `remain_play`='0' WHERE `serial`='".$WinInfo['config_id']."'");
				//$returnInsInfo=mysqli_fetch_assoc($mysqli2->query("SELECT * FROM `game_configure` WHERE `serial`='".$WinInfo['config_id']."'"));
				$mysqli4->query("DELETE FROM `deposit_out`  WHERE `play_id`='".$WinInfo['serial']."'");
				$board_game->query("DELETE FROM `lose_invest` WHERE `play_id`='".$WinInfo['serial']."'");
			/*}else{
				$mysqli4->query("DELETE FROM `trade_win_reward` `user`='".$WinInfo['user']."' AND `play_id`='".$WinInfo['serial']."'");
				$board_game->query("DELETE FROM `game_return` `user`='".$WinInfo['user']."' AND `play_id`='".$WinInfo['serial']."'");
				$board_game->query("DELETE FROM `game_configure` WHERE `serial`='".$WinInfo['config_id']."'");
				$board_game->query("DELETE FROM `play` WHERE `serial`='".$WinInfo['serial']."'");
				$mysqli4->query("DELETE FROM `deposit_out` WHERE `play_id`='".$WinInfo['serial']."'");
				$board_game->query("DELETE FROM `lose_invest` WHERE `play_id`='".$WinInfo['serial']."'");
			}*/
		}
		$loseQuery=$board_game->query("SELECT * FROM `play` WHERE `gameid`='".$gameSerial."' AND `choice`!='".$winCriteria."' ");//AND `win`='0'
		while($loseInfo=mysqli_fetch_assoc($loseQuery)){
			usleep(10);
			/*if($LastcountTime!=''){
				$uyttr=mysqli_num_rows($board_game->query("SELECT * FROM `play` WHERE `user`='".$loseInfo['user']."' AND `gameid`='".$gameSerial."' AND `choice`!='".$winCriteria."' AND `date`<'".$LastcountTime."'"));
			}else{
				$uyttr=1;
			}
			if($uyttr>0){*/
				$gameInvest2=$loseInfo['amount'];
				$investReturnToCurrentLose=$gameInvest2;
				$board_game->query("UPDATE `play` SET `win`='2' WHERE `serial`='".$loseInfo['serial']."' AND `choice`!='".$winCriteria."'"); // AND `win`='0'
				$returnInsInfo2=mysqli_fetch_assoc($board_game->query("SELECT * FROM `game_configure` WHERE `serial`='".$loseInfo['config_id']."'"));
				if($returnInsInfo2['count_c']==1){
					$board_game->query("UPDATE `game_configure` SET `remain_play`='0' WHERE `serial`='".$loseInfo['config_id']."'");
					if($investReturnToCurrentLose>0){
						$ffr=mysqli_num_rows($mysqli4->query("SELECT * FROM `deposit_out` WHERE `play_id`='".$loseInfo['serial']."'"));
						if($ffr>0){
							$mysqli4->query("UPDATE `deposit_out` SET `amount`='".$investReturnToCurrentLose."' WHERE `play_id`='".$loseInfo['serial']."'");
						}else{
							$mysqli4->query("INSERT INTO `deposit_out`(`user`, `game_type`, `gameid`, `play_id`, `amount`) VALUES ('".$loseInfo['user']."','".$loseInfo['type_id']."','".$loseInfo['gameid']."','".$loseInfo['serial']."','".$investReturnToCurrentLose."')");
						}
					}
					
				}elseif($returnInsInfo2['count_c']==2){
					$board_game->query("UPDATE `game_configure` SET `remain_play`='0' WHERE `serial`='".$loseInfo['config_id']."'");
					if($investReturnToCurrentLose>0){
						$ffr=mysqli_num_rows($board_game->query("SELECT * FROM `lose_invest` WHERE `play_id`='".$loseInfo['serial']."'"));
						if($ffr>0){
							$board_game->query("UPDATE `lose_invest` SET `amount`='".$investReturnToCurrentLose."' WHERE `play_id`='".$loseInfo['serial']."'");
						}else{
							$board_game->query("INSERT INTO `lose_invest`(`user`, `game_type`, `gameid`, `play_id`, `amount`) VALUES ('".$loseInfo['user']."','".$loseInfo['type_id']."','".$loseInfo['gameid']."','".$loseInfo['serial']."','".$investReturnToCurrentLose."')");
						}
					}
					
				}
				$board_game->query("DELETE FROM `game_return` WHERE `user`='".$loseInfo['user']."' AND `play_id`='".$loseInfo['serial']."'");
				$mysqli4->query("DELETE FROM `trade_win_reward` WHERE `user`='".$loseInfo['user']."' AND `play_id`='".$loseInfo['serial']."'");
			/*}else{
				$mysqli4->query("DELETE FROM `trade_win_reward` WHERE `user`='".$loseInfo['user']."' AND `play_id`='".$loseInfo['serial']."'");
				$mysqli4->query("DELETE FROM `deposit_out` WHERE `play_id`='".$loseInfo['serial']."'");
				$board_game->query("DELETE FROM `game_return` WHERE `user`='".$loseInfo['user']."' AND `play_id`='".$loseInfo['serial']."'");
				$board_game->query("DELETE FROM `game_configure` WHERE `serial`='".$loseInfo['config_id']."'");
				$board_game->query("DELETE FROM `play` WHERE `serial`='".$loseInfo['serial']."'");
				$board_game->query("DELETE FROM `lose_invest` WHERE `play_id`='".$loseInfo['serial']."'");
			}*/
		}
		
		$board_game->query("UPDATE `games` SET `active`='0',`win_team`='".$winCriteria."' WHERE `serial`='".$gameSerial."'");
		
		$_SESSION['msg1']="Your Game Win Successful";
		$rettt[0]=1;
		$rettt[1]="$gameInvest > $investReturn > $gameProfit > $profitToCurrent > $profitToBonus > $returnCurrent > $returnBonus";
		echo json_encode($rettt);
		die();
	}
?>	