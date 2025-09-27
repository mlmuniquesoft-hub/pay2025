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
		$packFF=explode("/", base64_decode($_GET['packs']));
		
		$Membv=$mysqli->query("SELECT * FROM `member` WHERE `user`='".$user."'");
		$Cher=mysqli_num_rows($Membv);
		if($Cher>0){
			$InfoMemm=mysqli_fetch_assoc($Membv);
			$cHECKpAK=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `product` WHERE `serial`='".$packFF[1]."'"));
			$dfgKKj=remainAmn($user);
			$jkhfskjd=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) as tyool FROM `upgrade` WHERE `user`='".$user."'"));
			$Chrge=$cHECKpAK['price'] * 0.30;
			if($Chrge>$dfgKKj){
				$rett['sts']=1;
				$rett['mess']="Success";
				$rett['url']="index.php?route=deposit&tild=".base64_encode(time())."&title=&amount=".$cHECKpAK['price']."&paccg=".base64_encode(time()."/NZProduct".$cHECKpAK['price']."/".$cHECKpAK['serial']);
				die(json_encode($rett));
			}else{
				$rett['sts']=1;
				$rett['mess']="Success";
				$rett['url']="index.php?route=product_details&tild=".base64_encode(time())."&title=&paccg=".base64_encode(time()."/NZProduct".$cHECKpAK['price']."/".$cHECKpAK['serial']);
				die(json_encode($rett));
			}
			
			
		}else{
			$rett['sts']=0;
			$rett['mess']="Invalid User ID";
			die(json_encode($rett));
		}
		//echo json_encode($rett);
		
	}

?>