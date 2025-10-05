<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';
		$item=$_POST['user_id'];
		
		$query = "select * from agent where user='".$item."'";
		$result=$mysqli->query($query);
		$row = mysqli_fetch_array($result);
		$name = $row['acc_suspend'];

		if($item==''){
			$ErrorMessage = "Please Enter a ID to Active/Inactive";       
			header("Location:agent_edit.php?ErrorMessage=$ErrorMessage ");
			exit;
		}

		if($name==''){
			$ErrorMessage = "Please Enter a Currect Agent ID to Active/Inactive";       
			header("Location:agent_edit.php?ErrorMessage=$ErrorMessage ");
			exit;
		}

		if($name=='yes'){
			$mysqli->query("UPDATE agent SET acc_suspend='no' WHERE user_id='".$item."'");	
			$ErrorMessage = "Suspention compleated $item is Active Now";       
			header("Location:agent_edit.php?ErrorMessage=$ErrorMessage ");
			exit;
		}elseif($name=='no'){
			$mysqli->query("UPDATE agent SET acc_suspend='yes' WHERE user_id='".$item."' ");
			
			$ErrorMessage = "Suspention compleated $item is Inactive Now";        
			header("Location:agent_edit.php?ErrorMessage=$ErrorMessage ");
			exit;
		}else{
			$ErrorMessage = "Please Enter a Currect Agent ID to Active/Inactive";       
			header("Location:agent_edit.php?ErrorMessage=$ErrorMessage ");
			exit;
		}

    }      
?>