<?php
	session_start();
	$timing_start = explode(' ', microtime());
	error_reporting(-1);
	set_time_limit(0);
	ini_set('memory_limit','4096M');
	$_SESSION['token']='12345gh';	
	require 'db.php';
	require 'functions.php';
	
	/*function finSecure(){
		global $mysqli;
		$sdgsd=array();
		//echo "werew";
		$dfkgjh=$mysqli->query("SELECT * FROM `gamesetup`");
		while($wueyew=mysqli_fetch_assoc($dfkgjh)){
			$qqwq=explode("/",$wueyew['return_amount']);
			if($qqwq[1]==100){
				array_push($sdgsd, $wueyew['serial']);
			}
		}
		return $sdgsd;
	}*/
	
	function invest_update($memberid,$secureTT){
		global $mysqli;
		//$PresentDate=date("Y-m-d");
		$iiiin=implode("' OR  `type_id`='", $secureTT);//
		$rrett="  `type_id`='" . $iiiin ."'";//
		//var_dump();
		//var_dump("SELECT * FROM play WHERE `user`='".$memberid."' AND ($rrett)");
		$mmm=mysqli_num_rows($mysqli->query("SELECT * FROM play WHERE `user`='".$memberid."' AND `type_id`='1'"));
		//$sedf=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `play_countUpdate` WHERE `user`='".$memberid."'"));
		$yuret=0;
		/*foreach($secureTT as $serr){
			$cols="type".$serr;
			$eeet=explode("/", $sedf[$cols]);
			$ertre=array_sum($eeet);
			$yuret=$yuret+$ertre;
		}*/
		$totalPlay=floor($mmm/50);
		if($mmm<=50){
			$totalPlay=0;//floor($mmm/50);
		}else{
			$totalPlay=$totalPlay+1;
		}
		
		//if($totalPlay==0){
			//
		//}
		$yteye=$mysqli->query("SELECT * FROM `level_user` WHERE `level`='".$totalPlay."'");
		$mkfdg=mysqli_num_rows($yteye);
		if($mkfdg>0){
			$jjfdgd=mysqli_fetch_assoc($yteye);
			$levelUser=$jjfdgd['user']+1;
			$mysqli->query("UPDATE `level_user` SET `user`='".$levelUser."' WHERE `level`='".$totalPlay."'");
		}else{
			$mysqli->query("INSERT INTO `level_user` (`level`,`user`) VALUES ('".$totalPlay."','1')");
		}
		
		$mysqli->query("UPDATE `member` SET `level`='".$totalPlay."' WHERE `user`='".$memberid."'");
		
		echo  "$memberid $totalPlay \n";
		
	}
	
	$secureType=finSecure();
	
	$mysqli->query("DELETE FROM `level_user`");
	$mysqli->query("ALTER TABLE `level_user` DROP `serial`");
	$mysqli->query("ALTER TABLE `level_user` ADD `serial` BIGINT(255) NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`serial`)");
	
	
	$query_10="SELECT DISTINCT user FROM member WHERE `pack`>'0'  ORDER BY `serial` ASC ";//AND `level`=''
	$result_10=$mysqli->query($query_10);
	while($row_10=mysqli_fetch_array($result_10)){
		$u_id_tmp = $row_10['user'];
		$check=invest_update($u_id_tmp,$secureType);
		usleep(50);
	}
?>