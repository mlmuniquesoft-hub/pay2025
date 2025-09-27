<?php
	session_start();
	$_SESSION['token']="sdfjgvsdkjfsd";
	require 'db.php';
	require 'functions.php';
?>
<?php
	if($_SESSION["MemLogId"]){$memberid=$_SESSION["MemLogId"];}


	$query=$mysqli->query("SELECT SUM(direct) AS amount FROM member where sponsor='".$memberid."'");
	while($res=mysqli_fetch_array($query)){
		$_SESSION['direct']=$res['amount'];
	}
	
	$query1=$mysqli->query("SELECT SUM(commission) AS commission FROM bcpp where sponsor='".$memberid."' ");
	while($res1=mysqli_fetch_array($query1)){
		$_SESSION['commission']=$res1['commission'];	
	}
	
	$direct=($_SESSION['direct']+$_SESSION['commission']);

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

	$query4=$mysqli->query("SELECT SUM(ammount) AS ammount FROM trans_receive where user_receive='".$memberid."' and type='Transfer' and account='Payza' ");
	while($res4=mysqli_fetch_array($query4)){
		$_SESSION['receive_payza']=$res4['ammount'];
	}

	$query5=$mysqli->query("SELECT SUM(ammount) AS ammount, SUM(tax) AS tax FROM trans_receive where user_trans='".$memberid."' and type='Withdraw' and account='Agent' ");
	while($res5=mysqli_fetch_array($query5))
	{
	$_SESSION['payments']=$res5['ammount'];
	$_SESSION['tax1']=$res5['tax'];	
	}
	
	$query5=$mysqli->query("SELECT SUM(ammount) AS ammount2, SUM(tax) AS tax2 FROM trans_receive where user_trans='".$memberid."' and type='Withdraw' and status='Cancel' and account='Agent' ");
	while($res5=mysqli_fetch_array($query5))
	{
	$_SESSION['payments2']=$res5['ammount2'];
	$_SESSION['tax12']=$res5['tax2'];
	}
	
	$_SESSION['payments']=$_SESSION['payments']-$_SESSION['payments2'];
	$_SESSION['tax1']=$_SESSION['tax1']-$_SESSION['tax12'];	
	
	$query6=$mysqli->query("SELECT SUM(ammount) AS ammounwwt,SUM(c_wallet) AS ddd FROM trans_receive where user_trans='".$memberid."' and type='Transfer' and account='Member' ");
	while($res6=mysqli_fetch_array($query6))
	{
	$_SESSION['transfer_member']=$res6['ammounwwt'];
	$_SESSION['bonus_ddd']=$res6['ddd'];
	}

			
	$query8=$mysqli->query("SELECT SUM(amount) AS amount FROM `game_configure` where user='".$memberid."' ");
	while($res8=mysqli_fetch_array($query8))
	{
	$_SESSION['investment']=$res8['amount'];
	}
	
	$query8=$mysqli->query("SELECT SUM(charge) AS renewCharge FROM `renew_game` where user='".$memberid."' ");
	while($res8=mysqli_fetch_array($query8))
	{
	$_SESSION['renewCharge']=$res8['renewCharge'];
	}

	$query9=$mysqli->query("SELECT SUM(amount) AS amount,SUM(bonus) AS upbonus FROM upgrade where user='".$memberid."' ");
	while($res9=mysqli_fetch_array($query9))
	{
	$_SESSION['upgrade']=$res9['amount'];
	$_SESSION['upbonus']=$res9['upbonus'];
	}
	
	$query91=$mysqli->query("SELECT SUM(amount) AS amounwt FROM `req_fund` where `receiver`='".$memberid."' AND `active`='1'");
	while($res91=mysqli_fetch_array($query91))
	{
	$_SESSION['req_funnd']=$res91['amounwt'];
	}
	
	$query911=$mysqli->query("SELECT SUM(curent_bal) AS curentamn,SUM(bonus_bal) AS bonusamn  FROM `game_return` where `user`='".$memberid."' ");
	while($res911=mysqli_fetch_array($query911))
	{
	$_SESSION['curentamn']=$res911['curentamn'];
	$_SESSION['bonusamn']=$res911['bonusamn'];
	}
	$query912=$mysqli->query("SELECT SUM(amount) AS total_ret  FROM `return_invest` where `user`='".$memberid."' ");
	while($res912=mysqli_fetch_array($query912))
	{
	$_SESSION['total_ret']=$res912['total_ret'];
	}



/*	$query121=$mysqli2->query("SELECT SUM(ammount) AS emalamn FROM trans_receive where user_trans='".$memberid."' AND `method`='logic account'");
	while($res12=mysqli_fetch_array($query121)){
		$_SESSION['emallamn']=$res12['emalamn'];
	}
	*/
	
	$play_taka=$_SESSION['curentamn'];
	$bonus_taka=(($_SESSION['bonudds']+$_SESSION['bonus_w']+$_SESSION['bonusamn'])-($_SESSION['bonus_ddd']+$_SESSION['upbonus']));
	//$safe_taka=0;
	$_SESSION['tax']=$_SESSION['tax1']+$_SESSION['tax2'];
	//$_SESSION['payments']=$_SESSION['payments']-$_SESSION['tax1'];
	//$_SESSION['transfer_member']=$_SESSION['transfer_member']-$_SESSION['tax2'];
	//safe_taka='".$safe_taka."',   
	$mysqli->query("UPDATE balance SET 
	direct_taka='".$direct."',
	receive_member_taka='".$_SESSION['receive_member']."',
	receive_agent_taka='".$_SESSION['receive_agent']."',
	receive_payza_taka='".$_SESSION['receive_payza']."',
	signup_taka='".$_SESSION['upgrade']."',
	bcpp_taka='".$_SESSION['investment']."',
	bonus_taka='".$bonus_taka."',
	play_taka='".$play_taka."',
	renew_taka='".$_SESSION['renewCharge']."',
	transfer_member_taka='".$_SESSION['transfer_member']."',
	transfer_agent_taka='".$_SESSION['payments']."',
	transfer_payza_taka='".$_SESSION['transfer_payza']."',
	tax_taka='".$_SESSION['tax']."'
	WHERE user='".$memberid."'");
	
?>	


<?php  

	$query51 = "SELECT `user`,`renew_taka`, `direct_taka`, `match_taka`, `upgrade_taka`, `rank_taka`, `receive_agent_taka`, `receive_member_taka`, `receive_payza_taka`, `transfer_agent_taka`, `transfer_member_taka`, `transfer_payza_taka`, `signup_taka`, `play_taka`, `safe_taka`, `generation_taka`, `bcpp_taka`, `tax_taka` FROM `balance` WHERE `user`='".$memberid."' ";
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

	$final_in_taka51 = ($_SESSION['total_ret']+$_SESSION['req_funnd']+$direct_taka51+$match_taka51+$upgrade_taka51+$generation_taka51+$rank_taka51+$play_taka51+$safe_taka51+$receive_member_taka51+$receive_agent_taka51);
	$final_out_taka51 = ($renew_taka51+$transfer_member_taka51+$transfer_agent_taka51+$transfer_payza_taka51+$upgrade_taka51+$bcpp_taka51+$signup_taka51);	//$tax_taka51+
	$final_taka51 = ($final_in_taka51-$final_out_taka51); 
	  
	  
	$mysqli->query("UPDATE balance SET         
	total_in_taka='".$final_in_taka51."', 
	total_out_taka='".$final_out_taka51."', 			                                 
	final_taka='".$final_taka51."' 								 
	WHERE user='".$memberid."'");
?>	