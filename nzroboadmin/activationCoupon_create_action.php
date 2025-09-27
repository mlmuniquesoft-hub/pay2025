<?php
	session_start();
	if(($_SESSION['Admin']=='')||(!isset($_SESSION['Admin']))){
    	header("Location:logout.php");
    	exit();
    }else{
		require '../db/db.php';
		require '../db/functions.php';
		
		$pinQQ=$_POST['pinQQ'];
		$pin=$_POST['trPass'];
		$pack=$_POST['pack'];
		
		$gamess=$_POST['gamess'];
		$pinfor=$_POST['pinfor'];
		$ReffAmn=$_POST['ReffAmn'];
		$refCond=$_POST['refCond'];
		$rankpin=$_POST['rankpin'];
		
		$pinamount=$_POST['pinQQ'];
		$useer=$_POST['uufffd'];
		//$pinfor=0;//$_POST['pinfor'];
		
		$depoamn=$_POST['depoamn'];
		$payAcc=$_POST['payAcc'];
		$location=$_POST['location'];
		$chekk=1;
		
		if($pinQQ==''){
			$chekk=0;
			$_SESSION['msg']="Please Insert Pin Amount";
			header("Location: $location");
			exit();
		}
		
		if(empty($pin)){
			$chekk=0;
			$_SESSION['msg']="Please Insert Your Transaction Pin";
			header("Location: $location");
			exit();
		}
		if($pinfor==0){
			
			if($pack==""){
				$_SESSION['msg']="Please Select Pack";
				header("Location: $location");
				exit();
				die();
			}
			$mmkl=$mysqli->query("SELECT * FROM `package` WHERE `serial`='".$pack."' ");
			$CheckPack=mysqli_num_rows($mmkl);
			if($CheckPack<1){
				$_SESSION['msg']="Invalid Package";
				header("Location: $location");
				exit();
				die();
			}
		}elseif($pinfor==1){
			if($gamess==""){
				$_SESSION['msg']="Please Select Game Type";
				header("Location: $location");
				exit();
				die();
			}
			$gamepack=$pack;
			$pack=$gamess;
			$mmkl=$mysqli->query("SELECT * FROM `gamesetup` WHERE `serial`='".$pack."' ");
			$CheckPack=mysqli_num_rows($mmkl);
			if($CheckPack<1){
				$_SESSION['msg']="Invalid Game Type";
				header("Location: $location");
				exit();
				die();
			}
		}
		
		
		
		$gghh=mysqli_num_rows($mysqli->query("SELECT * FROM `admin` WHERE `user_id`='".$_SESSION['Admin']."' AND `tr_password`='".$pin."'"));
		if($gghh<1){
			$chekk=0;
			$_SESSION['msg']="Please Insert Your Correct Transaction Pin";
			header("Location: $location");
			exit();
		}
		if($chekk==1){
			settype($pinamount, "integer");
			if($pinamount<=1){
				$pinr=1;
			}else{
				$pinr=$pinamount;
			}
			if($useer==""){
				$seell=0;
			}else{
				$seell=0;
				$mmnn=mysqli_num_rows($mysqli->query("SELECT `user_id` FROM `agent` WHERE `user_id`='".$useer."'"));
				if($mmnn<1){
					$_SESSION['msg']="Invalid Exchanger ID";
					header("Location: $location");
					exit();
				}
			}
			
			for($i=1;$i<=$pinr; $i++){
				usleep(30);
				$tt=bin2hex(time());
				$rr=str_shuffle(substr($tt, -8));
				$invoiced=base64_encode($rr);
				$mysqli->query("INSERT INTO `invoice_req`( `create_by`,`invoice_num`, `pack`,`rank_active`,`depoamn`, `sell`, `user`, `pin_for`,`specPin`,`payAcc`,`gamepack`,`ref_con`,`ref_amn`) VALUES ('".$useer."','".$invoiced."','".$pack."','".$rankpin."','".$depoamn."','".$seell."','','".$pinfor."','1','".$payAcc."','".$gamepack."','".$refCond."','".$ReffAmn."')");
			
				//echo "INSERT INTO `invoice_req`( `create_by`,`invoice_num`, `pack`,`rank_active`,`depoamn`, `sell`, `user`, `pin_for`,`specPin`) VALUES ('".$useer."','".$invoiced."','".$pack."','1','".$depoamn."','".$seell."','','0','1')";
				//die();				
				if($useer!=""){
					//$hhgff=mysqli_fetch_assoc($mysqli->query("SELECT MAX(serial) AS ghh FROM `invoice_req` WHERE `create_by`='".$memberid."'"));
					//$mysqli->query("INSERT INTO `pin_tranreciv`( `user_trans`, `user_reciv`, `pinser`) VALUES ('".$memberid."','".$useer."','".$hhgff['ghh']."')");
				}
			}
			$_SESSION['msg']="Your  Pin ($pinQQ) Create Successfull";
			header("Location: $location");
			exit();
		}else{
			$_SESSION['msg']="Your Connection Not Secure Try Latter";
			header("Location: $location");
			exit();
		}
		
		
	}
?>