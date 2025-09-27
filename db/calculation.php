<?php
	if($_SESSION["winMember"]){$memberid=$_SESSION["winMember"];}

	
	$query=$mysqli->query("SELECT SUM(direct) AS amount FROM member where sponsor='".$memberid."' ");
	while($res=mysqli_fetch_array($query)){
		$_SESSION['direct']=$res['amount'];
	}
	
	$hjsgfhsd=mysqli_fetch_assoc($mysqli->query("SELECT `pack` FROM `member` WHERE `user`='".$memberid."'"));
	if($hjsgfhsd['pack']>0){
		$_SESSION['direct']=$_SESSION['direct'];
	}else{
		$_SESSION['direct']=0;
	}
	
	
	//$dIRECTtObONUS=($_SESSION['direct2']* .30);
	

	$query2=$mysqli->query("SELECT SUM(ammount) AS ammount,SUM(c_wallet) AS bonudds FROM trans_receive where user_receive='".$memberid."' and type='Transfer' and account='Agent' ");
	while($res2=mysqli_fetch_array($query2)){
		$_SESSION['receive_agent']=$res2['ammount'];
		$_SESSION['bonudds']=$res2['bonudds'];
	}
	
	$query3=$mysqli->query("SELECT SUM(ammount) AS ammount,SUM(c_wallet) AS bonus_w, SUM(tax) AS cost  FROM trans_receive where user_receive='".$memberid."' and type='Transfer' and account='Member' ");
	while($res3=mysqli_fetch_array($query3)){
		$_SESSION['receive_member']=$res3['ammount']-$res3['cost'];
		$_SESSION['bonus_w']=$res3['bonus_w'];
	}
	
	
	$query33=$mysqli->query("SELECT SUM(u_balance) AS uniq_w FROM trans_receive where user_receive='".$memberid."' and type='Transfer' and account='Agent' ");
	while($res33=mysqli_fetch_array($query33)){
		$_SESSION['uniq_w']=$res33['uniq_w'];
	}

	
	$query5=$mysqli->query("SELECT SUM(ammount) AS ammount, SUM(tax) AS tax, SUM(u_balance) AS aaa FROM trans_receive where user_trans='".$memberid."' and type='Withdraw' and status!='Cancel' and account='Agent' ");
	while($res5=mysqli_fetch_array($query5))
	{
	$_SESSION['payments']=$res5['ammount']-$res5['aaa'];
	$_SESSION['tax1']=$res5['tax'];	
	$_SESSION['aaa']=$res5['aaa'];	
	}
	
	$query5=$mysqli->query("SELECT SUM(ammount) AS ammount2, SUM(tax) AS tax2, SUM(u_balance) AS bbb FROM trans_receive where user_trans='".$memberid."' and type='Withdraw' and status='Cancel' and account='Agent' ");
	while($res5=mysqli_fetch_array($query5))
	{
	$_SESSION['payments2']=$res5['ammount2'];
	$_SESSION['payments22']=$res5['bbb'];
	$_SESSION['tax12']=$res5['tax2'];
	}
	
	//$_SESSION['payments']=($_SESSION['payments']+$_SESSION['payments2']);
	$_SESSION['tax1']=$_SESSION['tax1']-$_SESSION['tax12'];	
	
	$query6=$mysqli->query("SELECT SUM(ammount) AS ammounwwt,SUM(c_wallet) AS ddd, SUM(u_balance) AS ccc FROM trans_receive where user_trans='".$memberid."' and type='Transfer' and account='Member' ");
	while($res6=mysqli_fetch_array($query6)){
		$_SESSION['transfer_member']=$res6['ammounwwt']-$res6['ccc'];
		$_SESSION['bonus_ddd']=$res6['ddd'];
		$_SESSION['ccc']=$res6['ccc'];
	}
	
	//$shortInvest=gameInvestss($memberid);
	//$_SESSION['investment']=$shortInvest['current'];
	
	
	
	
	$query8qqq=mysqli_fetch_array($mysqli->query("SELECT SUM(amount) AS amountqqq FROM `game_configure` where user='".$memberid."' AND `remain_play`>'0' AND `count_c`='2' "));
	$_SESSION['RmainInvest']=$query8qqq['amountqqq'];
	
	$query8qqq2=mysqli_fetch_array($board_game->query("SELECT SUM(amount) AS amountqqq2 FROM `game_configure` where user='".$memberid."' AND `remain_play`>'0' AND `count_c`='2' "));
	$_SESSION['RmainInvest2']=$query8qqq2['amountqqq2'];
	
	$_SESSION['RmainInvest']=$_SESSION['RmainInvest']+$_SESSION['RmainInvest2'];
	
	$res911=mysqli_fetch_array($mysqli->query("SELECT SUM(curent_bal) AS curentamn FROM `game_return` where `user`='".$memberid."' "));
	$_SESSION['curentamn']=$res911['curentamn'];
	
	//Leader Support 2018-09-03
	$res9191=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) AS camounttamn FROM `leader_support` where `user`='".$memberid."' "));
	$_SESSION['camounttamn']=$res9191['camounttamn'];
	
	
	
	$res9112=mysqli_fetch_array($board_game->query("SELECT SUM(curent_bal) AS curentamn2 FROM `game_return` where `user`='".$memberid."' "));
	$_SESSION['curentamn2']=$res9112['curentamn2'];
	
	$_SESSION['curentamn']=$_SESSION['curentamn']+$_SESSION['curentamn2'];
	
	$res8q=mysqli_fetch_array($mysqli->query("SELECT SUM(amount) AS amountq FROM `lose_invest` where user='".$memberid."' "));
	$_SESSION['TotalInveest']=$res8q['amountq'];
	
	$res8q2=mysqli_fetch_array($board_game->query("SELECT SUM(amount) AS amountq2 FROM `lose_invest` where user='".$memberid."' "));
	$_SESSION['TotalInveest2']=$res8q2['amountq2'];
	$_SESSION['TotalInveest']=$_SESSION['TotalInveest']+$_SESSION['TotalInveest2'];
	
	
	$resTrade=mysqli_fetch_array($mysqli4->query("SELECT SUM(c_balance) AS tradeAmn  FROM `deposit_amn` where `user`='".$memberid."' AND `deduct`='0' "));
	$_SESSION['tradeAmn']=$resTrade['tradeAmn'];
	


	
	$LostGame=$_SESSION['TotalInveest'];
	
	$query8=$mysqli->query("SELECT SUM(charge) AS renewCharge, SUM(u_balance) as uni_chrg FROM `renew_game` where user='".$memberid."' ");
	while($res8=mysqli_fetch_array($query8))
	{
	$_SESSION['renewCharge']=$res8['renewCharge']-$res8['uni_chrg'];
	$_SESSION['uni_chrg']=$res8['uni_chrg'];
	}

	$query9=$mysqli->query("SELECT SUM(amount) AS amount2,SUM(bonus) AS upbonus, SUM(u_balance) AS fff FROM upgrade where user='".$memberid."' ");
	
	while($res9=mysqli_fetch_array($query9))
	{
	$_SESSION['upgrade']=$res9['amount2']-($res9['fff']);
	$_SESSION['upbonus']=$res9['upbonus'];
	$_SESSION['fff']=$res9['fff'];
	}
	
	
	
	$query91=$mysqli->query("SELECT SUM(amount) AS amounwt FROM `req_fund` where `receiver`='".$memberid."' AND `active`='1'");
	while($res91=mysqli_fetch_array($query91))
	{
	$_SESSION['req_funnd']=$res91['amounwt'];
	}
	
	$query8q=$mysqli4->query("SELECT SUM(amount) AS autoInvestre FROM `autoreturn_depo` where user='".$memberid."' ");
	while($res8q=mysqli_fetch_array($query8q)){
		$_SESSION['autoreturn_depoBack']=$res8q['autoInvestre'];
	}
	
	
	$query911=$mysqli->query("SELECT SUM(u_amount) AS u_amount  FROM `generation_income` where `user`='".$memberid."' ");
	while($res911=mysqli_fetch_array($query911)){
		$_SESSION['u_amount']=$res911['u_amount'];
	}
	
	$query911=$mysqli->query("SELECT SUM(amount) AS rr_amount  FROM `rank_bonus` where `user`='".$memberid."' ");
	while($res911=mysqli_fetch_array($query911)){
		$_SESSION['rr_amount']=$res911['rr_amount'];
	}
	$hhhjj=mysqli_fetch_assoc($mysqli->query("SELECT `user`, `log_user` FROM `member` WHERE `user`='".$memberid."' ORDER BY `serial` ASC LIMIT 1"));
	$hhhjj2=mysqli_fetch_assoc($mysqli->query("SELECT `user`, `log_user` FROM `member` WHERE `log_user`='".$hhhjj['log_user']."' ORDER BY `serial` ASC LIMIT 1"));
	$PinChangeX=mysqli_fetch_assoc($mysqli->query("SELECT SUM(charge) as pichr FROM `reset_pin` WHERE `user`='".$memberid."'"));
	
	$query9112=$mysqli->query("SELECT `matching` AS bmC_amount FROM `uniq_binary` WHERE `user`='".$hhhjj['log_user']."' ORDER BY `serial` DESC LIMIT 1");
	while($res9112=mysqli_fetch_array($query9112)){
		$_SESSION['bmC_amount']=(($res9112['bmC_amount'] *.10) * .30);
	}
	$query9113=$mysqli->query("SELECT SUM(`matching`) AS bmI_amount FROM `binary` WHERE `user`='".$memberid."'");
	while($res9113=mysqli_fetch_array($query9113)){
		$_SESSION['bmI_amount']=(($res9113['bmI_amount'] *.05) * .30);
	}
	if($memberid==$hhhjj2['user']){
		$_SESSION['binaryMatch_bonus']=$_SESSION['bmC_amount']+$_SESSION['bmI_amount'];
	}else{
		$_SESSION['binaryMatch_bonus']=$_SESSION['bmI_amount'];
	}
	
