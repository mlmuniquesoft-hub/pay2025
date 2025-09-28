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
		
		// Create settings table if not exists
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
			'profit_percentage' => '60',
			'shopping_percentage' => '40'
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
				$mysqli->query("INSERT INTO `game_return`(`user`, `play_id`, `curent_bal`, `shop`, `bonus_bal`, `date`) VALUES ('".$memberid."','".$upgradeQuery['serial']."','".$profitAmount."','".$shoppingAmount."','".$returnRate."','".$PresentDate."')");
				
				// Add to user's view/wallet
				$description = "$$profitAmount ({$returnRate}%) Daily Investment Return + $$shoppingAmount Shopping Bonus";
				$mysqli->query("INSERT INTO `view`(`user`, `date`, `description`, `amount`, `types`) VALUES ('".$memberid."', '".$PresentDate."', '".$description."', '".$profitAmount."','credit')");
				
				echo "✅ $memberid: $returnRate% = $$profitAmount (Investment: $$totalInvestment)\n";
				return true;
			}
		}
		return false;
	}

	// Main execution
	echo "🚀 Capitol Money Pay - Daily Investment Return System\n";
	echo "==================================================\n";
	
	// Get admin settings
	$settings = getReturnSettings();
	
	// Check if system is enabled
	if($settings['system_enabled'] != '1') {
		echo "❌ Daily return system is disabled by admin.\n";
		exit();
	}
	
	echo "📊 Current Settings:\n";
	echo "Basic Range ({$settings['basic_range_min']}-{$settings['basic_range_max']}): {$settings['basic_min_rate']}%-{$settings['basic_max_rate']}%\n";
	echo "Premium Range ({$settings['premium_range_min']}-{$settings['premium_range_max']}): {$settings['premium_min_rate']}%-{$settings['premium_max_rate']}%\n";
	echo "VIP Range ({$settings['vip_range_min']}+): {$settings['vip_min_rate']}%-{$settings['vip_max_rate']}%\n";
	echo "Weekend Trading: " . ($settings['weekend_enabled'] == '1' ? 'Enabled' : 'Disabled') . "\n";
	echo "==================================================\n";

	$query_11 = mysqli_fetch_assoc($mysqli->query("SELECT MAX(`date`) AS date FROM game_return ORDER BY `serial` DESC"));
	$i = 0;
	$presentDate = date("Y-m-d");
	$excludeDays = array("Sun", "Sat");
	
	// If weekend trading is enabled, don't exclude weekends
	if($settings['weekend_enabled'] == '1') {
		$excludeDays = array();
	}
	
	while(true){
		$date = date("Y-m-d", strtotime($query_11['date']."+$i days"));
		$dayOfWeek = date("D", strtotime($date));
		$i++;
		
		echo "\n📅 Processing Date: $date ($dayOfWeek)\n";
		
		// Skip weekends if weekend trading is disabled
		if(in_array($dayOfWeek, $excludeDays)){
			echo "⏭️  Skipped (Weekend trading disabled)\n";
			continue;
		}
	
		if($date < $presentDate){
			// Get all users with investments before this date
			$query_10 = "SELECT DISTINCT user FROM upgrade WHERE DATE(`date`)<'".$date."' ORDER BY `serial` ASC";
			$result_10 = $mysqli->query($query_10);
			$processedCount = 0;
			
			while($row_10 = mysqli_fetch_array($result_10)){
				$userId = $row_10['user'];
				if(invest_update($userId, $date, $settings)) {
					$processedCount++;
				}
				usleep(50); // Small delay to prevent overload
			}
			
			echo "✅ Processed $processedCount users for $date\n";
		} else {
			echo "🏁 Reached current date. Process complete.\n";
			break;
		}
	}
	
	echo "\n🎉 Daily Investment Return Process Completed Successfully!\n";
?>