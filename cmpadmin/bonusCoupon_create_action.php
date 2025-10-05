<?php
	session_start();
	if(($_SESSION['Admin']=='')||(!isset($_SESSION['Admin']))){
    	header("Location:logout.php");
    	exit();
    }else{
		require '../db/db.php';
		require '../db/functions.php';
		
		$pinQQ=$_POST['pinQQ'];
		$pin=$_POST['trPass'];
		$location=$_POST['location'];
		$chekk=1;
		
		if($pinQQ==''){
			$chekk=0;
			$_SESSION['msg']="Please Insert Pin Amount";
			header("Location: $location");
			exit();
		}
		
		if(empty($pin)){
			$chekk=0;
			$_SESSION['msg']="Please Insert Your Transaction Pin";
			header("Location: $location");
			exit();
		}
		$gghh=mysqli_num_rows($mysqli->query("SELECT * FROM `admin` WHERE `user_id`='".$_SESSION['Admin']."' AND `tr_password`='".$pin."'"));
		if($gghh<1){
			$chekk=0;
			$_SESSION['msg']="Please Insert Your Correct Transaction Pin";
			header("Location: $location");
			exit();
		}
		if($chekk==1){
			for($i=1;$i<=$pinQQ;$i++){
				usleep(30);
				$ttyy=array();
				$coupon=str_shuffle(substr(time(),3));
				$mmhh=mysqli_num_rows($mysqli->query("SELECT `serial` FROM `bonus_invoice` WHERE `invoice_num`='".$coupon."'"));
				if($mmhh>0){
					$i--;
				}else{
					$ttyy['create_by']="Admin";
					$ttyy['invoice_num']=$coupon;
					$rrtt=InsertInfo("bonus_invoice", $ttyy);
				}
				echo $i;
			}
			$_SESSION['msg']="Your Bonus Pin ($pinQQ) Create Successfull";
			header("Location: $location");
			exit();
		
		}else{
			$_SESSION['msg']="Your Connection Not Secure Try Latter";
			header("Location: $location");
			exit();
		}
		
		
	}
?>