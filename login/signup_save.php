<?php
	session_start();
	$_SESSION['token']="sfhshd";
	require_once '../phpmailer/vendor/autoload.php';
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	
	// Set proper headers for JSON response
	header('Content-Type: application/json');
	
	$rett=array();
	
try {
	// Validate required POST data
	if(!isset($_POST['capths']) || empty($_POST['capths'])) {
		$rett['sts']='error';
		$rett['mess']='Captcha verification required';
		$rett['debug'] = 'POST data: ' . print_r($_POST, true);
		die(json_encode($rett));
	}
	
	$capths=$_POST['capths'];
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,
				"secret=6LfIeNgrAAAAABj3CFi_jvkeNu3Wh8cz0nW9vIVr&response=$capths");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec($ch);
	curl_close ($ch);
	$fdgdf=json_decode($server_output);
	
	// Debug captcha response
	if(!$fdgdf || !property_exists($fdgdf, 'success')) {
		$rett['sts']='error';
		$rett['mess']='Captcha verification failed - invalid response';
		$rett['debug'] = 'Captcha response: ' . $server_output;
		die(json_encode($rett));
	}
	
	if($fdgdf->success){
		if(!isset($_SESSION['token'])){
			$rett['sts']='error';
			$rett['mess']='Try Later';
			die(json_encode($rett));
		}else{  	
			require '../db/db.php';
			
			function count_user($user, &$rrr , $posiit){
				global $mysqli;
				if(!in_array($user, $rrr)){
					array_push($rrr, $user);
				}
				$exe2 = $mysqli->query("SELECT user,upline,`position` FROM member WHERE upline='".$user."' AND `position`='".$posiit."'");
				while($result2=mysqli_fetch_array($exe2)){
					if(!in_array($result2['user'], $rrr)){
						if($posiit==$result2['position']){
							//echo $result2['user'] ."<br/>";
							array_push($rrr, $result2['user']);
						}
					}
					count_user($result2['user'], $rrr, $posiit);
				}
			}
			function SearchPlace($user,$position){
				global $mysqli;
				$rett=array();
				$cgghh=$mysqli->query("SELECT * FROM `member` WHERE `upline`='".$user."' AND `position`='".$position."'");
				$CheckSponsor=mysqli_num_rows($cgghh);
				if($CheckSponsor>0){
					$nextId=mysqli_fetch_assoc($cgghh);
					count_user($nextId['user'], $rett, $position);
				}else{
					array_push($rett,$user);
				}
				
				return $rett;
			}
			
			// Validate and sanitize form inputs
			if(!isset($_POST['sponsor_id']) || !isset($_POST['poss']) || !isset($_POST['log_id']) || 
			   !isset($_POST['full_name']) || !isset($_POST['email']) || !isset($_POST['password']) || 
			   !isset($_POST['re_password']) || !isset($_POST['Password_tr'])) {
				$rett['sts']='error';
				$rett['mess']='All required fields must be filled';
				die(json_encode($rett));
			}
			
			$country0 = isset($_POST['country']) ? $_POST['country'] : '';
			$referrenceabc = trim($_POST['sponsor_id']);
			$referrence0 = mb_convert_case($referrenceabc, MB_CASE_LOWER, "UTF-8");
			$poss = $_POST['poss'];	
			$InfoPlaceId=SearchPlace($referrence0,$poss);
			$iii=count($InfoPlaceId);
			$placement0 =strtolower($InfoPlaceId[$iii-1]);
			
			$uplinkabc = $placement0;
			
			$uplink0 = mb_convert_case($uplinkabc, MB_CASE_LOWER, "UTF-8");
			$position_0001 = $poss;	
			//$user0 = str_shuffle(substr(time(),3)); 
			$user0 = $_POST['log_id'];		
			$name0 = $_POST['full_name'];		
			$Password0 = $_POST['password'];
			$Password_re0 = $_POST['re_password'];
			$Pin0 = $_POST['Password_tr'];
			$contact100 = $_POST['phone_number'];		
			$email0 = $_POST['email'];
				
			$digest0=md5($Password0);
			
			$date0=date("Y-m-d");
			
			
			$amount = 0;
			$didect= 0;
			$member_status = 0;
				
			$query="select user,pack from member where user ='$referrence0'";
			$result=$mysqli->query($query);
			$row = mysqli_fetch_array($result);
			$dirpack=$row['pack'];	
			$check = mysqli_num_rows($result);
			if(($referrence0=='user')||($referrence0=='')){
				$rett['sts']='error';
				$rett['mess']="Blank Reference User ID";
				die(json_encode($rett));
				
			}
			if($check==0){
				$rett['sts']='error';
				$rett['mess']="Invalid Reference User ID";
				die(json_encode($rett));
				
				
			}
			//die(json_encode($_POST));
			$account=0;
			if($account==0){
				$loguser00=str_shuffle(substr(time(),3));
				if (substr($contact100,0,4)=='+880'){$contact110=substr($contact100,4,15);}
				elseif (substr($contact100,0,3)=='880'){$contact110=substr($contact100,3,15);}
				elseif (substr($contact100,0,1)=='0'){$contact110=substr($contact100,1,15);}
				elseif (substr($contact100,0,1)=='1'){$contact110=substr($contact100,0,15);}
				
				$query10 = "select * from country where name='$country0'";
				$result10=$mysqli->query($query10);
				$row10 = mysqli_fetch_array($result10);	
				$mobile_code=$row10['calling_code'];
				$contact0="$mobile_code$contact110";	
				if($country0==''){
					$rett['sts']='error';
					$rett['mess']="Please Select a country";
					die(json_encode($rett));	
				}
				if($contact100==''){
					$rett['sts']='error';
					$rett['mess']="Please Provide Mobile Number";
					die(json_encode($rett));	
				}
				if($email0==''){
					$rett['sts']='error';
					$rett['mess']="Please Enter Your valid Email";
					die(json_encode($rett));
				}
				/*$mobilechk = $mysqli->query("SELECT * FROM `profile` WHERE mobile='".$contact0."'");
				$chk = mysqli_num_rows($mobilechk);
				if($chk>0){
					$_SESSION['msg']="This Number Is Already In Used";
					echo "<script>javascript:history.back()</script>";
					die();
				}*/
				
			}else{
				$sesuser=$_SESSION['winMember'];
				$mmmn=mysqli_fetch_assoc($mysqli->query("select * from `member` where `user`='".$sesuser."' "));
				$mmmn22=mysqli_fetch_assoc($mysqli->query("select * from `profile` where `user`='".$mmmn['log_user']."' "));
				$loguser00=$mmmn['log_user'];
				$email0=$mmmn22['email'];
			}
			
			$query1 = "select user from member where  user ='$uplink0' ";	
			$result1=$mysqli->query($query1);	
			$row1 = mysqli_fetch_array($result1);
			$check1 = mysqli_num_rows($result1);	
			if($uplink0==''){
				$rett['sts']='error';
				$rett['mess']="Blank Uplink/Placement User ID";
				die(json_encode($rett));
			}
			if($check1==0){
				$rett['sts']='error';
				$rett['mess']="Invalid Uplink/Placement User ID";
				die(json_encode($rett));
			}
			if($position_0001==''){
				$rett['sts']='error';
				$rett['mess']="Blank Placement";
				die(json_encode($rett));
			}
			$query2="SELECT user FROM member where user='$user0'";
			$result2=$mysqli->query($query2);
			$row2 = mysqli_fetch_array($result2);
			$check2 = mysqli_num_rows($result2);
			if($user0==''){
				$rett['sts']='error';
				$rett['mess']="Blank User ID";
				die(json_encode($rett));
			}	
			if($check2>0){
				$rett['sts']='error';
				$rett['mess']="Invalid User ID Already Exist";
				die(json_encode($rett));
			}
			
			$query3="SELECT position,upline FROM member WHERE  upline='$uplink0'";
			$result3=$mysqli->query($query3);
			$row3=mysqli_fetch_array($result3);
			$placement_po=$row3['position'];	
			$check3 = mysqli_num_rows($result3);
			if($position_0001==''){
				$rett['sts']='error';
				$rett['mess']="Blank Left/Right Position Please Select Anyone";
				die(json_encode($rett));
			}	
			if($check3==2){
				$rett['sts']='error';
				$rett['mess']="Both Position is Already Filled.Please choose another Uplink !!! $uplink0";
				die(json_encode($rett));
			}	
			if($placement_po==$position_0001){
				$rett['sts']='error';
				$rett['mess']="$position_0001 Position is Already Filled.Please choose another Position or Uplink !!!";
				die(json_encode($rett));
			}	
				
			$query4="select serial from member where user ='$referrence0'";
			$result4=$mysqli->query($query4);
			$row4 = mysqli_fetch_array($result4);	
			$query5 = "select serial from member where  user ='$uplink0'";
			$result5=$mysqli->query($query5);
			$row5= mysqli_fetch_array($result5);				
			if($row4 > $row5){
				$rett['sts']='error';
				$rett['mess']="Invalid Up-link/Reference User ID !!!";
				die(json_encode($rett));
			}						
			
			// Comprehensive form validation
			if(empty($name0)) {
				$rett['sts']='error';
				$rett['mess']="Full name is required";
				die(json_encode($rett));
			}
			
			if(!filter_var($email0, FILTER_VALIDATE_EMAIL)) {
				$rett['sts']='error';
				$rett['mess']="Invalid email format";
				die(json_encode($rett));
			}
			
			if($Password0!=$Password_re0){
				$rett['sts']='error';
				$rett['mess']="Both Password Doesn't Match";
				die(json_encode($rett));
			}
			
			$check_pass=strlen($Password0);
			$check_pin=strlen($Pin0);
			$ccvv=strlen($user0);
			if($ccvv<4){
				$rett['sts']='error';
				$rett['mess']="Enter At Least 4 Character User Name";
				die(json_encode($rett));
			}
			if($ccvv>10){
				$rett['sts']='error';
				$rett['mess']="Enter At 5-10 Character User Name";
				die(json_encode($rett));
			}
			
			$GHsdfs=explode(" ",$user0);
			if($GHsdfs[1]!=''){
				$rett['sts']='error';
				$rett['mess']="Space Not Allowed In User Name";
				die(json_encode($rett));
			}
			
			if($check_pass<=5){
				$rett['sts']='error';
				$rett['mess']="Enter At Least 6 Character Password";
				die(json_encode($rett));
			}
			if($check_pin<=3){
				$rett['sts']='error';
				$rett['mess']="Enter At Least 3 Character Pin";
				die(json_encode($rett));
			}
			
			// Check for email duplicates (allow admin emails to be reused)
			$PassMail=array("ashrafulislamw82@gmail.com",'sumonmti498@gmail.com');
			if(!in_array($email0,$PassMail)){
				$jkjfds=mysqli_num_rows($mysqli->query("SELECT * FROM `profile` WHERE `email`='".$email0."'"));
				if($jkjfds>=1){
					$rett['sts']='error';
					$rett['mess']="Email address already exists";
					die(json_encode($rett));
				}
			}
			
			
					
			

			$query16 = "SELECT `b_bank`, `b_branch`, `b_name`, `b_number`, `s_code`, `account_name`, `account_number` FROM `admin`";
			$bank_data = mysqli_fetch_array($mysqli->query($query16));
			$b_bank = $bank_data['b_bank'];
			$b_branch = $bank_data['b_branch'];
			$b_name = $bank_data['b_name'];
			$b_number = $bank_data['b_number'];
			$s_code = $bank_data['s_code'];
			$account_name = $bank_data['account_name'];
			$account_number = $bank_data['account_number'];
			$ticket=time();
									

			if(($check == 1)&&($check1 == 1)&&(($row4 < $row5)||($row4 == $row5))&&($check3<2)&&($check2 != 1)&&($row2 =='')&&($position_0001 !='')){
				$query = base64_encode("INSERT INTO `member`(`user`,`log_user`, `password`, `pin`, `position`, `upline`, `pack`,`point`, `direct`, `sponsor`, `date`,`active`)
						  VALUES('".$user0."','".$loguser00."','".$digest0."','".$Pin0."','".$position_0001."','".$uplink0."','".$member_status."','".$amount."','".$didect."','".$referrence0."','".$date0."','0')");
				//$mysqli->query($query);
				if($account==0){
					// Insert basic profile data with required fields only
					$query8 = base64_encode("INSERT INTO `profile`(`user`, `name`, `mobile`, `email`, `country`) 
								VALUES ('".$loguser00."','".$name0."','".$contact0."','".$email0."','".$country0."')");
					//$mysqli->query($query8);
				}
				
				$query10= base64_encode("INSERT INTO balance (user ) VALUES ('".$user0."')");
				//$mysqli->query($query10);	 
				$iuwery=time();
				$to = $email0;
				$subject = "Thanks for Sign up Process ";
				
				$user0=strtoupper($user0);
				include("mail.php");
				$Messdf=base64_encode($message2);
				$mysqli->query("INSERT INTO `info_verify`( `user`, `member`, `profile`, `balance`, `final_mess`, `email`) VALUES ('".$user0."','".$query."','".$query8."','".$query10."','".$Messdf."','".$email0."')");
				include("mail2.php");
				$message=$message;
				$from = "info@capitolmoneypay.com";
				
				/*$headers = "From:" . $from;
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= "From: Capitol Money Pay <info@capitolmoneypay.com>" . "\r\n";
				mail($to,$subject,$message,$headers);
				*/
				
				$mail = new PHPMailer;
				$mail->isSMTP();
				//$mail->SMTPDebug = 3; 
				$mail->CharSet  = 'UTF-8';
				$mail->Host = 'localhost';
				$mail->Port = 25;
				$mail->SMTPSecure = 'tls'; 
				$mail->SMTPOptions = array(
				   'ssl' => array(
				   'verify_peer' => false,
				   'verify_peer_name' => false,
				   'allow_self_signed' => true
				  )
				);
				$mail->SMTPAuth = true;
				$mail->Username = $from;
				$mail->Password = 'Mm123678@#';
				$mail->setFrom($from, 'Capitol Money Pay');
				$mail->addAddress($to, $name0);
				$mail->Subject = $subject;
				$mail->msgHTML($message);
				
				// Store SMS notification
				if(isset($text)) {
					$mysqli->query("INSERT INTO `sms`(`user`, `mobile`, `text`) VALUES ('$user0','$contact0','$text')"); 
				}
				
				// Attempt to send email
				try {
					$mail->send();
					$rett['url']='#';
					$rett['sts']='success';
					$rett['mess']="Registration successful! Please verify your email address.";
					$rett['user_id'] = $user0;
					die(json_encode($rett));
				} catch (Exception $e) {
					// Even if email fails, registration was successful
					$rett['url']='#';
					$rett['sts']='success';
					$rett['mess']="Registration successful! Email verification may be delayed.";
					$rett['user_id'] = $user0;
					die(json_encode($rett));
				}
				
			}else{
				$rett['sts']='error';
				$rett['mess']="Registration failed. Please check your information and try again.";
				$rett['debug'] = "Validation failed: Check=".$check.", Check1=".$check1.", Check2=".$check2.", Check3=".$check3;
				die(json_encode($rett));
			}
		}
	}else{
		$rett['sts']='error';
		$rett['resd']=1;
		$rett['mess']="Invalid Captcha Or Session Expire, Try again";
		$rett['captcha_errors'] = isset($fdgdf->{'error-codes'}) ? $fdgdf->{'error-codes'} : [];
		die(json_encode($rett));
	}
	
} catch(Exception $e) {
	// Catch any uncaught exceptions
	$rett['sts']='error';
	$rett['mess']='Registration system error. Please try again.';
	$rett['debug'] = $e->getMessage();
	die(json_encode($rett));
} catch(Error $e) {
	// Catch any fatal errors
	$rett['sts']='error';
	$rett['mess']='System error occurred. Please try again.';
	$rett['debug'] = $e->getMessage();
	die(json_encode($rett));
}
?>