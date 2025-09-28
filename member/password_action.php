<?php
    session_start(); 
    if(!isset($_SESSION['roboMember'])){
    	header("Location:logout.php");
    	exit();
    }else{
		require '../db/db.php';
		$memberid=$_SESSION['roboMember'];
		$oldPassword = $_POST["oldPassword"];
		$newPassword1 = $_POST["newPassword1"];
		$newPassword2 = $_POST["newPassword2"];	
		$location = $_POST["location"];	
		$mpass =md5($oldPassword);
		$newpass =md5($newPassword1);
		
		$check_pass=strlen($newPassword1);
		if($check_pass<=5){
			$_SESSION['msg']="Enter At Least 6 Character Password";
			header("Location:$location");
			exit();
		}
		
		if($newPassword1==$newPassword2){
			$query = "select user,password from member where user='".$memberid."' and password='".$mpass."' ";
			$result=$mysqli->query($query);
			$row = mysqli_fetch_array($result);
			$check = mysqli_num_rows($result);		
			if(($check==1)&&($newPassword1!='')){
				$q="UPDATE `member` SET `password`='".$newpass."' WHERE `user`='".$memberid."'";
				$mysqli->query($q);
				$query2 = "select * from `profile` where `user`='".$memberid."' ";
				$result2=$mysqli->query($query2);
				$row2 = mysqli_fetch_array($result2);
				$to=$row2['email'];
				$date0=date("Y-m-d");
				$message = "
				Success!!!
				Your Password Changed Successfully.<br/>
				New Password : $newPassword1 <br/>	
				Changed date : $date0
				";
				
				$subject="Change Password";
				$from = "info@capitolmoneypay.com";
				$headers = "From:" . $from;
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: Capitol Money Pay <info@capitolmoneypay.com>' . "\r\n";
				mail($to,$subject,$message,$headers);

				$_SESSION['msg1'] = "Your Login Password Has Been Changed";       
				header("Location:$location");
				exit;
			}else{
				$_SESSION['msg'] = "Invalid / Blank Current Password !!!";
				header("Location:$location");
				exit;
			}
		}else{
			$_SESSION['msg'] = "Both New Password Does Not Match";
			header("Location:$location");
			exit;				
		}  	

	}
?>