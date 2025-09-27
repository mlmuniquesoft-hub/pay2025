<?php
	 session_start(); 
    if(!isset($_SESSION['roboMember'])){
    	header("Location:logout.php");
    	exit();
    }else{
		require '../../db/db.php';
		require '../../db/functions.php';
		$rett=array();
		$user=$_SESSION['roboMember'];
		$DepositReceive=TtalIncome($user);
		$remainAmn=RemainingReturn($user);
		$MemberUpgrade=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) AS asmUpgrade FROM `upgrade` WHERE `user`='".$user."'"));
		$ExpectyedReturn=$MemberUpgrade['asmUpgrade']*3;
		if($remainAmn>0){
			$rett[0]=array(
				"value"=>$DepositReceive,
				"color"=>"#2acd72",
				"highlight"=>"rgba(44,188,108,0.65)",
				"label"=>"Completed"
			);
			
			if($remainAmn<=10){
				$rett[1]=array(
					"value"=>10,
					"color"=>"#E91E63",
					"highlight"=>"rgba(250,133,100,0.8)",
					"label"=>"Recharge"
				);
			}else{
				$rett[1]=array(
					"value"=>$remainAmn,
					"color"=>"#eee",
					"highlight"=>"#e1dcdc",
					"label"=>"Bot Working"
				);
			}
		}else{
			array_push($rett,array(
				"value"=>1,
				"color"=>"#E91E63",
				"highlight"=>"rgba(250,133,100,0.8)",
				"label"=>"Canceled"
			));
		}
		
		echo json_encode($rett);
		
	}

?>