<?php
	$timing_start = explode(' ', microtime());
	error_reporting(-1);
	set_time_limit(0);
	ini_set('memory_limit','512M');
	$_SESSION['token']='12345gh';	
	require 'db.php';
	//require 'functions.php';
	
	function MatchRankCons($users,$cons){
		global $mysqli;
		
		foreach($users as $user){
			if($cons=='sponsor'){
				$tds="member";
				$consD="`user`='".$user."' AND `pack`!=''";
			}else{
				$tds="ranks";
				$consD="`user`='".$user."' AND `rank`='".$cons."'";
			}
			$sdfds=mysqli_num_rows($mysqli->query("SELECT `serial` FROM `$tds` WHERE $consD"));
			if($sdfds>0){
				return 1;
			}
		}
		return 0;
	}
	
	function RankCos($user,$cons){
		global $mysqli;
		$kdjhfd=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member_total` WHERE `user`='".$user."'"));
		$TotalLeft=explode(",", $kdjhfd['totalLeftId']);
		$TotalRight=explode(",", $kdjhfd['totalrightId']);
		$TotalSponsor=array();
		$jkhks=$mysqli->query("SELECT `user` FROM `member` WHERE `sponsor`='".$user."'");
		while($allSponsor=mysqli_fetch_assoc($jkhks)){
			array_push($TotalSponsor,$allSponsor['user']);
		}
		$leftSposnor=array_intersect($TotalSponsor,$TotalLeft);
		$rightSposnor=array_intersect($TotalSponsor,$TotalRight);
		$leftCons=MatchRankCons($leftSposnor,$cons);
		$rightCons=MatchRankCons($rightSposnor,$cons);
		return $leftCons+$rightCons;
	}
	
	
	function rank_update($user){
		global $mysqli;
		$jhdsfd=mysqli_fetch_assoc($mysqli->query("SELECT SUM(matching) AS sjdfh FROM `binary_income` WHERE `user`='".$user."'"));
		$TotalMatch=$jhdsfd['sjdfh'];
		if($TotalMatch>=100){
			$ranksh=array("Silver Star 1","Silver Star 2",
				"Gold Star 1","Gold Star 2",
				"Diamond Star","White Diamond Star","Gold Diamond Star","Platinum Diamond Star","President Diamond Star",
				"Lord President","Ambassador"
				);
			$rankshReq=array("sponsor","sponsor",
				"Silver Star 1","Gold Star 1","Gold Star 1","Gold Star 2",
				"Diamond Star","White Diamond Star","Platinum Diamond Star","President Diamond Star",
				"Lord President"
				);
				
			$requirCons=array(100, 200,1000,5000,20000,50000,150000,300000,500000,1000000,2000000);
			$i=0;
			foreach($requirCons as $ranks){
				if($TotalMatch>=$ranks){
					$RankName=$ranksh[$i];
					$hgsfs=mysqli_num_rows($mysqli->query("SELECT `serial` FROM `ranks` WHERE `user`='".$user."' AND `rank`='".$RankName."'"));
					if($hgsfs<1){
						$jksdfhsd=mysqli_fetch_assoc($mysqli->query("SELECT `sponsor` FROM `member` WHERE `user`='".$user."'"));
						$RankCons=$rankshReq[$i];
						$Validater=RankCos($user,$RankCons);
						if($Validater>=2){
							$mysqli->query("INSERT INTO `ranks`( `user`, `sponsor`, `rank`) VALUES ('".$user."','".$jksdfhsd['sponsor']."','".$RankName."')");
							//echo $RankName ." >> ". $user ."<br/>";
						}
					}
					$TotalMatch=$TotalMatch-$ranks;
				}
			}
		}
	}
	$query_10="select distinct `user` from member where `pack`!='' order by serial asc";
	$result_10=$mysqli->query( $query_10);		
	while($row_10=mysqli_fetch_array($result_10)){
		$u_id_tmp = $row_10['user'];
		//$current_serial = $row_10['serial'];
		$check=0;
		$check=rank_update($u_id_tmp);
		//SpecialRankReward($u_id_tmp);
		usleep(50);		
	}
	//RankPinUpdate();
	//RankSpecialRewardUpdate();
?>