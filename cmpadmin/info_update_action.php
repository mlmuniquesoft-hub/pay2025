<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		// Set JSON content type for AJAX responses
		header('Content-Type: application/json');
		
		require '../db/db.php';
		$admin = $_SESSION['Admin'];
		
		// Support both GET and POST requests
		$request_method = $_SERVER['REQUEST_METHOD'];
		$data = ($request_method === 'POST') ? $_POST : $_GET;
		
		// Sanitize input parameters
		$value = isset($data["vas"]) ? trim($data["vas"]) : '';
		$serial = isset($data["sers"]) ? intval($data["sers"]) : 0;
		$clos = isset($data["coll"]) ? mysqli_real_escape_string($mysqli, $data["coll"]) : '';
		$table = isset($data["tbs"]) ? mysqli_real_escape_string($mysqli, $data["tbs"]) : '';
		$dts = isset($data["dts"]) ? $data["dts"] : '';
		
		// Validate required parameters
		if(empty($value) && $value !== '0' && $value !== 'Delete') {
			http_response_code(400);
			echo json_encode(['error' => 'Invalid value parameter']);
			exit();
		}
		
		if($serial <= 0) {
			http_response_code(400);
			echo json_encode(['error' => 'Invalid serial parameter']);
			exit();
		}
		
		if(empty($clos) || empty($table)) {
			http_response_code(400);
			echo json_encode(['error' => 'Missing required parameters']);
			exit();
		}
		
		// Whitelist allowed tables and columns for security
		$allowed_tables = ['package', 'agent', 'users'];
		$allowed_columns = [
			'package' => ['pack', 'pack_amn', 'min_deposit', 'max_deposit', 'react_amn', 'game_renew', 'color', 'dessc', 'cid_dessc', 
						  'ads_amount', 'direct_com', 'min_slot', 'max_slot', 'rank_com', 'rank_slot', 
						  'rank_active', 'active_country', 'inactive_country', 'active'],
			'agent' => ['name', 'email', 'phone', 'status'],
			'users' => ['name', 'email', 'phone', 'status']
		];
		
		if(!in_array($table, $allowed_tables)) {
			http_response_code(403);
			echo json_encode(['error' => 'Table not allowed']);
			exit();
		}
		
		if(!in_array($clos, $allowed_columns[$table])) {
			http_response_code(403);
			echo json_encode(['error' => 'Column not allowed']);
			exit();
		}
		
		// Additional validation for package table
		if($table === 'package') {
			if($clos === 'pack_amn' || $clos === 'min_deposit' || $clos === 'max_deposit' || $clos === 'ads_amount') {
				if(!is_numeric($value) || floatval($value) < 0) {
					http_response_code(400);
					echo json_encode(['error' => 'Invalid amount value']);
					exit();
				}
			} elseif($clos === 'react_amn') {
				if(!is_numeric($value) || floatval($value) < 1) {
					http_response_code(400);
					echo json_encode(['error' => 'Multiplier must be at least 1']);
					exit();
				}
			} elseif($clos === 'direct_com' || $clos === 'rank_com') {
				if(!is_numeric($value) || floatval($value) < 0 || floatval($value) > 100) {
					http_response_code(400);
					echo json_encode(['error' => 'Commission must be between 0-100%']);
					exit();
				}
			} elseif($clos === 'game_renew' || $clos === 'min_slot' || $clos === 'max_slot' || $clos === 'rank_slot') {
				if(!is_numeric($value) || intval($value) <= 0) {
					http_response_code(400);
					echo json_encode(['error' => 'Invalid numeric value']);
					exit();
				}
			} elseif($clos === 'active' || $clos === 'rank_active') {
				if(!in_array($value, ['0', '1'])) {
					http_response_code(400);
					echo json_encode(['error' => 'Status must be 0 or 1']);
					exit();
				}
			}
		}
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
			try {
				if($value == "Delete"){
					// Use prepared statement for delete
					$stmt = $mysqli->prepare("DELETE FROM `$table` WHERE `serial` = ?");
					$stmt->bind_param("i", $serial);
					$result = $stmt->execute();
					
					if($result) {
						echo json_encode(['success' => true, 'message' => 'Record deleted successfully']);
					} else {
						http_response_code(500);
						echo json_encode(['error' => 'Failed to delete record']);
					}
					$stmt->close();
				} else {
					// Use prepared statement for update
					if($table == "agent"){
						$stmt = $mysqli->prepare("UPDATE `$table` SET `$clos` = ? WHERE `serialno` = ?");
					} else {
						$stmt = $mysqli->prepare("UPDATE `$table` SET `$clos` = ? WHERE `serial` = ?");
					}
					
					// Determine parameter type based on column
					$param_type = 's'; // default to string
					if(in_array($clos, ['pack_amn', 'react_amn', 'ads_amount', 'direct_com', 'rank_com'])) {
						$param_type = 'd'; // double/float
					} elseif(in_array($clos, ['game_renew', 'min_slot', 'max_slot', 'rank_slot', 'active', 'rank_active'])) {
						$param_type = 'i'; // integer
					}
					
					$stmt->bind_param($param_type . "i", $value, $serial);
					$result = $stmt->execute();
					
					if($result) {
						echo json_encode(['success' => true, 'message' => 'Field updated successfully', 'field' => $clos, 'value' => $value]);
					} else {
						http_response_code(500);
						echo json_encode(['error' => 'Failed to update field: ' . $mysqli->error]);
					}
					$stmt->close();
				}
			} catch (Exception $e) {
				http_response_code(500);
				echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
			}
		}
		
	}
?>