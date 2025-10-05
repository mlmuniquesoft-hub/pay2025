<?php
    session_start(); 
	if((!isset($_SESSION['Admin']))&&(!isset($_SESSION['token']))){
        header("Location: index.php");
        exit();
    }else{
        require_once("../db/db.php");
		require_once("../db/functions.php");
		
		$send_cri = $_POST["send_cri"];
		$send_to = $_POST["send_to"];
		
		$userabc = $_POST["user_id"];
		$subject = $_POST["subj"];
		$mess = $_POST["mess"];
		$location = $_POST["location"];
		
		if($send_cri==1){
			if($userabc==''){
				$_SESSION['msg']="Blank User ID";
				header("Location: $location");
				exit;	
			}
			if($mess==''){
				$_SESSION['msg']="Your Message Empty ";
				header("Location: $location");
				exit;	
			}
			if(($mess!='')&&($userabc!='')){
				$hdfgd=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `user`='".$userabc."'"));
				$meme=$mysqli->query("SELECT * FROM `profile` WHERE `user`='".$userabc."' OR `user`='".$hdfgd['log_user']."'");
				$check=mysqli_num_rows($meme);
				if($check>0){
					$member=mysqli_fetch_assoc($meme);
					$to=$member['email'];
					$message = $mess;
					$from = "support@capitolmoneypay.com";
					$headers = "From:" . $from;
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From: Capitol Money Pay Support<support@capitolmoneypay.com>' . "\r\n";
					if(in_array(2,$send_to)){
						mail($to,$subject,$message,$headers);
					}
					if(in_array(1,$send_to)){
						$timeK=time();
						$mysqli->query("INSERT INTO `message2`(`ticket_id`, `user_id`, `message`) VALUES ('".$timeK."','".$hdfgd['log_user']."','".$message."')");
					}
					
					$_SESSION['msg1']="Notification Send Successful";
					header("Location: $location");
					exit;
				}else{
					$_SESSION['msg']="Invalid User Id";
					header("Location: $location");
					exit;
				}
			}
		}elseif($send_cri==2){
			if($mess==''){
				$_SESSION['msg']="Your Message Empty ";
				header("Location: $location");
				exit;	
			}
			$jkhdgkf=$mysqli->query("SELECT * FROM `profile`");
			while($lsdf=mysqli_fetch_assoc($jkhdgkf)){
				usleep(50);
				$to=$lsdf['email'];
				$message = $mess;
				$from = "support@capitolmoneypay.com";
				$headers = "From:" . $from;
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: Capitol Money Pay Support<support@capitolmoneypay.com>' . "\r\n";
				if(in_array(1,$send_to)){
					mail($to,$subject,$message,$headers);
				}
				if(in_array(2,$send_to)){
					$timeK=time();
					$mysqli->query("INSERT INTO `message2`(`ticket_id`, `user_id`, `message`) VALUES ('".$timeK."','".$lsdf['user']."','".$message."')");
				}
				
				
			}
			$_SESSION['msg1']="Notification Send Successful";
			header("Location: $location");
			exit;
		}elseif($send_cri==3){
			$country=$_POST['countr'];
			if($mess==''){
				$_SESSION['msg']="Your Message Empty ";
				header("Location: $location");
				exit;	
			}
			if($country==''){
				$_SESSION['msg']="Select Country";
				header("Location: $location");
				exit;	
			}
			
			$jkhdgkf=$mysqli->query("SELECT * FROM `profile` WHERE `country`='".$country."'");
			while($lsdf=mysqli_fetch_assoc($jkhdgkf)){
				usleep(50);
				$to=$lsdf['email'];
				$message = $mess;
				$from = "support@capitolmoneypay.com";
				$headers = "From:" . $from;
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: Capitol Money Pay Support<support@capitolmoneypay.com>' . "\r\n";
				if(in_array(1,$send_to)){
					mail($to,$subject,$message,$headers);
				}
				if(in_array(2,$send_to)){
					$timeK=time();
					$mysqli->query("INSERT INTO `message2`(`ticket_id`, `user_id`, `message`) VALUES ('".$timeK."','".$lsdf['user']."','".$message."')");
				}
				
				
			}
			$_SESSION['msg1']="Notification Send Successful";
			header("Location: $location");
			exit;
		}elseif($send_cri==4){
			$country=$_POST['packj'];
			if($mess==''){
				$_SESSION['msg']="Your Message Empty ";
				header("Location: $location");
				exit;	
			}
			if($country==''){
				$_SESSION['msg']="Select Package";
				header("Location: $location");
				exit;	
			}
			
			$jkhdgkf=$mysqli->query("SELECT * FROM `member` WHERE `pack`='".$country."'");
			while($lsdf2=mysqli_fetch_assoc($jkhdgkf)){
				$lsdf=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$lsdf2['log_user']."' AND `user`='".$lsdf2['user']."'"));
				usleep(50);
				$to=$lsdf['email'];
				$message = $mess;
				$from = "support@capitolmoneypay.com";
				$headers = "From:" . $from;
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: Capitol Money Pay Support<support@capitolmoneypay.com>' . "\r\n";
				if(in_array(1,$send_to)){
					mail($to,$subject,$message,$headers);
				}
				if(in_array(2,$send_to)){
					$timeK=time();
					$mysqli->query("INSERT INTO `message2`(`ticket_id`, `user_id`, `message`) VALUES ('".$timeK."','".$lsdf['user']."','".$message."')");
				}
				
				
			}
			$_SESSION['msg1']="Notification Send Successful";
			header("Location: $location");
			exit;
		}
		
		
		
		
	}
?>	