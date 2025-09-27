<?php
    session_start();
	$_SESSION['token']="fsgsdfsdf";
	$rett=array();
	$capths=$_POST['capths'];
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,
				"secret=6LfTCbIUAAAAAMMOvOCawpOaDpwwMx0dzASk7nNN&response=$capths");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec($ch);
	curl_close ($ch);
	$fdgdf=json_decode($server_output);
	
	if($fdgdf->success){
		//unset($_SESSION['num_login_fail']);
		if((isset($_SESSION['num_login_fail']))||(!isset($_SESSION['token']))){
			if($_SESSION['num_login_fail'] == 4){
				if(time() - $_SESSION['last_login_time'] < 10*60 ){    
					//$_SESSION['msg']="Hacking Suspect Please wait for 10 minutes Then Try again .";
					$rett['sts']='error';
					$rett['mess']="Hacking Suspect Please wait for 10 minutes Then Try again .";
					die(json_encode($rett));
				}else{
					//after 10 minutes
					 $_SESSION['num_login_fail'] = 0;
				}
			}      
		}
			  
		if($_SESSION['num_login_fail']<4){
			require '../db/db.php';	
			$loginUserId=$mysqli->real_escape_string($_POST['user_id']);
			$password0=$mysqli->real_escape_string($_POST['password']);
			$loginPassword=md5($password0);	
			$stmt = $mysqli->prepare("SELECT user, password FROM member where user=? and password=? ");
			$stmt->bind_param('ss', $loginUserId, $loginPassword);
			$result = $stmt->execute();
			$stmt->store_result();
			$count=$stmt->num_rows;	

			if($count==1){
				$result=$mysqli->query("select user, password, active from member where user='".$loginUserId."' and password='".$loginPassword."'");
				$row=$result->fetch_array();
				$check= mysqli_num_rows($result);	
				$result->close();	
				$id=$row['user'];
				$active=$row['active'];
					
				function getRealIpAddr(){
					if(!empty($_SERVER['HTTP_CLIENT_IP'])){$ip=$_SERVER['HTTP_CLIENT_IP'];}
					elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];}
					else{$ip=$_SERVER['REMOTE_ADDR'];}
					return $ip;
				}
				
				$xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=".getRealIpAddr());
				$location = "Bangladesh";
				$mysqli->query("DELETE FROM `hacker` WHERE `date`<(NOW()-INTERVAL 10 DAY)");
						
				if(($check==0)||($active==0)){
					$_SESSION['num_login_fail'] ++;
					$_SESSION['last_login_time'] = time();	
					$mysqli->query("INSERT INTO `hacker`(`user`, `password`, `ip`, `level`, `location`, `status`) VALUES ('".$loginUserId."','".$loginPassword."','".$ip."','".$type."','".$location."','".Fail."')");			 	 
					//$_SESSION['msg']="Invalid User Name or Password";
					$rett['sts']='error';
					$rett['mess']="Invalid User Name or Password !!!";
					die(json_encode($rett));
				}  
				  
				if(($check==1)&&($active==1)){
					//echo "<script>javascript:history.back()</script>";
					//echo "<script>javascript:history.back()</script>";
					//die();
					$_SESSION['roboMember'] = strtolower($id); 	
					session_write_close();
					$mysqli->query("INSERT INTO `hacker`(`user`, `password`, `ip`, `level`, `location`, `status`) VALUES ('".$loginUserId."','".$loginPassword."','".$ip."','".$type."','".$location."','".Success."')");			
				
					$rett['sts']='success';
					$rett['url']='/member/index.php';
					$rett['mess']="Login Approved, Redirect To Member Panel";
					die(json_encode($rett));
					
				}else{
					$_SESSION['num_login_fail'] ++;
					$_SESSION['last_login_time'] = time();	
					$mysqli->query("INSERT INTO `hacker`(`user`, `password`, `ip`, `level`, `location`, `status`) VALUES ('".$loginUserId."','".$loginPassword."','".$ip."','".$type."','".$location."','".Fail."')");				
					//$_SESSION['msg']="Invalid User Name or Password !!!";
					$rett['sts']='error';
					$rett['mess']="Invalid User Name or Password !!!";
					die(json_encode($rett));
				}
			}else{
				$_SESSION['num_login_fail'] ++;
				$_SESSION['last_login_time'] = time();	
				$mysqli->query("INSERT INTO `hacker`(`user`, `password`, `ip`, `level`, `location`, `status`) VALUES ('".$loginUserId."','".$loginPassword."','".$ip."','".$type."','".$location."','".Fail."')");				
				//$_SESSION['msg']="Invalid User Name or Password !!!";
				$rett['sts']='error';
				$rett['mess']="Invalid User Name or Password !!!";
				die(json_encode($rett));
				
			}	
		
		}
	}else{
		$rett['sts']='error';
		$rett['resd']=1;
		$rett['mess']="Invalid Captcha Or Session Expire, Try aggain";
		die(json_encode($rett));
	}
	

?>