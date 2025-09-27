<?php
	session_start();
	require_once '../db/db.php';
	require_once '../db/functions.php';
	$Accv=$_GET['Asd'];
	$receiveID=$_POST['receiveID'];
	$amount=$_POST['amount'];
	$TransCode=$_POST['TransCode'];
	$user=$_SESSION['roboMember'];

	$rett=array();
	
	
		
	if($receiveID==''){
		$rett['sts']=0;
		$rett['mess']="Submit Receiver ID";
		die(json_encode($rett));
	}
	if($amount==''){
		$rett['sts']=0;
		$rett['mess']="Submit Amount";
		die(json_encode($rett));
	}
	if($TransCode==''){
		$rett['sts']=0;
		$rett['mess']="Submit Transaction Code";
		die(json_encode($rett));
	}
	
	
	
	$kjhgd=$mysqli->query("SELECT * FROM `member` WHERE `user`='".$user."' AND `pin`='".$TransCode."'");
	//$rett['df']="SELECT * FROM `member` WHERE `user`='".$user."' AND `pin`='".$TransCode."'";
	$CheckUs=mysqli_num_rows($kjhgd);
	if($CheckUs>0){
		$CheckRecei=mysqli_num_rows($mysqli->query("SELECT * FROM `member` WHERE `user`='".$receiveID."'"));
		if($CheckRecei<1){
			$rett['sts']=0;
			$rett['mess']="Invalid Receiver ID";
			die(json_encode($rett));
		}
		

		$dfgKKj=remainAmn($user);
		if($amount>$dfgKKj){
			$rett['sts']=0;
			$rett['mess']="Insufficient Fund";
			die(json_encode($rett));
		}
		$user2=strtolower($user);
		$SkipUser=array("admin001","power001","kalroys");
		if(!in_array($user2, $SkipUser)){
			if($amount<50){
				$rett['sts']=0;
				$rett['mess']="Minimum Amount $50";
				die(json_encode($rett));
			}
			$BalanceSts=remainAmn22($user);
			$jhfdd=floor($BalanceSts['final']/50);
			$transable=$jhfdd*50;
			if($transable>$BalanceSts['final']){
				$transable=$BalanceSts['final']-50;
				if($transable<=0){
					$transable=0;
				}
			}
			$amount2=floor($amount/50);
			$amount=$amount2*50;
		}else{
			if($amount<10){
				$rett['sts']=0;
				$rett['mess']="Minimum Amount $10";
				die(json_encode($rett));
			}
			$transable=$amount;
			$amount=$amount;
		}
		
		
		if($amount>$transable){
			$rett['sts']=0;
			$rett['mess']="Insufficient Fund";
			die(json_encode($rett));
		}
		
		$Err=count($rett);
		if($Err==0){
			$tax=0;
			$date=date("Y-m-d");
			$mysqli->query("INSERT INTO trans_receive(user_trans,ammount,tax,date,user_receive,method,status,remark,type,account) VALUES ('".$user."','".$amount."','".$tax."','".$date."','".$receiveID."','Transter','Complete','".$remark."','Transfer','Member')");
			$description="$$amount Transfer To $receiveID";
			$mysqli->query("INSERT INTO `view`(`user`, `date`, `description`, `amount`, `types`) VALUES ('".$user."', '".$date."', '".$description."', '".$amount."','debit')");
			$_SESSION['msg1'] = "Fund Transfer Successful";
			$rett['sts']=1;
			$rett['mess']="Fund Transfer Successful";
			die(json_encode($rett));
		}else{
			$rett['sts']=0;
			$rett['mess']="Try Later!!";
			die(json_encode($rett));
		}
	}else{
		$rett['sts']=0;
		$rett['mess']="Invalid Transaction Code";
		die(json_encode($rett));
	}

?>