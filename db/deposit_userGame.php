<?php
	session_start();
	$timing_start = explode(' ', microtime());
	error_reporting(-1);
	set_time_limit(0);
	ini_set('memory_limit','4096M');
	$_SESSION['token']='12345gh';	
	require 'db.php';
	require 'functions.php';
	$sdf=$mysqli->query("SELECT DISTINCT `user` FROM `member` WHERE `pack`>'0'");
	$i=1;
	while($allMember=mysqli_fetch_assoc($sdf)){
		$checkUsed=mysqli_num_rows($mysqli4->query("SELECT `user` FROM `deposit_amn` WHERE `user`='".$allMember['user']."'"));
		if($checkUsed<1){
			$cHECKnUMB22=mysqli_num_rows($mysqli4->query("SELECT `serial` FROM `trade_trans_recive` WHERE `user_receive`='".$allMember['user']."'"));
			if($cHECKnUMB22<1){
				$hhdgdf=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) AS DEPOtOTAL FROM `game_configure` WHERE `user`='".$allMember['user']."' AND `game_type`='2'"));
				$hhdgdf2=mysqli_fetch_assoc($board_game->query("SELECT SUM(amount) AS DEPOtOTAL2 FROM `game_configure` WHERE `user`='".$allMember['user']."'"));
				$TotalDpoe=$hhdgdf['DEPOtOTAL']+$hhdgdf2['DEPOtOTAL2'];
				if($TotalDpoe>=10){
					$erLivePlay=mysqli_num_rows($mysqli->query("SELECT `serial` FROM `game_configure` WHERE `user`='".$allMember['user']."' AND `game_type`='2'"));
					$erbOARDPlay=mysqli_num_rows($board_game->query("SELECT `serial` FROM `game_configure` WHERE `user`='".$allMember['user']."'"));
					$CHEDepositU=mysqli_num_rows($mysqli->query("SELECT `serial` FROM `noDeposit_user` WHERE `user`='".$allMember['user']."'"));
					if($CHEDepositU<1){
						$mysqli->query("INSERT INTO `noDeposit_user`( `user`, `amount`, `board_play`, `live_play`) VALUES ('".$allMember['user']."','".$TotalDpoe."','".$erbOARDPlay."','".$erLivePlay."')");
					}else{
						$mysqli->query("UPDATE `noDeposit_user` SET `amount`='".$TotalDpoe."', `board_play`='".$erbOARDPlay."', `live_play`='".$erLivePlay."' WHERE `user`='".$allMember['user']."'");
					}
					
					//echo $i++ . " >> ". $allMember['user'] ."\n";
				}
			}
			
		}
	}
?>