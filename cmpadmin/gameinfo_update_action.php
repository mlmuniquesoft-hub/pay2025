<?php
    session_start(); 
	if((!isset($_SESSION['Admin']))&&(!isset($_SESSION['token']))){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';
		//var_dump($_GET);
		$dts=$_GET['dts'];
		$tabbs=$_GET['tbs'];
		$colls=$_GET['coll'];
		$sers=$_GET['sers'];
		$values=$mysqli->real_escape_string($_GET['vas']);
		if($values!=''){
			$myyu=$$dts;
			//var_dump($myyu);
			$myyu->query("UPDATE `$tabbs` SET `$colls`='".$values."' WHERE `serial`='".$sers."'");
			
		}
	}
?>