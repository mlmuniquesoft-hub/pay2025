<?php
	$user0=$_GET['dfgfd'];
	$rett=array();
	$ccvv=strlen($user0);
	if($ccvv<4){
		$rett['sts']='error';
		$rett['mess']="Enter At Least 4 Character User Name";
		die(json_encode($rett));
	}
	if($ccvv>10){
		$rett['sts']='error';
		$rett['mess']="Enter 5-10 Character User Name";
		die(json_encode($rett));
	}
	
	$GHsdfs=explode(" ",$user0);
	if($GHsdfs[1]!=''){
		$rett['sts']='error';
		$rett['mess']="Space Not Allowed In User Name";
		die(json_encode($rett));
	}
	$rett['sts']='success';
	$rett['mess']="";
	die(json_encode($rett));
?>