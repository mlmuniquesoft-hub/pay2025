<?php
	/*session_start();
	$timing_start = explode(' ', microtime());
	error_reporting(-1);
	set_time_limit(0);
	ini_set('memory_limit','512M');
	$_SESSION['token']=4368098775524;	
	require_once('db.php');
	require_once('functions.php');*/
	$timezone = "Pacific/Auckland"; // Asia/Dacca
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);	
	//$ttyy=mysqli_fetch_assoc($mysqli->query("SELECT MAX(date) as `today` FROM `ptc_calc` "));
	$date=date("Y-m-d");
	//$mysqli->query("INSERT INTO `generation_time`( `date`) VALUES ('".$date."')");
	

	// Get daily ROI total for downline users on specific date
	function getDailyROITotal($userlist, $date){
		global $mysqli;
		
		if(empty($userlist)) return 0;
		
		$usersList = "'" . implode("','", $userlist) . "'";
		$query = "SELECT SUM(curent_bal) as total_roi FROM `game_return` WHERE DATE(`date`) = '$date' AND `user` IN ($usersList)";
		$result = mysqli_fetch_assoc($mysqli->query($query));
		
		return ($result && $result['total_roi']) ? (float)$result['total_roi'] : 0;
	}
	
	// Count direct referrals for a user based on active investments
	function countDirectReferrals($user_id){
		global $mysqli;
		
		// Check for active referrals who have made investments (upgrade table)
		$query = "SELECT COUNT(DISTINCT m.user) as total 
				  FROM `member` m 
				  INNER JOIN `upgrade` u ON m.user = u.user 
				  WHERE m.sponsor = '$user_id' AND m.paid = '1'";
		$result = mysqli_fetch_assoc($mysqli->query($query));
		
		return ($result && $result['total']) ? (int)$result['total'] : 0;
	}
	
	// Check if user meets referral requirement for specific level
	function meetsReferralRequirement($user_id, $level){
		$direct_referrals = countDirectReferrals($user_id);
		
		// Level requirements: Level 1=0, Level 2=2, Level 3=3, etc.
		$required_referrals = ($level == 1) ? 0 : $level;
		
		return $direct_referrals >= $required_referrals;
	}
	
	
	function downUser11($users,$table){
		global $mysqli;
		$fff=array();
		if(is_array($users)){
			foreach($users as $user){
				$uu=$mysqli->query("select `sponsor`,`user` from `$table` where sponsor='".$user."'");
				while($spp=mysqli_fetch_assoc($uu)){
					array_push($fff, $spp['user']);
				}
			}
		}else{
			$uu=$mysqli->query("select `sponsor`,`user` from `$table` where sponsor='".$users."'");
			while($spp=mysqli_fetch_assoc($uu)){
				array_push($fff, $spp['user']);
			}
		}
		return $fff;
	}
	
	function downUser221($users,$table,$date){
		global $mysqli;
		$fff=array();
		if(is_array($users)){
			foreach($users as $user){
				$uu=$mysqli->query("select `sponsor`,`user` from `$table` where sponsor='".$user."' AND `pack`!='' AND `date`='".$date."'");
				while($spp=mysqli_fetch_assoc($uu)){
					array_push($fff, $spp['user']);
				}
			}
		}else{
			$uu=$mysqli->query("select `sponsor`,`user` from `$table` where sponsor='".$users."' ");
			while($spp=mysqli_fetch_assoc($uu)){
				array_push($fff, $spp['user']);
			}
		}
		return $fff;
	}
	
	
	
	
	function downusers11($user, &$hhh){
		global $mysqli;
		$www=$mysqli->query("SELECT `user`,`sponsor` FROM `member` WHERE `sponsor`='".$user."'");
		$erer=array();
		while($sponsor=mysqli_fetch_assoc($www)){
			array_push($hhh, $sponsor['user']);
			downusers11($sponsor['user'], $hhh);
		}
	}
	
	function SkipList11($user){
		global $mysqli;
		$errr=array();
		$lists=array();
		downusers11($user, $lists);
		foreach($lists as $list){
			$ttyy=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `generation_skip` WHERE `user`='".$list."'"));
			if($ttyy['skip_user']!=''){
				$trrii=explode("/", $ttyy['skip_user']);
				$errr=array_merge($errr,$trrii);
			}
		}
		return array_unique($errr);
	}
	
	// Ensure generation_income table has required columns for new system
	function createGenerationIncomeTable(){
		global $mysqli;
		
		// First, check if table exists
		$table_exists = mysqli_query($mysqli, "SHOW TABLES LIKE 'generation_income'");
		
		if(mysqli_num_rows($table_exists) == 0) {
			// Create new table with all required columns
			$create_table = "CREATE TABLE `generation_income` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`user` varchar(50) NOT NULL,
				`amount` decimal(15,2) DEFAULT 0.00,
				`shop` decimal(15,2) DEFAULT 0.00,
				`date` date NOT NULL,
				`from_user` varchar(50) DEFAULT NULL,
				`level` tinyint(2) DEFAULT NULL,
				`percentage` decimal(5,2) DEFAULT NULL,
				`roi_amount` decimal(15,2) DEFAULT NULL,
				`created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`),
				KEY `idx_user_date` (`user`, `date`),
				KEY `idx_from_user` (`from_user`),
				KEY `idx_level` (`level`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8";
			
			if(!mysqli_query($mysqli, $create_table)) {
				echo "Error creating generation_income table: " . mysqli_error($mysqli) . "\n";
				return false;
			}
		} else {
			// Table exists, add missing columns
			$columns_to_add = array(
				'from_user' => "ALTER TABLE generation_income ADD COLUMN from_user varchar(50) DEFAULT NULL",
				'level' => "ALTER TABLE generation_income ADD COLUMN level tinyint(2) DEFAULT NULL", 
				'percentage' => "ALTER TABLE generation_income ADD COLUMN percentage decimal(5,2) DEFAULT NULL",
				'roi_amount' => "ALTER TABLE generation_income ADD COLUMN roi_amount decimal(15,2) DEFAULT NULL",
				'created_at' => "ALTER TABLE generation_income ADD COLUMN created_at timestamp DEFAULT CURRENT_TIMESTAMP"
			);
			
			foreach($columns_to_add as $column => $sql){
				$check = mysqli_query($mysqli, "SHOW COLUMNS FROM generation_income LIKE '$column'");
				if(!$check || mysqli_num_rows($check) == 0){
					mysqli_query($mysqli, $sql);
				}
			}
			
			// Add indexes if they don't exist
			$indexes = array(
				'idx_from_user' => 'ALTER TABLE generation_income ADD INDEX idx_from_user (from_user)',
				'idx_level' => 'ALTER TABLE generation_income ADD INDEX idx_level (level)'
			);
			
			foreach($indexes as $index_name => $sql){
				$check = mysqli_query($mysqli, "SHOW INDEX FROM generation_income WHERE Key_name = '$index_name'");
				if(!$check || mysqli_num_rows($check) == 0){
					mysqli_query($mysqli, $sql);
				}
			}
		}
		
		return true;
	}

	function user_update11($U_ID,$date){
		global $mysqli;
		$memberid = $U_ID;
		
		// New Generation Bonus Structure (33% total)
		// Level percentages and referral conditions
		$generation_levels = array(
			1 => array('percentage' => 10, 'required_referrals' => 0),   // 1st level: 10%, no condition
			2 => array('percentage' => 8,  'required_referrals' => 2),   // 2nd level: 8%, 2 referrals
			3 => array('percentage' => 5,  'required_referrals' => 3),   // 3rd level: 5%, 3 referrals
			4 => array('percentage' => 3,  'required_referrals' => 4),   // 4th level: 3%, 4 referrals
			5 => array('percentage' => 2,  'required_referrals' => 5),   // 5th level: 2%, 5 referrals
			6 => array('percentage' => 1,  'required_referrals' => 6),   // 6th level: 1%, 6 referrals
			7 => array('percentage' => 1,  'required_referrals' => 7),   // 7th level: 1%, 7 referrals
			8 => array('percentage' => 1,  'required_referrals' => 8),   // 8th level: 1%, 8 referrals
			9 => array('percentage' => 1,  'required_referrals' => 9),   // 9th level: 1%, 9 referrals
			10=> array('percentage' => 1,  'required_referrals' => 10)   // 10th level: 1%, 10 referrals
		);
		
		// Get this user's daily ROI for the date first (early return if no ROI)
		$roi_query = mysqli_fetch_assoc($mysqli->query("SELECT SUM(curent_bal) as daily_roi FROM `game_return` WHERE `user`='".$memberid."' AND DATE(`date`)='".$date."'"));
		$daily_roi = ($roi_query && $roi_query['daily_roi']) ? (float)$roi_query['daily_roi'] : 0;
		
		// If no ROI, skip processing
		if($daily_roi <= 0) {
			return;
		}
		
		// Check if user is eligible (has investment)
		$check_user = mysqli_fetch_assoc($mysqli->query("SELECT `user` FROM `member` WHERE `user`='".$memberid."' AND `paid`='1'"));
		if(!$check_user) return;
		
		// Get upline chain for this user (who will receive bonuses from this user's ROI)
		$upline_chain = array();
		$current_user = $memberid;
		
		// Build upline chain up to 10 levels with single query per level
		for($level = 1; $level <= 10; $level++){
			$sponsor_query = mysqli_fetch_assoc($mysqli->query("SELECT `sponsor` FROM `member` WHERE `user`='".$current_user."'"));
			if($sponsor_query && !empty($sponsor_query['sponsor'])){
				$sponsor = $sponsor_query['sponsor'];
				
				// Check if sponsor is active and meets referral requirements for this level
				$sponsor_check = mysqli_fetch_assoc($mysqli->query("SELECT `user` FROM `member` WHERE `user`='".$sponsor."' AND `paid`='1'"));
				if($sponsor_check && meetsReferralRequirement($sponsor, $level)){
					$upline_chain[$level] = $sponsor;
				}
				$current_user = $sponsor;
			} else {
				break; // No more sponsors in chain
			}
		}
		
		// If no upline, skip processing
		if(empty($upline_chain)) {
			return;
		}
		
		// Batch insert/update generation bonuses to reduce database calls
		$bonus_inserts = array();
		$bonus_updates = array();
		$view_inserts = array();
		
		foreach($upline_chain as $level => $sponsor_id){
			$percentage = $generation_levels[$level]['percentage'];
			$bonus_amount = ($daily_roi * $percentage) / 100;
			
			if($bonus_amount > 0){
				// Check if bonus already exists for today (use safer query)
				$check_query = "SELECT COUNT(*) as count_records FROM `generation_income` 
							   WHERE `user`='$sponsor_id' AND `date`='$date' 
							   AND `from_user`='$memberid' AND `level`='$level'";
				$existing_check = mysqli_fetch_assoc($mysqli->query($check_query));
				$existing_bonus = ($existing_check && $existing_check['count_records']) ? (int)$existing_check['count_records'] : 0;
				
				if($existing_bonus == 0){
					// Prepare for batch insert
					$bonus_inserts[] = "('$sponsor_id', '$bonus_amount', '$date', '$memberid', '$level', '$percentage', '$daily_roi')";
					
					// Prepare transaction history
					$description = "Level $level Generation Bonus ($percentage%) from $memberid - ROI: $".number_format($daily_roi, 2);
					$view_inserts[] = "('$sponsor_id', '$date', '$description', '$bonus_amount', 'credit')";
				} else {
					// Prepare for batch update
					$bonus_updates[] = "UPDATE `generation_income` SET `amount`='$bonus_amount', `percentage`='$percentage', `roi_amount`='$daily_roi' 
									   WHERE `user`='$sponsor_id' AND `date`='$date' AND `from_user`='$memberid' AND `level`='$level'";
				}
			}
		}
		
		// Execute batch inserts
		if(!empty($bonus_inserts)) {
			$insert_query = "INSERT INTO `generation_income`(`user`, `amount`, `date`, `from_user`, `level`, `percentage`, `roi_amount`) VALUES " . implode(',', $bonus_inserts);
			if(!mysqli_query($mysqli, $insert_query)) {
				echo "Error batch inserting generation bonuses for $memberid: " . mysqli_error($mysqli) . "\n";
			}
		}
		
		// Execute batch updates
		foreach($bonus_updates as $update_query) {
			if(!mysqli_query($mysqli, $update_query)) {
				echo "Error updating generation bonus for $memberid: " . mysqli_error($mysqli) . "\n";
			}
		}
		
		// Execute batch view inserts
		if(!empty($view_inserts)) {
			$view_query = "INSERT INTO `view`(`user`, `date`, `description`, `amount`, `types`) VALUES " . implode(',', $view_inserts);
			mysqli_query($mysqli, $view_query);
		}
		
		// Update total generation balance for each user in upline (batch this too)
		$balance_updates = array();
		foreach($upline_chain as $level => $sponsor_id){
			$total_generation = mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) AS total FROM `generation_income` WHERE `user`='".$sponsor_id."'"));
			if($total_generation && $total_generation['total'] > 0){
				$balance_updates[] = "UPDATE `balance` SET `generation_taka`='".$total_generation['total']."' WHERE `user`='".$sponsor_id."'";
			}
		}
		
		// Execute balance updates
		foreach($balance_updates as $balance_query) {
			mysqli_query($mysqli, $balance_query);
		}
		
	} /// end of user_update function
	
	function Generationoncome($DATE){
		global $mysqli;
		
		// Set execution time and memory limits for large processing
		set_time_limit(300); // 5 minutes
		ini_set('memory_limit', '512M');
		
		// Ensure table structure is correct
		if(!createGenerationIncomeTable()) {
			echo "❌ Failed to create/update generation_income table structure\n";
			return false;
		}
		
		$SkipUser=array("habib","kingkhan");
		
		// Get all active members with investments - optimized query
		$mdfg=$mysqli->query("SELECT DISTINCT m.user FROM `member` m 
							 INNER JOIN `upgrade` u ON m.user = u.user 
							 WHERE DATE(m.time)<='".$DATE."' AND m.paid='1' 
							 ORDER BY m.user 
							 LIMIT 1000");
		
		if(!$mdfg) {
			echo "❌ Error getting members for generation bonus: " . mysqli_error($mysqli) . "\n";
			return false;
		}
		
		$userCount = mysqli_num_rows($mdfg);
		echo "🎯 Processing generation bonuses for $userCount users on $DATE\n";
		
		$processedUsers = 0;
		$batchSize = 50; // Process in batches to avoid timeout
		
		while($allmember=mysqli_fetch_assoc($mdfg)){
			$u_id_tmp = $allmember['user'];
			if(!in_array(strtolower($allmember['user']),$SkipUser)){
				user_update11($u_id_tmp,$DATE);
				$processedUsers++;
				
				// Output progress every batch to prevent timeout
				if($processedUsers % $batchSize == 0) {
					echo "⏳ Processed $processedUsers/$userCount users...\n";
					flush(); // Flush output to prevent timeout
					
					// Small delay to prevent overwhelming the database
					usleep(10000); // 10ms delay
				}
			}
		}
		
		echo "✅ Generation bonuses processed for $processedUsers users\n";
		return true;
	}
	//Generationoncome();
	
?>