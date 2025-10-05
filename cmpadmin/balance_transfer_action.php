<?php
    session_start();
	if((isset($_SESSION['num_login_fail']))||(!isset($_SESSION['token']))){
		if($_SESSION['num_login_fail'] == 4){
			if(time() - $_SESSION['last_login_time'] < 10*60 ){    
				$ErrorMessage="Hacking Suspect Please wait for 10 minutes Then Try again .";
				header("Location: login.php?ErrorMessage=$ErrorMessage");
				exit();
			}else{
				//after 10 minutes
				 $_SESSION['num_login_fail'] = 0;
			}
		}      
	}
		      
	if($_SESSION['num_login_fail']<4){
		require '../db/db.php';
		if($_SESSION['OriginalAdmin']=="superadmin"){
			$admin = $_SESSION['OriginalAdmin']; 
		}else{
			$admin = $_SESSION["Admin"]; 
		}
			
		$quantity = $_POST["quantity"];
		$touser= $_POST["user"];
		$remark= $_POST["for"];
		$pincode= $_POST["pincode"];			
		$location= $_POST["location"];			
		
		$timezone = "Asia/Dacca";
		if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);	
		$date=date("Y-m-d");
		
		$query = "select * from admin where user_id='".$admin."' ";
		$result=$mysqli->query($query);
		$row = mysqli_fetch_array($result);
		$balance=$row['final_balance'];
		$tr_password=$row['tr_password'];			        
		if($touser==$admin){		
			$_SESSION['msg'] = "You are not authorized to transfer in your own account !!";       
			header("Location:$location");
			exit;
		}
		if($tr_password!=$pincode){		
			$_SESSION['msg']= "Invalid Transaction Password!!";       
			header("Location:$location");
			exit;
		} 	
		if($balance<$quantity){
			$_SESSION['msg']= "You have not Sufficient balance to transfer!!";       
			header("Location:$location");
			exit;
		}	

		$query2 = "select * from member where user='".$touser."' ";
		$result2=$mysqli->query($query2);
		$row2 = mysqli_fetch_array($result2);	
		$check2 = mysqli_num_rows($result2);
		$suspend=$row2['acc_suspend'];	
		if($check2!=1){
			$_SESSION['msg']= "Invalid Member please enter correct Member id !!";       
			header("Location:$location");
			exit;
		}
		

		if($check2==1){	
			$mysqli->query("INSERT INTO admin_trans_receive(user_transfer,amount,date,user_receive,remark) VALUES ('".$admin."','".$quantity."','".$date."','".$touser."','".$remark."')");
			$_SESSION['msg1']= "Balance transfer successfully completed for $tousers";       
			header("Location:$location");
			exit;
		}	
	}
	 
	
	
	
?>