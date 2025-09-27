<?php
	$timing_start = explode(' ', microtime());
	error_reporting(-1);
	set_time_limit(0);
	ini_set('memory_limit','512M');
	$_SESSION['token']='12345gh';	
	//require 'functions.php';
	require 'db.php';
	$i=1;
	$jkhfd=$mysqli->query("SELECT DISTINCT `user` FROM `binary_income` ");
	while($Aklsjf=mysqli_fetch_assoc($jkhfd)){
		$kdfh=mysqli_num_rows($mysqli->query("SELECT * FROM `member` WHERE `user`='".$Aklsjf['user']."' AND `pack`>'0'"));
		if($kdfh<1){
			echo $Aklsjf['user'] ." Inactive >> $i<br/>";
		}else{
			echo $Aklsjf['user'] ." Active >> $i<br/>";
		}
		$i++;
	}
	
	/*
	function count_user($user, &$rrr , $posiit){
		global $mysqli;
		if(!in_array($user, $rrr)){
			array_push($rrr, $user);
		}
		$exe2 = $mysqli->query("SELECT user,upline,`position` FROM member WHERE upline='".$user."' AND `position`='".$posiit."'");
		while($result2=mysqli_fetch_array($exe2)){
			if(!in_array($result2['user'], $rrr)){
				if($posiit==$result2['position']){
					//echo $result2['user'] ."<br/>";
					array_push($rrr, $result2['user']);
				}
			}
			count_user($result2['user'], $rrr, $posiit);
		}
	}
	function SearchPlace22($user,$position){
		global $mysqli;
		$rett=array();
		$cgghh=$mysqli->query("SELECT * FROM `member` WHERE `upline`='".$user."' AND `position`='".$position."'");
		$CheckSponsor=mysqli_num_rows($cgghh);
		if($CheckSponsor>0){
			$nextId=mysqli_fetch_assoc($cgghh);
			count_user($nextId['user'], $rett, $position);
		}else{
			array_push($rett,$user);
		}
		
		return $rett;
	}
	function RetunExchane($Exchange,$Amount){
		$url = 'https://pro-api.coinmarketcap.com/v1/tools/price-conversion';
		$parameters = [
			'symbol' => 'BTC',
			'amount' => $Amount,
			'convert' => $Exchange
		];
		$headers = [
			'Accepts: application/json',
			'X-CMC_PRO_API_KEY: 05488dcd-935f-45df-a43b-6be90591454a'
		];
		$qs = http_build_query($parameters);
		$request = "{$url}?{$qs}"; // create the request URL


		$curl = curl_init(); // Get cURL resource
		// Set cURL options
		curl_setopt_array($curl, array(
			CURLOPT_URL => $request,            // set the request URL
			CURLOPT_HTTPHEADER => $headers,     // set the headers 
			CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
		));

		$response = curl_exec($curl); // Send the request, save the response
		$yyruie=json_decode($response);
		curl_close($curl);
		return $yyruie->data->quote->$Exchange->price;
	}
	var_dump(RetunExchane("USD",1));
	var_dump(date("D"));
	*/
	//var_dump(SearchPlace22("Pintu01",2));
	//var_dump(SearchRankUp("dream"));
	
	/*$member=$_SESSION['MemLogId'];
	$memberid="0734981";
	$ggh=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `games` ORDER BY `serial` DESC"));
	var_dump(date("h:i A",$ggh['endtime']));
	var_dump($ggh['endtime']);
	
	date_default_timezone_set('GMT');

	$script_tz = date_default_timezone_get();

	if (strcmp($script_tz, ini_get('date.timezone'))){
		echo 'Script timezone differs from ini-set timezone.'.$script_tz ."<br/>";
	} else {
		echo 'Script timezone and ini-set timezone match.';
	}
	echo date("h:i A", time());
	echo time();*/
	//var_dump(rank_update($memberid));
	
	/*$jjj=$mysqli->query("SELECT * FROM `upgrade` WHERE DATE(`date`)='2017-10-16' ORDER BY `serial` ASC");
	while($mmnnkk=mysqli_fetch_assoc($jjj)){
		$mmjhg=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `package` WHERE `pack`='".$mmnnkk['package']."'"));
		$mysqli->query("UPDATE `member` SET `pack`='".$mmjhg['serial']."' WHERE `user`='".$mmnnkk['user']."'");
	}*/
	
	
	
	/*function TotalBalanceww($user,$table){
		global $mysqli;
		$eerr=$mysqli->query("SHOW COLUMNS FROM $table");
		$bammm=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `$table` WHERE `user`='".$user."'"));
		while($cols=mysqli_fetch_assoc($eerr)){
			$uuyy=explode("_", $cols['Field']);
			$ddff=count($uuyy);
			$tttyy=$uuyy[$ddff-1];
			if($tttyy=="in"){
				$inamn=$inamn+$bammm[$cols['Field']];
			}elseif($tttyy=="out"){
				$outamn=$outamn+$bammm[$cols['Field']];
			}
			
		}
		$finaltaka=$inamn-$outamn;
		//$mysqli->query("UPDATE `balance` SET `total_in_taka`='".$inamn."', `total_out_taka`='".$outamn."', `final_taka`='".$finaltaka."' WHERE `user`='".$user."'");
		return $finaltaka;
	}
	
	function UniqueBalanceOutww($cid){
		global $mysqli;
		$userss=CidToUser($cid);
		$totalUout=array();
		$out=0;
		$requireTable=array("trans_receive", "renew_game", "game_configure", "upgrade");
		foreach($userss as $user){
			foreach($requireTable as $table){
				if($table=="trans_receive"){
					$out=Sumamn($table, "SUM(`u_balance`) as total","`user_trans`='$user'");
				}else{
					$out=Sumamn($table, "SUM(`u_balance`) as total","`user`='$user'");
				}
				$totalUout[$table]=$totalUout[$table]+$out;
				
			}
		}
		$totalOout=array_sum($totalUout);
		$mysqli->query("UPDATE `uniq_balance` SET `total_out`='".$totalOout."' WHERE `user`='".$cid."'");
		return $totalUout;
	}
	
	
	function UniqueBalanceInwww($cid){
		global $mysqli;
		SpotComission($cid);
		$totalOut=array_sum(UniqueBalanceOutww($cid));
		$finalBanalce=TotalBalanceww($cid,"uniq_balance");
		$mysqli->query("UPDATE `uniq_balance` SET `final_balance`='".$finalBanalce."' WHERE `user`='".$cid."'");
		return $finalBanalce;
	}
	
	
	//var_dump(array_sum(UniqueBalanceInwww("9244870")));
	var_dump(UniqueBalanceInwww("9244870"));
	
	
	
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
	
	$referral="khalid01";
	$table="member";
	$usekk=leftRightqq($referral, $table);
	$totalLeft=array();
	$totalRight=array();
	
	CountUserqq($usekk['left'],$table, $totalLeft);
	CountUserqq($usekk['right'],$table, $totalRight);
	
	$CidLeft=userToCID($totalLeft);
	
	$CidRight=userToCID($totalRight);
	
	$activveLeft=activeFilter($CidLeft);
	$activveRight=activeFilter($CidRight);
	
	//var_dump($activveLeft);
	//var_dump($activveRight);
	$cid="0321213";
	$cidSlot1=mysqli_fetch_assoc($mysqli->query("SELECT MAX(point) AS point FROM `member` WHERE `log_user`='".$cid."'"));
	$cvidSlott=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `package` WHERE `pack_amn`='".$cidSlot1['point']."'"));
	var_dump(explode(",", $cvidSlott['cid_dessc']));
	
	
	/*function CountUser($user,$table, $sess, &$newSES=''){
		global $mysqli;
		$users=$mysqli->query("SELECT * FROM `$table` WHERE `upline`='".$user."'");
		while($user=mysqli_fetch_assoc($users)){
			if($user['point']>1){
				$_SESSION[$sess]=$_SESSION[$sess]+1;
				if(is_array($newSES)){
					if(!in_array($user['log_user'], $newSES)){
						array_push($newSES, $user['log_user']);
					}
				}
			}
			CountUser($user['user'], $table, $sess, $newSES);
		}
	}
	
	
	$Left=array();
	$Right=array();
	$uiiyt=mysqli_fetch_assoc($mysqli->query("SELECT `user`, `log_user` FROM `member` WHERE `log_user`='5210946' ORDER BY `serial` ASC LIMIT 1"));
	$tttii=$mysqli->query("SELECT * FROM `member` WHERE `upline`='".$uiiyt['user']."'");
	while($mmnn=mysqli_fetch_assoc($tttii)){
		$_SESSION[$mmnn['position']]=0;
		$kjhh=$mmnn['position'];
		CountUser($mmnn['user'],"member", $mmnn['position'],$$kjhh);
	}
	
	var_dump($Left);
	var_dump($Right);
	*/
	
	/*
	//var_dump(leftRightCID("0321213"));
	$jjh=$mysqli->query("SELECT * FROM `play` where DATE(`date`)>='2017-09-20'");
	while($miUpgrade=mysqli_fetch_assoc($jjh)){
		$mmnn=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `game_configure` WHERE `serial`='".$miUpgrade['config_id']."'"));
		if($mmnn['amount']<1){
			$mysqli->query("UPDATE `game_configure` SET `amount`='".$miUpgrade['amount']."' WHERE `serial`='".$miUpgrade['config_id']."'");
			echo $mmnn['amount'] . "<br/>";
		}
	}*/
	
	
	
	/*function gameInvestss($user){
		global $mysqli;
		$mmn=$mysqli->query("SELECT * FROM `play` WHERE `user`='".$user."' AND `win`='0'");
		$invest=array();
		while($shortInvest=mysqli_fetch_assoc($mmn)){
			$hhh=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `game_configure` WHERE `serial`='".$shortInvest['config_id']."'"));
			if($hhh['u_balance']>0){
				$amount=$amount+($hhh['amount']-$hhh['u_balance']);
				$invest['uniq']=$invest['uniq']+$hhh['u_balance'];
			}else{
				$amount=$amount+$hhh['amount'];
			}
			
		}
		$invest['current']=$amount;
		return $invest;
	}
	
	var_dump(gameInvestss($member));
	
	$totalTrans=TransReciveww("moneybooster","trans_receive");
	
	$recivFromAgentCurrent=$totalTrans['Agent']['Transfer']['user_receive']['ammount'];
	$recivFromAgentBonus=$totalTrans['Agent']['Transfer']['user_receive']['c_wallet'];
	
	$WithdrawToAgent=$totalTrans['Agent']['Withdraw']['user_trans']['ammount'];
	$WithdrawToAgentTax=$totalTrans['Agent']['Withdraw']['user_trans']['tax'];
	
	$recivFromMemberCurrent=$totalTrans['Member']['Transfer']['user_receive']['ammount'];
	$recivFromMemberBunus=$totalTrans['Member']['Transfer']['user_receive']['c_wallet'];
	
	$transferToMemberCurrent=$totalTrans['Member']['Transfer']['user_trans']['ammount'];
	$transferToMemberBunus=$totalTrans['Member']['Transfer']['user_trans']['c_wallet'];
	$transferToMemberCurrentTax=$totalTrans['Member']['Transfer']['user_trans']['tax'];
	$transferFromUnique=$totalTrans['Member']['Transfer']['user_trans']['u_balance'];
	
	var_dump(generationCID("8037534"));*/
	
	//print_r($totalTrans['Agent']['Transfer']['user_receive']);
	//print_r($totalTrans['Member']['Transfer']['user_trans']);
	//$directCid=DirectDownCid("0321213");
	//var_dump(SpotComission($directCid));
	//var_dump(DirectDownCid("0321213"));
	//$jhh=leftRightCID("0321213");
	//var_dump(activeFilter($jhh['Right']));
	/*function DownnCCIDww($cids){
		global $mysqli;
		$rrggv=array();
		foreach($cids as $cid){
			$hhgg=DownCid($cid);
			$rrggv=array_merge($rrggv, $hhgg);
		}
		return array_unique($rrggv);
	}*/
	
	//var_dump(activeFilter(DownnCCID($jhh['Right'])));
	/*function count_user($user, &$rrr){
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
	function leftRightUser($CID){
		global $mysqli;
		$hhh=array();
		$Left=array();
		$Right=array();
		$CIDposition=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `log_user`='".$CID."' ORDER BY `serial` ASC LIMIT 1"));
		$userId=$CIDposition['user'];
		$msd=$mysqli->query("SELECT * FROM `member` WHERE `upline`='".$userId."'");
		while($userleft=mysqli_fetch_assoc($msd)){
			count_user($userleft['user'], $$userleft['position']);
		}
		$hhh['lll']=$Left;
		$hhh['rrr']=$Right;
		return $hhh;
	}
	function selfuserIdfilter($users, $cid){
		global $mysqli;
		$uuudd=array();
		foreach($users as $user){
			$checkself=mysqli_num_rows($mysqli->query("SELECT `user`, `log_user`,`point` FROM `member` WHERE `user`='".$user."' AND `log_user`='".$cid."'"));
			if($checkself>0){
				$comm=mysqli_fetch_assoc($mysqli->query("SELECT `user`, `log_user`,`point` FROM `member` WHERE `user`='".$user."'"));
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
	function CidBinary($cid){
		global $mysqli;
		$hhj=leftRightCID($cid);
		$lkj=array("Left", "Right");
		$Left=0;
		$Right=0;
		$retty=array();
		foreach($lkj as $possi){
			$total=activeFilter(DownnCCID($hhj[$possi]));
			$invest=0;
			foreach($total as $ccii){
				$invest=$invest+((Sumamn("member", "SUM(point) AS total","`log_user`='$ccii'")*50)/100);
			}
			$$possi=$invest;
		}
		$retty['match']=matchAmount($Left, $Right);
		$retty['leftTotal']=$Left;
		$retty['rightTotal']=$Right;
		return $retty;
	}
	function UpdateFlash($selfkkk,$memberid,$table,$arr,$sllot,$matchPercent){
		global $mysqli;
		if(($selfkkk['match']['match']>0)||($selfkkk['match']['left']>0)||($selfkkk['match']['right']>0)){
			UpdateChainUser($memberid,$table,$arr);
		}
		$que1 = "SELECT `user`, `flash_match`, `matching` FROM `$table` WHERE `user`='".$memberid."' ORDER BY serial DESC LIMIT 1";
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
		$flash_match=($todays_match-$slotmatch);
		$total_match=($slotmatch+$rows1['matching']);
		$mysqli->query("UPDATE `$table` SET 
				`matching`='".$total_match."',
				`flash_match`='".$flash_match."',
				`l_cary`='".$left_carry."',
				`r_cary`='".$right_carry."'
				WHERE `user`='".$memberid."'");
				
		$que12 = "SELECT `user`, `flash_match`, `matching` FROM `$table` WHERE `user`='".$memberid."' ORDER BY serial DESC LIMIT 1";
		$res12=$mysqli->query($que12);
		$rows12 = mysqli_fetch_array($res12);
		$match_taka=(($rows12['matching']*$matchPercent)/100);
		return $match_taka;
	}
	function updateCidBinary($cid){
		global $mysqli;
		$ffd=array($cid);
		$ttrr=count(activeFilter($ffd));
		if($ttrr>0){
			$Matchhammn=CidBinary($cid);
			$arr['user']=$cid;
			$sllot=array(100,250,500,1000,2500,5000,10000,25000);
			$matchTaka=UpdateFlash($Matchhammn,$cid,"uniq_binary",$arr,$sllot,5);
			$mysqli->query( "UPDATE `uniq_balance` SET 
				`binary_in`='".$matchTaka."'
			WHERE `user`='".$cid."'");
		}
	}
	$ffd=array("0321213");
	$ttrr=count(activeFilter($ffd));
	//var_dump(CidBinary("0321213"));
	
	//var_dump(TotalBalance("0321213","uniq_balance"));
	function CaluCulateCurent($user){
		global $mysqli;
		$reqTable=array("member","bcpp", "trans_receive","game_configure","renew_game","upgrade","req_fund","game_return","return_invest");
		$tableCols=array(
			"member"=>array("cols"=>"direct","cons"=>"sponsor='".$user."'";
			"bcpp"=>array("cols"=>"commission","cons"=>"sponsor='".$user."'");
			"trans_receive"=>array("cols"=>"ammount,c_wallet","cons"=>"user_receive='".$memberid."' and type='Transfer' and account='Agent'");
		);
		foreach(){
			Sumamn("member", "SUM(`u_balance`) as total","`user`='$user'");
		}
	}
	*/
	/*$slots=array(10,20,30,40,50,500);
	$hhhh=leftRightUser("0321213");
	$selfLeftPoint=array_sum(selfuserIdfilter($hhhh['lll'], "0321213"));
	$selfRightPoint=array_sum(selfuserIdfilter($hhhh['rrr'], "0321213"));
	$matchaam=matchAmount($selfLeftPoint, $selfRightPoint);
	
	$matchslot=matchSlot($matchaam['match'], $slots);
	var_dump($matchslot);
	//var_dump($selfRightPoint);
	
	/*function selfBinaryw($memberid,$cid){
		global $mysqli;
		$msd=$mysqli->query("SELECT * FROM `member` WHERE `upline`='".$memberid."'");
		$Left=0;
		$Right=0;
		while($userleft=mysqli_fetch_assoc($msd)){
			$uuyy=array();
			count_user($userleft['user'], $uuyy);
			$cons=" AND `active`='1'";
			$$userleft['position']=array_sum(selfuserIdfilter($uuyy, $cid));//InvestAamn($uuyy, "invest", "amount", $cons);
		}
		$ttrr=matchAmount($Left, $Right);
		return $ttrr;
	}
	var_dump(selfBinaryw("0321213"));*/

	/*$mm=$mysqli->query("SELECT * FROM `play` WHERE `return_cur`='1'");
	while($played=mysqli_fetch_assoc($mm)){
		$investReturnToCurrent=$played['amount'];
		$ffr=mysqli_num_rows($mysqli->query("SELECT * FROM `return_invest` WHERE `play_id`='".$played['serial']."'"));
		if($ffr>0){
			$mysqli->query("UPDATE `return_invest` SET `amount`='".$investReturnToCurrent."' WHERE `play_id`='".$played['serial']."'");
		}else{
			$mysqli->query("INSERT INTO `return_invest`(`user`, `game_type`, `gameid`, `play_id`, `amount`) VALUES ('".$played['user']."','".$played['type_id']."','".$played['gameid']."','".$played['serial']."','".$investReturnToCurrent."')");
		}
			
		
	}*/
?>