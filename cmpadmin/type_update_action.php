<?php
    session_start(); 
	if((!isset($_SESSION['Admin']))&&(!isset($_SESSION['token']))){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';
		$column=$_GET["column"];
		$serial=$_GET["serial"];
		$value=$mysqli->real_escape_string($_GET["value"]);
		$dts=$_GET["dts"];
		if($value!=''){
			$mysqli4=$$dts;
			//echo "UPDATE `gametype` SET `$column`='".$value."' WHERE `serial`='".$serial."'";
			$mysqli4->query("UPDATE `gametype` SET `$column`='".$value."' WHERE `serial`='".$serial."'");
		}
		
	}
?>