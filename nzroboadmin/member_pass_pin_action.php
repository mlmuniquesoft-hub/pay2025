<?php
	session_start();
   	if(($_SESSION['Admin']=='')||(!isset($_SESSION['Admin']))){
    	header("Location:logout.php");
    	exit();
    }else{
		require '../db/db.php';

		$type=$_POST['type'];
		$page='member_edit.php';
		$user=$_POST['user'];
		$newPassword1=$_POST['newPassword1'];	
		$newPassword2=$_POST['newPassword2'];	
		
		$date=date("Y-m-d");

		$row=mysqli_num_rows($mysqli->query("select * from member where user='".$user."' "));  
		  
		if($row==0){
			$msg="Invalid  User ID";
			header("Location:$page?msg=$msg"); 
			exit();       
		}
			
		if($newPassword1!=$newPassword2){
			$msg = "Both Password are not same";       
			header("Location:$page?msg=$msg ");
			exit();	
		}
		
		if($user==''){
			$msg = "Please submit a user";       
			header("Location:$page?msg=$msg ");
			exit();	
		}		
		  
		if(($newPassword1==$newPassword2)&&($user!='')&&($type=='pin')&&($row==1)){
			$mysqli->query("UPDATE `member` SET pin='".$newPassword1."' WHERE user='".$user."'");
			
			$msg = " Pin Changed Successfully";       
			header("Location:$page?msg=$msg ");
			exit(); 
		}elseif(($newPassword1==$newPassword2)&&($user!='')&&($type=='pass')&&($row==1)){
		
			$pasu=md5($newPassword1);
			$mysqli->query("UPDATE `member` SET password='".$pasu."' WHERE user='".$user."'");

			$msg = " Password Changed Successfully";       
			header("Location:$page?msg=$msg ");
			exit(); 
		}else{
			$msg="Update Failed";
			header("Location:$page?msg=$msg");
			exit();
		}	
	}

?>