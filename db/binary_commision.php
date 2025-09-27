<?php
	session_start();
	$timing_start = explode(' ', microtime());
	error_reporting(-1);
	set_time_limit(0);
	ini_set('memory_limit','4096M');
	$_SESSION['token']='12345gh';	
	require_once('db.php');
	require_once('functions.php');
	require_once('generation.php');
	//require 'binary_function.php';
	$timezone = "Pacific/Auckland"; // Asia/Dacca
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);	
	function CountUserqq($user,$table,$date, &$sess){
		global $mysqli;
		if(!in_array($user, $sess)){
			array_push($sess, $user);
		}
		$users=$mysqli->query("SELECT * FROM `$table` WHERE `upline`='".$user."'");
		while($user=mysqli_fetch_assoc($users)){
			if(!in_array($user['user'], $sess)){
				if($user['date']==$date){
					array_push($sess, $user['user']);
				}
			}
			CountUserqq($user['user'], $table,$date, $sess);
		}
	}
	
	function matchSlot($amn, $slots){
		$i=1;
		$match=0;
		$totaldd=count($slots);
		foreach($slots as $slot){
			if($amn<$slots[0]){
				$match=2;
				break;
			}
			if(($amn>=$slot)&&($amn<=$slots[$i])){
				if($amn==$slots[$i]){
					$match=$slots[$i];
				}else{
					$match=$slot;
				}
				break;
			}
			if($i==$totaldd){
				$match=1;
			}
			$i++;
		}
		if($match==2){
			$newslot=0;
		}elseif($match==1){
			$newslot=$slots[$totaldd-1];
		}else{
			$newslot=$match;
		}
		return $newslot;
	}
	function leftRightqq($usse, $table,$date){
		global $mysqli;
		$eer=array();
		$eerer=array();
		$mmm=$mysqli->query("SELECT * FROM `$table` WHERE `upline`='".$usse."'");
		while($uuui=mysqli_fetch_assoc($mmm)){
			array_push($eer,$uuui['user']);
			//echo $uuui['user'] ." IID \n";
		}
		foreach($eer as $spoNsoruser){
			$sess=array();
			CountUserqq($spoNsoruser,$table,$date, $sess);
			$eerer[$spoNsoruser]=$sess;
		}
		
		return $eerer;
	}
	function GetSales($user, $table,$date){
		global $mysqli;
		$hjdf=leftRightqq($user, $table,$date);
		$dfgdf=array_keys($hjdf);
		
		$TotalPoint=array();
		$dfhgsd=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `binary_income` WHERE `user`='".$user."' AND DATE(date)<'".$date."' ORDER BY `serial` DESC LIMIT 1"));
		foreach($dfgdf as $usedd){
			
			$iiiin=implode("' OR DATE(`date`)='".$date."' AND `user`='", $hjdf[$usedd]);
			$rrett=" DATE(`date`)='".$date."' AND `user`='" . $iiiin ."'";
			
			$ttyy=mysqli_fetch_assoc($mysqli->query("SELECT SUM(`amount`) AS total FROM `upgrade` WHERE  $rrett"));
			$Counted=$ttyy['total']*0.10;
			if($dfhgsd['carry_id']==$usedd){
				$taoltalsale=$Counted+$dfhgsd['cary'];
			}else{
				$taoltalsale=$Counted;
			}
			if($taoltalsale>0){
				$TotalPoint[$usedd]=$taoltalsale;
			}
		}
		
		return $TotalPoint;
	}
	
	
	function IdentifyCarry($ary,&$etw){
		$carry=array();
		$evfghhh=array();
		arsort($ary);
		$dsfgsd=array_keys($ary);
		$jhgfj=count($dsfgsd);
		if($jhgfj>0){
			$erter=floor($jhgfj/2);
			$erter22=($jhgfj%2);
			if($erter>0){
				$ii=1;
				for($i=1; $i<=$erter;$i++){
					$first=$dsfgsd[$ii-1];
					$second=$dsfgsd[$ii];
					$evfghhh[$first]=$ary[$first]-$ary[$second];
					array_push($etw, $ary[$second]);
					if($i==$erter){
						if($erter22>0){
							$ertero=$dsfgsd[$jhgfj-1];
							$evfghhh[$ertero]=$ary[$ertero];
						}
						return IdentifyCarry($evfghhh,$etw);
					}
					$ii+=2;
				}
			}else{
				$user=$dsfgsd[$jhgfj-1];
				$carry['usere']=$user;
				$carry['cary']=$ary[$user];
				return $carry;
			}
		}else{
			$user=$dsfgsd[0];
			$carry['usere']=$user;
			$carry['cary']=$ary[$user];
			return $carry;
		}
	}
	
	function matchAmountAdf($user, $table,$date){
		global $mysqli;
		$rety=array();
		$usedd=array();
		$dfhd=GetSales($user, $table,$date);
		$match=array();
		$etrell=count($dfhd);
		$crrayAmn=0;
		$crrayUser='';
		if($etrell>0){
			$caryy=IdentifyCarry($dfhd, $match);
			$crrayAmn=$caryy['cary'];
			$crrayUser=$caryy['usere'];
			
		}
		arsort($dfhd);
		foreach($dfhd as $user=>$val){
			array_push($usedd, $user ." : ".$val);
		}
		$matchAmn=array_sum($match);
		$yuwerw=implode("/", $usedd);
		
		$rety['users']=$yuwerw;
		$rety['match']=$matchAmn;
		$rety['carry']=$crrayAmn;
		$rety['carryUser']=$crrayUser;
		return $rety;
	}
	$dfjkghdkfj=mysqli_fetch_assoc($mysqli->query("SELECT MAX(date) as days FROM `binary_income`"));
	//$dfjkghdkfj['days']='2020-02-06';
	$ghsdfs=date("Y-m-d", strtotime($dfjkghdkfj['days']."-1 days"));
	$datetime1 = date_create($ghsdfs);
	$recenDate=date("Y-m-d", strtotime("-1 day"));
	$datetime2 = date_create($recenDate);
	$interval = date_diff($datetime1, $datetime2);
	$differDate=$interval->days;
	//echo $differDate ."\n";
	//$iuwryt=$mysqli->query("SELECT DISTINCT `date` FROM `member` ORDER BY `date` ASC");
	//while($Alldate=mysqli_fetch_assoc($iuwryt)){
		$SkipUser=array("habib","kingkhan");
	for($i=1;$i<=$differDate;$i++){
		$DATE=date("Y-m-d", strtotime($ghsdfs."+ $i days"));//$Alldate['date'];
		if($DATE!=$TIMNB){
		
			//echo $DATE ."\n";
			$mdfg=$mysqli->query("SELECT `user`,`pack` FROM `member` WHERE DATE(`time`)<='".$DATE."' AND `paid`='1'");
			while($allmember=mysqli_fetch_assoc($mdfg)){
				
				$yuryu=matchAmountAdf($allmember['user'], "member",$DATE);
				//echo $yuryu['carry'] ." >> ".$yuryu['match']."\n";
				if(in_array(strtolower($allmember['user']),$SkipUser)){
					$yuryu['match']=0;
				}
				if(($yuryu['match']>0)||($yuryu['carry']>0)){
					$jkfghk=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `package` WHERE `serial`='".$allmember['pack']."'"));
					$slots=explode(",",$jkfghk['dessc']);
					if($yuryu['match']>0){
						$slotMatch=$yuryu['match'];//matchSlot($yuryu['match'], $slots);
						$flashMn=$yuryu['match'];//-$slotMatch;
					}else{
						$slotMatch='0.00';
						$flashMn=0;
					}
					$remainK=RemainingReturn($allmember['user']);
					if($remainK>0){
						$ToalAmnI=$slotMatch;
						if($ToalAmnI>$remainK){
							$ToalAmnI=$remainK;
						}
						$jkhjksd=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) AS `sdss` FROM `upgrade` WHERE `user`='".$allmember['user']."'"));
						$ReqKKJ=$jkhjksd['sdss'];
						if($ToalAmnI>$ReqKKJ){
							$ToalAmnI=$ReqKKJ;
						}
					}else{
						$ToalAmnI=0;
					}
					$checkInc=mysqli_num_rows($mysqli->query("SELECT `serial` FROM `binary_income` WHERE `user`='".$allmember['user']."' AND `date`='".$DATE."'"));
					if($checkInc<1){
						//echo "Insert \n";
						$mysqli->query("INSERT INTO `binary_income`( `user`, `total_sale`, `matching`,`slot_match`,`flash_match`,`carry_id`, `cary`, `date`) VALUES ('".$allmember['user']."','".$yuryu['users']."','".$yuryu['match']."','".$ToalAmnI."','".$flashMn."','".$yuryu['carryUser']."','".$yuryu['carry']."','".$DATE."')");
						if($ToalAmnI>0){
							$description="$$ToalAmnI (".$yuryu['match'].") Matching Bonus Added";
							$mysqli->query("INSERT INTO `view`(`user`, `date`, `description`, `amount`,`types`) VALUES ('".$allmember['user']."', '".$DATE."', '".$description."', '".$ToalAmnI."','credit')");
						}else{
							//echo "Income Expire \n";
						}
						
					}else{
						//echo "Updated \n";
						$mysqli->query("UPDATE `binary_income` SET `total_sale`='".$yuryu['users']."', `matching`='".$yuryu['match']."',`slot_match`='".$ToalAmnI."',`flash_match`='".$flashMn."',`carry_id`='".$yuryu['carryUser']."', `cary`='".$yuryu['carry']."' WHERE `user`='".$allmember['user']."' AND DATE(`date`)='".$DATE."'");
					}
				}
			}
			Generationoncome($DATE);
		}
		$TIMNB=$DATE;
	}
	
?>