<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';
		$admin = $_SESSION['Admin'];
		
		// Get all form fields matching database structure
		$pack = isset($_POST["package"]) ? $_POST["package"] : '';
		$pack_amn = isset($_POST["pack_amn"]) ? $_POST["pack_amn"] : '';
		$react_amn = isset($_POST["react_amn"]) ? $_POST["react_amn"] : '';
		$game_renew = isset($_POST["game_renew"]) ? $_POST["game_renew"] : '';
		$color = isset($_POST["color"]) ? $_POST["color"] : '#3498db';
		$dessc = isset($_POST["dessc"]) ? $_POST["dessc"] : '';
		$cid_dessc = isset($_POST["cid_dessc"]) ? $_POST["cid_dessc"] : '';
		$ads_amount = isset($_POST["ads_amount"]) ? $_POST["ads_amount"] : '0';
		$direct_com = isset($_POST["direct_com"]) ? $_POST["direct_com"] : '';
		$min_slot = isset($_POST["min_slot"]) ? $_POST["min_slot"] : '';
		$max_slot = isset($_POST["max_slot"]) ? $_POST["max_slot"] : '';
		$rank_com = isset($_POST["rank_com"]) ? $_POST["rank_com"] : '0';
		$rank_slot = isset($_POST["rank_slot"]) ? $_POST["rank_slot"] : '0';
		$rank_active = isset($_POST["rank_active"]) ? $_POST["rank_active"] : '1';
		$active_country = isset($_POST["active_country"]) ? $_POST["active_country"] : '';
		$inactive_country = isset($_POST["inactive_country"]) ? $_POST["inactive_country"] : '';
		$active = isset($_POST["active"]) ? $_POST["active"] : '1';
		$location = isset($_POST["location"]) ? $_POST["location"] : '';
		$check=1;
		if($pack==''){
			$check=0;
			$_SESSION['msg']="Please Select A Package Type!";
			header("Location: $location");
			exit();
		}
		if($pack_amn==''){
			$check=0;
			$_SESSION['msg']="Please Enter Package Amount!";
			header("Location: $location");
			exit();
		}
		if($react_amn==''){
			$check=0;
			$_SESSION['msg']="Please Enter React Amount!";
			header("Location: $location");
			exit();
		}
		if($game_renew==''){
			$check=0;
			$_SESSION['msg']="Please Enter Game Renew Days!";
			header("Location: $location");
			exit();
		}
		if($dessc==''){
			$check=0;
			$_SESSION['msg']="Please Enter Package Description!";
			header("Location: $location");
			exit();
		}
		if($direct_com==''){
			$check=0;
			$_SESSION['msg']="Please Enter Direct Commission!";
			header("Location: $location");
			exit();
		}
		if($min_slot==''){
			$check=0;
			$_SESSION['msg']="Please Enter Min Game Slot!!!";
			header("Location: $location");
			exit();
		}
		if($max_slot==''){
			$check=0;
			$_SESSION['msg']="Please Enter Max Game Slot!!!";
			header("Location: $location");
			exit();
		}
		
		if($check==1){
			// Escape all values for security
			$pack = $mysqli->real_escape_string($pack);
			$pack_amn = $mysqli->real_escape_string($pack_amn);
			$react_amn = $mysqli->real_escape_string($react_amn);
			$game_renew = $mysqli->real_escape_string($game_renew);
			$color = $mysqli->real_escape_string($color);
			$dessc = $mysqli->real_escape_string($dessc);
			$cid_dessc = $mysqli->real_escape_string($cid_dessc);
			$ads_amount = $mysqli->real_escape_string($ads_amount);
			$direct_com = $mysqli->real_escape_string($direct_com);
			$min_slot = $mysqli->real_escape_string($min_slot);
			$max_slot = $mysqli->real_escape_string($max_slot);
			$rank_com = $mysqli->real_escape_string($rank_com);
			$rank_slot = $mysqli->real_escape_string($rank_slot);
			$rank_active = $mysqli->real_escape_string($rank_active);
			$active_country = $mysqli->real_escape_string($active_country);
			$inactive_country = $mysqli->real_escape_string($inactive_country);
			$active = $mysqli->real_escape_string($active);
			
			$query = "INSERT INTO `package`(
				`pack`, `pack_amn`, `react_amn`, `game_renew`, `color`, 
				`dessc`, `cid_dessc`, `ads_amount`, `direct_com`, `min_slot`, 
				`max_slot`, `rank_com`, `rank_slot`, `rank_active`, 
				`active_country`, `inactive_country`, `active`
			) VALUES (
				'$pack', '$pack_amn', '$react_amn', '$game_renew', '$color', 
				'$dessc', '$cid_dessc', '$ads_amount', '$direct_com', '$min_slot', 
				'$max_slot', '$rank_com', '$rank_slot', '$rank_active', 
				'$active_country', '$inactive_country', '$active'
			)";
			
			if($mysqli->query($query)){
				$package_id = $mysqli->insert_id;
				$_SESSION['msg1']="Package '".$pack."' created successfully! ID: ".$package_id." | Amount: $".$pack_amn." | React: $".$react_amn." | Commission: ".$direct_com."%";
			} else {
				$_SESSION['msg']="Database error: " . $mysqli->error;
			}
			
			header("Location: $location");
			exit();
		}else{
			$_SESSION['msg']="Please fill all required fields!";
			header("Location: $location");
			exit();
		} 
	}
?>