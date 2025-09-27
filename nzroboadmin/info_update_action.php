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
		$dts=$_GET["dts"];
		if($dts!=''){
			$conn=$$dts;
			if(isset($_GET["retur"])){
				$hhjj=$_GET["retur"];
				$iinn=mysqli_fetch_assoc($conn->query("SELECT * FROM `$table` WHERE `serial`='".$serial."'"));
				$hhgg=explode("/",$iinn[$clos]);
				$hhgg[$hhjj]=$value;
				$uppp=implode("/", $hhgg);
				$query = "UPDATE `$table` SET `$clos`='".$uppp."' WHERE `serial`='".$serial."'";
				$conn->query($query);
			}elseif(isset($_GET['game'])){
				$game=$_GET['game'];
				$iinn=mysqli_fetch_assoc($conn->query("SELECT * FROM `$table` WHERE `serial`='".$serial."'"));
				$hhgg=explode("/",$iinn['criteria_active']);
				$fddd=$hhgg[$value];
				if($iinn['criteria_inactive']!=''){
					$hhgg2=explode("/",$iinn['criteria_inactive']);
				}else{
					$hhgg2=array();
				}
				
				if($game=="out"){
					if(!in_array($fddd, $hhgg2)){
						array_push($hhgg2, $fddd);
					}
				}else{
					if(in_array($fddd, $hhgg2)){
						$rrr=array_search($fddd, $hhgg2);
						unset($hhgg2[$rrr]);
					}
					
				}
				$gff=implode("/", $hhgg2);
				$query = "UPDATE `$table` SET `$clos`='".$gff."' WHERE `serial`='".$serial."'";
				echo $query;
				$conn->query($query);
			}else{
				$query = "UPDATE `$table` SET `$clos`='".$value."' WHERE `serial`='".$serial."'";
				$conn->query($query);
				echo $query;
				var_dump($conn);
				die();
			}
			
		}
		if(isset($_GET["retur"])){
			$hhjj=$_GET["retur"];
			$iinn=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `$table` WHERE `serial`='".$serial."'"));
			$hhgg=explode("/",$iinn[$clos]);
			$hhgg[$hhjj]=$value;
			$uppp=implode("/", $hhgg);
			$query = "UPDATE `$table` SET `$clos`='".$uppp."' WHERE `serial`='".$serial."'";
			$mysqli->query($query);
		}elseif(isset($_GET['game'])){
			$game=$_GET['game'];
			$iinn=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `$table` WHERE `serial`='".$serial."'"));
			$hhgg=explode("/",$iinn['criteria_active']);
			$fddd=$hhgg[$value];
			if($iinn['criteria_inactive']!=''){
				$hhgg2=explode("/",$iinn['criteria_inactive']);
			}else{
				$hhgg2=array();
			}
			
			if($game=="out"){
				if(!in_array($fddd, $hhgg2)){
					array_push($hhgg2, $fddd);
				}
			}else{
				if(in_array($fddd, $hhgg2)){
					$rrr=array_search($fddd, $hhgg2);
					unset($hhgg2[$rrr]);
				}
				
			}
			$gff=implode("/", $hhgg2);
			$query = "UPDATE `$table` SET `$clos`='".$gff."' WHERE `serial`='".$serial."'";
			$mysqli->query($query);
			
			
		}else{
			if($value=="Delete"){
				$query = "DELETE FROM `$table` WHERE `serial`='".$serial."'";
				$mysqli->query($query);
			}else{
				if($table=="agent"){
					$query = "UPDATE `$table` SET `$clos`='".$value."' WHERE `serialno`='".$serial."'";
					$mysqli->query($query);
				}else{
					$query = "UPDATE `$table` SET `$clos`='".$value."' WHERE `serial`='".$serial."'";
					//echo "UPDATE `$table` SET `$clos`='".$value."' WHERE `serial`='".$serial."'";
					$mysqli->query($query);
				}
			}
		}
		
	}
?>