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
		
		$yyy=array_keys($_POST);
		foreach($yyy as $ttt){
			if($ttt!='time_play'){
				if($_POST[$ttt]==''){
					$ttt=strtoupper($ttt);
					$_SESSION['msg']="Please Fill $ttt This Carefully!!";
					header("Location: $location");
					exit();
					break;
				}
			}
			
		}
	
		if($cheeek==1){
			$check=InsertInfo("gamesetup", $_POST);
			if($check==1){
				$_SESSION['msg1']="New Game Type Setup Successful";
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

