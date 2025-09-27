<?php
    session_start(); 
    if(!isset($_SESSION['winMember'])){
    	header("Location:logout.php");
    	exit();
    }else{
		require 'db.php';
		require 'calculation.php';
		require 'functions.php';
		$member=$_SESSION['winMember'];
		
		
		$sekkk=mysqli_fetch_assoc($mysqli->query("SELECT `user`, `log_user` FROM `member` WHERE `user`='".$member."'"));
		$sekkk2=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member_total` WHERE `user`='".$member."'"));
		
		$mysqli->query("UPDATE `uniq_balance` SET `recin_in`='".$_SESSION['uniq_w']."' WHERE `user`='".$sekkk['log_user']."'");
		
		UniqueBalanceIn($sekkk['log_user']);
		$returnCurrent=Sumamn("game_return", "SUM(curent_bal) as total","`user`='$member'");
		$returnBonus=Sumamn("game_return", "SUM(bonus_bal) as total","`user`='$member'");
		
		$rankIncome=mysqli_fetch_assoc($mysqli->query("SELECT `rank` FROM `ranks` WHERE `user`='".$sekkk['user']."' ORDER BY `serial` DESC"));
		$rankIncome2=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) as jjh FROM `rank_bonus` WHERE `user`='".$sekkk['user']."' ORDER BY `serial` DESC"));
		
		$returnAmn=array();
		
		$returnAmn['totalCid']=$sekkk2['totalCid'];//count($cidDD);
		$returnAmn['totalUserId']=$sekkk2['totalUserId'];//count($userDD);
		$returnAmn['activeId']=$sekkk2['activeId'];//count($activeUser);
		$returnAmn['TotalGenId']=$sekkk2['TotalGenId'];//$total_genId;
		$returnAmn['selfAccount']=$sekkk2['selfAccount'];//count($self_accAccount);
		$returnAmn['otherActiveAccount']=$sekkk2['otherActiveAccount'];//count($otherActiveAccount);
		$returnAmn['selfInvest']="$ ". gameDepositCalc($member);//$selfInvest;
		$returnAmn['otherAccountInvest']=$sekkk2['otherAccountInvest'];//$otherAccountInvest;
		
		$returnAmn['totalInvest']=$sekkk2['otherAccountInvest']+$sekkk2['selfInvest'];
		$returnAmn['generation']=Sumamn("balance", "SUM(generation_taka) as total","`user`='$member'");
		$returnAmn['rank']=floor($rankIncome2['jjh']);
		$returnAmn['rankPosition']=$rankIncome['rank'];
		$returnAmn['gameWin']="$ ".$returnCurrent+$returnBonus;
		$returnAmn['gameWin22']="$ ".$returnCurrent+$returnBonus;
		$returnAmn['sponsor']="$ ".Sumamn("balance", "SUM(direct_taka) as total","`user`='$member'");
		$returnAmn['sponsor22']="$ ".Sumamn("balance", "SUM(direct_taka) as total","`user`='$member'");
		$returnAmn['binary']="$ ".Sumamn("balance", "SUM(match_taka) as total","`user`='$member'");
		$returnAmn['binary22']="$ ".Sumamn("balance", "SUM(match_taka) as total","`user`='$member'");
		$returnAmn['CurrentBal']="$ ".number_format($final_taka51, 2, '.', '');
		$returnAmn['TotalIn']="$ ".$final_in_taka51;
		$returnAmn['TotalOut']="$ ".$final_out_taka51;
		$returnAmn['GenIncome']="$ ".$generation_taka51;
		$returnAmn['GenIncome22']="$ ".$generation_taka51;
		$returnAmn['GenIncome2222']="$ ".$recivAgent;//$_SESSION['req_funnd'];
		
		echo json_encode($returnAmn);
		
	}
?>