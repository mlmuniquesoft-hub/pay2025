 <?php
	$_SESSION['token']="gdkjfhglkjdrf";
	//require 'db.php';
?>
<?php
		
  	if($_SESSION["agentLoginId"]){$agent=$_SESSION["agentLoginId"];}      
	

	$query2=$mysqli->query("SELECT SUM(amount) AS amount FROM admin_trans_receive where user_receive='".$agent."' ");
	while($res2=mysqli_fetch_array($query2)){
		$admin_receive=$res2['amount'];
		$admin_tax=(($res2['amount']*5)/100);
	}

	$query3=$mysqli->query("SELECT SUM(amount) AS amount FROM admin_trans_receive where user_transfer='".$agent."' AND `type`!='Exchanger' ");
	while($res3=mysqli_fetch_array($query3))
	{
	$admin_withdraw=$res3['amount'];
	}
	
	
	$query32=$mysqli->query("SELECT SUM(amount) AS amount FROM admin_trans_receive where user_transfer='".$agent."' AND `type`='Exchanger' ");
	while($res32=mysqli_fetch_array($query32))
	{
	$admin_withdraw22=$res32['amount'];
	}	
	
	$query31=$mysqli->query("SELECT SUM(amount) AS amount FROM req_fund where user='".$agent."' AND `active`='1' ");
	while($res31=mysqli_fetch_array($query31))
	{
	$user_send1=$res31['amount'];
	}

	$query4=$mysqli->query("SELECT SUM(ammount) AS amount,SUM(c_wallet) AS bonuss, SUM(u_balance) AS uniqq FROM trans_receive where user_trans='".$agent."' and type='Transfer' and account='Agent'");
	while($res4=mysqli_fetch_array($query4))
	{
	$user_send=$res4['amount'];//+$res4['bonuss']+$res4['uniqq'];
	//var_dump($res4['bonuss']);
	}
	$user_send=$user_send+$user_send1;
	//var_dump($user_send);
	$query5=$mysqli->query("SELECT SUM(ammount) AS amount, SUM(tax) AS tax FROM trans_receive where user_receive='".$agent."' and status='Paid' and type='Withdraw' and account='Agent' ");
	while($res5=mysqli_fetch_array($query5))
	{
	$user_withdrow=$res5['amount'];
	$tax=$res5['tax'];
	}	
	
	$query55=$mysqli3->query("SELECT SUM(amount) AS amoount FROM terminal_trans where user_trans='".$agent."' and reciv_from='Exchanger'  ");
	while($res55=mysqli_fetch_array($query55)){
		$transferToTerminal=$res55['amoount'];
	}	
	
	//var_dump($_SESSION['user_withdrow']);
	/*$query56=$mysqli2->query("SELECT SUM(ammount) AS amountt, SUM(tax) AS taxx FROM trans_receive where user_receive='".$agent."' and status='Paid' and type='Withdraw' and account='Agent' ");
	while($res56=mysqli_fetch_array($query56)){
		$_SESSION['user_withdroww']=$res56['amountt'];
		$_SESSION['taxd']=$res56['taxx'];
	}	*/

	//var_dump($_SESSION['user_withdrow']+$_SESSION['user_withdroww']);+$_SESSION['taxd'] 
	$uaserWithdraw=$user_withdrow-$tax;
	//$tax=($uaserWithdraw*.10);
	if($agent=="Money Booster"){
		$uaserWithdraw=$uaserWithdraw+15000;
	}
	//var_dump($transferToTerminal);
	$transferToTerminal=$transferToTerminal+$user_send;
	//var_dump($transferToTerminal);
	
	$check=$mysqli->query("UPDATE agent SET
				`receive_from_admin`='".$admin_receive."',
				`receive_admin_com`='".$admin_tax."',
				
				`withdrow_to_admin`='".$admin_withdraw."',
				`withdrow_admin_com`='".(($admin_withdraw*5)/100)."',
				`send_to_exchanger`='".$admin_withdraw22."',
				`send_to_exchanger_com`='0',
				
				`send_to_member`='".$transferToTerminal."',
				`send_member_com`='0',
				
				`withdrow_from_member`='".$uaserWithdraw."',
				`withdrow_member_com`='".$tax."'
				
	  WHERE user_id='".$agent."'");
	


	$row = mysqli_fetch_array($mysqli->query("select * from agent where user_id='".$agent."' "));
	$r_from_admin=$row['receive_from_admin'];   
	$r_admin_com=$row['receive_admin_com']; 
	
	$w_admin=$row['withdrow_to_admin']; 
	$w_admin_com=$row['withdrow_admin_com']; 
	
	$w_admin22=$row['send_to_exchanger']; 
	$w_admin_com22=$row['send_to_exchanger_com']; 
	
	$s_member=$row['send_to_member']; 
	
	$w_from_member=$row['withdrow_from_member']; 
	$w_member_com=$row['withdrow_member_com'];
	
	$in=($r_from_admin+$r_admin_com+$w_from_member+$w_member_com+$w_admin_com22);
	$out=($w_admin+$w_admin_com+$s_member+$w_admin22);
	$net=($in-$out);
	
	//var_dump($in);
	//var_dump($out);
	//die();
	$mysqli->query("UPDATE agent SET total_in='".$in."', total_out='".$out."', final_balance='".$net."' WHERE user_id='".$agent."'");  

?>