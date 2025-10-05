<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';
		$item=$_POST['user_id'];
		
		$query = "select * from member where user='".$item."'";
		$result=$mysqli->query($query);
		$row = mysqli_fetch_array($result);
		$name = $row['active'];

		if($item==''){
			$msg = "Please Enter a ID to Active/Inactive";       
			header("Location:member_block.php?msg=$msg ");
			exit;
		}
		
		if($name==''){
			$msg = "Please Enter a Currect Member ID to Active/Inactive";       
			header("Location:member_block.php?msg=$msg ");
			exit;
		}

		if($name==1){
			$mysqli->query("UPDATE member SET active=0 WHERE user='".$item."'");	
			$msg = "Suspention compleated $item is Active Now";       
			header("Location:member_block.php?msg=$msg ");
			exit;
		}elseif($name==0){	
			$mysqli->query("UPDATE member SET active=1 WHERE user='".$item."' ");
			
			$msg = "Suspention compleated $item is Inactive Now";        
			header("Location:member_block.php?msg=$msg ");
			exit;
		}else{
			$msg = "Please Enter a Currect Member ID to Active/Inactive";       
			header("Location:member_block.php?msg=$msg ");
			exit;
		}
    }      
?>