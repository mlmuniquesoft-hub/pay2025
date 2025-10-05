<?php
	session_start(); 
	if(!isset($_SESSION['Admin'])){
		header("Location:logout.php");
		exit();
	}else{
		require '../db/db.php';
		$chhg=1;
		//var_dump($_FILES);
		//die();
		$offname=$_POST["offname"];
		$dessc=$_POST["dessc"];
		$location=$_POST["location"];
		$ggfd=$_FILES['offerImg']['name'];
		$temp_name=$_FILES['offerImg']['tmp_name'];
		if($offname==""){
			$chhg=0;
			$_SESSION['msg']="Please Submit Offer Name";
			header("Location:$location");
			exit;
		}
		if($dessc==""){
			$chhg=0;
			$_SESSION['msg']="Please Submit Offer Description";
			header("Location:$location");
			exit;
		}
		if($ggfd==""){
			$chhg=0;
			$_SESSION['msg']="Please Submit Offer Image";
			header("Location:$location");
			exit;
		}
		
		$validType=array("jpg","JPG", "jpeg","JPEG", "GIF","gif", "png", "PNG");
		$imgTyppo=explode("/", $_FILES['offerImg']['type']);
		if(!in_array($imgTyppo[1], $validType)){
			$chhg=0;
			$hgfj=implode(" OR ", $validType);
			$_SESSION['msg']="Please Submit Valid Image Type ( $hgfj )";
			header("Location:$location");
			exit;
		}
		$imghname=time()."jpg";

		if($chhg==1){
			$mysqli->query("INSERT INTO `offer`( `title`, `dessc`, `imggs`) VALUES ('".$offname."','".$dessc."','".$imghname."')");
			move_uploaded_file($temp_name,"../member/img/".$imghname);
			$_SESSION['msg1']="Offer Create Successfully";
			header("Location:$location");
			exit;
		}else{
			$_SESSION['msg']="Notice Changed Successfully";
			header("Location:$location");
			exit;
		}

	}
?>