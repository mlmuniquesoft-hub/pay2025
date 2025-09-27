<?php
	session_start();
	$timing_start = explode(' ', microtime());
	error_reporting(-1);
	set_time_limit(0);
	ini_set('memory_limit','4096M');
	$_SESSION['token']='12345gh';	
	require 'db.php';
	require 'functions.php';
	
	
	function TotalUpdate($member){
		global $mysqli;
		$userDD=array();
		$cidDD=array();
		$activeUser=array();
		$self_aacount=array();
		$otherAccount=array();
		$otherActiveAccount=array();
		
		UserDown($member,"member","log_user", $cidDD);
		UserDown($member,"member","user", $userDD);
		UserDownActive($userDD, "member", $activeUser);
			
		$downUserInvest=DepositUsers($userDD);
		
		$ttyy=LevelUsers($member,"member",11);
		$total_genId=array_sum($ttyy['totaluser']);
		
		
		$iii=$mysqli->query("SELECT `user`, `log_user` FROM `member` WHERE `log_user`='".$sekkk['log_user']."'");
		while($vvff=mysqli_fetch_assoc($iii)){
			if(!in_array($vvff['user'], $self_aacount)){
				array_push($self_aacount, $vvff['user']);
			}
		}
		

		
		$self_accAccount=array();
		
		
		UserDownActive($self_aacount, "member", $self_accAccount);
		$selfInvest=DepositUsers($self_accAccount);
		
		
		foreach($userDD as $uss){
			if(!in_array($uss, $self_accAccount)){
				array_push($otherAccount, $uss);
			}
		}
		UserDownActive($otherAccount, "member", $otherActiveAccount);
		
		$otherAccountInvest=DepositUsers($otherAccount);
		$returnAmn=array();
		
		$returnAmn['user']=$member;
		$returnAmn['totalCid']=count($cidDD);
		$returnAmn['totalUserId']=count($userDD);
		$returnAmn['activeId']=count($activeUser);
		$returnAmn['TotalGenId']=$total_genId;
		$returnAmn['selfAccount']=count($self_accAccount);
		$returnAmn['otherActiveAccount']=count($otherActiveAccount);
		$returnAmn['selfInvest']=$selfInvest;
		$returnAmn['otherAccountInvest']=$otherAccountInvest;
		
		UpdateChainUser($member,"member_total",$returnAmn,'');
		
		/*$mysqli->query("INSERT INTO `member_total`( `user`, `totalCid`, `totalUserId`, `activeId`, `TotalGenId`, `selfAccount`, `otherActiveAccount`, `selfInvest`, `otherAccountInvest`) 
		VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9])");*/
		
	}
	
	
	
	$query_10="select user,serial from member order by serial asc ";
	$result_10=$mysqli->query($query_10);
	//$ssdd=array();
	while($row_10=mysqli_fetch_array($result_10)){
		$u_id_tmp = $row_10['user'];
		$check=TotalUpdate($u_id_tmp);
		usleep(50);
	}
	
	
?>