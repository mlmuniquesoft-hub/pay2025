<?php
    session_start(); 
    if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
    	exit();
	}else{
		require '../db/db.php'; 
		$date=date("Y-m-d");
		$memberid=$_SESSION['Admin'];
		$user=$_POST['uhgf'];
		$trPin=$_POST['trPin'];
		$location=$_POST['location'];
		$cchek_member=mysqli_num_rows($mysqli->query("SELECT `user_id` FROM `admin` WHERE `user_id`='".$memberid."' AND `tr_password`='".$trPin."'"));
		if($cchek_member<1){
			$_SESSION['msg']="Invalid Transaction Password";
			header("Location:$location");
			exit();
		}
		$cchek_user=mysqli_num_rows($mysqli->query("SELECT `user` FROM `member` WHERE `user`='".$user."' "));
		if($cchek_user<1){
			$_SESSION['msg']="Invalid User ID";
			header("Location:$location");
			exit();
		}
		
		$q = $mysqli->query("SELECT * FROM `bonus_invoice` where `user`='' AND `active`='0' ");
		$i=0;
		
		while($allpin=mysqli_fetch_assoc($q)){
			$checkPiin=mysqli_num_rows($mysqli->query("SELECT `serial` FROM `bonus_invoice` WHERE `serial`='".$allpin['serial']."' "));
			if($checkPiin>0){
				$checkk="bbb".$allpin['serial'];
				if($_POST[$checkk]!=''){
					$i++;
					$sers=$_POST[$checkk];
					//echo $user ." >> ". $sers;
					$mysqli->query("UPDATE `bonus_invoice` SET `user`='".$user."' WHERE `serial`='".$sers."'");
					//$mysqli->query("INSERT INTO `pin_tranreciv`( `user_trans`, `user_reciv`, `pinser`) VALUES ('".$_SESSION['MemLogId']."','".$user."','".$sers."')");
				}
			}
		}
		//die();
		if($i>1){
			$_SESSION['msg1']="Total $i Pin Send To $user Successful";
			header("Location:$location");
			exit();
		}else{
			$_SESSION['msg']="Something Wrong Try Latter";
			header("Location:$location");
			exit();
		}
	}
?>