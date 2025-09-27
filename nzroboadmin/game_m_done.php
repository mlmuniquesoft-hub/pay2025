<?php
	session_start();
	if(($_SESSION['Admin']=='')||(!isset($_SESSION['Admin'])))
    	{
    	header("Location:logout.php");
    	exit();
    	}
	else
	{
	
	require '../db/db.php';
	$user=$_SESSION['Admin'];	           
	$team= $_GET['team'] ;
	$serial= $_GET['game'] ;	
	$amt= $_GET['amount'] ;
	$memberid= $_GET['member'] ;	
	
	
	$chk=mysqli_num_rows($mysqli->query("SELECT * FROM `play` WHERE `serial`='".$serial."'"));
	if($chk==0)
	{
	$msg="There is No Active Games";
	header("Location:game_status.php?msg=$msg"); 
	exit();       
	}		
	
		
	if(($team==1)&&($chk==1))
	{

	$mysqli->query("UPDATE `play` SET `active`='1' WHERE  `serial`='".$serial."' ");
	}
	elseif(($team==2)&&($chk==1))
	{
	$mysqli->query("UPDATE `play` SET `active`='2' WHERE  `serial`='".$serial."' ");
	}		
	elseif(($team==3)&&($chk==1))
	{
	$mysqli->query("UPDATE `play` SET `active`='3' WHERE  `serial`='".$serial."' ");
	}			
	elseif(($team==5)&&($chk==1))
	{
	 $load=$mysqli->query("UPDATE `bcpp` SET active='1' WHERE `user`='".$memberid."' and `type`='Special' and `amount`='$amt' ORDER BY serial DESC LIMIT 1");	
		if($load==1)
		{
		$mysqli->query("DELETE FROM `play` WHERE `serial`='".$serial."' ");
		}		
	}			
		
	$msg = "Winner Config Successfull";       
	header("Location:game_status.php?msg=$msg"); 
	exit();   
	}	


?>	