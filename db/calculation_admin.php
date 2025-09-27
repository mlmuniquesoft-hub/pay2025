 <?php
	//require 'db.php';
	$admin = $_SESSION["Admin"];	
	$timezone = "Asia/Dacca";
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);	
	$date=date("Y-m-d");         
?>
<?php

	$queryget2="SELECT SUM(amount) AS amount FROM admin_trans_receive where user_receive='".$admin."' ";
	$querygetexe2=$mysqli->query($queryget2);
	while($querygetexe2res=mysqli_fetch_array($querygetexe2))
	{
	$querygetexe2res['amount']; 
	$_SESSION['receive']=$querygetexe2res['amount'];
	}
	
	$queryget31="SELECT SUM(amount) AS amount FROM req_fund where user='".$agent."' AND `active`='1'  ";
	$querygetexe31=$mysqli->query($queryget31);
	while($querygetexe31res=mysqli_fetch_array($querygetexe31))
	{
	$_SESSION['transfer1']=$querygetexe31res['amount'];
	}
	
	$queryget3="SELECT SUM(amount) AS amount FROM admin_trans_receive where user_transfer='".$admin."' ";
	$querygetexe3=$mysqli->query($queryget3);
	while($querygetexe3res=mysqli_fetch_array($querygetexe3))
	{
	//$querygetexe3res['amount'];
	$_SESSION['transfer']=$querygetexe3res['amount'];
	}
	$_SESSION['transfer']=$_SESSION['transfer']+$_SESSION['transfer1'];
	$query = "select * from admin where user_id='".$admin."' ";
	$result=$mysqli->query($query);
	$row = mysqli_fetch_array($result);
	$capital=$row['capital'];   
	$withdrow=$_SESSION['receive'];    
	$expenses=$row['expenses'];
	$transfer=$_SESSION['transfer']; 
	$withdrow_commision=0;	
	$transfer_commission=0;	
	
	
	
		    
	$current_balance=(($withdrow+$capital+$withdrow_commision)-($expenses+$transfer+$transfer_commission));  
	    
	$mysqli->query("UPDATE admin SET 
				final_balance='".$current_balance."',
				transfer_taka='".$transfer."',
				transfer_bonus='".$transfer_commission."',
				withdrow_bonus='".$withdrow_commision."',
				withdrow_taka='".$withdrow."'					
	 WHERE user_id='".$admin."'");   
    
?>