<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';
		require '../db/functions.php';
		$option2=$_POST['option2'];
		$location=$_POST['location'];
		$MEMBERiD=$_SESSION['Admin'];
		$cheeek=1;
		if($option2=="Bank_Details"){
			if($_POST['bank_name']==''){
				$cheeek=0;
				$_SESSION['msg']="Please Insert Bank Name";
				header("Location: $location");
				exit();
			}
			if($_POST['holder_name']==''){
				$cheeek=0;
				$_SESSION['msg']="Please Insert Account Holder Name";
				header("Location: $location");
				exit();
			}
			if($_POST['branch']==''){
				$cheeek=0;
				$_SESSION['msg']="Please Insert Branch Name";
				header("Location: $location");
				exit();
			}
			if($_POST['account_number']==''){
				$cheeek=0;
				$_SESSION['msg']="Please Insert Bank Account Number";
				header("Location: $location");
				exit();
			}
			
		}else{
			if($_POST['b_number']==''){
				$cheeek=0;
				$_SESSION['msg']="Please Insert Account Number";
				header("Location: $location");
				exit();
			}
		}
		$pincode=$_POST['pincode'];
		$check=mysqli_num_rows($mysqli->query("SELECT * FROM `admin` WHERE `user_id`='".$MEMBERiD."' AND `tr_password`='".$pincode."'"));
		if($check<1){
			$cheeek=0;
			$_SESSION['msg']="Invalid Tr Pin";
			header("Location: $location");
			exit();
		}
		if($cheeek==1){
			$check=InsertInfo("payment_setup", $_POST);
			if($check==1){
				$_SESSION['msg1']="New Payment System Setup Successful";
				header("Location: $location");
				exit();
			}else{
				$_SESSION['msg']="Your Connection Not Secure Try Latter";
				header("Location: $location");
				exit();
			}
		}else{
			$_SESSION['msg']="Your Connection Not Secure Try Latter";
			header("Location: $location");
			exit();
		}
		
	}
?>

