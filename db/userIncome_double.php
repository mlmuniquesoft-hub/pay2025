<?php
	$timing_start = explode(' ', microtime());
	error_reporting(-1);
	set_time_limit(0);
	ini_set('memory_limit','512M');
	$_SESSION['token']='12345gh';	
	require 'db.php';
	require 'functions.php';
	
	
	function CheckUserReturn($user){
		global $mysqli;
		global $mysqli4;
		$dfgs=$mysqli4->query("SELECT * FROM `deposit_amn` WHERE `user`='".$user."' AND `play_method`='0'");
		$checkk=mysqli_num_rows($dfgs);
		if($checkk>0){
			$sfsf=mysqli_fetch_assoc($mysqli4->query("SELECT SUM(c_balance) AS depoAmn FROM `deposit_amn` WHERE `user`='".$user."' AND `play_method`='0'"));
			$tOTAlInvest=$sfsf['depoAmn'];
			$totalReturn=0;
			if($tOTAlInvest>0){
				$weerwe=$mysqli->query("SELECT * FROM `play` WHERE `user`='".$user."' AND `type_id`='1' AND `win`='1'");
				while($rete=mysqli_fetch_assoc($weerwe)){
					$dgdfgd=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `game_return` WHERE `user`='".$user."' AND `play_id`='".$rete['serial']."'"));
					$totalReturn=$totalReturn+$dgdfgd['curent_bal'];
				}
				$mdfHH=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `user`='".$user."'"));
				if($mdfHH['ref_con']>0){
					$ertr=100;
					$SponsAmn=$mdfHH['ref_con'];
				}else{
					$ertr=200;
					$SponsAmn=2;
				}
				$expectedReturn=(($tOTAlInvest*$ertr)/100);
				if($totalReturn>=$expectedReturn){
					$CheckAsd=mysqli_num_rows($mysqli->query("SELECT `user` FROM `double_income_user` WHERE `user`='".$user."' AND `active`='1'"));
					if($CheckAsd<1){
						$mysqli->query("INSERT INTO `double_income_user`( `user`, `ref_amn`,`depoamn`,`expectedReturn`,`total_return`) VALUES ('".$user."','".$SponsAmn."','".$tOTAlInvest."','".$expectedReturn."','".$totalReturn."')");
					}
					
					echo "Done >> ". $user ." >> $tOTAlInvest >> " . $expectedReturn ." >> " . $totalReturn ."\n";
				}
			}
		}
	}
	
	$query_10="select `user` from `member` WHERE `pack`>'0'";
	$result_10=$mysqli->query( $query_10);		
	while($row_10=mysqli_fetch_array($result_10)){
		$u_id_tmp = $row_10['user'];
		$check=CheckUserReturn($u_id_tmp);
		usleep(50);		
	}
?>