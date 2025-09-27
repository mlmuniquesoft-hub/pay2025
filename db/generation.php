<?php
	/*session_start();
	$timing_start = explode(' ', microtime());
	error_reporting(-1);
	set_time_limit(0);
	ini_set('memory_limit','512M');
	$_SESSION['token']=4368098775524;	
	require_once('db.php');
	require_once('functions.php');*/
	$timezone = "Pacific/Auckland"; // Asia/Dacca
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);	
	//$ttyy=mysqli_fetch_assoc($mysqli->query("SELECT MAX(date) as `today` FROM `ptc_calc` "));
	$date=date("Y-m-d");
	//$mysqli->query("INSERT INTO `generation_time`( `date`) VALUES ('".$date."')");
	

	function daily_in11($userlist,$skipList,$amount,$date){
		global $mysqli;
		global $mysqli4;
		
		$ggg=array_diff($userlist, $skipList);
		$iiiin=implode("' OR DATE(`date`)='".$date."' AND `user`='", $ggg);//
		$rrett="  DATE(`date`)='".$date."' AND `user`='" . $iiiin ."'";//
		
		$ttyy3=mysqli_fetch_assoc($mysqli->query("SELECT slot_match jj2 FROM `binary_income` WHERE  $rrett"));
		return (($ttyy3['jj2']*$amount)/100);
	}
	
	
	function downUser11($users,$table){
		global $mysqli;
		$fff=array();
		if(is_array($users)){
			foreach($users as $user){
				$uu=$mysqli->query("select `sponsor`,`user` from `$table` where sponsor='".$user."'");
				while($spp=mysqli_fetch_assoc($uu)){
					array_push($fff, $spp['user']);
				}
			}
		}else{
			$uu=$mysqli->query("select `sponsor`,`user` from `$table` where sponsor='".$users."'");
			while($spp=mysqli_fetch_assoc($uu)){
				array_push($fff, $spp['user']);
			}
		}
		return $fff;
	}
	
	function downUser221($users,$table,$date){
		global $mysqli;
		$fff=array();
		if(is_array($users)){
			foreach($users as $user){
				$uu=$mysqli->query("select `sponsor`,`user` from `$table` where sponsor='".$user."' AND `pack`!='' AND `date`='".$date."'");
				while($spp=mysqli_fetch_assoc($uu)){
					array_push($fff, $spp['user']);
				}
			}
		}else{
			$uu=$mysqli->query("select `sponsor`,`user` from `$table` where sponsor='".$users."' ");
			while($spp=mysqli_fetch_assoc($uu)){
				array_push($fff, $spp['user']);
			}
		}
		return $fff;
	}
	
	
	
	
	function downusers11($user, &$hhh){
		global $mysqli;
		$www=$mysqli->query("SELECT `user`,`sponsor` FROM `member` WHERE `sponsor`='".$user."'");
		$erer=array();
		while($sponsor=mysqli_fetch_assoc($www)){
			array_push($hhh, $sponsor['user']);
			downusers11($sponsor['user'], $hhh);
		}
	}
	
	function SkipList11($user){
		global $mysqli;
		$errr=array();
		$lists=array();
		downusers($user, $lists);
		foreach($lists as $list){
			$ttyy=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `generation_skip` WHERE `user`='".$list."'"));
			if($ttyy['skip_user']!=''){
				$trrii=explode("/", $ttyy['skip_user']);
				$errr=array_merge($errr,$trrii);
			}
		}
		return array_unique($errr);
	}
	
	function user_update11($U_ID,$date){
		global $mysqli;
		$memberid = $U_ID;
		//$date=date("Y-m-d");
		//$date="2017-08-24";
		
		$trrii=array();
		$yyy=array();
		$yyy22=array();
		$yyyPoint=array();
		$comms=array(2,2,1.5,1,1,1,1);
		$comms22=array(40,30,10,10,10);
		$ttt2=downUser11($memberid,'member');
		$yyy[0]=daily_in11($ttt2,$trrii,$comms[0],$date);
		
		for($i=1;$i<=11;$i++){
			if($i>=6){
				$comms[$i]=0.50;
			}
			
			$ttt2=downUser11($ttt2,'member');
			
			$yyy[$i]=daily_in11($ttt2,$trrii,$comms[$i],$date);
			
		}
	
		$total_gen=array_sum($yyy);
		$gen_main=$total_gen*.60;
		$gen_shop=$total_gen*.40;
	
		$check=mysqli_fetch_assoc($mysqli->query("SELECT `user`,`pack` FROM `member` WHERE `user`='".$memberid."'"));
		//if($check['pack']!=''){
			$remainK=RemainingReturn($memberid);
			if($remainK>0){
				if($total_gen>=$remainK){
					$total_gen=$remainK;
				}
			}else{
				$total_gen=0;
			}
			if($total_gen>0){
				
				$checkToday=mysqli_num_rows($mysqli->query("SELECT `user`,`date` FROM `generation_income` WHERE `user`='".$memberid."' AND `date`='".$date."'"));
				if($checkToday>0){
					$mysqli->query("UPDATE `generation_income` SET `amount`='".$gen_main."',`shop`='".$gen_shop."' WHERE `user`='".$memberid."' AND `date`='".$date."'");
				}else{
					$mysqli->query("INSERT INTO `generation_income`(`user`, `amount`,`shop`, `date`) VALUES ('".$memberid."','".$gen_main."','".$gen_shop."','".$date."')");
					$description="$$gen_main Generation $$gen_shop shopping Bonus Added";
					$mysqli->query("INSERT INTO `view`(`user`, `date`, `description`, `amount`, `types`) VALUES ('".$memberid."', '".$date."', '".$description."', '".$gen_main."','credit')");
				}
				
			}
			$ttrr=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) AS usd,SUM(shop) AS shop FROM `generation_income` WHERE `user`='".$memberid."'"));
			if($ttrr['usd']>0){
				$mysqli->query("UPDATE `balance` SET `generation_taka`='".$ttrr['usd']."',`shoping_taka`='".$ttrr['shop']."', WHERE `user`='".$memberid."'");
			}
		//}
		
		
	} /// end of user_update function
	
	function Generationoncome($DATE){
		global $mysqli;
		$SkipUser=array("habib","kingkhan");
		$mdfg=$mysqli->query("SELECT `user`,`pack` FROM `member` WHERE DATE(`time`)<='".$DATE."' AND `paid`='1'");
		while($allmember=mysqli_fetch_assoc($mdfg)){
			$u_id_tmp = $allmember['user'];
			if(!in_array(strtolower($allmember['user']),$SkipUser)){
				$check=user_update11($u_id_tmp,$DATE);
			}
			
		}
	}
	//Generationoncome();
	
?>