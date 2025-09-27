<?php
	session_start();
	$rett=array();
	if(isset($_SESSION['roboMember'])){
		if($_SESSION['roboMember']!=''){
			require_once("../../db/db.php");
			$user=$_SESSION['roboMember'];
			
			$CheckUser=$mysqli->query("SELECT * FROM `member` WHERE `user`='".$user."'");
			$validateUser=mysqli_num_rows($CheckUser);
			if($validateUser>0){
				$hdfd=$mysqli->query("SELECT * FROM `generate_btc` WHERE `user`='".$user."'");
				$Checksdf=mysqli_num_rows($hdfd);
				if($Checksdf<1){
					$baseUrl="https://coopcrowds.uk/merchant/4dff5870-0a2e-4321-8d66-df4138ba4ace/new_address?password=16DJkuF3SMTVCd519WycRF3zkjDoYoT5V1";
					//$baseUrl="https://coopcrowds.uk/merchant/4af66f06-5e90-4ef7-9d49-75067b9b384a/new_address?password=Mm123678@#mainur";
					$ere=json_decode(file_get_contents($baseUrl));
					$addREss=$ere->address;
					if($addREss!=''){
						$mysqli->query("INSERT INTO `generate_btc`( `user`, `btc_address`) VALUES ('".$user."','".$addREss."')");
						$rett['sts']=1;
						$rett['mess']="Send Deposit Amount";
						$rett['addr']=$addREss;
						die(json_encode($rett));
					}else{
						$rett['sts']=0;
						$rett['mess']="Try Later";
						$rett['addr']=$addREss;
						die(json_encode($rett));
					}
					
				}else{
					$inFoAds=mysqli_fetch_assoc($hdfd);
					$rett['sts']=1;
					$rett['mess']="Send Deposit Amount";
					$rett['addr']=$inFoAds['btc_address'];
					die(json_encode($rett));
				}
				
			}else{
				$rett['sts']=0;
				$rett['mess']="Connection Not Secure ";
				die(json_encode($rett));
			}
		}else{
			$rett['sts']=0;
			$rett['mess']="Connection Not Secure ";
			die(json_encode($rett));
		}
	}else{
		$rett['sts']=0;
		$rett['mess']="Connection Not Secure ";
		die(json_encode($rett));
	}

?>