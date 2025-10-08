<?php
    session_start(); 
    if(!isset($_SESSION['roboMember'])){
    	header("Location:logout.php");
    	exit();
    }else{
	require '../db/db.php';
	require '../db/functions.php';
	
	// Income calculation functions
	function getPoolIncome($user) {
		global $mysqli;
		$result = $mysqli->query("SELECT SUM(amount) as total FROM pool_income WHERE user='$user'");
		$row = mysqli_fetch_assoc($result);
		return $row['total'] ? $row['total'] : 0;
	}
	
	function getPoolReferIncome($user) {
		global $mysqli;
		$result = $mysqli->query("SELECT SUM(amount) as total FROM pool_refer_income WHERE user='$user'");
		$row = mysqli_fetch_assoc($result);
		return $row['total'] ? $row['total'] : 0;
	}
	
	function getDailyROIIncome($user) {
		global $mysqli;
		$result = $mysqli->query("SELECT SUM(amount) as total FROM daily_roi_income WHERE user='$user'");
		$row = mysqli_fetch_assoc($result);
		return $row['total'] ? $row['total'] : 0;
	}
	
	function getReferGenerationIncome($user) {
		global $mysqli;
		$result = $mysqli->query("SELECT SUM(amount) as total FROM refer_generation_income WHERE user='$user'");
		$row = mysqli_fetch_assoc($result);
		return $row['total'] ? $row['total'] : 0;
	}
	
	function getGenerationROIIncome($user) {
		global $mysqli;
		$result = $mysqli->query("SELECT SUM(amount) as total FROM generation_roi_income WHERE user='$user'");
		$row = mysqli_fetch_assoc($result);
		return $row['total'] ? $row['total'] : 0;
	}
	
	function getSpecialReferSales($user) {
		global $mysqli;
		$result = $mysqli->query("SELECT SUM(amount) as total FROM special_refer_sales WHERE user='$user'");
		$row = mysqli_fetch_assoc($result);
		return $row['total'] ? $row['total'] : 0;
	}
	
	function getPremiumClubProfit($user) {
		global $mysqli;
		$result = $mysqli->query("SELECT SUM(amount) as total FROM premium_club_profit WHERE user='$user'");
		$row = mysqli_fetch_assoc($result);
		return $row['total'] ? $row['total'] : 0;
	}
	
	function getVipClubProfit($user) {
		global $mysqli;
		$result = $mysqli->query("SELECT SUM(amount) as total FROM vip_club_profit WHERE user='$user'");
		$row = mysqli_fetch_assoc($result);
		return $row['total'] ? $row['total'] : 0;
	}
	
	function getRankRewardIncentive($user) {
		global $mysqli;
		$result = $mysqli->query("SELECT SUM(amount) as total FROM rank_reward_incentive WHERE user='$user'");
		$row = mysqli_fetch_assoc($result);
		return $row['total'] ? $row['total'] : 0;
	}
	
	function getTotalWithdraw($user) {
		global $mysqli;
		$result = $mysqli->query("SELECT SUM(amount) as total FROM withdrawal WHERE user='$user' AND status='completed'");
		$row = mysqli_fetch_assoc($result);
		return $row['total'] ? $row['total'] : 0;
	}
	
	function getCurrentRank($user) {
		global $mysqli;
		// First try to get rank from user table
		$result = $mysqli->query("SELECT rank FROM user WHERE user_id='$user'");
		$row = mysqli_fetch_assoc($result);
		
		if ($row && !empty($row['rank'])) {
			return $row['rank'];
		}
		
		// If no rank in user table, try rank table
		$result = $mysqli->query("SELECT rank_name FROM rank WHERE user='$user' ORDER BY id DESC LIMIT 1");
		$row = mysqli_fetch_assoc($result);
		
		if ($row && !empty($row['rank_name'])) {
			return $row['rank_name'];
		}
		
		return "No Rank";
	}
	
		$returnAmn=array();
		$user=$_SESSION['roboMember'];
		
		$BotAmn=mysqli_num_rows($mysqli->query("SELECT * FROM `upgrade` WHERE `user`='".$user."'"));
		
		$uiyre=remainAmn22($user);
		
	$returnAmn['bOTqTY']=$BotAmn;
	$returnAmn['RemainReturn']=RemainingReturn($user);
	$returnAmn['TotalIncome']=TtalIncome($user);
	$returnAmn['FinalAmount']=number_format($uiyre['final'],2,'.',',');
	$returnAmn['TotaoIn']=number_format($uiyre['in'],2,'.',',');
	$returnAmn['TotaoOut']=number_format($uiyre['out'],2,'.',',');
	$returnAmn['shopping']=number_format($uiyre['shop'],2,'.',',');
	
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
	
	echo json_encode($returnAmn);
		
	}
?>