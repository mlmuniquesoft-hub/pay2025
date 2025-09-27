<?php
	session_start();
	if(($_SESSION['Admin']=='')||(!isset($_SESSION['Admin']))){
    	header("Location:logout.php");
    	exit();
    }else{
		require '../db/db.php';
		$serial=$_GET['gam'];
		$winCri=$_GET['ww'];
		$KKJJJ=mysqli_fetch_assoc($multichallenge->query("SELECT `serial`,`gameType`,`typeName` FROM `game_question` WHERE `serial`='".$serial."'"));
		$mm=$multichallenge->query("SELECT * FROM `game_play` WHERE  `active`='1' AND `gameType`='".$KKJJJ['gameType']."' AND `typeName`='".$KKJJJ['typeName']."'");
		while($allgame=mysqli_fetch_assoc($mm)){
			$ffg=explode(",",$allgame['choice']);
			$ffg22=explode(",",$allgame['gameId']);
			
			if(in_array($serial,$ffg22)){
				$WinGmaiseret=array_search($serial,$ffg22);
				$winvalue=$ffg[$WinGmaiseret];
				
				if($winCri==$winvalue){
					//echo $winvalue;
					//die();
					$kkkll=mysqli_fetch_assoc($multichallenge->query("SELECT * FROM `game_play` WHERE  `serial`='".$allgame['serial']."'"));
					$kkkll33=$kkkll['bonus_for']+1;
					$multichallenge->query("UPDATE `game_play` SET `bonus_for`='".$kkkll33."' WHERE `serial`='".$allgame['serial']."'");
				}
			}
		}
		
		$multichallenge->query("UPDATE `game_question` SET `active`='2' WHERE `serial`='".$serial."'");
		
		$mwmnn=mysqli_num_rows($multichallenge->query("SELECT `serial` FROM `game_question` WHERE `gameType`='".$KKJJJ['gameType']."' AND `typeName`='".$KKJJJ['typeName']."' AND `active`<='1'"));
		if($mwmnn<1){
			//$KKJJJ=mysqli_fetch_assoc($multichallenge->query("SELECT `serial`,`gameType`,`typeName` FROM `game_question` WHERE `serial`='88'"));
			if($KKJJJ['gameType']==7){
				$mm22=$multichallenge->query("SELECT * FROM `game_play` WHERE  `active`='1' AND `gameType`='".$KKJJJ['gameType']."' AND `typeName`='".$KKJJJ['typeName']."'");
				while($allgame22=mysqli_fetch_assoc($mm22)){
					if($allgame22['bonus_for']==7){
						$profit=$allgame22['amount'] *3;
						$chargee=$profit*0.15;
						$multichallenge->query("INSERT INTO `win_list`(`user`, `amount`, `profit`,`charge`,`gameType`,`play_id`) VALUES ('".$allgame22['user']."','".$allgame22['amount']."','".$profit."','".$chargee."','".$KKJJJ['gameType']."','".$allgame22['serial']."')");
					}elseif($allgame22['bonus_for']==6){
						$profit=$allgame22['amount'];
						$chargee=$profit*0.15;
						$multichallenge->query("INSERT INTO `win_list`(`user`, `amount`, `profit`,`charge`,`gameType`,`play_id`) VALUES ('".$allgame22['user']."','".$allgame22['amount']."','".$profit."','".$chargee."','".$KKJJJ['gameType']."','".$allgame22['serial']."')");
					}elseif($allgame22['bonus_for']==5){
						$profit=$allgame22['amount'] * .10;
						$chargee=$profit*0.15;
						$multichallenge->query("INSERT INTO `win_list`(`user`, `amount`, `profit`, `charge`,`gameType`,`play_id`) VALUES ('".$allgame22['user']."','".$allgame22['amount']."','".$profit."','".$chargee."','".$KKJJJ['gameType']."','".$allgame22['serial']."')");
					}elseif($allgame22['bonus_for']==4){
						$profit=$allgame22['amount'] * .05;
						$chargee=$profit*0.15;
						$multichallenge->query("INSERT INTO `win_list`(`user`, `amount`, `profit`, `charge`,`gameType`,`play_id`) VALUES ('".$allgame22['user']."','".$allgame22['amount']."','".$profit."','".$chargee."','".$KKJJJ['gameType']."','".$allgame22['serial']."')");
					}elseif($allgame22['bonus_for']==3){
						$loseAmon=$allgame22['amount'] * .25;
						$multichallenge->query("INSERT INTO `lose_list`(`user`, `amount`,`gameType`,`play_id`) VALUES ('".$allgame22['user']."','".$loseAmon."','".$KKJJJ['gameType']."','".$allgame22['serial']."')");
					}elseif($allgame22['bonus_for']==2){
						$loseAmon=$allgame22['amount'] * .50;
						$multichallenge->query("INSERT INTO `lose_list`(`user`, `amount`,`gameType`,`play_id`) VALUES ('".$allgame22['user']."','".$loseAmon."','".$KKJJJ['gameType']."','".$allgame22['serial']."')");
					}elseif($allgame22['bonus_for']==1){
						$loseAmon=$allgame22['amount'] * .75;
						$multichallenge->query("INSERT INTO `lose_list`(`user`, `amount`,`gameType`,`play_id`) VALUES ('".$allgame22['user']."','".$loseAmon."','".$KKJJJ['gameType']."','".$allgame22['serial']."')");
					}else{
						$loseAmon=$allgame22['amount'];
						$multichallenge->query("INSERT INTO `lose_list`(`user`, `amount`,`gameType`,`play_id`) VALUES ('".$allgame22['user']."','".$loseAmon."','".$KKJJJ['gameType']."','".$allgame22['serial']."')");
					}
					$multichallenge->query("UPDATE `game_play` SET `active`='3' WHERE `serial`='".$allgame22['serial']."'");
					//$multichallenge->query("DELETE FROM `game_play` WHERE `serial`='".$allgame22['serial']."'");
				}
			}elseif($KKJJJ['gameType']==3){
				$mm22=$multichallenge->query("SELECT * FROM `game_play` WHERE  `active`='1' AND `gameType`='".$KKJJJ['gameType']."' AND `typeName`='".$KKJJJ['typeName']."'");
				while($allgame22=mysqli_fetch_assoc($mm22)){
					if($allgame22['bonus_for']==3){
						$profit=$allgame22['amount'] *0.80;
						$chargee=$profit*0.15;
						$multichallenge->query("INSERT INTO `win_list`(`user`, `amount`, `profit`,`charge`,`gameType`,`play_id`) VALUES ('".$allgame22['user']."','".$allgame22['amount']."','".$profit."','".$chargee."','".$KKJJJ['gameType']."','".$allgame22['serial']."')");
					}elseif($allgame22['bonus_for']==2){
						$loseAmon=$allgame22['amount'] * 0.30;
						$multichallenge->query("INSERT INTO `lose_list`(`user`, `amount`,`gameType`,`play_id`) VALUES ('".$allgame22['user']."','".$loseAmon."','".$KKJJJ['gameType']."','".$allgame22['serial']."')");
					}else{
						$loseAmon=$allgame22['amount'] * 0.50;
						$multichallenge->query("INSERT INTO `lose_list`(`user`, `amount`,`gameType`,`play_id`) VALUES ('".$allgame22['user']."','".$loseAmon."','".$KKJJJ['gameType']."','".$allgame22['serial']."')");
					}
					$multichallenge->query("UPDATE `game_play` SET `active`='3' WHERE `serial`='".$allgame22['serial']."'");
					//$multichallenge->query("DELETE FROM `game_play` WHERE `serial`='".$allgame22['serial']."'");
				}
			}
			$multichallenge->query("ALTER TABLE `game_play` DROP `serial`");
			$multichallenge->query("ALTER TABLE `game_play` ADD `serial` BIGINT(255) NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`serial`)");
		}
		die();
		
	}
?>