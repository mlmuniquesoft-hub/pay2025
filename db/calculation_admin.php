 <?php
	//require 'db.php';
	// Check if admin session exists
	if (!isset($_SESSION["Admin"])) {
		error_log("calculation_admin.php: Admin session not found");
		return;
	}
	
	$admin = $_SESSION["Admin"];	
	$timezone = "Asia/Dacca";
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);	
	$date=date("Y-m-d");         
?>
<?php

	$queryget2="SELECT SUM(amount) AS amount FROM admin_trans_receive where user_receive='".$admin."' ";
	$querygetexe2=$mysqli->query($queryget2);
	$_SESSION['receive'] = 0; // Initialize with default value
	if ($querygetexe2) {
		while($querygetexe2res=mysqli_fetch_array($querygetexe2))
		{
			$_SESSION['receive'] = $querygetexe2res['amount'] ?? 0;
		}
	} else {
		error_log("calculation_admin.php: Query failed for admin_trans_receive (receive): " . $mysqli->error);
	}
	
	$queryget31="SELECT SUM(amount) AS amount FROM req_fund where user='".$admin."' AND `active`='1'  ";
	$querygetexe31=$mysqli->query($queryget31);
	$_SESSION['transfer1'] = 0; // Initialize with default value
	if ($querygetexe31) {
		while($querygetexe31res=mysqli_fetch_array($querygetexe31))
		{
			$_SESSION['transfer1'] = $querygetexe31res['amount'] ?? 0;
		}
	} else {
		error_log("calculation_admin.php: Query failed for req_fund: " . $mysqli->error);
	}
	
	$queryget3="SELECT SUM(amount) AS amount FROM admin_trans_receive where user_transfer='".$admin."' ";
	$querygetexe3=$mysqli->query($queryget3);
	$_SESSION['transfer'] = 0; // Initialize with default value
	if ($querygetexe3) {
		while($querygetexe3res=mysqli_fetch_array($querygetexe3))
		{
			$_SESSION['transfer'] = $querygetexe3res['amount'] ?? 0;
		}
	} else {
		error_log("calculation_admin.php: Query failed for admin_trans_receive (transfer): " . $mysqli->error);
	}
	$_SESSION['transfer'] = ($_SESSION['transfer'] ?? 0) + ($_SESSION['transfer1'] ?? 0);
	$query = "select * from admin where user_id='".$admin."' ";
	$result=$mysqli->query($query);
	$row = mysqli_fetch_array($result);
	
	// Add null checking for database values
	$capital = $row['capital'] ?? 0;   
	$withdrow = $_SESSION['receive'] ?? 0;    
	$expenses = $row['expenses'] ?? 0;
	$transfer = $_SESSION['transfer'] ?? 0; 
	$withdrow_commision=0;	
	$transfer_commission=0;	
	
	
	
		    
	$current_balance=(($withdrow+$capital+$withdrow_commision)-($expenses+$transfer+$transfer_commission));  
	    
	$update_query = "UPDATE admin SET 
				final_balance='".$current_balance."',
				transfer_taka='".$transfer."',
				transfer_bonus='".$transfer_commission."',
				withdrow_bonus='".$withdrow_commision."',
				withdrow_taka='".$withdrow."'					
	 WHERE user_id='".$admin."'";
	 
	$update_result = $mysqli->query($update_query);
	if (!$update_result) {
		error_log("calculation_admin.php: Failed to update admin balance: " . $mysqli->error);
	}   
    
?>