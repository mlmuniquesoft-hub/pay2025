<?php
session_start(); 
if(!isset($_SESSION['Admin'])){
	header("Location:logout.php");
	exit();
} else {
	require '../db/db.php';
	require '../db/functions.php';
	require_once '../db/calculation_admin.php';
	require_once '../db/template.php';
	
	// Handle form submission
	if(isset($_POST['update_settings'])) {
		$pin = $_POST['transaction_pin'];
		
		// Verify admin pin
		$adminCheck = mysqli_num_rows($mysqli->query("SELECT * FROM `admin` WHERE `user_id`='".$_SESSION['Admin']."' AND `tr_password`='".$pin."'"));
		if($adminCheck < 1) {
			$_SESSION['msg'] = "Invalid Transaction PIN";
		} else {
			// Update settings
			$settings = array(
				'system_enabled' => $_POST['system_enabled'],
				'weekend_enabled' => $_POST['weekend_enabled'],
				'basic_min_rate' => $_POST['basic_min_rate'],
				'basic_max_rate' => $_POST['basic_max_rate'],
				'premium_min_rate' => $_POST['premium_min_rate'],
				'premium_max_rate' => $_POST['premium_max_rate'],
				'vip_min_rate' => $_POST['vip_min_rate'],
				'vip_max_rate' => $_POST['vip_max_rate'],
				'basic_range_min' => $_POST['basic_range_min'],
				'basic_range_max' => $_POST['basic_range_max'],
				'premium_range_min' => $_POST['premium_range_min'],
				'premium_range_max' => $_POST['premium_range_max'],
				'vip_range_min' => $_POST['vip_range_min'],
				'profit_percentage' => $_POST['profit_percentage'],
				'shopping_percentage' => $_POST['shopping_percentage']
			);
			
			foreach($settings as $name => $value) {
				$value = $mysqli->real_escape_string($value);
				$mysqli->query("UPDATE `return_settings` SET `setting_value`='$value', `updated_at`=NOW() WHERE `setting_name`='$name'");
			}
			
			$_SESSION['msg'] = "Daily return settings updated successfully!";
		}
		
		header("Location: daily_return_settings.php");
		exit();
	}
	
	// Get current settings
	$currentSettings = array();
	$settingsQuery = $mysqli->query("SELECT * FROM `return_settings`");
	while($row = mysqli_fetch_assoc($settingsQuery)) {
		$currentSettings[$row['setting_name']] = $row['setting_value'];
	}
	
	// Get system statistics
	$totalUsers = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(DISTINCT user) as total FROM `upgrade`"));
	$todayReturns = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(*) as count, SUM(curent_bal) as total FROM `game_return` WHERE DATE(`date`)=CURDATE()"));
	$totalReturns = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(*) as count, SUM(curent_bal) as total FROM `game_return`"));
?>

<!DOCTYPE html>
<html>
<head>
	<title>Daily Return System Settings - Capitol Money Pay</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="../assets/css/font-awesome.min.css" rel="stylesheet">
	<style>
		body { background: #f8fafc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
		.main-header { background: linear-gradient(135deg, #1e3a8a, #3b82f6); color: white; padding: 30px 0; margin-bottom: 30px; }
		.settings-card { background: white; border-radius: 10px; padding: 25px; margin-bottom: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
		.stat-card { background: linear-gradient(135deg, #059669, #10b981); color: white; padding: 20px; border-radius: 10px; text-align: center; margin-bottom: 20px; }
		.stat-card.orange { background: linear-gradient(135deg, #f59e0b, #f97316); }
		.stat-card.red { background: linear-gradient(135deg, #dc2626, #ef4444); }
		.stat-card.purple { background: linear-gradient(135deg, #7c3aed, #8b5cf6); }
		.form-group label { font-weight: bold; color: #374151; margin-bottom: 5px; }
		.form-control { border-radius: 5px; border: 1px solid #d1d5db; }
		.btn-primary { background: linear-gradient(135deg, #1e3a8a, #3b82f6); border: none; border-radius: 5px; }
		.alert { border-radius: 8px; }
		.range-info { background: #f0f9ff; border-left: 4px solid #3b82f6; padding: 10px 15px; margin: 10px 0; border-radius: 5px; }
		.toggle-switch { position: relative; display: inline-block; width: 60px; height: 34px; }
		.toggle-switch input { opacity: 0; width: 0; height: 0; }
		.slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 34px; }
		.slider:before { position: absolute; content: ""; height: 26px; width: 26px; left: 4px; bottom: 4px; background-color: white; transition: .4s; border-radius: 50%; }
		input:checked + .slider { background-color: #059669; }
		input:checked + .slider:before { transform: translateX(26px); }
	</style>
</head>
<body>

<div class="main-header">
	<div class="container">
		<h1>🎯 Daily Investment Return System</h1>
		<p>Manage package-wise return rates and system settings</p>
	</div>
</div>

<div class="container">
	<?php if(isset($_SESSION['msg'])): ?>
		<div class="alert alert-info">
			<strong>Notice:</strong> <?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?>
		</div>
	<?php endif; ?>
	
	<!-- Statistics Cards -->
	<div class="row">
		<div class="col-md-3">
			<div class="stat-card">
				<h3><?php echo $totalUsers['total']; ?></h3>
				<p>Total Investors</p>
			</div>
		</div>
		<div class="col-md-3">
			<div class="stat-card orange">
				<h3><?php echo $todayReturns['count'] ?? 0; ?></h3>
				<p>Today's Returns Processed</p>
			</div>
		</div>
		<div class="col-md-3">
			<div class="stat-card red">
				<h3>$<?php echo number_format($todayReturns['total'] ?? 0, 2); ?></h3>
				<p>Today's Return Amount</p>
			</div>
		</div>
		<div class="col-md-3">
			<div class="stat-card purple">
				<h3>$<?php echo number_format($totalReturns['total'] ?? 0, 2); ?></h3>
				<p>Total Returns Paid</p>
			</div>
		</div>
	</div>

	<form method="POST" action="">
		<div class="row">
			<!-- System Control -->
			<div class="col-md-6">
				<div class="settings-card">
					<h3>🎛️ System Controls</h3>
					
					<div class="form-group">
						<label>Daily Return System Status</label>
						<br>
						<label class="toggle-switch">
							<input type="checkbox" name="system_enabled" value="1" <?php echo ($currentSettings['system_enabled'] == '1') ? 'checked' : ''; ?>>
							<span class="slider"></span>
						</label>
						<span style="margin-left: 10px;">
							<?php echo ($currentSettings['system_enabled'] == '1') ? '✅ System Enabled' : '❌ System Disabled'; ?>
						</span>
					</div>
					
					<div class="form-group">
						<label>Weekend Trading (Saturday & Sunday)</label>
						<br>
						<label class="toggle-switch">
							<input type="checkbox" name="weekend_enabled" value="1" <?php echo ($currentSettings['weekend_enabled'] == '1') ? 'checked' : ''; ?>>
							<span class="slider"></span>
						</label>
						<span style="margin-left: 10px;">
							<?php echo ($currentSettings['weekend_enabled'] == '1') ? '✅ Weekend Trading Enabled' : '❌ Weekends Off'; ?>
						</span>
					</div>
				</div>
				
				<!-- Profit Distribution -->
				<div class="settings-card">
					<h3>💰 Profit Distribution</h3>
					
					<div class="form-group">
						<label>Profit Percentage (%)</label>
						<input type="number" class="form-control" name="profit_percentage" value="<?php echo $currentSettings['profit_percentage']; ?>" min="0" max="100" step="1" required>
						<small class="text-muted">Percentage of daily return that goes to user's main balance</small>
					</div>
					
					<div class="form-group">
						<label>Shopping Bonus Percentage (%)</label>
						<input type="number" class="form-control" name="shopping_percentage" value="<?php echo $currentSettings['shopping_percentage']; ?>" min="0" max="100" step="1" required>
						<small class="text-muted">Percentage of daily return that goes as shopping bonus</small>
					</div>
					
					<div class="range-info">
						<strong>Note:</strong> Profit % + Shopping % should equal 100%
					</div>
				</div>
			</div>
			
			<!-- Return Rate Settings -->
			<div class="col-md-6">
				<div class="settings-card">
					<h3>📊 Package-wise Return Rates</h3>
					
					<!-- Basic Range -->
					<div style="border: 2px solid #059669; border-radius: 8px; padding: 15px; margin-bottom: 15px;">
						<h4 style="color: #059669;">🌱 Basic Range</h4>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Amount Range ($)</label>
									<div class="input-group">
										<input type="number" class="form-control" name="basic_range_min" value="<?php echo $currentSettings['basic_range_min']; ?>" required>
										<span class="input-group-addon">to</span>
										<input type="number" class="form-control" name="basic_range_max" value="<?php echo $currentSettings['basic_range_max']; ?>" required>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Return Rate Range (%)</label>
									<div class="input-group">
										<input type="number" class="form-control" name="basic_min_rate" value="<?php echo $currentSettings['basic_min_rate']; ?>" step="0.1" required>
										<span class="input-group-addon">to</span>
										<input type="number" class="form-control" name="basic_max_rate" value="<?php echo $currentSettings['basic_max_rate']; ?>" step="0.1" required>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<!-- Premium Range -->
					<div style="border: 2px solid #dc2626; border-radius: 8px; padding: 15px; margin-bottom: 15px;">
						<h4 style="color: #dc2626;">⭐ Premium Range</h4>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Amount Range ($)</label>
									<div class="input-group">
										<input type="number" class="form-control" name="premium_range_min" value="<?php echo $currentSettings['premium_range_min']; ?>" required>
										<span class="input-group-addon">to</span>
										<input type="number" class="form-control" name="premium_range_max" value="<?php echo $currentSettings['premium_range_max']; ?>" required>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Return Rate Range (%)</label>
									<div class="input-group">
										<input type="number" class="form-control" name="premium_min_rate" value="<?php echo $currentSettings['premium_min_rate']; ?>" step="0.1" required>
										<span class="input-group-addon">to</span>
										<input type="number" class="form-control" name="premium_max_rate" value="<?php echo $currentSettings['premium_max_rate']; ?>" step="0.1" required>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<!-- VIP Range -->
					<div style="border: 2px solid #7c3aed; border-radius: 8px; padding: 15px; margin-bottom: 15px;">
						<h4 style="color: #7c3aed;">👑 VIP Range</h4>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Minimum Amount ($)</label>
									<input type="number" class="form-control" name="vip_range_min" value="<?php echo $currentSettings['vip_range_min']; ?>" required>
									<small class="text-muted">No maximum limit</small>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Return Rate Range (%)</label>
									<div class="input-group">
										<input type="number" class="form-control" name="vip_min_rate" value="<?php echo $currentSettings['vip_min_rate']; ?>" step="0.1" required>
										<span class="input-group-addon">to</span>
										<input type="number" class="form-control" name="vip_max_rate" value="<?php echo $currentSettings['vip_max_rate']; ?>" step="0.1" required>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Security Confirmation -->
		<div class="settings-card">
			<h3>🔐 Security Confirmation</h3>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Transaction PIN</label>
						<input type="password" class="form-control" name="transaction_pin" placeholder="Enter your admin transaction PIN" required>
						<small class="text-muted">Required to confirm settings changes</small>
					</div>
				</div>
				<div class="col-md-6" style="padding-top: 25px;">
					<button type="submit" name="update_settings" class="btn btn-primary btn-lg">
						💾 Update Settings
					</button>
				</div>
			</div>
		</div>
	</form>
	
	<!-- Manual Execution -->
	<div class="settings-card">
		<h3>⚡ Manual Execution</h3>
		<p>Run the daily return process manually (useful for testing or catching up missed days)</p>
		<a href="../db/invest_return.php" target="_blank" class="btn btn-warning">
			🚀 Run Daily Returns Process
		</a>
		<small class="text-muted" style="margin-left: 10px;">Opens in new window to show execution log</small>
	</div>
</div>

<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>

</body>
</html>

<?php } ?>