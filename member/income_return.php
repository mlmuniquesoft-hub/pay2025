<?php
    session_start(); 
    if(!isset($_SESSION['roboMember'])){
    	header("Location:logout.php");
    	exit();
    }else{
	require '../db/db.php';
	require '../db/functions.php';
	
	// Income calculation functions with error handling
	function getPoolIncome($user) {
		global $mysqli;
		try {
			// Check if table exists first
			$tableCheck = $mysqli->query("SHOW TABLES LIKE 'pool_income'");
			if ($tableCheck->num_rows == 0) {
				return 0; // Table doesn't exist, return 0
			}
			
			$result = $mysqli->query("SELECT SUM(amount) as total FROM pool_income WHERE user='$user'");
			if (!$result) {
				return 0;
			}
			$row = mysqli_fetch_assoc($result);
			return $row['total'] ? $row['total'] : 0;
		} catch (Exception $e) {
			error_log("getPoolIncome error: " . $e->getMessage());
			return 0;
		}
	}
	
	function getPoolReferIncome($user) {
		global $mysqli;
		try {
			$tableCheck = $mysqli->query("SHOW TABLES LIKE 'pool_refer_income'");
			if ($tableCheck->num_rows == 0) {
				return 0;
			}
			
			$result = $mysqli->query("SELECT SUM(amount) as total FROM pool_refer_income WHERE user='$user'");
			if (!$result) {
				return 0;
			}
			$row = mysqli_fetch_assoc($result);
			return $row['total'] ? $row['total'] : 0;
		} catch (Exception $e) {
			error_log("getPoolReferIncome error: " . $e->getMessage());
			return 0;
		}
	}
	
	function getDailyROIIncome($user) {
		global $mysqli;
		try {
			$tableCheck = $mysqli->query("SHOW TABLES LIKE 'daily_roi_income'");
			if ($tableCheck->num_rows == 0) {
				return 0;
			}
			
			$result = $mysqli->query("SELECT SUM(amount) as total FROM daily_roi_income WHERE user='$user'");
			if (!$result) {
				return 0;
			}
			$row = mysqli_fetch_assoc($result);
			return $row['total'] ? $row['total'] : 0;
		} catch (Exception $e) {
			error_log("getDailyROIIncome error: " . $e->getMessage());
			return 0;
		}
	}
	
	function getReferGenerationIncome($user) {
		global $mysqli;
		try {
			$tableCheck = $mysqli->query("SHOW TABLES LIKE 'refer_generation_income'");
			if ($tableCheck->num_rows == 0) {
				return 0;
			}
			
			$result = $mysqli->query("SELECT SUM(amount) as total FROM refer_generation_income WHERE user='$user'");
			if (!$result) {
				return 0;
			}
			$row = mysqli_fetch_assoc($result);
			return $row['total'] ? $row['total'] : 0;
		} catch (Exception $e) {
			error_log("getReferGenerationIncome error: " . $e->getMessage());
			return 0;
		}
	}
	
	function getGenerationROIIncome($user) {
		global $mysqli;
		try {
			$tableCheck = $mysqli->query("SHOW TABLES LIKE 'generation_roi_income'");
			if ($tableCheck->num_rows == 0) {
				return 0;
			}
			
			$result = $mysqli->query("SELECT SUM(amount) as total FROM generation_roi_income WHERE user='$user'");
			if (!$result) {
				return 0;
			}
			$row = mysqli_fetch_assoc($result);
			return $row['total'] ? $row['total'] : 0;
		} catch (Exception $e) {
			error_log("getGenerationROIIncome error: " . $e->getMessage());
			return 0;
		}
	}
	
	function getSpecialReferSales($user) {
		global $mysqli;
		try {
			$tableCheck = $mysqli->query("SHOW TABLES LIKE 'special_refer_sales'");
			if ($tableCheck->num_rows == 0) {
				return 0;
			}
			
			$result = $mysqli->query("SELECT SUM(amount) as total FROM special_refer_sales WHERE user='$user'");
			if (!$result) {
				return 0;
			}
			$row = mysqli_fetch_assoc($result);
			return $row['total'] ? $row['total'] : 0;
		} catch (Exception $e) {
			error_log("getSpecialReferSales error: " . $e->getMessage());
			return 0;
		}
	}
	
	function getPremiumClubProfit($user) {
		global $mysqli;
		try {
			$tableCheck = $mysqli->query("SHOW TABLES LIKE 'premium_club_profit'");
			if ($tableCheck->num_rows == 0) {
				return 0;
			}
			
			$result = $mysqli->query("SELECT SUM(amount) as total FROM premium_club_profit WHERE user='$user'");
			if (!$result) {
				return 0;
			}
			$row = mysqli_fetch_assoc($result);
			return $row['total'] ? $row['total'] : 0;
		} catch (Exception $e) {
			error_log("getPremiumClubProfit error: " . $e->getMessage());
			return 0;
		}
	}
	
	function getVipClubProfit($user) {
		global $mysqli;
		try {
			$tableCheck = $mysqli->query("SHOW TABLES LIKE 'vip_club_profit'");
			if ($tableCheck->num_rows == 0) {
				return 0;
			}
			
			$result = $mysqli->query("SELECT SUM(amount) as total FROM vip_club_profit WHERE user='$user'");
			if (!$result) {
				return 0;
			}
			$row = mysqli_fetch_assoc($result);
			return $row['total'] ? $row['total'] : 0;
		} catch (Exception $e) {
			error_log("getVipClubProfit error: " . $e->getMessage());
			return 0;
		}
	}
	
	function getRankRewardIncentive($user) {
		global $mysqli;
		try {
			$tableCheck = $mysqli->query("SHOW TABLES LIKE 'rank_reward_incentive'");
			if ($tableCheck->num_rows == 0) {
				return 0;
			}
			
			$result = $mysqli->query("SELECT SUM(amount) as total FROM rank_reward_incentive WHERE user='$user'");
			if (!$result) {
				return 0;
			}
			$row = mysqli_fetch_assoc($result);
			return $row['total'] ? $row['total'] : 0;
		} catch (Exception $e) {
			error_log("getRankRewardIncentive error: " . $e->getMessage());
			return 0;
		}
	}
	
	function getTotalWithdraw($user) {
		global $mysqli;
		try {
			$tableCheck = $mysqli->query("SHOW TABLES LIKE 'withdrawal'");
			if ($tableCheck->num_rows == 0) {
				return 0;
			}
			
			$result = $mysqli->query("SELECT SUM(amount) as total FROM withdrawal WHERE user='$user' AND status='completed'");
			if (!$result) {
				return 0;
			}
			$row = mysqli_fetch_assoc($result);
			return $row['total'] ? $row['total'] : 0;
		} catch (Exception $e) {
			error_log("getTotalWithdraw error: " . $e->getMessage());
			return 0;
		}
	}
	
	function getCurrentRank($user) {
		global $mysqli;
		try {
			// First try to get rank from user table
			$tableCheck = $mysqli->query("SHOW TABLES LIKE 'user'");
			if ($tableCheck->num_rows > 0) {
				$result = $mysqli->query("SELECT rank FROM user WHERE user_id='$user'");
				if ($result) {
					$row = mysqli_fetch_assoc($result);
					if ($row && !empty($row['rank'])) {
						return $row['rank'];
					}
				}
			}
			
			// If no rank in user table, try rank table
			$tableCheck = $mysqli->query("SHOW TABLES LIKE 'rank'");
			if ($tableCheck->num_rows > 0) {
				$result = $mysqli->query("SELECT rank_name FROM rank WHERE user='$user' ORDER BY id DESC LIMIT 1");
				if ($result) {
					$row = mysqli_fetch_assoc($result);
					if ($row && !empty($row['rank_name'])) {
						return $row['rank_name'];
					}
				}
			}
			
			return "No Rank";
		} catch (Exception $e) {
			error_log("getCurrentRank error: " . $e->getMessage());
			return "No Rank";
		}
	}

	// Main execution wrapped in try-catch
	try {
		$returnAmn=array();
		$user=$_SESSION['roboMember'];
		
		$BotAmn=mysqli_num_rows($mysqli->query("SELECT * FROM `upgrade` WHERE `user`='".$user."'"));
		
		$uiyre=remainAmn22($user);
		
		// Ensure we have valid data
		if (!$uiyre || !is_array($uiyre)) {
			$uiyre = array('final' => 0, 'in' => 0, 'out' => 0, 'shop' => 0);
		}
		
	$returnAmn['bOTqTY']=$BotAmn;
	$returnAmn['RemainReturn']=RemainingReturn($user) ?: 0;
	$returnAmn['TotalIncome']=TtalIncome($user) ?: 0;
	$returnAmn['FinalAmount']=number_format(($uiyre['final'] ?: 0),2,'.',',');
	$returnAmn['TotaoIn']=number_format(($uiyre['in'] ?: 0),2,'.',',');
	$returnAmn['TotaoOut']=number_format(($uiyre['out'] ?: 0),2,'.',',');
	$returnAmn['shopping']=number_format(($uiyre['shop'] ?: 0),2,'.',',');
	
	// New Income Types
	$returnAmn['PoolIncome'] = number_format(getPoolIncome($user), 2, '.', ',');
	$returnAmn['PoolReferIncome'] = number_format(getPoolReferIncome($user), 2, '.', ',');
	$returnAmn['DailyROIIncome'] = number_format(getDailyROIIncome($user), 2, '.', ',');
	$returnAmn['ReferGenerationIncome'] = number_format(getReferGenerationIncome($user), 2, '.', ',');
	$returnAmn['GenerationROIIncome'] = number_format(getGenerationROIIncome($user), 2, '.', ',');
	$returnAmn['SpecialReferSales'] = number_format(getSpecialReferSales($user), 2, '.', ',');
	$returnAmn['PremiumClubProfit'] = number_format(getPremiumClubProfit($user), 2, '.', ',');
	$returnAmn['VipClubProfit'] = number_format(getVipClubProfit($user), 2, '.', ',');
	$returnAmn['RankRewardIncentive'] = number_format(getRankRewardIncentive($user), 2, '.', ',');
	$returnAmn['TotalWithdraw'] = number_format(getTotalWithdraw($user), 2, '.', ',');
	$returnAmn['CurrentRank'] = getCurrentRank($user);
	
	// Set proper JSON header
	header('Content-Type: application/json');
	echo json_encode($returnAmn);
	
	} catch (Exception $e) {
		// Error handling - return default values
		error_log("Income return error: " . $e->getMessage());
		$errorResponse = array(
			'FinalAmounts' => '0.00',
			'TotaoIn' => '0.00',
			'TotaoOut' => '0.00',
			'shopping' => '0.00',
			'PoolIncome' => '0.00',
			'PoolReferIncome' => '0.00',
			'DailyROIIncome' => '0.00',
			'ReferGenerationIncome' => '0.00',
			'GenerationROIIncome' => '0.00',
			'SpecialReferSales' => '0.00',
			'PremiumClubProfit' => '0.00',
			'VipClubProfit' => '0.00',
			'RankRewardIncentive' => '0.00',
			'TotalWithdraw' => '0.00',
			'CurrentRank' => 'No Rank'
		);
		header('Content-Type: application/json');
		echo json_encode($errorResponse);
	}
		
	}
?>