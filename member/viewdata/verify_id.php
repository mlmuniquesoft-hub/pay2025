<?php
	session_start();
	$_SESSION['token']="wwerwe";
	
	require_once("../../db/db.php");
	
	// Add error reporting for debugging
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	$User=$_POST['Usfd'];
	
	// Debug: Log the verification attempt
	error_log("Verification attempt for user: " . $User);
	
	function count_user($user, &$rrr , $posiit){
		global $mysqli;
		if(!in_array($user, $rrr)){
			array_push($rrr, $user);
		}
		$exe2 = $mysqli->query("SELECT user,upline,`position` FROM member WHERE upline='".$user."' AND `position`='".$posiit."'");
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
	
	
	$Dgdfg=mysqli_num_rows($mysqli->query("SELECT * FROM `info_verify` WHERE `user`='".$User."' AND `active`='0'"));
	if($Dgdfg>0){
		error_log("Found pending verification for user: " . $User);
		$hfss=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `info_verify` WHERE `user`='".$User."' AND `active`='0'"));
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
			$PartInfo=explode(",", $member);
			$referrence0=trim($PartInfo[16]);
			$poss=trim($PartInfo[15]);
			
			$kjhgk=$mysqli->query("SELECT * FROM `member` WHERE `upline`='".$referrence0."'");
			$jkdhgkdf=mysqli_num_rows($kjhgk);
			if($jkdhgkdf>2){
				$InfoPlaceId=SearchPlace($referrence0,$poss);
				$iii=count($InfoPlaceId);
				$placement0 =strtolower($InfoPlaceId[$iii-1]);
				$PartInfo[16]=$placement0;
				$member=implode(",", $PartInfo);
			}
			
			
			$jkhfgd=mysqli_num_rows($mysqli->query("SELECT * FROM `member` WHERE `upline`='".$referrence0."' AND `position`='".$poss."'"));
			if($jkhfgd>1){
				$InfoPlaceId=SearchPlace($referrence0,$poss);
				$iii=count($InfoPlaceId);
				$placement0 =strtolower($InfoPlaceId[$iii-1]);
				$PartInfo[16]=$placement0;
				$member=implode(",", $PartInfo);
			}
			
			$mysqli->query($member);
			if($mysqli->error) {
				error_log("Member insertion error: " . $mysqli->error);
			}
			
			$reero=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `user`='".$User."'"));
			$kjhgk=$mysqli->query("SELECT * FROM `member` WHERE `upline`='".$reero['upline']."'");
			$jkdhgkdf=mysqli_num_rows($kjhgk);
			if($jkdhgkdf>2){
				$mysqli->query("DELETE FROM `member` WHERE `user`='".$User."'");
				$InfoPlaceId=SearchPlace($referrence0,$poss);
				$iii=count($InfoPlaceId);
				$placement0 =strtolower($InfoPlaceId[$iii-1]);
				$PartInfo[16]=$placement0;
				$member=implode(",", $PartInfo);
				$mysqli->query($member);
				//echo 0;
				//die();
			}else{
				$jkhfgd=mysqli_num_rows($mysqli->query("SELECT * FROM `member` WHERE `upline`='".$reero['upline']."' AND `position`='".$reero['position']."'"));
				if($jkhfgd>1){
					$mysqli->query("DELETE FROM `member` WHERE `user`='".$User."'");
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
		if($profile!=''){
			$mysqli->query($profile);
			if($mysqli->error) {
				error_log("Profile insertion error: " . $mysqli->error);
			}
		}
		if($balance!=''){
			$mysqli->query($balance);
			if($mysqli->error) {
				error_log("Balance insertion error: " . $mysqli->error);
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
			
		$mysqli->query("UPDATE `info_verify` SET `active`='1' WHERE `user`='".$User."' AND `active`='0' ");
		$mysqli->query("UPDATE `member` SET `active`='1' WHERE `user`='".$User."' AND `active`='0' ");
		$mysqli->query("INSERT INTO `member_total` (`user`) VALUES ('".$User."')");
		
		error_log("Verification completed successfully for user: " . $User);
		echo 0;
		die();
	}else{
		// Check if user is already verified
		$AlreadyVerified=mysqli_num_rows($mysqli->query("SELECT * FROM `info_verify` WHERE `user`='".$User."' AND `active`='1'"));
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