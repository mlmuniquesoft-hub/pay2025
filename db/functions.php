<?php
session_start();
$_SESSION['token']="uerutgeruioer";
	require_once("db.php");
	
	function InsertInfo($table, $arr,$conn=''){
		if($conn==''){
			global $mysqli;
		}else{
			$mysqli=$conn;
		}
		
		$eerr=$mysqli->query("SHOW COLUMNS FROM `$table`");
		$uuyy=array();
		while($cols=mysqli_fetch_assoc($eerr)){
			array_push($uuyy , $cols['Field']);
		}
		$rryt=array_keys($arr);
		$keys=array();
		$values=array();
		foreach($rryt as $ttr){
			if(in_array($ttr, $uuyy)){
				array_push($keys,"`$ttr`");
				if(is_array($arr[$ttr])){
					$arruu=array();
					foreach($arr[$ttr] as $ggg){
						if($ggg!=''){
							array_push($arruu, $ggg);
						}
					}
					$vals=$mysqli->real_escape_string(implode("/", $arruu));
				}else{
					$vals=$mysqli->real_escape_string($arr[$ttr]);
				}
				array_push($values,"'$vals'");
			}
		}
		
		$in_keys=implode(",",$keys);
		$in_values=implode(",",$values);
		$check=$mysqli->query("INSERT INTO `$table`($in_keys) VALUES ($in_values)");
		if($check){
			return 1;
		}else{
			return 0;
		}
		
	}
	
	function RenameID($PastID, $NewID, $conn){
		global $mysqli;
		
		$eiurtyie=array("receiver","from_user","create_by","user_reciv","request_by","user_opsite","fund_id","user_transfer","user_receive","user_id","user","sponsor","carry_id","upline","for_user","user_trans","user_receive");
		$wrwe=array_keys($conn);
		$ewUy=date("Y-m-d h:i:s");
		foreach($wrwe as $fsdf){
			$connS2=$conn[$fsdf];
			$connS=$$connS2;
			$erte=$connS->query("SHOW tables");
			while($altsb=mysqli_fetch_assoc($erte)){
				//var_dump($altsb);
				if($altsb['Tables_in_'.$fsdf]!="rename"){
					$dfghfd=$connS->query("SHOW COLUMNS FROM ".$altsb['Tables_in_'.$fsdf]);
					while($allColumn=mysqli_fetch_assoc($dfghfd)){
						if(in_array($allColumn['Field'],$eiurtyie)){
							$kfhfg=mysqli_num_rows($connS->query("SELECT * FROM `".$altsb['Tables_in_'.$fsdf]."` WHERE `".$allColumn['Field']."`='".$PastID."'"));
							if($kfhfg>0){
								$connS->query("UPDATE `".$altsb['Tables_in_'.$fsdf]."` SET `".$allColumn['Field']."`='".$NewID."' WHERE `".$allColumn['Field']."`='".$PastID."'");
								//echo $allColumn['Field'] ." >> ". $altsb['Tables_in_'.$fsdf] ."\n";
							}
						}
						
					}
					//echo $altsb['Tables_in_'.$fsdf] ."<br/>";
				}
			}
			
		}
		$mysqli->query("INSERT INTO `rename`( `newid`, `pastid`, `date`) VALUES ('".$NewID."','".$PastID."','".$ewUy."')");
	}
	
	
	
	function TtalIncome($user, $cons=''){
		global $mysqli;
		$SponsorReceive=mysqli_fetch_assoc($mysqli->query("SELECT SUM(bonus) AS asmSponsor FROM `upgrade` WHERE `sponsor`='".$user."'"));
		$DepositReceive=mysqli_fetch_assoc($mysqli->query("SELECT SUM(curent_bal) AS asmDeposit FROM `game_return` WHERE `user`='".$user."'"));
		$DepositReceiveWorld=mysqli_fetch_assoc($mysqli->query("SELECT SUM(curent_bal) AS asmDeposit2 FROM `game_return2` WHERE `user`='".$user."'"));
		$BinaryReceive=mysqli_fetch_assoc($mysqli->query("SELECT SUM(slot_match) AS asmBinary FROM `binary_income` WHERE `user`='".$user."'"));
		$GenerationReceive=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) AS asmGeneration FROM `generation_income` WHERE `user`='".$user."'"));
		if($cons!=''){
			$income=$GenerationReceive['asmGeneration']+$BinaryReceive['asmBinary']+$DepositReceiveWorld['asmDeposit2']+$DepositReceive['asmDeposit'];
		}else{
			$income=$GenerationReceive['asmGeneration']+$BinaryReceive['asmBinary']+$DepositReceiveWorld['asmDeposit2']+$DepositReceive['asmDeposit']+$SponsorReceive['asmSponsor'];
		}
		
		if($income>0){
			return $income;
		}else{
			return 0.00;
		}
	}
	
	function TtalShopping($user, $cons=''){
		global $mysqli;
		$SponsorReceiveshop=mysqli_fetch_assoc($mysqli->query("SELECT SUM(shopping) AS asmSponsorshop FROM `upgrade` WHERE `sponsor`='".$user."'"));
		// Handle null values
		if($SponsorReceiveshop['asmSponsorshop'] == null) {
			$SponsorReceiveshop['asmSponsorshop'] = 0;
		}
		
		// Using 0 for shop columns since they don't exist in the database
		$DepositReceiveshop = array('asmDepositshop' => 0);
		$DepositReceiveWorldshop = array('asmDeposit2shop' => 0);
		$BinaryReceiveshop = array('asmBinaryshop' => 0);
		$GenerationReceiveshop = array('asmGenerationshop' => 0);
		
		if($cons!=''){
			$shopping=$GenerationReceiveshop['asmGenerationshop']+$BinaryReceiveshop['asmBinaryshop']+$DepositReceiveWorldshop['asmDeposit2shop']+$DepositReceiveshop['asmDepositshop'];
		}else{
			$shopping=$GenerationReceiveshop['asmGenerationshop']+$BinaryReceiveshop['asmBinaryshop']+$DepositReceiveWorldshop['asmDeposit2shop']+$DepositReceiveshop['asmDepositshop']+$SponsorReceiveshop['asmSponsorshop'];
		}
		
		if($shopping>0){
			return $shopping;
		}else{
			return 0.00;
		}
	}
	
	
	function TtalcOMMISIO($user,$date=''){
		global $mysqli;
		if($date!=''){
			$consd="WHERE DATE(`date`)='".$date."'";
		}else{
			$consd=null;
		}
		$SponsorReceive=mysqli_fetch_assoc($mysqli->query("SELECT SUM(bonus) AS asmSponsor FROM `upgrade` $consd"));
		$DepositReceive=mysqli_fetch_assoc($mysqli->query("SELECT SUM(curent_bal) AS asmDeposit FROM `game_return` $consd"));
		$DepositReceiveWorld=mysqli_fetch_assoc($mysqli->query("SELECT SUM(curent_bal) AS asmDeposit2 FROM `game_return2` $consd"));
		$BinaryReceive=mysqli_fetch_assoc($mysqli->query("SELECT SUM(slot_match) AS asmBinary FROM `binary_income` $consd"));
		$GenerationReceive=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) AS asmGeneration FROM `generation_income` $consd"));
		$income=$GenerationReceive['asmGeneration']+$BinaryReceive['asmBinary']+$DepositReceiveWorld['asmDeposit2']+$DepositReceive['asmDeposit']+$SponsorReceive['asmSponsor'];
		if($income>0){
			return $income;
		}else{
			return 0.00;
		}
	}
	
	function TtalcOMMISIOshop($user,$date=''){
		global $mysqli;
		if($date!=''){
			$consd="WHERE DATE(`date`)='".$date."'";
		}else{
			$consd=null;
		}
		$SponsorReceiveshop=mysqli_fetch_assoc($mysqli->query("SELECT SUM(shopping) AS asmSponsorshop FROM `upgrade` $consd"));
		$DepositReceiveshop=mysqli_fetch_assoc($mysqli->query("SELECT SUM(shop) AS asmDepositshop FROM `game_return` $consd"));
		$DepositReceiveWorldshop=mysqli_fetch_assoc($mysqli->query("SELECT SUM(curent_bal) AS asmDeposit2 FROM `game_return2` $consd"));
		$BinaryReceiveshop=mysqli_fetch_assoc($mysqli->query("SELECT SUM(shop) AS asmBinaryshop FROM `binary_income` $consd"));
		$GenerationReceiveshop=mysqli_fetch_assoc($mysqli->query("SELECT SUM(shop) AS asmGenerationshop FROM `generation_income` $consd"));
		$shopping=$GenerationReceive['asmGeneration']+$BinaryReceive['asmBinary']+$DepositReceiveWorld['asmDeposit2']+$DepositReceive['asmDeposit']+$SponsorReceive['asmSponsor'];
		if($shopping>0){
			return $shopping;
		}else{
			return 0.00;
		}
	}
	
	function RemainingReturn($user){
		global $mysqli;
		$DepositReceive=TtalIncome($user,1);
		$MemberUpgrade=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) AS asmUpgrade FROM `upgrade` WHERE `user`='".$user."'"));
		$ExpectyedReturn=$MemberUpgrade['asmUpgrade']*4;
		$remainReturn=($ExpectyedReturn-($shopping+$DepositReceive));
		if($remainReturn>0){
			return $remainReturn;
		}else{
			return 0.00;
		}
	}
	
	function RemainingReturnPer($user){
		global $mysqli;
		$shopping = TtalShopping($user);
		$DepositReceive=TtalIncome($user,1);
		$MemberUpgrade=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) AS asmUpgrade FROM `upgrade` WHERE `user`='".$user."'"));
		$ExpectyedReturn=$MemberUpgrade['asmUpgrade']*4;
		$remainReturn=$ExpectyedReturn-$DepositReceive;
		
		// Prevent division by zero
		if($ExpectyedReturn > 0){
			$retuu=((($DepositReceive+$shopping)*400)/$ExpectyedReturn);
			if($retuu>0){
				return $retuu;
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}
	
	
	function remainAmn($user){
		global $mysqli;
		$AdminReceive=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) AS asmAdmin FROM `admin_trans_receive` WHERE `user_receive`='".$user."'"));
		$DepositBtc=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) AS asmSatoshi FROM `req_fund` WHERE `user`='".$user."'"));
		$DolarAmount=$DepositBtc['asmSatoshi'];
		
		$MemberReceive=mysqli_fetch_assoc($mysqli->query("SELECT SUM(ammount) AS asmMember FROM `trans_receive` WHERE `user_receive`='".$user."' AND `type`='Transfer'"));
		$iNcome=TtalIncome($user);
		$shopping=TtalShopping($user);
		$TotalIn=$iNcome+$DolarAmount+$MemberReceive['asmMember']+$AdminReceive['asmAdmin'];
		
		$MemberTrans=mysqli_fetch_assoc($mysqli->query("SELECT SUM(ammount) AS asmTrans FROM `trans_receive` WHERE `user_trans`='".$user."' AND `type`='Transfer'"));
		$MemberWithdraw=mysqli_fetch_assoc($mysqli->query("SELECT SUM(ammount) AS asmWithdraw FROM `trans_receive` WHERE `user_trans`='".$user."' AND `type`='Withdraw' AND `status`!='Cancel'"));
		$MemberUpgrade=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) AS asmUpgrade FROM `upgrade` WHERE `user`='".$user."'"));
		$MemberUpgradeCharge=mysqli_fetch_assoc($mysqli->query("SELECT SUM(charge) AS asmChhr FROM `upgrade` WHERE `user`='".$user."'"));
		$TotalOut=$MemberUpgradeCharge['asmChhr']+$MemberUpgrade['asmUpgrade']+$MemberWithdraw['asmWithdraw']+$MemberTrans['asmTrans'];
		$FinalAmount=$TotalIn-$TotalOut;
		
		$mysqli->query("UPDATE `balance` SET `shoping_taka`='".$shopping."',`total_in_taka`='".$TotalIn."',`total_out_taka`='".$TotalOut."',`final_taka`='".$FinalAmount."' WHERE `user`='".$user."'");
		
		if($FinalAmount>0){
			return $FinalAmount;
		}else{
			return 0.00;
		}
	}
	
	
	function remainAmn22($user){
		global $mysqli;
		$AdminReceive=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) AS asmAdmin FROM `admin_trans_receive` WHERE `user_receive`='".$user."'"));
		$DepositBtc=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) AS asmSatoshi FROM `req_fund` WHERE `user`='".$user."'"));
		$DolarAmount=$DepositBtc['asmSatoshi'];
		$MemberReceive=mysqli_fetch_assoc($mysqli->query("SELECT SUM(ammount) AS asmMember FROM `trans_receive` WHERE `user_receive`='".$user."' AND `type`='Transfer'"));
		$iNcome=TtalIncome($user);
		$shopping=TtalShopping($user);
		$TotalIn=$iNcome+$DolarAmount+$MemberReceive['asmMember']+$AdminReceive['asmAdmin'];
		
		$MemberTrans=mysqli_fetch_assoc($mysqli->query("SELECT SUM(ammount) AS asmTrans FROM `trans_receive` WHERE `user_trans`='".$user."' AND `type`='Transfer'"));
		$MemberWithdraw=mysqli_fetch_assoc($mysqli->query("SELECT SUM(ammount) AS asmWithdraw FROM `trans_receive` WHERE `user_trans`='".$user."' AND `type`='Withdraw' AND `status`!='Cancel'"));
		$MemberUpgrade=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) AS asmUpgrade FROM `upgrade` WHERE `user`='".$user."'"));
		$MemberUpgradeCharge=mysqli_fetch_assoc($mysqli->query("SELECT SUM(charge) AS asmChhr FROM `upgrade` WHERE `user`='".$user."'"));
		$MemberProductAdj=mysqli_fetch_assoc($mysqli->query("SELECT SUM(adj_bal) AS pro_pur FROM `order` WHERE `user_id`='".$user."'"));
		$TotalOut=$MemberUpgradeCharge['asmChhr']+$MemberUpgrade['asmUpgrade']+$MemberWithdraw['asmWithdraw']+$MemberTrans['asmTrans'];
		$Finalshopping=$shopping-$MemberProductAdj['pro_pur'];
		$FinalAmount=$TotalIn-$TotalOut;
		$rett=array();
		$rett['in']=$TotalIn;
		$rett['out']=$TotalOut;
		$rett['shop']=$Finalshopping;
		$rett['final']=$FinalAmount; 
		return $rett;
	}
	
	function finSecure(){
		global $mysqli;
		$sdgsd=array();
		//echo "werew";
		$dfkgjh=$mysqli->query("SELECT * FROM `gamesetup`");
		while($wueyew=mysqli_fetch_assoc($dfkgjh)){
			$qqwq=explode("/",$wueyew['return_amount']);
			if($qqwq[1]!=''){
				if($qqwq[1]==100){
					array_push($sdgsd, $wueyew['serial']);
				}
			}
			
		}
		return $sdgsd;
	}
	
	
	function PlayedGame($memberid,$secureTT){
		global $mysqli;
		//$PresentDate=date("Y-m-d");
		$iiiin=implode("' OR  `type_id`='", $secureTT);
		$rrett="  `type_id`='" . $iiiin ."'";
		
		$mmm=mysqli_num_rows($mysqli->query("SELECT * FROM play WHERE `user`='".$memberid."' AND `renew`='0' AND ($rrett)"));
		$sedf=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `play_countUpdate` WHERE `user`='".$memberid."'"));
		$yuret=0;
		foreach($secureTT as $serr){
			$cols="type".$serr;
			$eeet=explode("/", $sedf[$cols]);
			$ertre=$eeet[0];
			$yuret=$yuret+$ertre;
		}
		$totalPlay=($mmm+$yuret);
		return $totalPlay;
	}
	
	function SearchRankUp($user){
		global $mysqli;
		$er=array();
		$i=true;
		while($i){
			$yy=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `user`='".$user."'"));
			$user=$yy['sponsor'];
			if($user!=''){
				$rtej=mysqli_num_rows($mysqli->query("SELECT `user` FROM `ranks` WHERE `user`='".$user."'"));
				if($rtej>0){
					array_push($er,$user);
					$i=false;
					break;
				}else{
					$i=true;
				}
				//array_unshift($er, $user);
			}else{
				$i=false;
				break;
			}
		}
		return $er;
	}
	
	function maxMinWithdrawView($order,$set_limit){
		global $mysqli;
		$erter=$mysqli->query("SELECT DISTINCT `user_trans` FROM `trans_receive` WHERE `type`='Withdraw'");
		$sdfsd=array();
		$Retutt=array();
		while($allInfo=mysqli_fetch_assoc($erter)){
			$fhgfhf=mysqli_num_rows($mysqli->query("SELECT `user` FROM `member` WHERE `user`='".$allInfo['user_trans']."' "));
			if($fhgfhf>0){
				$chejh=mysqli_num_rows($mysqli->query("SELECT `user_trans` FROM `trans_receive` WHERE `user_trans`='".$allInfo['user_trans']."' AND type='Withdraw'"));
				$sdfsd[$allInfo['user_trans']]=$chejh;
			}
		}
		if($order=="ASC"){
			asort($sdfsd);
		}else{
			arsort($sdfsd);
		}
		$fdgd=array_keys($sdfsd);
		$Retutt['totyal']=count($fdgd);
		$qewqe=array_slice($fdgd,$set_limit,30);
		$Retutt['total_sanitize']=$qewqe;
		return $Retutt;
	}
	
	function maxMinTransferView($order,$set_limit){
		global $mysqli;
		$erter=$mysqli->query("SELECT DISTINCT `user_trans` FROM `trans_receive` WHERE `type`='Transfer' AND `account`='Member'");
		$sdfsd=array();
		$Retutt=array();
		while($allInfo=mysqli_fetch_assoc($erter)){
			$fhgfhf=mysqli_num_rows($mysqli->query("SELECT `user` FROM `member` WHERE `user`='".$allInfo['user_trans']."' "));
			if($fhgfhf>0){
				$chejh=mysqli_num_rows($mysqli->query("SELECT `user_trans` FROM `trans_receive` WHERE `user_trans`='".$allInfo['user_trans']."' AND type='Transfer' AND `account`='Member'"));
				$sdfsd[$allInfo['user_trans']]=$chejh;
			}
		}
		if($order=="ASC"){
			asort($sdfsd);
		}else{
			arsort($sdfsd);
		}
		$fdgd=array_keys($sdfsd);
		$Retutt['totyal']=count($fdgd);
		$qewqe=array_slice($fdgd,$set_limit,30);
		$Retutt['total_sanitize']=$qewqe;
		return $Retutt;
	}
	
	

	function maxMingAMEPLAYView($order,$set_limit,$conn=''){
		global $mysqli;
		if($conn!=''){
			$consdf=$conn;
		}else{
			$consdf=$mysqli;
		}
		$erter=$consdf->query("SELECT DISTINCT `user` FROM `play`");
		$sdfsd=array();
		$Retutt=array();
		while($allInfo=mysqli_fetch_assoc($erter)){
			$fhgfhf=mysqli_num_rows($mysqli->query("SELECT `user` FROM `member` WHERE `user`='".$allInfo['user']."' "));
			if($fhgfhf>0){
				$chejh=mysqli_num_rows($consdf->query("SELECT `user` FROM `play` WHERE `user`='".$allInfo['user']."' "));
				$sdfsd[$allInfo['user']]=$chejh;
			}
		}
		if($order=="ASC"){
			asort($sdfsd);
		}else{
			arsort($sdfsd);
		}
		$fdgd=array_keys($sdfsd);
		$Retutt['totyal']=count($fdgd);
		$qewqe=array_slice($fdgd,$set_limit,30);
		$Retutt['total_sanitize']=$qewqe;
		return $Retutt;
	}
	
	
	
	function sendSMS($CID, $messa, $sendid="8804445629106"){
		global $mysqli;
		$mndf=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$CID."'"));
		$contact=$mndf['mobile'];
		$name=$mndf['name'];
		
		$ertre="http://websms.dhakasoftbd.com/smsapi?api_key=C20017835b1918e2481d67.25415677&type=text&contacts=$contact&senderid=$sendid&msg=$messa";
		file_get_contents($ertre);
	}
	
	function BoardGameCalc($conn, $playId, $criteria=''){
		if($criteria!=''){
			$criteria=$criteria;
			$gameID=$playId;
			$invest=1;
		}else{
			$Criteria_Info=mysqli_fetch_assoc($conn->query("SELECT * FROM `play` WHERE `serial`='".$playId."'"));
			$gameID=$Criteria_Info['gameid'];
			$criteria=$Criteria_Info['choice'];
			$invest=$Criteria_Info['amount'];
		}
		
		$TotalAmount=mysqli_fetch_assoc($conn->query("SELECT SUM(amount) as total FROM `play` WHERE `gameid`='".$gameID."' AND `choice`!='".$criteria."'"));
		$TotalAmount22=mysqli_fetch_assoc($conn->query("SELECT SUM(amount) as total FROM `play` WHERE `gameid`='".$gameID."' AND `choice`='".$criteria."'"));
		$CHARGE=$TotalAmount['total']*0.20;
		$remainAmn=$TotalAmount['total']-$CHARGE;
		if($TotalAmount22['total']<1){
			$opoitB=1;
		}else{
			$opoitB=$TotalAmount22['total'];
		}
		$indivisualProfit=$remainAmn/$opoitB;
		$expectedReturn=$indivisualProfit*$invest;
		if($expectedReturn>0){
			$expectedReturn=$expectedReturn;
		}else{
			$expectedReturn=1;
		}
		return $expectedReturn;
	}
	
	function GMTtmeConvert($dateCheeck,$serverToGmtDiffer,$val=''){
		if($val!=''){
			$sttTime=explode("/", $val);
			$hourrt=(($sttTime[0]*60)*60);
			$minkt=($sttTime[1]*60);
			$extraTime=$hourrt+$minkt;
		}else{
			$extraTime=0;
		}
		$gmttTime=date("Y-m-d H:i:s ", strtotime($dateCheeck.$serverToGmtDiffer)+$extraTime);
		return $gmttTime;
	}
	
	
	function SeverToLocalTime($conn, $dateCheeck,$serverToGmtDiffer){
		if(!empty($_SERVER['HTTP_CLIENT_IP'])){$ip=$_SERVER['HTTP_CLIENT_IP'];}
		elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];}
		else{$ip=$_SERVER['REMOTE_ADDR'];}
		$xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=".$ip);
		$location = $xml->geoplugin_countryName;
		$mmm=mysqli_fetch_assoc($conn->query("SELECT * FROM `Calendar|TimeZones` WHERE `CountryCode`='BD'"));
		$timediffer=$mmm['UTC offset'];
		$rrr=substr($timediffer,0,1);
		$rrr22=explode(":",substr($timediffer,-5));
		$gmttTime=date("Y-m-d H:i:s ", strtotime($dateCheeck.$serverToGmtDiffer));
		//echo $timediffer;
		//echo $xml->geoplugin_countryCode;
		if($rrr=="+"){
			$hourrt=(($rrr22[0]*60)*60);
			$minkt=($rrr22[1]*60);
			$timeZonett=$hourrt+$minkt;
			$timetoCheck=date("M d, Y H:i:s ", strtotime($gmttTime)+$timeZonett);
		}else{
			$hourrt=(($rrr22[0]*60)*60);
			$minkt=($rrr22[1]*60);
			$timeZonett=$hourrt+$minkt;
			$timetoCheck=date("M d, Y H:i:s ", strtotime($gmttTime)-$timeZonett);
		}
		
		return $timetoCheck;
	}
	
	function userGame($user){
		global $mysqli;
		$Availl=array();
		$user=mysqli_fetch_assoc($mysqli->query("SELECT `user`,`pack`,`level` FROM `member` WHERE `user`='".$user."'"));
		$game=$mysqli->query("SELECT * FROM `games` WHERE `active`='1'");
		$n=0;
		$g=0;
		while($games=mysqli_fetch_assoc($game)){
			$usdd=explode("/", $games['user']);
			$usdd22=explode("/", $games['level']);
			if((in_array($user['pack'], $usdd))&&(in_array($user['level'], $usdd22))){
				if(!in_array($games['type'], $Availl['type'])){
					$Availl['type'][$g]=$games['type'];
					sort($Availl['type']);
					$g++;
				}
				$Availl['game'][$n]=$games['serial'];
				$n++;
			}
		}
		return $Availl;
	}
	
	function UpdateChainUser($user,$table,$arr,$cons2='',$connec=''){
		if($cons2!=''){
			$conss=$cons2;
		}else{
			$conss=null;
		}
		if($connec!=''){
			$mysqli=$connec;
		}else{
			global $mysqli;
		}
		
		$check=mysqli_num_rows($mysqli->query("SELECT * FROM `$table` WHERE `user`='".$user."' $conss"));
		if($check<1){
			InsertInfo($table, $arr);
		}
	}
	
	
	
	function UpdateUpgradeAmn($user,$table,$query){
		global $mysqli;
		$check=mysqli_num_rows($mysqli->query("SELECT * FROM `$table` WHERE `user`='".$user."'"));
		if($check<1){
			$mysqli->query($query);
		}
	}
	function gameDepositCalc($user){
		global $mysqli;
		global $mysqli4;
		global $board_game;
		$uytuy=array();
		$gameDepAmn=mysqli_fetch_assoc($mysqli4->query("SELECT SUM(c_balance+u_balance) as tolls FROM `deposit_amn` WHERE `user`='".$user."' AND `play_method`='0' "));
		$playDepAmn=mysqli_fetch_assoc($mysqli4->query("SELECT SUM(amount) as tollsamn FROM `deposit_out` WHERE `user`='".$user."' "));
		
		$playDepAmn12=mysqli_fetch_assoc($mysqli4->query("SELECT SUM(amount) as tollsamn21 FROM `trade_win_reward` WHERE `user`='".$user."' "));
		$playDepAmn123=mysqli_fetch_assoc($mysqli4->query("SELECT SUM(amount) as tollsamn22 FROM `trade_trans_recive` WHERE `user_trans`='".$user."' "));
		$playDepAmn124=mysqli_fetch_assoc($mysqli4->query("SELECT SUM(amount) as tollsamn23 FROM `trade_trans_recive` WHERE `user_receive`='".$user."' "));
		
		//$tradesIn=((+));
		
		$playDepAmn2=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) as tollsamn2 FROM `game_configure` WHERE `user`='".$user."' AND `count_c`='1' AND `remain_play`>'0' "));
		$toollfDepo=$gameDepAmn['tolls']+$playDepAmn12['tollsamn21']+$playDepAmn124['tollsamn23'];
		
		$playDepAmn22=mysqli_fetch_assoc($board_game->query("SELECT SUM(amount) as tollsamn22 FROM `game_configure` WHERE `user`='".$user."' AND `count_c`='1' AND `remain_play`>'0' "));
		$toollfPlayLose=$playDepAmn['tollsamn']+$playDepAmn123['tollsamn22'];
		$toollfPlay=$playDepAmn2['tollsamn2'];
		$toollfPlay2=$playDepAmn22['tollsamn22'];
		$toollfPlay=$toollfPlay+$toollfPlay2;
		$remainPlayAmn=((($toollfDepo-$toollfPlayLose)-$toollfPlay));//
		return $remainPlayAmn;
	
	}
	

	function UpdateBalance($user,$table,$col,$colBal,$hhh, $rr=''){
		global $mysqli;
		$check=mysqli_fetch_assoc($mysqli->query("SELECT SUM($col) as ams FROM `$table` WHERE $hhh"));
		$upamn=$check['ams'];
		$mysqli->query("UPDATE `balance` SET `$colBal`='".$upamn."' WHERE `user`='".$user."'");
	}

	function CheckBal($member,$amn){
		global $mysqli;
		userupdateBlalnce($member);
		$checkBalance=mysqli_fetch_assoc($mysqli->query("SELECT `final_taka` FROM `balance` WHERE `user`='".$member."'"));
		$total=array_sum($amn);
		if($checkBalance['final_taka']>=$total){
			echo true;
		}else{
			echo false;
		}
	}
	
	function downUser($users,$table){
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
	
	function UserDown($users, $table, $lll, &$ttt){
		global $mysqli;
		$uu=$mysqli->query("select `sponsor`,`user`,`log_user` from `$table` where `sponsor`='".$users."'");
		while($spp=mysqli_fetch_assoc($uu)){
			if(!in_array($spp[$lll], $ttt)){
				array_push($ttt, $spp[$lll]);
			}
			UserDown($spp['user'],$table,$lll, $ttt);
		}
		
	}
	
	function TreeUserDown($users, $table, $lll, &$ttt){
		global $mysqli;
		$uu=$mysqli->query("select `sponsor`,`user`,`log_user` from `$table` where `upline`='".$users."'");
		while($spp=mysqli_fetch_assoc($uu)){
			if(!in_array($spp[$lll], $ttt)){
				array_push($ttt, $spp[$lll]);
			}
			TreeUserDown($spp['user'],$table,$lll, $ttt);
		}
		
	}
	
	function UserDownActive($users, $table, &$ttt){
		global $mysqli;
		foreach($users as $user){
			if(!in_array($user, $ttt)){
				$jjhh=mysqli_num_rows($mysqli->query("SELECT `user`,`pack` FROM `member` WHERE `user`='".$user."' AND `paid`='1'"));
				if($jjhh>0){
					array_push($ttt, $user);
				}
			}
		}
		
	}
	
	function DepositUsers($users){
		global $mysqli;
		$total=0;
		foreach($users as $user){
			$jjhh=mysqli_fetch_assoc($mysqli->query("SELECT SUM(`amount`) as total FROM `game_configure` WHERE `user`='".$user."' "));
			$total=$total+$jjhh['total'];
		}
		return $total;
	}
	
	function UpdateIncome($income,$user,$table,$cool){
		global $mysqli;
		global $date;
		$mmm=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) as total FROM `$table` WHERE `user`='".$user."' AND `type`='debit' AND `chains`='".$cool."'"));
		
		if($income>$mmm['total']){
			$today_income=$income-$mmm['total'];
			$eeww=$mysqli->query("SELECT * FROM `$table` WHERE `user`='".$user."' AND `type`='debit' AND `chains`='".$cool."' AND `date`='".$date."'");
			$mmm2=mysqli_num_rows();
			if($mmm2>0){
				$mmyy=mysqli_fetch_assoc($eeww);
				$newupdate=$mmyy['amount']+$today_income;
				$mysqli->query("UPDATE `$table` SET `amount`='".$newupdate."' WHERE `user`='".$user."' AND `type`='debit' AND `chains`='".$cool."' AND `date`='".$date."'");
			}else{
				$mysqli->query("INSERT INTO `$table`(`user`, `amount`, `chains`, `date`) VALUES ('".$user."','".$today_income."','".$cool."','".$date."')");
			}
		}
		$mmme=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) as total FROM `$table` WHERE `user`='".$user."' AND `type`='debit' AND `chains`='".$cool."'"));
		return $mmme['total'];
	}
	
	function UpdateGenerationIncome($income,$user,$table,$cool){
		global $mysqli;
		global $date;
		$mmm=mysqli_fetch_assoc($mysqli->query("SELECT SUM($cool) as total FROM `$table` WHERE `user`='".$user."' "));
		if($income>$mmm['total']){
			$today_income=$income-$mmm['total'];
			$eeww=$mysqli->query("SELECT * FROM `$table` WHERE `user`='".$user."' AND DATE(`date`)='".$date."'");
			$mmm2=mysqli_num_rows($eeww);
			if($mmm2>0){
				$mmyy=mysqli_fetch_assoc($eeww);
				$newupdate=$mmyy['amount']+$today_income;
				$mysqli->query("UPDATE `$table` SET `$cool`='".$newupdate."' WHERE `user`='".$user."' AND DATE(`date`)='".$date."'");
			}else{
				$mysqli->query("INSERT INTO `$table`(`user`, `$cool`) VALUES ('".$user."','".$today_income."')");
			}
		}
		$mmme=mysqli_fetch_assoc($mysqli->query("SELECT SUM($cool) as total FROM `$table` WHERE `user`='".$user."'"));
		return $mmme['total'];
	}
	
	function LevelUsers($memberid,$table,$level){
		global $mysqli;
		$yyy=array();
		$retuu=array();
		$ammn=array();
		$ttt2=downUser($memberid,$table);
		$yyy[0]=$ttt2;
		$ammn[0]=count($ttt2);
		for($i=1;$i<=$level;$i++){
			$ttt2=downUser($ttt2,$table);
			$yyy[$i]=$ttt2;
			$ammn[$i]=count($ttt2);
		}
		$retuu['userid']=$yyy;
		$retuu['totaluser']=$ammn;
		return $retuu;
	}
	
	
	
	function user_update($U_ID, $table,$amn,$colm,$tree=''){
		global $mysqli;
		$memberid = $U_ID;
		$date = date("Y-m-d");
		$cool=explode("_", $colm);
		if($tree==''){
			$level=5;
		}else{
			$level=10;
		}
		$yyy=array();
		$ttt2=downUser($memberid,$table);
		$ttte=count($ttt2);
		$yyy[0]=$ttte;
		for($i=1;$i<=$level;$i++){
			$ttt2=downUser($ttt2,$table);
			$yyyii=count($ttt2);
			$yyy[$i]=$yyyii;
		}
		
		$connd=$cool[0];
		$colBal=$connd."_in";
		
		if($tree==''){
			$total_gen = (array_sum($yyy)*$amn);
			UpdateIncome($total_gen,$memberid,"generation_income",$cool[0]);
			$hhh="`user`='$memberid' AND `chains`='$connd' AND `type`='credit'";
			UpdateBalance($memberid,"generation_income","amount",$colBal,$hhh);
		}else{
			$total_gen=(array_sum($yyy)*$amn);
			UpdateIncome($total_gen,$memberid,"auto_income",$cool[0]);
			$hhh="`user`='$memberid' AND `chains`='$connd' AND `type`='credit'";
			UpdateBalance($memberid,"auto_income","amount",$colBal,$hhh);
		}
		
		
		
		return 1;
	}
	
	
	function debitCredit($user, $table,$chains){
		global $mysqli;
		$in=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) as `total` FROM `$table` WHERE `user`='".$user."' AND `chains`='".$chains."' AND `type`='debit'"));
		$out=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) as `total2` FROM `$table` WHERE `user`='".$user."' AND `chains`='".$chains."' AND `type`='credit'"));
		$tax=$out['total2']*.13;
		return ($in['total']-($out['total2']+$tax));
	}
	
	function Sumamn($table, $cols,$cons){
		global $mysqli;
		$tto=mysqli_fetch_assoc($mysqli->query("SELECT $cols FROM `$table` WHERE $cons"));
		return $tto['total'];
	}
	
	function searcReference($table,$cons){
		global $mysqli;
		$query_10=$mysqli->query("select user from `$table`");	
		while($row_10=mysqli_fetch_array($query_10)){
			$u_id_tmp = $row_10['user'];
			usleep(50);
			$ttt=mysqli_num_rows($mysqli->query("SELECT * FROM `$table` WHERE `sponsor`='".$u_id_tmp."'"));
			if($ttt<$cons){
				return $u_id_tmp;
				break;
			}
		}
	}
	
	function PositionUser($refid, $table){
		global $mysqli;
		$ttt=mysqli_num_rows($mysqli->query("SELECT * FROM `$table` WHERE `sponsor`='".$refid."'"));
		if($ttt<1){
			return 1;
		}else{
			return 2;
		}
	}
	
	function AutoUpdate($refId,$tablefrom, $tableTo,$amn){
		global $mysqli;
		$queryww=mysqli_fetch_assoc($mysqli->query("select `user`,`sponsor` from `$tablefrom` where `user`='".$refId."'"));
		//if($queryww>=5){
			$reference=searcReference($tableTo,5);
			$tt=array();
			$tt['user']=$refId;
			$tt['amount']=$amn;
			//$tt['sponsor']=$reference;
			$tt['sponsor']=$queryww['sponsor'];
			UpdateChainUser($refId,$tableTo,$tt);
		//}
	}
	
	function UpdateTree($refId,$tablefrom, $tableTo,$amn){
		global $mysqli;
		$queryww=mysqli_num_rows($mysqli->query("select `user`,`sponsor` from `$tablefrom` where `sponsor`='".$refId."'"));
		if($queryww>=5){
			$reference=searcReference($tableTo,2);
			$position=PositionUser($reference, $tableTo);
			$tt=array();
			$tt['user']=$refId;
			$tt['amount']=$amn;
			$tt['sponsor']=$reference;
			$tt['placement']=$position;
			$tt['date']=date("Y-m-d");
			UpdateChainUser($refId,$tableTo,$tt);
		}
	}
	
	function TotalBalance($user,$table){
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
	
	function DownCid($cid){
		global $mysqli;
		$cidList=array();
		$idunderCIDQuery=$mysqli->query("SELECT `user` FROM `member` WHERE `log_user`='".$cid."'");
		while($idunderCID=mysqli_fetch_assoc($idunderCIDQuery)){
			UserDown($idunderCID['user'], "member", "log_user", $cidList);
		}
		$ownCID=array_search($cid, $cidList);
		if($ownCID){
			unset($cidList[$ownCID]);
		}
		return $cidList;
	}
	
	
	function DirectDownCid($cid){
		global $mysqli;
		$cidList=array();
		$idunderCIDQuery=$mysqli->query("SELECT `user` FROM `member` WHERE `log_user`='".$cid."'");
		while($idunderCID=mysqli_fetch_assoc($idunderCIDQuery)){
			$cidUnderIDQuery=$mysqli->query("SELECT `user`,`sponsor`,`log_user` FROM `member` WHERE `sponsor`='".$idunderCID['user']."'");
			while($DirectCid=mysqli_fetch_assoc($cidUnderIDQuery)){
				if(!in_array($DirectCid['log_user'], $cidList)){
					array_push($cidList, $DirectCid['log_user']);
				}
			}
		}
		$ownCID=array_search($cid, $cidList);
		if($ownCID){
			unset($cidList[$ownCID]);
		}
		return $cidList;
	}
	function leftRightCID($cid, $concols=''){
		global $mysqli;
		$downCID=DirectDownCid($cid);
		$returncid=array();
		$Left=array();
		$Right=array();
		foreach($downCID as $CID){
			$CIDposition=mysqli_fetch_assoc($mysqli->query("SELECT `user`,`position` FROM `member` WHERE `log_user`='".$CID."' ORDER BY `serial` ASC LIMIT 1"));
			if(!in_array($CID, $$CIDposition['position'])){
				array_push($$CIDposition['position'], $CID);
			}
			
		}
		$returncid['Left']=$Left;
		$returncid['Right']=$Right;
		return $returncid;
	}
	
	
	
	function activeFilter($cids){
		global $mysqli;
		$activvCID=array();
		foreach($cids as $CID){
			$activeCID=mysqli_num_rows($mysqli->query("SELECT `user`,`log_user` FROM `member` WHERE `log_user`='".$CID."' AND `pack`>'0'"));
			if($activeCID>0){
				if(!in_array($CID,$activvCID)){
					array_push($activvCID, $CID);
				}
			}
		}
		return $activvCID;
	}
	function activeFilter22($cids){
		global $mysqli;
		$activvCID=array();
		foreach($cids as $CID){
			$activeCID=mysqli_num_rows($mysqli->query("SELECT `user`,`log_user` FROM `member` WHERE `log_user`='".$CID."' AND `pack`>'0' AND `chk`='1'"));
			if($activeCID>0){
				if(!in_array($CID,$activvCID)){
					array_push($activvCID, $CID);
				}
			}
		}
		return $activvCID;
	}
	
	
	function userToCID($users){
		global $mysqli;
		$cidList=array();
		foreach($users as $user){
			$ownCID=mysqli_fetch_assoc($mysqli->query("SELECT `user`,`log_user` FROM `member` WHERE `user`='".$user."'"));
			if(!in_array($ownCID['log_user'], $cidList)){
				array_push($cidList, $ownCID['log_user']);
			}
		}
		return $cidList;
	}
	
	function userToCID22($users){
		global $mysqli;
		$cidList=array();
		foreach($users as $user){
			$ownCID=mysqli_fetch_assoc($mysqli->query("SELECT `user`,`log_user`,`pack`,`chk` FROM `member` WHERE `user`='".$user."'"));
			if($ownCID['pack']!=''){
				if($ownCID['chk']>0){
					if(!in_array($ownCID['log_user'], $cidList)){
						array_push($cidList, $ownCID['log_user']);
					}
				}
			}
		}
		return $cidList;
	}
	function userToCID2($users){
		global $mysqli;
		$cidList=array();
		foreach($users as $user){
			$ownCID=mysqli_fetch_assoc($mysqli->query("SELECT `user`,`log_user`,`pack`,`chk` FROM `member` WHERE `user`='".$user."'"));
			if($ownCID['pack']!=''){
				if(!in_array($ownCID['log_user'], $cidList)){
					array_push($cidList, $ownCID['log_user']);
				}
			}
		}
		return $cidList;
	}
	
	function CidToUser($cid){
		global $mysqli;
		$userList=array();
		$ggj=$mysqli->query("SELECT `user`,`log_user` FROM `member` WHERE `log_user`='".$cid."'");
		while($ownUser=mysqli_fetch_assoc($ggj)){
			if(!in_array($ownUser['user'], $userList)){
				array_push($userList, $ownUser['user']);
			}
		}
		return $userList;
	}
	
	
	
	function SpotComission($cid){
		global $mysqli;
		$comms=0;
		$cids=DirectDownCid($cid);
		foreach($cids as $cidaa){
			if($cidaa!=$cid){
				$sumAmn=mysqli_fetch_assoc($mysqli->query("SELECT SUM(direct) AS comm FROM `member` WHERE `log_user`='".$cidaa."'"));
				$comms=$comms+$sumAmn['comm'];
			}
		}
		if($comms>0){
			$arr['user']=$cid;
			$arr['spot_in']=$comms;
			UpdateChainUser($cid,"uniq_balance",$arr);
		}
		return $comms;
	}
	function firstGameDeposit($cid){
		global $mysqli;
		$hh=$mysqli->query("SELECT * FROM `member` WHERE `log_user`='".$cid."'");
		$h2h=array();
		$totalDeposit=0;
		while($deposit=mysqli_fetch_assoc($hh)){
			$ii=$mysqli->query("SELECT * FROM `game_configure` WHERE `user`='".$deposit['user']."' AND `remain_play`='0' ORDER BY `serial` ASC LIMIT 1");
			$check=mysqli_num_rows($ii);
			if($check>0){
				$uudd=mysqli_fetch_assoc($ii);
		        //$uudd22=mysqli_fetch_assoc($mysqli->query("SELECT SUM(c_balance) AS cPrevGame, SUM(u_balance) AS uPrevGame FROM `prev_game_amount` where user='".$deposit['user']."'"));
				$h2h[$cid][$uudd['user']]=$uudd['amount'];
			}
		}
		$sdd=count($h2h[$cid]);
		if($sdd>0){
			if($sdd<=3){
				$ggff=$sdd;
			}else{
				$ggff=3;
			}
			for($i=1; $i<=$ggff; $i++){
				$ttt=array_keys($h2h[$cid]);
				$totalDeposit=$totalDeposit+$h2h[$cid][$ttt[0]];
				unset($h2h[$cid][$ttt[0]]);
			}
			if($totalDeposit>0){
				$arr['user']=$cid;
				$arr['amount']=$totalDeposit;
				UpdateChainUser($cid,"first_deposit",$arr);
			}
			$depositOnServer=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `first_deposit` WHERE `user`='".$cid."'"));
			if($totalDeposit>$depositOnServer['amount']){
				$mysqli->query("UPDATE `first_deposit` SET `amount`='".$totalDeposit."' WHERE `user`='".$cid."'");
			}
		}
		return $totalDeposit;
	}
	
	function LevelCID($memberid,$table,$level){
		global $mysqli;
		$yyy=array();
		$ttt2=downUser($memberid,$table);
		$yyy[0]=userToCID($ttt2);
		for($i=1;$i<=$level;$i++){
			$ttt2=downUser($ttt2,$table);
			$yyy[$i]=userToCID($ttt2);
		}
		return $yyy;
	}
	
	
	
	
	function generationCID($cid){
		global $mysqli;
		$levelComm=array(5,3,2,1,1);
		$totalComm=0;
		$ttree=array();
		$hh=$mysqli->query("SELECT `user`,`log_user` FROM `member` WHERE `log_user`='".$cid."'");
		while($member=mysqli_fetch_assoc($hh)){
			$downCIID=LevelCID($member['user'],"member",4);
			for($i=0; $i<=4; $i++){
				$levfelCID=$downCIID[$i];
				foreach($levfelCID as $cidvv){
					if($cidvv!=$cid){
						if(!in_array($cidvv,$ttree)){
							array_push($ttree, $cidvv);
							$totalComm=($totalComm+((firstGameDeposit($cidvv)*$levelComm[$i])/100));
						}
					}
				}
			}
		}
		
		if($totalComm>0){
			$arr['user']=$cid;
			$arr['generation_in']=$totalComm;
			UpdateChainUser($cid,"uniq_balance",$arr);
		}
		return $totalComm;
	}
	function CountUser($user,$table, $sess, &$newSES=''){
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
	function DownnCCID($cids){
		global $mysqli;
		$rrggv=array();
		foreach($cids as $cid){
			$hhgg=DownCid($cid);
			$rrggv=array_merge($rrggv, $hhgg);
		}
		return array_unique($rrggv);
	}
	
	function DirectDownUserId($user,$users){
		global $mysqli;
		global $mysqli4;
		$cidList=0;
		foreach($users as $uytrt){
			$cidUnderIDQuery=mysqli_num_rows($mysqli->query("SELECT `user`,`sponsor`,`log_user` FROM `member` WHERE `user`='".$uytrt."' AND `sponsor`='".$user."' AND `pack`>'0'"));
			if($cidUnderIDQuery>0){
				$cHECKnUMB=mysqli_num_rows($mysqli4->query("SELECT `user` FROM `deposit_amn` WHERE `user`='".$uytrt."'"));
				if($cHECKnUMB>0){
					$cidList++;
				}
			}
			if($cidList>=5){
				break;
			}
		}
		return $cidList;
	}
	
	function RankNewCindition($userss, $rank,$table){
		global $mysqli;
		$COUNrANK=0;
		foreach($userss as $user){
			$CheckRank=mysqli_num_rows($mysqli->query("SELECT * FROM `$table` WHERE `user`='".$user."' AND `rank`='".$rank."'"));
			if($CheckRank>0){
				$COUNrANK++;
			}
			if($COUNrANK>=2){
				break;
			}
		}
		return $COUNrANK;
	}
	
	
	function RankReward($memberid){
		global $mysqli;
		$Left=array();
		$Right=array();
		//$uiiyt=mysqli_fetch_assoc($mysqli->query("SELECT `user`, `log_user` FROM `member` WHERE `user`='".."'"));
		
		$tttii=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member_total` WHERE `user`='".$memberid."'"));
		
		$lyy=explode(",", $tttii['totalLeftId']);
		$Left=userToCID(array_merge($Left,$lyy));
		$ActiveLEft=activeFilter22($Left);
		
		$lyy2=explode(",", $tttii['totalrightId']);
		$Right=userToCID(array_merge($Right,$lyy2));
		$ActiveRight=activeFilter22($Right);
	
	
		$ownCID=array_search($memberid, $Left);
		if($ownCID){
			unset($Left[$ownCID]);
		}
		$ownCID2=array_search($memberid, $Right);
		if($ownCID2){
			unset($Right[$ownCID2]);
		}
		
		//var_dump($Right);
		//var_dump($Left);
		
		$leftSponsor=DirectDownUserId($memberid,$ActiveLEft);
		$rightSponsor=DirectDownUserId($memberid,$ActiveRight);
		//var_dump($rightSponsor);
		//var_dump($leftSponsor);
		
		$_SESSION['Left']=count($ActiveLEft);
		$_SESSION['Right']=count($ActiveRight);
		
		
		$left_paid=$_SESSION['Left'];
		$right_paid=$_SESSION['Right'];
		
		$rryy=array("Entrepreneur", "Winger", "Manager", "Associate","Star Associate","Bronze", "Silver", "Gold", "Diamond", "Platinum");
		$reqquu=array(7,15, 40, 60, 120,300, 600, 1500,3000, 7000);
		$reqquu2=array(7,22, 62, 122, 242, 542, 1142, 2642, 5642, 12642);
		$reward=array(25,55, 120, 150, 250,500, 1000, 5000,12000, 50000);
		//$reward22=array("70/30", "70/30", "50/50", "50/50", "50/50","30/70", "30/70", "30/70", "30/70", "30/70", "30/70", "30/70");
		$ttr=0;
		//var_dump($left_paid);
		//var_dump($right_paid);
		//var_dump($memberid);
		$amount=0.00;
		$Rank="Member";
		$Rttff=array();
		$tttii11=mysqli_num_rows($mysqli->query("SELECT `user` FROM `member` WHERE `user`='".$memberid."' "));
		foreach($rryy as $rrank){
			$arr=array();
			if($tttii11>0){
				if(($left_paid>=$reqquu2[$ttr])&&($right_paid>=$reqquu2[$ttr])){
					$amount=0;//$amount+$reward[$ttr];
					$Rank=$rryy[$ttr];
					$ranDis=explode("/", $reward22[$ttr]);
					$bonus=$reward[$ttr];
					$orginalAmount=0;
					$arr['user']=$memberid;
					$arr['amount']=0;//$orginalAmount;
					$arr['c_wallet']=$bonus;
					$arr['rank']=$Rank;
					$consdd=" AND `rank`='".$Rank."'";
					UpdateChainUser($memberid,"ranks",$arr,$consdd);
				}
			}
			$ttr++;
		}
		
		$Rttff['amn']=$bonus;
		$Rttff['rank']=$Rank;
		$Rttff['LeftCid']=$ActiveLEft;//$Left;
		$Rttff['RightCid']=$ActiveRight;//$Right;
		return $Rttff;
	}
	
	function SpecialRankReward($memberid){
		global $mysqli;
		$Left=array();
		$Right=array();
		$tttii=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member_total` WHERE `user`='".$memberid."'"));
		$lyy=explode(",", $tttii['totalLeftId']);
		
		$Left=array_merge($Left,$lyy);
		$ActiveLEft=activeFilter($Left);
		$lyy2=explode(",", $tttii['totalrightId']);
		$Right=array_merge($Right,$lyy2);
		$ActiveRight=activeFilter($Right);
		$leftSponsor=DirectDownUserId($memberid,$ActiveLEft);
		$rightSponsor=DirectDownUserId($memberid,$ActiveRight);
		if(($leftSponsor>=5)&&($rightSponsor>=5)){
			$arr2=array();
			$arr2['user']=$memberid;
			$arr2['amount']=20;//$orginalAmount;
			$arr2['c_wallet']=0;
			$arr2['rank']="Bronze";
			UpdateChainUser($memberid,"special_ranks",$arr2,$consdd);
		}

		$rryy=array("Bronze", "Silver", "Gold", "Platinum","Diamond","Crown Diamond", "Titanium", "Ambassador", "Royal Ambassador", "Crown Ambassador", "Emiretars", "Champion");
		$reqquu=array(2, 2, 2, 2, 2,2, 2, 2, 2, 2, 2, 3);
		$reqquu2=array(5,15, 45, 95, 195, 445, 945, 1945, 4445, 9445, 19445, 44445);
		$reward=array(20,50, 100, 200, 400,800, 1500, 3000,7500, 15000, 30000, 100000);
		$ttr=1;
		
		$tttii11=mysqli_num_rows($mysqli->query("SELECT `user` FROM `member` WHERE `user`='".$memberid."' AND `pack`>'0' "));
		
		foreach($rryy as $rrank){
			$arr=array();
			if($tttii11>0){
				$tttii1122=mysqli_num_rows($mysqli->query("SELECT `user` FROM `special_ranks` WHERE `user`='".$memberid."' AND `rank`='".$rrank."' "));
				if($tttii1122>0){
					$leftRF=RankNewCindition($ActiveLEft, $rryy[$ttr-1],"special_ranks");
					$rightRF=RankNewCindition($ActiveRight, $rryy[$ttr-1],"special_ranks");
					if(($leftRF>=$reqquu[$ttr])&&($rightRF>=$reqquu[$ttr])){
						$amount=0;//$amount+$reward[$ttr];
						$Rank=$rryy[$ttr];
						$bonus=$reward[$ttr];
						$orginalAmount=0;
						$arr['user']=$memberid;
						$arr['amount']=0;//$orginalAmount;
						$arr['c_wallet']=0;
						$arr['rank']=$Rank;
						$consdd=" AND `rank`='".$Rank."'";
						UpdateChainUser($memberid,"special_ranks",$arr,$consdd);
					}
				}
			}
			$ttr++;
		}
		
	}
	
	function StateScore($user,$date){
		global $mysqli;
		$dateSTart=date("Y-m-01",strtotime($date));
		$dateEnd=date("Y-m-t",strtotime($date));
		$jksfhk=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member_total` WHERE `user`='".$user."'"));
		$AchVDate=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `ranks` WHERE `user`='".$user."'"));
		$sgdafDate=date("Y-m-d", strtotime($AchVDate['date']));
		if(($sgdafDate>$dateSTart)&($sgdafDate<$dateEnd)){
			$dateSTart=$sgdafDate;
		}
		$Lefgdfg=$jksfhk['totalLeftId'];
		$Rifgdfg=$jksfhk['totalrightId'];
		$hjsdf=array_unique(array_merge($Lefgdfg,$Rifgdfg));
		$TotalSale=0;
		foreach($hjsdf as $usdf){
			$kjgfd=mysqli_num_rows($mysqli->query("SELECT `serial` FROM `upgrade` WHERE `user`='".$usdf."' AND DATE(`date`) BETWEEN '".$dateSTart."' AND '".$dateEnd."'"));
			if($kjgfd>0){
				$kjgfd2=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) as totalk FROM `upgrade` WHERE `user`='".$usdf."' AND DATE(`date`) BETWEEN '".$dateSTart."' AND '".$dateEnd."'"));
				$TotalSale=$TotalSale+$kjgfd2['totalk'];
			}
		}
		return $TotalSale;
	}
	
	
	
	function rank_update($memberid){
		global $mysqli;
		$amt=RankReward($memberid);
		if($amt['amn']>0){
			$mnb=mysqli_fetch_assoc($mysqli->query("SELECT `user` FROM `member` WHERE `user`='".$memberid."' ORDER BY `serial` ASC LIMIT 1"));
			$mnb22=mysqli_fetch_assoc($mysqli->query("SELECT SUM(`amount`) as Amn,SUM(`c_wallet`) as Amn2 FROM `ranks` WHERE `user`='".$memberid."' "));
			$rankAmn=$mnb22['Amn'];
			$userAmn=$mnb22['Amn2'];
			UpdateGenerationIncome($userAmn,$mnb['user'],"rank_bonus","amount");
			//
			$kk=mysqli_num_rows($mysqli->query("SELECT `user` FROM `uniq_balance` WHERE `user`='".$memberid."'"));
			if($kk>0){
				//$mysqli->query("UPDATE `uniq_balance` SET `leadership_in`='".$rankAmn."' WHERE `user`='".$memberid."'");
			}else{
				//$mysqli->query("INSERT INTO `uniq_balance`( `user`, `leadership_in`) VALUES ('".$memberid."','".$rankAmn."')");	
			}
		}else{
			//$mysqli->query( "UPDATE `uniq_balance` SET `leadership_in`='0' WHERE `user`='".$memberid."'");
		}
		return $amt;
	}
	
	function RankPinUpdate(){
		global $mysqli;
		$RANKbONUS=array(
			"Bronze"=>"1/1",
			"Silver"=>"1/3",
			"Gold"=>"2/3", 
			"Platinum"=>"5/3",
			"Diamond"=>"6/5",
			"Crown Diamond"=>"5/6", 
			"Titanium"=>"10/3;5/6", 
			"Ambassador"=>"6/6;5/7", 
			"Royal Ambassador"=>"10/6;10/7"
		);
		//,"Crown Ambassador"=>"1 Practice PIN", "Emiretars"=>"1 Practice PIN","Champion"=>"1 Practice PIN"
		//echo $RANKbONUS['Crown Diamond'];
		
		$dfgfddf=$mysqli->query("SELECT * FROM `ranks` WHERE `c_wallet`='0'");
		while($fghfg=mysqli_fetch_assoc($dfgfddf)){
			$bonusM=explode(";",$RANKbONUS[$fghfg['rank']]);
			$useer=$fghfg['user'];
			foreach($bonusM as $kjfdg){
				$fjhgf=explode("/",$kjfdg);
				$pack=$fjhgf[1];
				for($i=1;$i<=$fjhgf[0];$i++){
					usleep(30);
					$tt=bin2hex(time());
					$rr=str_shuffle(substr($tt, -8));
					$invoiced=base64_encode($rr);
					$mysqli->query("INSERT INTO `invoice_req`( `create_by`,`invoice_num`,`rank_active`, `pack`, `sell`, `user`, `pin_for`) VALUES ('company','".$invoiced."','1','".$pack."','0','".$useer."','0')");
					$hhgff=mysqli_fetch_assoc($mysqli->query("SELECT MAX(serial) AS ghh FROM `invoice_req` WHERE `create_by`='company'"));
					$mysqli->query("INSERT INTO `pin_tranreciv`( `user_trans`, `user_reciv`, `pinser`) VALUES ('company','".$useer."','".$hhgff['ghh']."')");
				}
			}
			$mysqli->query("UPDATE `ranks` SET `c_wallet`='1' WHERE `serial`='".$fghfg['serial']."' ");
		}
	}
  
	function RankSpecialRewardUpdate(){
		global $mysqli;
		global $mysqli4;
		$RANKbONUS=array(
			"Bronze"=>20,
			"Silver"=>30,
			"Gold"=>50, 
			"Platinum"=>100,
			"Diamond"=>200,
			"Crown Diamond"=>400, 
			"Titanium"=>750, 
			"Ambassador"=>1500, 
			"Royal Ambassador"=>3500,
			"Crown Ambassador"=>7500,
			"Emiretars"=>15000,
			"Champion"=>50000 
		);
		
		$dfgfddf=$mysqli->query("SELECT * FROM `special_ranks` WHERE `c_wallet`='0'");
		while($fghfg=mysqli_fetch_assoc($dfgfddf)){
			$wrwerwe=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `rank_duration` WHERE `rank_name`='".$fghfg['rank']."'"));
			$bonusM=$wrwerwe['rank_amn'];
			$useer=$fghfg['user'];
			$mysqli4->query("INSERT INTO `deposit_amn`( `user`, `c_balance`, `play_method`, `deduct`,`rank`) VALUES ('".$useer."','".$bonusM."','1','1','".$fghfg['rank']."')");
			$mysqli->query("UPDATE `special_ranks` SET `c_wallet`='1' WHERE `serial`='".$fghfg['serial']."' ");
		}
		
	}
  
	
  
	function UniqueBalanceOut($cid){
		global $mysqli;
		global $mysqli3;
		global $mysqli4;
		$userss=CidToUser($cid);
		$totalUout=array();
		$out=0;
		$requireTable=array("trans_receive", "renew_game", "game_configure", "upgrade","pin_price");
		$tradeUout=0;
		foreach($userss as $user){
			foreach($requireTable as $table){
				if($table=="trans_receive"){
					$out=Sumamn($table, "SUM(`u_balance`) as total","`user_trans`='$user'");
					
				}elseif($table=="game_configure"){
					$pREViNSSDD=mysqli_fetch_assoc($mysqli->query("SELECT SUM(u_balance) AS uPrevGame FROM `prev_game_amount` where user='".$user."'"));
					$out=Sumamn($table, "SUM(`u_balance`) as total","`user`='$user' AND `count_c`='1'")+$pREViNSSDD['uPrevGame'];
					
				}else{
					$out=Sumamn($table, "SUM(`u_balance`) as total","`user`='$user'");
				}
				$totalUout[$table]=$totalUout[$table]+$out;
			}
			$mmnn=mysqli_fetch_assoc($mysqli3->query("SELECT SUM(uni_amount) AS uniqq FROM `terminal_trans` WHERE `user_trans`='".$user."'"));
			$totalUout['terminal_trans']=$totalUout['terminal_trans']+$mmnn['uniqq'];
			$tradeout=mysqli_fetch_assoc($mysqli4->query("SELECT SUM(u_balance) as tradeUni FROM `deposit_amn` WHERE `user`='".$user."'"));
			$tradeUout=$tradeUout+$tradeout['tradeUni'];
		}
		$totalUout['tradeUout']=$tradeUout;
		$totalOout=array_sum($totalUout);
		$USERiD=mysqli_fetch_assoc($mysqli->query("SELECT `user` FROM `member` WHERE `log_user`='".$cid."'"));
		
		$mysqli->query("UPDATE `uniq_balance` SET `total_out`='".$totalOout."' WHERE `user`='".$cid."'");
		return $totalUout;
	}
	
	function UniqueBalanceRecivIn($cid){
		global $mysqli;
		$kkk=$mysqli->query("SELECT `user` FROM `member` WHERE `log_user`='".$cid."'");
		$totalReciv=0;
		while($jjkk=mysqli_fetch_assoc($kkk)){
			$res33=mysqli_fetch_array($mysqli->query("SELECT SUM(u_balance) AS uniq_w FROM trans_receive where user_receive='".$jjkk['user']."' and type='Transfer' and account='Agent' "));
			$totalReciv=$totalReciv+$res33['uniq_w'];
		}
		$mysqli->query("UPDATE `uniq_balance` SET `recin_in`='".$totalReciv."' WHERE `user`='".$cid."'");
	}
	function UniqueBalanceIn($cid){
		global $mysqli;
		global $mysqli4;
		SpotComission($cid);
		UniqueBalanceRecivIn($cid);
		$totalOut=UniqueBalanceOut($cid);
		$finalBanalce=TotalBalance($cid,"uniq_balance");
		$mysqli->query("UPDATE `uniq_balance` SET `final_balance`='".$finalBanalce."' WHERE `user`='".$cid."'");
		return $finalBanalce;
	}
	
	
	function TransReciveww($user,$table){
		global $mysqli;
		$type=array("Transfer","Withdraw");
		$account=array("Agent","Member");
		$cols=array("ammount","c_wallet","tax","u_balance");
		$returnjj=array();
		foreach($account as $acc){
			$typeCols=array("user_receive","user_trans");
			foreach($type as $transType){
				//echo $acc ." ".$transType;
				foreach($typeCols as $colkk){
					$cons="`$colkk`='".$user."' and type='$transType' and account='$acc'";
					foreach($cols as $cdf){
						$returnjj[$acc][$transType][$colkk][$cdf]=Sumamn($table, "SUM($cdf) AS total",$cons);
					}
				}
			}
		}
		return $returnjj;
		$cons="user_receive='".$user."' and type='Transfer' and account='Agent'";
		$cons3="user_trans='".$user."' and type='Withdraw' and account='Agent'";
		$cons5="user_trans='".$user."' and type='Withdraw' and status='Cancel' and account='Agent'";
		
		
		$cons2="user_receive='".$user."' and type='Transfer' and account='Member'";
		
		$cons4="user_trans='".$user."' and type='Transfer' and account='Member'";
	
		
		//$recivAgentCurrent=Sumamn($table, "SUM(ammount) AS total",$cons);
		//$recivAgentBonus=Sumamn($table, "SUM(c_wallet) AS total",$cons);
		//$recivMemberBonus=Sumamn($table, "SUM(c_wallet) AS total",$cons2);
		//$recivMemberCurrent=Sumamn($table, "SUM(ammount) AS total",$cons2);
		//$recivMemberTax=Sumamn($table, "SUM(tax) AS total",$cons2);
		
		//$TransferAagentCurrent=Sumamn($table, "SUM(ammount) AS total",$cons3);
		//$TransferAagentTax=Sumamn($table, "SUM(tax) AS total",$cons3);
	}
	
	function recentTrade($user){
		global $mysqli;
		global $mysqli4;
		$Ghh=1;
		$YYtt=mysqli_num_rows($mysqli4->query("SELECT * FROM `deposit_amn` WHERE `user`='".$user."' AND `play_method`='0'"));
		if($YYtt>0){
			$remainDeposit=gameDepositCalc($user);
			$User=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `user`='".$user."'"));
			$pack=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `package` WHERE `serial`='".$User["pack"]."'"));
			$paccgg=$pack['game_renew'];
			if($remainDeposit<$paccgg){
				$Ghh=0;
			}
		}
		
		return $Ghh;
	}
	
	function TransferAccs($user){
		global $mysqli;
		global $mysqli4;
		$Ghh=0;
		$mmHG=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `user`='".$user."'"));
		$erIu=$mmHG['ref_con'];
		$werrI=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `package` WHERE `serial`='".$mmHG['pack']."'"));
		$pointf=$werrI['pack_amn'];
		$Ghhsd=mysqli_num_rows($mysqli->query("SELECT * FROM `member` WHERE `sponsor`='".$user."' AND `point`>='".$pointf."'"));
		if($erIu>=$Ghhsd){
			$Ghh=1;
		}
		return $Ghh;
	}
	

?>