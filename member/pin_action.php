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
		$Format = $_POST["Format"];	
		$location = $_POST["location"];	
		$mpass =$oldPassword;
		$newpass =$newPassword1;
		
		$check_pin=strlen($newpass);
		if($check_pin<=3){
			$_SESSION['msg3']="Enter At Least 4 Character Transaction Code";
			header("Location:$location");
			exit;
		}
		if(isset($_POST["Format"])){
			$query = "select user,pin from member where user='".$memberid."' ";
			$result=$mysqli->query($query);
			$row = mysqli_fetch_array($result);
			$prevPin=$row['pin'];
			$q="UPDATE member SET pin='$newpass' WHERE user='".$memberid."'";
			$mysqli->query($q);
			$query2 = "select * from `profile` where `user`='".$memberid."' ";
			$result2=$mysqli->query($query2);
			$row2 = mysqli_fetch_array($result2);
			$to=$row2['email'];
			$date0=date("Y-m-d");
			$mysqli->query("INSERT INTO `reset_pin`( `user`, `prev_pin`, `new_pin`, `charge`) VALUES ('".$memberid."','".$prevPin."','".$newpass."','1')");
			$message = "
			Success!!!
			Your Transaction Code Changed Successfully.<br/>
			New Transaction Code : $newpass <br/>	
			Changed date : $date0
			";
			$subject="Change Transaction Code";
			$from = "info@nzrobotrade.com";
			$headers = "From:" . $from;
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: NZ Robo Trade <info@nzrobotrade.com>' . "\r\n";
			mail($to,$subject,$message,$headers);
			
			$_SESSION['msg4'] = "Your Transaction Code Has Been Changed";       
			header("Location:$location");
			exit;
		}else{
			if($newPassword1 == $newPassword2){
				$query = "select user,pin from member where user='".$memberid."' and pin='".$mpass."' ";
				$result=$mysqli->query($query);
				$row = mysqli_fetch_array($result);
				$check = mysqli_num_rows($result);		
				if(($check==1)&&($newPassword1!='')){
					$q="UPDATE member SET pin='$newpass' WHERE user='".$memberid."'";
					$mysqli->query($q);
					$query2 = "select * from `profile` where `user`='".$memberid."' ";
					$result2=$mysqli->query($query2);
					$row2 = mysqli_fetch_array($result2);
					$to=$row2['email'];
					$date0=date("Y-m-d");
					$message = "
					Success!!!
					Your Transaction Code Changed Successfully.<br/>
					New Transaction Code : $newpass <br/>	
					Changed date : $date0
					";
					$subject="Change Transaction Code";
					$from = "info@nzrobotrade.com";
					$headers = "From:" . $from;
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From: NZ Robo Trade <info@nzrobotrade.com>' . "\r\n";
					mail($to,$subject,$message,$headers);
					
					$_SESSION['msg4'] = "Your Transaction Code Has Been Changed";       
					header("Location:$location");
					exit;
				}else{
					$_SESSION['msg3']="Invalid / Blank Current Code !!!";
					header("Location:$location");
					exit;
				}
			}else{
				$_SESSION['msg3']="Both Code Does Not Match";
				header("Location:$location");
				exit;				
			}  	
		}
		
	}
?>