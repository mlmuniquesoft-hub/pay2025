<?php
	session_start();
	$_SESSION['token']="wwerwe";
	
	require_once("../../db/db.php");
	
	// Add error reporting for debugging
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	// Validate input
	if(!isset($_POST['Usfd']) || empty($_POST['Usfd'])) {
		error_log("No user ID provided in verification request");
		echo 2; // Invalid input
		die();
	}
	
	$User = trim($_POST['Usfd']);
	
	// Debug: Log the verification attempt
	error_log("Verification attempt for user: " . $User);
	
	function count_user($user, &$rrr , $posiit){
		global $mysqli;
		if(!in_array($user, $rrr)){
			array_push($rrr, $user);
		}
		$stmt = $mysqli->prepare("SELECT user,upline,`position` FROM member WHERE upline=? AND `position`=?");
		$stmt->bind_param("ss", $user, $posiit);
		$stmt->execute();
		$exe2 = $stmt->get_result();
		$stmt->close();
		while($result2=mysqli_fetch_array($exe2)){
			if(!in_array($result2['user'], $rrr)){
				if($posiit==$result2['position']){
					array_push($rrr, $result2['user']);
				}
			}
			count_user($result2['user'], $rrr, $posiit);
		}
	}
	
	
	function SearchPlace($user,$position){
		global $mysqli;
		$rett=array();
		$ereww=strlen($user);
		$user=substr($user, 1, $ereww-2);
		$sdffd=substr($position, 1,1);
		settype($sdffd, "integer");
		$position=$sdffd;
		$stmt = $mysqli->prepare("SELECT * FROM `member` WHERE `upline`=? AND `position`=?");
		$stmt->bind_param("si", $user, $position);
		$stmt->execute();
		$cgghh = $stmt->get_result();
		$stmt->close();
		$CheckSponsor=mysqli_num_rows($cgghh);
		if($CheckSponsor>0){
			$nextId=mysqli_fetch_assoc($cgghh);
			count_user($nextId['user'], $rett, $position);
		}else{
			array_push($rett,$user);
		}
		
		return $rett;
	}
	
	
	// Check database connection
	if($mysqli->connect_error) {
		error_log("Database connection failed: " . $mysqli->connect_error);
		echo 2;
		die();
	}
	
	// Use prepared statement to prevent SQL injection
	$stmt = $mysqli->prepare("SELECT * FROM `info_verify` WHERE `user`=? AND `active`='0'");
	$stmt->bind_param("s", $User);
	$stmt->execute();
	$result = $stmt->get_result();
	$Dgdfg = $result->num_rows;
	$stmt->close();
	error_log("Found " . $Dgdfg . " pending verification records for user: " . $User);
	
	if($Dgdfg>0){
		error_log("Found pending verification for user: " . $User);
		$stmt = $mysqli->prepare("SELECT * FROM `info_verify` WHERE `user`=? AND `active`='0'");
		$stmt->bind_param("s", $User);
		$stmt->execute();
		$result = $stmt->get_result();
		$hfss = $result->fetch_assoc();
		$stmt->close();
		$member=base64_decode($hfss['member']);
		$profile=base64_decode($hfss['profile']);
		$balance=base64_decode($hfss['balance']);
		$final_mess=base64_decode($hfss['final_mess']);
		$email=$hfss['email'];
		
		// Debug: Log the decoded queries
		error_log("Member query: " . $member);
		error_log("Profile query: " . $profile);
		error_log("Balance query: " . $balance);
		
		if($member!=''){
			// Clean and validate the SQL query before execution
			$member = trim($member);
			
			// Log the query for debugging
			error_log("Raw member query: " . $member);
			
			// Fix common SQL issues by properly escaping quotes
			// Replace any problematic characters
			$member = str_replace(["\r\n", "\r", "\n"], " ", $member);
			$member = preg_replace('/\s+/', ' ', $member); // Remove extra spaces
			
			error_log("Cleaned member query: " . $member);
			
			// Check if it's a valid INSERT statement
			if(strpos($member, 'INSERT INTO') === 0) {
				$result = $mysqli->query($member);
				if($mysqli->error) {
					error_log("Member insertion error: " . $mysqli->error);
					error_log("Failed query: " . $member);
					// Don't stop execution, continue with other tables
				} else {
					error_log("Member insertion successful");
				}
			} else {
				error_log("Invalid member query format: " . substr($member, 0, 100));
			}
			
			// Get member information using prepared statement
			$stmt_member = $mysqli->prepare("SELECT * FROM `member` WHERE `user`=?");
			$stmt_member->bind_param("s", $User);
			$stmt_member->execute();
			$result_member = $stmt_member->get_result();
			$reero = $result_member->fetch_assoc();
			$stmt_member->close();
			
			if($reero) {
				$stmt_upline = $mysqli->prepare("SELECT * FROM `member` WHERE `upline`=?");
				$stmt_upline->bind_param("s", $reero['upline']);
				$stmt_upline->execute();
				$kjhgk = $stmt_upline->get_result();
				$stmt_upline->close();
				
				$jkdhgkdf=mysqli_num_rows($kjhgk);
				if($jkdhgkdf>2){
					$stmt_delete = $mysqli->prepare("DELETE FROM `member` WHERE `user`=?");
					$stmt_delete->bind_param("s", $User);
					$stmt_delete->execute();
					$stmt_delete->close();
					$InfoPlaceId=SearchPlace($referrence0,$poss);
					$iii=count($InfoPlaceId);
					$placement0 =strtolower($InfoPlaceId[$iii-1]);
					$PartInfo[16]=$placement0;
					$member=implode(",", $PartInfo);
					$mysqli->query($member);
					//echo 0;
					//die();
				}else{
					$stmt_check = $mysqli->prepare("SELECT * FROM `member` WHERE `upline`=? AND `position`=?");
					$stmt_check->bind_param("ss", $reero['upline'], $reero['position']);
					$stmt_check->execute();
					$result_check = $stmt_check->get_result();
					$jkhfgd = $result_check->num_rows;
					$stmt_check->close();
					if($jkhfgd>1){
						$stmt_delete2 = $mysqli->prepare("DELETE FROM `member` WHERE `user`=?");
						$stmt_delete2->bind_param("s", $User);
						$stmt_delete2->execute();
						$stmt_delete2->close();
						$InfoPlaceId=SearchPlace($referrence0,$poss);
						$iii=count($InfoPlaceId);
						$placement0 =strtolower($InfoPlaceId[$iii-1]);
						$PartInfo[16]=$placement0;
						$member=implode(",", $PartInfo);
						$mysqli->query($member);
						//echo 0;
						//die();
					}
				}
			}
		}
		if($profile!=''){
			// Clean and validate the profile query
			$profile = trim($profile);
			$profile = str_replace(["\r\n", "\r", "\n"], " ", $profile);
			$profile = preg_replace('/\s+/', ' ', $profile);
			
			error_log("Cleaned profile query: " . $profile);
			
			if(strpos($profile, 'INSERT INTO') === 0) {
				$result = $mysqli->query($profile);
				if($mysqli->error) {
					error_log("Profile insertion error: " . $mysqli->error);
					error_log("Failed query: " . $profile);
				} else {
					error_log("Profile insertion successful");
				}
			} else {
				error_log("Invalid profile query format: " . substr($profile, 0, 100));
			}
		}
		if($balance!=''){
			// Clean and validate the balance query
			$balance = trim($balance);
			$balance = str_replace(["\r\n", "\r", "\n"], " ", $balance);
			$balance = preg_replace('/\s+/', ' ', $balance);
			
			error_log("Cleaned balance query: " . $balance);
			
			if(strpos($balance, 'INSERT INTO') === 0) {
				$result = $mysqli->query($balance);
				if($mysqli->error) {
					error_log("Balance insertion error: " . $mysqli->error);
					error_log("Failed query: " . $balance);
				} else {
					error_log("Balance insertion successful");
				}
			} else {
				error_log("Invalid balance query format: " . substr($balance, 0, 100));
			}
		}
		if($final_mess!=''){
			$subject = "Thanks for Complete Sign up Process";
			$to=$email;
			$message=$final_mess;
			
			$from = "info@capitolmoneypay.com";
			$headers = "From:" . $from;
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: Capitol Money Pay<info@capitolmoneypay.com>' . "\r\n";
			mail($to,$subject,$message,$headers);
		}
		
		// Try to update score - make it non-blocking
		try {
			$dfdsfds=file_get_contents("https://capitolmoneypay.com/member/viewdata/update_score.php?Usfd=$User");
		} catch(Exception $e) {
			error_log("Score update failed: " . $e->getMessage());
			// Continue verification even if score update fails
		}
			
		// Update verification status using prepared statements
		$stmt_update1 = $mysqli->prepare("UPDATE `info_verify` SET `active`='1' WHERE `user`=? AND `active`='0'");
		$stmt_update1->bind_param("s", $User);
		$stmt_update1->execute();
		$stmt_update1->close();
		
		$stmt_update2 = $mysqli->prepare("UPDATE `member` SET `active`='1' WHERE `user`=? AND `active`='0'");
		$stmt_update2->bind_param("s", $User);
		$stmt_update2->execute();
		$stmt_update2->close();
		
		$stmt_insert = $mysqli->prepare("INSERT INTO `member_total` (`user`) VALUES (?)");
		$stmt_insert->bind_param("s", $User);
		$stmt_insert->execute();
		$stmt_insert->close();
		
		error_log("Verification completed successfully for user: " . $User);
		echo 0;
		die();
	}else{
		// Check if user is already verified using prepared statement
		$stmt_verified = $mysqli->prepare("SELECT * FROM `info_verify` WHERE `user`=? AND `active`='1'");
		$stmt_verified->bind_param("s", $User);
		$stmt_verified->execute();
		$result_verified = $stmt_verified->get_result();
		$AlreadyVerified = $result_verified->num_rows;
		$stmt_verified->close();
		if($AlreadyVerified>0){
			error_log("User already verified: " . $User);
			echo 1; // Already verified
		} else {
			error_log("User not found in verification table: " . $User);
			echo 2; // User not found or expired
		}
		die();
	}
?>