/*	$query121=$mysqli2->query("SELECT SUM(ammount) AS emalamn FROM trans_receive where user_trans='".$memberid."' AND `method`='logic account'");
	while($res12=mysqli_fetch_array($query121)){
		$_SESSION['emallamn']=$res12['emalamn'];
	}
	*/
	$dIRECTtObONUS=$dIRECTtObONUS;
	$play_taka=$_SESSION['curentamn'];
	$totalBonussIn=($_SESSION['binaryMatch_bonus']+$_SESSION['u_amount']+$dIRECTtObONUS+$_SESSION['bonusamn']+$_SESSION['bonus_w']+$_SESSION['bonudds']);
	$totalBonusOut=($_SESSION['upbonus']+$_SESSION['bonus_ddd']);
	$bonus_taka=($totalBonussIn-$totalBonusOut);
	//$safe_taka=0;
	$_SESSION['tax']=$_SESSION['tax1']+$_SESSION['tax2'];
	//$_SESSION['payments']=$_SESSION['payments']-$_SESSION['tax1'];
	//$_SESSION['transfer_member']=$_SESSION['transfer_member']-$_SESSION['tax2'];
	//safe_taka='".$safe_taka."',
	//var_dump($bonus_taka);
	$Totalmatch2=mysqli_fetch_assoc($mysqli->query("SELECT SUM(slot_match) AS sasdfg FROM `binary_income` WHERE `user`='".$memberid."'"));
	$matchIncome=$Totalmatch2['sasdfg']*0.05; 
	$recivAgent=$_SESSION['receive_agent']+$_SESSION['req_funnd'];
	$mysqli->query("UPDATE balance SET 
	direct_taka='".$_SESSION['direct']."',
	match_taka='".$matchIncome."',
	receive_member_taka='".$_SESSION['receive_member']."',
	receive_agent_taka='".$recivAgent."',
	receive_payza_taka='".$_SESSION['receive_payza']."',
	signup_taka='".$_SESSION['upgrade']."',
	bcpp_taka='".$_SESSION['investment']."',
	bonus_taka='".$bonus_taka."',
	rank_taka='".$_SESSION['rr_amount']."',
	play_taka='".$play_taka."',
	lost_game_taka='".$LostGame."',
	safe_taka='".$_SESSION['returnGame']."',
	renew_taka='".$_SESSION['renewCharge']."',
	transfer_member_taka='".$_SESSION['transfer_member']."',
	transfer_agent_taka='".$_SESSION['payments']."',
	transfer_payza_taka='".$_SESSION['transfer_payza']."',
	tax_taka='".$_SESSION['tax']."'
	WHERE user='".$memberid."'");
	


	$query51 = "SELECT * FROM `balance` WHERE `user`='".$memberid."' ";
	$result51=$mysqli->query($query51);
	$row51 = mysqli_fetch_array($result51);

	$direct_taka51=$row51['direct_taka'];
	$match_taka51=$row51['match_taka'];
	$upgrade_taka51=$row51['upgrade_taka'];
	$generation_taka51=$row51['generation_taka'];
	$rank_taka51=$row51['rank_taka'];
	$play_taka51=$row51['play_taka'];	
	$safe_taka51=$row51['safe_taka'];		
	$receive_member_taka51=$row51['receive_member_taka'];
	$receive_agent_taka51=$row51['receive_agent_taka'];
	$receive_payza_taka51=$row51['receive_payza_taka'];
	
	$bcpp_taka51=$row51['bcpp_taka'];
	$renew_taka51=$row51['renew_taka'];
	$signup_taka51=$row51['signup_taka'];	
	$transfer_member_taka51=$row51['transfer_member_taka'];
	$transfer_agent_taka51=$row51['transfer_agent_taka'];
	$transfer_payza_taka51=$row51['transfer_payza_taka'];	
	$tax_taka51=$row51['tax_taka'];
	$lost_game_taka51=$row51['lost_game_taka'];
	
	$bonus_taka51=$row51['bonus_taka'];
	$recover_taka51=$row51['recover_taka'];
	
	$multichallengeImamount=mysqli_fetch_assoc($multichallenge->query("SELECT SUM(amount) as playamn,SUM(profit-charge) as playprof32 FROM `win_list` WHERE `user`='".$memberid."' "));
	
	$multichallengePlay=mysqli_fetch_assoc($multichallenge->query("SELECT SUM(amount) as poweramn12 FROM `game_play` WHERE `user`='".$memberid."' AND `active`='1' "));
	$multichallengelose=mysqli_fetch_assoc($multichallenge->query("SELECT SUM(amount) as playamn3 FROM `lose_list` WHERE `user`='".$memberid."' "));
	$chllangeOut=$multichallengePlay['poweramn12']+$multichallengelose['playamn3'];
	//$_SESSION['total_ret']+$_SESSION['req_funnd']+$upgrade_taka51+$upgrade_taka51+
	$Decudt=mysqli_fetch_assoc($mysqli->query("SELECT SUM(`amount`) AS asda FROM `bal_deduct` WHERE `user`='".$memberid."'"));
	$final_in_taka51 = ($_SESSION['camounttamn']+$multichallengeImamount['playprof32']+$_SESSION['autoreturn_depoBack']+$recover_taka51+$bonus_taka51+$rank_taka51+$_SESSION['payments22']+$safe_taka51+$direct_taka51+$match_taka51+$generation_taka51+$play_taka51+$receive_member_taka51+$receive_agent_taka51);
	$final_out_taka51 = ($Decudt['asda']+$chllangeOut+$PinChangeX['pichr']+$_SESSION['tradeAmn']+$_SESSION['TotalInveest']+$_SESSION['RmainInvest']+$signup_taka51+$renew_taka51+$transfer_member_taka51+$transfer_agent_taka51);	//+++$tax_taka51
	$final_taka51 = ($final_in_taka51-$final_out_taka51);
	
	if($final_taka51<0){
		$final_taka51=0;
	}
	$mysqli->query("UPDATE balance SET         
	total_in_taka='".$final_in_taka51."', 
	total_out_taka='".$final_out_taka51."', 			                                 
	final_taka='".$final_taka51."' 								 
	WHERE user='".$memberid."'");
	
?>	