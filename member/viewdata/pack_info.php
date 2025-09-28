<?php
	 session_start(); 
    if(!isset($_SESSION['roboMember'])){
    	header("Location:logout.php");
    	exit();
    }else{
		require '../../db/db.php';
		require '../../db/functions.php';
		$rett=array();
		$user=$_SESSION['roboMember'];
		$packFF=explode("/", base64_decode($_POST['packs']));
		$Membv=$mysqli->query("SELECT * FROM `member` WHERE `user`='".$user."'");
		$Cher=mysqli_num_rows($Membv);
		if($Cher>0){
			$InfoMemm=mysqli_fetch_assoc($Membv);
			if($InfoMemm['pack']>=$packFF[1]){
				$rett['sts']=0;
				$rett['mess']="Your Recent Robo Plan Better Than This Plan";
				die(json_encode($rett));
			}else{
				$cHECKpAK=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `package` WHERE `serial`='".$packFF[1]."'"));
				$dfgKKj=remainAmn($user);
				$jkhfskjd=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) as tyool FROM `upgrade` WHERE `user`='".$user."'"));
				$membershipFee = 10; // $10 membership fee for every upgrade
				$totalUpgradeCost = $cHECKpAK['pack_amn'] + $membershipFee;
				$Chrge=$totalUpgradeCost-$jkhfskjd['tyool'];
				if($Chrge>$dfgKKj){
					$rett['sts']=1;
					$rett['mess']="Success - Package: $".$cHECKpAK['pack_amn']." + $10 Membership Fee = $".$totalUpgradeCost;
					$rett['url']="index.php?route=deposit&tild=".base64_encode(time())."&title=&amount=".$totalUpgradeCost."&paccg=".base64_encode(time()."/DBOT".$cHECKpAK['pack_amn']."/".$cHECKpAK['serial']."/MF10");
					die(json_encode($rett));
				}else{
					$rett['sts']=1;
					$rett['mess']="Success - Package: $".$cHECKpAK['pack_amn']." + $10 Membership Fee = $".$totalUpgradeCost;
					$rett['url']="index.php?route=activation_details&tild=".base64_encode(time())."&title=&paccg=".base64_encode(time()."/DBOT".$cHECKpAK['pack_amn']."/".$cHECKpAK['serial']."/MF10");
					die(json_encode($rett));
				}
			}
			
		}else{
			$rett['sts']=0;
			$rett['mess']="Invalid User ID";
			die(json_encode($rett));
		}
		//echo json_encode($rett);
		
	}

?>