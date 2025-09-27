<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';
		$admin = $_SESSION['Admin'];
		$value=$_GET["vas"];
		$serial=$_GET["sers"];
		$clos=$_GET["coll"];
		$table=$_GET["tbs"];
		$rett=array();
		$CheckUser=mysqli_num_rows($mysqli->query("SELECT `serial` FROM `member` WHERE `user`='".$value."'"));
		if($CheckUser>0){
			$query = "UPDATE `$table` SET `$clos`='".$value."' WHERE `serial`='".$serial."'";
			$mysqli->query($query);
			array_push($rett, 1);
			array_push($rett, "Pin Send Success To $value");
			echo json_encode($rett);
			die();
		}else{
			array_push($rett, 0);
			array_push($rett, "Invalid User Id");
			echo json_encode($rett);
			die();
		}
		
	}
?>