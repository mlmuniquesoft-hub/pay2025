<?php
	session_start();
	$_SESSION['token']="wwerwe";
	
	require_once("../../db/db.php");
	$User=$_POST['Usfd'];
	
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
		$hfss=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `info_verify` WHERE `user`='".$User."' AND `active`='0'"));
		$member=base64_decode($hfss['member']);
		$profile=base64_decode($hfss['profile']);
		$balance=base64_decode($hfss['balance']);
		$final_mess=base64_decode($hfss['final_mess']);
		$email=$hfss['email'];
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
		}
		if($balance!=''){
			$mysqli->query($balance);
		}
		if($final_mess!=''){
			$subject = "Thanks for Complete Sign up Process";
			$to=$email;
			$message=$final_mess;
			
			$from = "info@nzrobotrade.com";
			$headers = "From:" . $from;
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: NZ Robo Trade<info@nzrobotrade.com>' . "\r\n";
			mail($to,$subject,$message,$headers);
		}
		$dfdsfds=file_get_contents("https://nzrobotrade.com/member/viewdata/update_score.php?Usfd=$User");
			
		$mysqli->query("UPDATE `info_verify` SET `active`='1' WHERE `user`='".$User."' AND `active`='0' ");
		$mysqli->query("UPDATE `member` SET `active`='1' WHERE `user`='".$User."' AND `active`='0' ");
		$mysqli->query("INSERT INTO `member_total` (`user`) VALUES ('".$User."')");
		echo 0;
		die();
	}else{
		echo 1;
		die();
	}
?>