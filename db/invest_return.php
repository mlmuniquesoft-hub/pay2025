<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	$timing_start = explode(' ', microtime());
	error_reporting(-1);
	set_time_limit(0);
	ini_set('memory_limit','4096M');
	$_SESSION['token']='12345gh';	
	require_once 'db.php';
	require_once 'functions.php';
	
	$timezone = "Asia/Dacca";
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);	
	
	// Get admin settings for return system
	function getReturnSettings(){
		global $mysqli;
		
		// Check if new structure exists
		$check_new = $mysqli->query("SHOW TABLES LIKE 'return_settings'");
		
		if(mysqli_num_rows($check_new) > 0) {
			// Check if it has the new column structure
			$check_columns = $mysqli->query("SHOW COLUMNS FROM return_settings LIKE 'system_active'");
			
			if(mysqli_num_rows($check_columns) > 0) {
				// Use new structure
				$result = $mysqli->query("SELECT * FROM return_settings WHERE id = 1");
				$settings = mysqli_fetch_assoc($result);
				
				if($settings) {
					// Map to expected format
					return array(
						'system_enabled' => $settings['system_active'],
						'weekend_enabled' => $settings['weekend_mode'],
						'basic_min_rate' => $settings['basic_rate_min'],
						'basic_max_rate' => $settings['basic_rate_max'],
						'premium_min_rate' => $settings['premium_rate_min'],
						'premium_max_rate' => $settings['premium_rate_max'],
						'vip_min_rate' => $settings['vip_rate_min'],
						'vip_max_rate' => $settings['vip_rate_max'],
						'basic_range_min' => $settings['basic_min'],
						'basic_range_max' => $settings['basic_max'],
						'premium_range_min' => $settings['premium_min'],
						'premium_range_max' => $settings['premium_max'],
						'vip_range_min' => $settings['vip_min'],
						'profit_percentage' => '70',
						'shopping_percentage' => '30'
					);
				}
			}
		}
		
		// Fallback: Create old-style settings table if not exists
		$mysqli->query("CREATE TABLE IF NOT EXISTS `return_settings` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`setting_name` varchar(100) NOT NULL,
			`setting_value` varchar(500) NOT NULL,
			`description` text,
			`updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`),
			UNIQUE KEY `setting_name` (`setting_name`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8");
		
		// Initialize default settings if not exist
		$defaults = array(
			'system_enabled' => '1',
			'weekend_enabled' => '0',
			'basic_min_rate' => '0.3',
			'basic_max_rate' => '0.5',
			'premium_min_rate' => '0.5',
			'premium_max_rate' => '0.7',
			'vip_min_rate' => '0.8',
			'vip_max_rate' => '1.0',
			'basic_range_min' => '100',
			'basic_range_max' => '999',
			'premium_range_min' => '1000',
			'premium_range_max' => '4999',
			'vip_range_min' => '5000',
			'profit_percentage' => '70',
			'shopping_percentage' => '30'
		);
		
		foreach($defaults as $name => $value) {
			$check = $mysqli->query("SELECT * FROM `return_settings` WHERE `setting_name`='$name'");
			if(mysqli_num_rows($check) == 0) {
				$mysqli->query("INSERT INTO `return_settings` (`setting_name`, `setting_value`) VALUES ('$name', '$value')");
			}
		}
		
		// Get all settings
		$settings = array();
		$result = $mysqli->query("SELECT * FROM `return_settings`");
		while($row = mysqli_fetch_assoc($result)) {
			$settings[$row['setting_name']] = $row['setting_value'];
		}
		
		return $settings;
	}
	
	// Calculate package-wise return rate
	function getPackageReturnRate($investmentAmount, $settings) {
		$amount = floatval($investmentAmount);
		
		if($amount >= $settings['basic_range_min'] && $amount <= $settings['basic_range_max']) {
			// Basic Range: Random between min and max rate
			$minRate = floatval($settings['basic_min_rate']);
			$maxRate = floatval($settings['basic_max_rate']);
		} elseif($amount >= $settings['premium_range_min'] && $amount <= $settings['premium_range_max']) {
			// Premium Range
			$minRate = floatval($settings['premium_min_rate']);
			$maxRate = floatval($settings['premium_max_rate']);
		} else {
			// VIP Range (5000+)
			$minRate = floatval($settings['vip_min_rate']);
			$maxRate = floatval($settings['vip_max_rate']);
		}
		
		// Generate random rate within range
		$randomRate = $minRate + (($maxRate - $minRate) * (mt_rand(0, 100) / 100));
		return round($randomRate, 2);
	}
	
	function invest_update($memberid, $date, $settings){
		global $mysqli;
		$PresentDate = $date;
		
		// Get user's total investment amount
		$investmentQuery = $mysqli->query("SELECT SUM(amount) as total_amount FROM `upgrade` WHERE `user`='".$memberid."' AND DATE(`date`)<'".$date."'");
		$investmentData = mysqli_fetch_assoc($investmentQuery);
		$totalInvestment = floatval($investmentData['total_amount']);
		
		if($totalInvestment <= 0) {
			return false;
		}
		
		// Get latest upgrade record
		$upgradeQuery = mysqli_fetch_assoc($mysqli->query("SELECT `serial` FROM `upgrade` WHERE `user`='".$memberid."' ORDER BY `serial` DESC"));
		
		// Calculate remaining return allowance
		$remainK = RemainingReturn($memberid);
		
		if($remainK <= 0) {
			return false;
		}
		
		// Calculate package-wise return rate
		$returnRate = getPackageReturnRate($totalInvestment, $settings);
		
		// Calculate profit amounts
		$dailyReturn = ($totalInvestment * $returnRate) / 100;
		$profitAmount = $dailyReturn * (floatval($settings['profit_percentage']) / 100);
		$shoppingAmount = $dailyReturn * (floatval($settings['shopping_percentage']) / 100);
		
		// Don't exceed remaining return limit
		if($profitAmount > $remainK) {
			$profitAmount = $remainK;
			$shoppingAmount = $profitAmount * (floatval($settings['shopping_percentage']) / floatval($settings['profit_percentage']));
		}
		
		if($profitAmount > 0) {
			// Check if return already processed for today
			$checkPrev = mysqli_num_rows($mysqli->query("SELECT * FROM `game_return` WHERE `user`='".$memberid."' AND DATE(`date`)='".$PresentDate."'"));
			
			if($checkPrev < 1) {
				// Insert daily return record
				$insertSQL = "INSERT INTO `game_return`(`user`, `play_id`, `curent_bal`, `shop`, `bonus_bal`, `date`) VALUES ('".$memberid."','".$upgradeQuery['serial']."','".$profitAmount."','".$shoppingAmount."','".$returnRate."','".$PresentDate."')";
				
				$result = $mysqli->query($insertSQL);
				if($result) {
					// Add to user's view/wallet
					$description = "$$profitAmount ({$returnRate}%) Daily Investment Return + $$shoppingAmount Shopping Bonus";
					$viewSQL = "INSERT INTO `view`(`user`, `date`, `description`, `amount`, `types`) VALUES ('".$memberid."', '".$PresentDate."', '".$description."', '".$profitAmount."','credit')";
					$mysqli->query($viewSQL);
					
					echo "✅ $memberid: $returnRate% = $$profitAmount (Investment: $$totalInvestment)\n";
					return true;
				}
			}
		}
		return false;
	}

	// Function to check if a specific date is disabled by admin
	function isDateDisabled($date) {
		global $mysqli;
		$result = mysqli_query($mysqli, "SELECT is_disabled FROM daily_control WHERE control_date = '$date' ORDER BY disabled_at DESC LIMIT 1");
		if($result && mysqli_num_rows($result) > 0) {
			$control = mysqli_fetch_assoc($result);
			return $control['is_disabled'] == 1;
		}
		return false; // Date not controlled = enabled by default
	}

	// Main execution
	echo "🚀 Capitol Money Pay - Daily Investment Return System\n";
	echo "==================================================\n";
	
	// Get admin settings
	$settings = getReturnSettings();
	
	// Check if system is enabled
	if(!isset($settings['system_enabled']) || $settings['system_enabled'] != '1') {
		echo "❌ Daily return system is disabled by admin.\n";
		exit();
	}
	
	echo "📊 Current Settings:\n";
	echo "Basic Range (" . (isset($settings['basic_range_min']) ? $settings['basic_range_min'] : 'N/A') . "-" . (isset($settings['basic_range_max']) ? $settings['basic_range_max'] : 'N/A') . "): " . (isset($settings['basic_min_rate']) ? $settings['basic_min_rate'] : 'N/A') . "%-" . (isset($settings['basic_max_rate']) ? $settings['basic_max_rate'] : 'N/A') . "%\n";
	echo "Premium Range (" . (isset($settings['premium_range_min']) ? $settings['premium_range_min'] : 'N/A') . "-" . (isset($settings['premium_range_max']) ? $settings['premium_range_max'] : 'N/A') . "): " . (isset($settings['premium_min_rate']) ? $settings['premium_min_rate'] : 'N/A') . "%-" . (isset($settings['premium_max_rate']) ? $settings['premium_max_rate'] : 'N/A') . "%\n";
	echo "VIP Range (" . (isset($settings['vip_range_min']) ? $settings['vip_range_min'] : 'N/A') . "+): " . (isset($settings['vip_min_rate']) ? $settings['vip_min_rate'] : 'N/A') . "%-" . (isset($settings['vip_max_rate']) ? $settings['vip_max_rate'] : 'N/A') . "%\n";
	echo "Weekend Trading: " . (isset($settings['weekend_enabled']) && $settings['weekend_enabled'] == '1' ? 'Enabled' : 'Disabled') . "\n";
	echo "==================================================\n";

	$query_11 = mysqli_fetch_assoc($mysqli->query("SELECT MAX(`date`) AS date FROM game_return ORDER BY `serial` DESC"));
	$presentDate = date("Y-m-d");
	$excludeDays = array("Sun", "Sat");
	
	// Check if there are any users with investments
	$userCheck = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(DISTINCT user) as count FROM upgrade"));
	
	if($userCheck['count'] == 0) {
		echo "❌ No users with investments found. Nothing to process.\n";
		exit();
	}
	
	// Determine start date
	if(empty($query_11['date'])) {
		// If no previous records, start from yesterday (or last business day if yesterday was weekend)
		$yesterday = date("Y-m-d", strtotime("-1 day"));
		$yesterdayDow = date("D", strtotime($yesterday));
		
		// If weekend trading is disabled and yesterday was a weekend, find last business day
		if($settings['weekend_enabled'] != '1' && in_array($yesterdayDow, array("Sun", "Sat"))) {
			if($yesterdayDow == "Sun") {
				$startDate = date("Y-m-d", strtotime("-2 day")); // Friday
			} else { // Saturday
				$startDate = date("Y-m-d", strtotime("-1 day")); // Friday (yesterday was Saturday)
			}
			echo "📅 No previous records found. Yesterday was weekend, starting from last business day: $startDate\n";
		} else {
			$startDate = $yesterday;
			echo "📅 No previous records found. Starting from yesterday: $startDate\n";
		}
	} else {
		$startDate = date("Y-m-d", strtotime($query_11['date'] . "+1 day"));
		echo "📅 Last processed date: {$query_11['date']}. Starting from: $startDate\n";
	}
	
	// If weekend trading is enabled, don't exclude weekends
	if($settings['weekend_enabled'] == '1') {
		$excludeDays = array();
	}
	
	// Calculate how many days we need to process
	$daysDifference = (strtotime($presentDate) - strtotime($startDate)) / (60 * 60 * 24);
	$maxDays = max(1, $daysDifference + 1); // At least process today, but could be more if catching up
	
	echo "📊 Need to process $maxDays days from $startDate to $presentDate\n";
	
	$totalProcessed = 0;
	
	// Process all days from start date to present date (inclusive)
	for($i = 0; $i <= $daysDifference; $i++) {
		$date = date("Y-m-d", strtotime($startDate . "+$i days"));
		$dayOfWeek = date("D", strtotime($date));
		
		echo "\n📅 Processing Date: $date ($dayOfWeek)\n";
		
		// Check if this date is disabled by admin
		if(isDateDisabled($date)){
			echo "🚫 Skipped (Disabled by admin)\n";
			continue;
		}
		
		// Skip weekends if weekend trading is disabled
		if(in_array($dayOfWeek, $excludeDays)){
			echo "⏭️  Skipped (Weekend trading disabled)\n";
			continue;
		}
	
		// Get all users with investments before this date
		$result_10 = $mysqli->query("SELECT DISTINCT user FROM upgrade WHERE DATE(`date`)<'".$date."' ORDER BY `serial` ASC");
		$userCount = mysqli_num_rows($result_10);
		
		if($userCount > 0) {
			echo "� Found $userCount users to process\n";
			$processedCount = 0;
			
			while($row_10 = mysqli_fetch_array($result_10)){
				$userId = $row_10['user'];
				if(invest_update($userId, $date, $settings)) {
					$processedCount++;
				}
			}
			
			echo "✅ Processed $processedCount users for $date\n";
			$totalProcessed += $processedCount;
		} else {
			echo "ℹ️ No users found for processing on $date\n";
		}
	}
	
	// Process Generation Bonuses after daily returns
	echo "\n🎯 Processing Generation Bonuses...\n";
	require_once 'generation.php';
	Generationoncome($date);
	echo "✅ Generation bonuses processed!\n";
	
	echo "\n🎉 Daily Investment Return Process Completed Successfully!\n";
	echo "📈 Total users processed: $totalProcessed\n";
?>