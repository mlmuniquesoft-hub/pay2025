<?php
	function count_user($user, &$rrr){
		global $mysqli;
		if(!in_array($user, $rrr)){
			array_push($rrr, $user);
		}
		$exe2 = $mysqli->query("SELECT user,upline FROM member WHERE upline='".$user."'");
		while($result2=mysqli_fetch_array($exe2)){
			if(!in_array($result2['user'], $rrr)){
				array_push($rrr, $result2['user']);
			}
			count_user($result2['user'], $rrr);
		}
	}
	
	
	function InvestAamn($users, $table, $cols, $cons=''){
		global $mysqli;
		$total=0;
		if($cons!=''){
			$cons=$cons;
		}else{
			$cons=null;
		}
		foreach($users as $user){
			$amn=mysqli_fetch_assoc($mysqli->query("SELECT SUM($cols) AS `total` FROM `$table` WHERE `user`='".$user."' $cons"));
			$total=$total+$amn['total'];
		}
		return $total;
	}
	function SleftLeftRight($memberid){
		global $mysqli;
		$tttii=$mysqli->query("SELECT * FROM `member` WHERE `upline`='".$memberid."'");
		while($mmnn=mysqli_fetch_assoc($tttii)){
			$_SESSION[$mmnn['position']]=0;
			CountUser($mmnn['user'],"member", $mmnn['position']);
		}
	}
	function selfuserIdfilter($users, $cid){
		global $mysqli;
		$uuudd=array();
		foreach($users as $user){
			$comm=mysqli_fetch_assoc($mysqli->query("SELECT `user`, `log_user`,`point` FROM `member` WHERE `user`='".$user."'"));
			$comission=$comm['point'];
			array_push($uuudd,$comission);
		}
		return $uuudd;
	}
	function selfuserToday($users, $cid){
		global $mysqli;
		$uuudd=array();
		$date=date("Y-m-d");
		foreach($users as $user){
			$comm=mysqli_fetch_assoc($mysqli->query("SELECT `user`, `log_user`,`point`,`date` FROM `member` WHERE `user`='".$user."'"));
			if($comm['date']==$date){
				$comission=$comm['point'];
				array_push($uuudd,$comission);
			}
		}
		return $uuudd;
	}
	
	function matchAmount($leftt, $rightt){
		$rree=array();
		if($leftt>$rightt){
			$match=$rightt;
			$leftcarry=$leftt-$rightt;
			$righttcarry=0;
		}elseif($rightt>$leftt){
			$match=$leftt;
			$righttcarry=$rightt - $leftt ;
			$leftcarry=0;
		}elseif($rightt==$leftt){
			$match=$leftt;
			$righttcarry=0;
			$leftcarry=0;
		}else{
			$match=0;
			$righttcarry=0;
			$leftcarry=0;
		}
		$rree['match']=$match;
		$rree['left']=$leftcarry;
		$rree['right']=$righttcarry;
		return $rree;
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
			if(($amn>=$slot)&&($amn<$slots[$i])){
				$match=$slot;
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
	function selfBinary($memberid,$cid){
		global $mysqli;
		$msd=$mysqli->query("SELECT * FROM `member` WHERE `upline`='".$memberid."'");
		$Left=0;
		$Right=0;
		$rrtt=array();
		while($userleft=mysqli_fetch_assoc($msd)){
			$uuyy=array();
			count_user($userleft['user'], $uuyy);
			$$userleft['position']=array_sum(selfuserIdfilter($uuyy, $cid));//InvestAamn($uuyy, "invest", "amount", $cons);
		}
		$rrtt['match']=matchAmount($Left, $Right);
		$rrtt['leftTotal']=$Left;
		$rrtt['rightTotal']=$Right;
		return $rrtt;
	}
	
	function selfBinaryDaily($memberid,$cid){
		global $mysqli;
		$msd=$mysqli->query("SELECT * FROM `member` WHERE `upline`='".$memberid."'");
		$Left=0;
		$Right=0;
		$rrtt=array();
		while($userleft=mysqli_fetch_assoc($msd)){
			$uuyy=array();
			count_user($userleft['user'], $uuyy);
			$$userleft['position']=array_sum(selfuserToday($uuyy, $cid));//InvestAamn($uuyy, "invest", "amount", $cons);
		}
		$rrtt['match']=matchAmount($Left, $Right);
		$rrtt['leftTotal']=$Left;
		$rrtt['rightTotal']=$Right;
		return $rrtt;
	}
	
	function UpdateFlash($selfkkk,$memberid,$table,$arr,$sllot,$matchPercent){
		global $mysqli;
		$date=date("Y-m-d");
		$consdd=" AND DATE(date)='".$date."'";
		if(($selfkkk['match']['match']>0)||($selfkkk['match']['left']>0)||($selfkkk['match']['right']>0)){
			UpdateChainUser($memberid,$table,$arr);
		}
		$que1 = "SELECT `user`, `flash_match`, `matching` FROM `$table` WHERE `user`='".$memberid."' ORDER BY serial DESC LIMIT 1,1";
		$res1=$mysqli->query($que1);
		$rows1 = mysqli_fetch_assoc($res1);
		
		$todays_match=$selfkkk['match']['match']-($rows1['matching']+$rows1['flash_match']);
		if($todays_match>0){
			$slotmatch=matchSlot($todays_match, $sllot);
		}else{
			$slotmatch=0;
		}
		$left_carry=$selfkkk['match']['left'];
		$right_carry=$selfkkk['match']['right'];
		if($slotmatch>0){
			$flash_match=($todays_match-$slotmatch);
		}else{
			$flash_match=0;
		}
		
	
		
		$total_match=($slotmatch+$rows1['matching']);
		
		$mysqli->query("UPDATE `$table` SET 
				`matching`='".$total_match."',
				`flash_match`='".$flash_match."',
				`l_cary`='".$left_carry."',
				`r_cary`='".$right_carry."'
				WHERE `user`='".$memberid."' ");
				
		$que12 = "SELECT `user`, `flash_match`, `matching` FROM `$table` WHERE `user`='".$memberid."' ORDER BY serial DESC LIMIT 1";
		$res12=$mysqli->query($que12);
		$rows12 = mysqli_fetch_array($res12);
		$match_taka=(($rows12['matching']*$matchPercent)/100);
		return $match_taka;
	}
	function UpdateFlashDaily($selfkkk,$memberid,$table,$arr,$sllot,$matchPercent){
		global $mysqli;
		$date=date("Y-m-d");
		$consdd=" AND DATE(date)='".$date."'";
		
		$todays_match=$selfkkk['match']['match'];
		if($todays_match>0){
			$slotmatch=matchSlot($todays_match, $sllot);
		}else{
			$slotmatch=0;
		}
		$left_carry=$selfkkk['match']['left'];
		$right_carry=$selfkkk['match']['right'];
		if($slotmatch>0){
			$flash_match=($todays_match-$slotmatch);
		}else{
			$flash_match=0;
		}
		
		$tabl2="daily_".$table;
		$datts=array();
		$datts['user']=$memberid;
		$datts['matching']=$todays_match;
		$datts['slot_matching']=$slotmatch;
		$datts['flash_match']=$flash_match;
		$datts['l_cary']=$left_carry;
		$datts['r_cary']=$right_carry;
		$datts['date']=date("Y-m-d H:i:s");
		UpdateChainUser($memberid,$tabl2,$datts,$consdd);
		
	}
	
	function CountUserqq($user,$table, &$sess){
		global $mysqli;
		if(!in_array($user, $sess)){
			array_push($sess, $user);
		}
		$users=$mysqli->query("SELECT * FROM `$table` WHERE `upline`='".$user."'");
		while($user=mysqli_fetch_assoc($users)){
			//$_SESSION[$sess]=$_SESSION[$sess]+1;
			if(!in_array($user['user'], $sess)){
				array_push($sess, $user['user']);
			}
			CountUserqq($user['user'], $table, $sess);
		}
	}
	
	
	function leftRightqq($usse, $table){
		global $mysqli;
		$eer=array();
		$mmm=$mysqli->query("SELECT * FROM `$table` WHERE `upline`='".$usse."'");
		while($uuui=mysqli_fetch_assoc($mmm)){
			if($uuui['position']=="Left"){
				$eer['left']=$uuui['user'];
			}elseif($uuui['position']=="Right"){
				$eer['right']=$uuui['user'];
			}
		}
		return $eer;
	}
	
	


	
	function CidBinary($cid){
		global $mysqli;
		$mmnn=mysqli_fetch_assoc($mysqli->query("SELECT `user`, `log_user` FROM `member` WHERE `log_user`='".$cid."' ORDER BY `serial` ASC LIMIT 1"));
		$usekk=leftRightqq($mmnn['user'], "member");
		$lkj=array("left", "right");
		$left=0;
		$right=0;
		$retty=array();
		foreach($lkj as $possi){
			$totalLeft=array();
			CountUserqq($usekk[$possi],"member", $totalLeft);
			$total=activeFilter(userToCID($totalLeft));
			$invest=0;
			foreach($total as $ccii){
				$invest=$invest+((Sumamn("member", "SUM(point) AS total","`log_user`='$ccii'")*50)/100);
			}
			$$possi=$invest;
		}
		$retty['match']=matchAmount($left, $right);
		$retty['leftTotal']=$left;
		$retty['rightTotal']=$right;
		return $retty;
	}
	
	
	function updateCidBinary($cid){
		global $mysqli;
		$ffd=array($cid);
		$ttrr=count(activeFilter($ffd));
		if($ttrr>0){
			$Matchhammn=CidBinary($cid);
			$arr['user']=$cid;
			$cidSlot1=mysqli_fetch_assoc($mysqli->query("SELECT MAX(point) AS point FROM `member` WHERE `log_user`='".$cid."'"));
			$cvidSlott=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `package` WHERE `pack_amn`='".$cidSlot1['point']."'"));
			$sllot=explode(",", $cvidSlott['cid_dessc']);
			$matchTaka=UpdateFlash($Matchhammn,$cid,"uniq_binary",$arr,$sllot,10) *.70;
			$mysqli->query( "UPDATE `uniq_balance` SET `binary_in`='".$matchTaka."' WHERE `user`='".$cid."'");
		}
	}

?>