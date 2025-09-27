<?php
    session_start(); 
    if(!isset($_SESSION['roboMember'])){
    	header("Location:logout.php");
    	exit();
    }else{
		require '../db/db.php';
		require '../db/functions.php';
		
		$returnAmn=array();
		$user=$_SESSION['roboMember'];
		
		$BotAmn=mysqli_num_rows($mysqli->query("SELECT * FROM `upgrade` WHERE `user`='".$user."'"));
		
		$uiyre=remainAmn22($user);
		
		$returnAmn['bOTqTY']=$BotAmn;
		$returnAmn['RemainReturn']=RemainingReturn($user);
		$returnAmn['TotalIncome']=TtalIncome($user);
		$returnAmn['FinalAmount']=number_format($uiyre['final'],2,'.',',');
		$returnAmn['TotaoIn']=number_format($uiyre['in'],2,'.',',');
		$returnAmn['TotaoOut']=number_format($uiyre['out'],2,'.',',');
		$returnAmn['shopping']=number_format($uiyre['shop'],2,'.',',');
		
		echo json_encode($returnAmn);
		
	}
?>