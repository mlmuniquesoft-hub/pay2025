<?php
	session_start();
	$timing_start = explode(' ', microtime());
	error_reporting(-1);
	set_time_limit(0);
	ini_set('memory_limit','4096M');
	$_SESSION['token']='12345gh';	
	require 'db.php';
	require 'functions.php';
	
	$timezone = "Pacific/Auckland"; // Asia/Dacca
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);	
	
	function RealAmnBack(){
		$returnPer=array(0.50,0.60,0.70,0.80,0.90,1,1.01,1.03,1.05,1.06,1.08,1.10,1.12,1.14,1.18,1.22,1.23,1.26,1.28,1.35,1.42,1.50,1.55,1.66,1.70,1.85,1.90,1.63,1.95);
		$returnPerWE=array(0.01,0.02,0.03,0.04,0.05,0.06,0.07,0.08,0.09);
		shuffle($returnPerWE);
		shuffle($returnPer);
		$hgfsd=array_rand($returnPer);
		$hgfsd2=array_rand($returnPerWE);
		$ExpAmn=$returnPerWE[$hgfsd2];
		$RealAmn=$returnPer[$hgfsd2];
		if(1+$ExpAmn<$RealAmn){
			$RealAmn=$RealAmn-$ExpAmn;
		}
		if($RealAmn>=1.05){
			$RealAmn=1.05;
			$RealAmn=$RealAmn-$ExpAmn;
		}
		return $RealAmn;
	}
	
	function invest_update($memberid,$realAMn,$date){
		global $mysqli;
		$PresentDate=$date;//date("Y-m-d");
		
		$dfhgdf=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) as hhg FROM `upgrade` WHERE `user`='".$memberid."' AND DATE(`date`)<'".$date."'"));
		$dfhgdf2=mysqli_fetch_assoc($mysqli->query("SELECT `serial` FROM `upgrade` WHERE `user`='".$memberid."' ORDER BY `serial` DESC"));
		if($dfhgdf['hhg']>=3000){
			$hjgs=0;
			$dates=date("Y-m-d");
			$datesww=date("Y-m-d");
			$jhsjkd=$mysqli->query("SELECT * FROM `upgrade` WHERE `user`='".$memberid."'");
			while($Alkdfg=mysqli_fetch_assoc($jhsjkd)){
				$hjgs=$hjgs+$Alkdfg['amount'];
				if($hjgs>=3000){
					$dates=$Alkdfg['date'];
				}
			}
			
			$remainK=RemainingReturn($memberid);
			$shgdJH=date("Y-m-d", strtotime($dates."+6 days"));
			if($shgdJH>$datesww){
				$remainK=0;
				return 1;
			}
			
			if($remainK>0){
				$ToalAmnI=(($dfhgdf['hhg']*$realAMn)/100)*.60;
				$shop=(($dfhgdf['hhg']*$realAMn)/100)*.40;
				if($ToalAmnI>$remainK){
					$ToalAmnI=$remainK;
				}
				//echo $realAMn ." >> $ToalAmnI >> $memberid >> ".$dfhgdf['hhg']."\n";
				if($ToalAmnI>0){
					$CheckPrev=mysqli_num_rows($mysqli->query("SELECT * FROM `game_return2` WHERE `user`='".$memberid."' AND DATE(`date`)='".$PresentDate."'"));
					if($CheckPrev<1){
						$mysqli->query("INSERT INTO `game_return2`( `user`, `play_id`, `curent_bal`, `shop`, `bonus_bal`, `date`) VALUES ('".$memberid."','".$dfhgdf2['serial']."','".$ToalAmnI."','".$shop."','".$realAMn."','".$PresentDate."')");
						$description="$$ToalAmnI ($realAMn) ($shop) Global Profit Added";
						$mysqli->query("INSERT INTO `view`(`user`, `date`, `description`, `amount`, `types`) VALUES ('".$memberid."', '".$PresentDate."', '".$description."', '".$ToalAmnI."','credit')");
					}else{
						//$mysqli->query("UPDATE `game_return` SET `curent_bal`='".$ToalAmnI."', `bonus_bal`='".$realAMn."' WHERE `user`='".$memberid."' AND `date`='".$PresentDate."'");
					}
				}
				
			}
		}
		
	}

	$query_11=mysqli_fetch_assoc($mysqli->query("SELECT MAX(`date`) AS date FROM upgrade ORDER BY `serial` ASC "));
	$i=0;
	//$query_11['date']="2020-06-26";
	$PresenP=date("Y-m-d");
	$ExpDateP=array("Mon");
	while(true){
		//echo $Ladate['date'] ."<br/>";
		$date=date("Y-m-d", strtotime($query_11['date']."+$i days"));
		$Dafsg=date("D", strtotime($date));
		$i++;
		if(!in_array($Dafsg,$ExpDateP)){
			continue;
		}
		
		if($date<=$PresenP){
			$query_10="SELECT DISTINCT user FROM upgrade WHERE DATE(`date`)<'".$date."' ORDER BY `serial` ASC ";
			$result_10=$mysqli->query($query_10);
			$realAMn=RealAmnBack();
			while($row_10=mysqli_fetch_array($result_10)){
				$u_id_tmp = $row_10['user'];
				echo $u_id_tmp ."\n";
				$jkhgfd=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) as touu FROM `upgrade` WHERE `user`='".$u_id_tmp."'"));
				if($jkhgfd['touu']>=3000){
					//echo $u_id_tmp ."Acheived \n";
					$check=invest_update($u_id_tmp,$realAMn,$date);
				}
				usleep(50);
			}
		}else{
			break;
		}
	}
?>