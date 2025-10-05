<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';
		$admin = $_SESSION['Admin'];
		if(isset($_GET['dts'])){
			$cons=$_GET['dts'];
			$mysqli=$$cons;
		}else{
			$mysqli=$mysqli;
		}
		if(isset($_GET['redf'])){
			$table="games";
			$hhjj=$_GET["rets"];
			$serial=$_GET["serd"];
			$iinn=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `$table` WHERE `serial`='".$serial."'"));
			$hhgg=explode("/",$iinn['criteria_amn']);
			$hhgg2=explode("/",$iinn['criteria_active']);
			
			unset($hhgg[$hhjj]);
			unset($hhgg2[$hhjj]);
			$uppp=implode("/", $hhgg);
			$uppp2=implode("/", $hhgg2);
			
			$query = "UPDATE `$table` SET `criteria_amn`='".$uppp."',`criteria_active`='".$uppp2."' WHERE `serial`='".$serial."'";
			$mysqli->query($query);
		}
		if(isset($_GET['werwe'])){
			$table="games";
			$vals=$_GET["vals"];
			$serial=$_GET["serd"];
			$cols=$_GET["cols"];
			$iinn=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `$table` WHERE `serial`='".$serial."'"));
			$hhgg=explode("/",$iinn[$cols]);
			$hhgg[count($hhgg)]=$vals;
			$uppp=implode("/", $hhgg);
			
			$query = "UPDATE `$table` SET `$cols`='".$uppp."' WHERE `serial`='".$serial."'";
			$mysqli->query($query);
		}
		if(isset($_GET['cvbd'])){
			$tds=$_GET["tds"];
			if($tds!=''){
				$table=$tds;
			}else{
				$table="games";
			}
			$vals=$_GET["rets"];
			$serial=$_GET["serd"];
			$cols=$_GET["cols"];
			$iinn=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `$table` WHERE `serial`='".$serial."'"));
			$hhgg=explode("/",$iinn[$cols]);
			if(in_array($vals,$hhgg)){
				$erter=array_search($vals,$hhgg);
				unset($hhgg[$erter]);
			}else{
				array_push($hhgg,$vals);
			}
			$uppp=implode("/", $hhgg);
			$query = "UPDATE `$table` SET `$cols`='".$uppp."' WHERE `serial`='".$serial."'";
			$mysqli->query($query);
		}
		
		
	}
?>