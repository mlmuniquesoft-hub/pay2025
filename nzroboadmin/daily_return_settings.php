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

    // Ensure table exists and has correct structure
    $create_table_sql = "CREATE TABLE IF NOT EXISTS `return_settings` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `system_active` tinyint(1) DEFAULT 1,
        `weekend_mode` tinyint(1) DEFAULT 0,
        `saturday_enabled` tinyint(1) DEFAULT 1,
        `sunday_enabled` tinyint(1) DEFAULT 1,
        `basic_min` decimal(10,2) DEFAULT 100.00,
        `basic_max` decimal(10,2) DEFAULT 999.00,
        `premium_min` decimal(10,2) DEFAULT 1000.00,
        `premium_max` decimal(10,2) DEFAULT 4999.00,
        `vip_min` decimal(10,2) DEFAULT 5000.00,
        `basic_rate_min` decimal(5,2) DEFAULT 0.30,
        `basic_rate_max` decimal(5,2) DEFAULT 0.50,
        `premium_rate_min` decimal(5,2) DEFAULT 0.50,
        `premium_rate_max` decimal(5,2) DEFAULT 0.70,
        `vip_rate_min` decimal(5,2) DEFAULT 0.80,
        `vip_rate_max` decimal(5,2) DEFAULT 1.00,
        `min_balance_threshold` decimal(10,2) DEFAULT 10.00,
        `max_return_per_day` decimal(15,2) DEFAULT 1000000.00,
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        `last_updated` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `updated_by` varchar(50) DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8";
    
    mysqli_query($mysqli, $create_table_sql);
    
    // Create daily_control table for per-day return control
    $daily_control_sql = "CREATE TABLE IF NOT EXISTS `daily_control` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `control_date` date NOT NULL,
        `is_disabled` tinyint(1) DEFAULT 0,
        `reason` varchar(255) DEFAULT NULL,
        `disabled_by` varchar(50) DEFAULT NULL,
        `disabled_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `idx_control_date` (`control_date`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8";
    
    mysqli_query($mysqli, $daily_control_sql);
    
    // Remove unique constraint if it exists (for existing installations)
    $unique_index_check = mysqli_query($mysqli, "SHOW INDEX FROM daily_control WHERE Key_name = 'control_date'");
    if($unique_index_check && mysqli_num_rows($unique_index_check) > 0) {
        mysqli_query($mysqli, "ALTER TABLE daily_control DROP INDEX control_date");
    }
    
    // Add regular index if not exists
    $index_check = mysqli_query($mysqli, "SHOW INDEX FROM daily_control WHERE Key_name = 'idx_control_date'");
    if(!$index_check || mysqli_num_rows($index_check) == 0) {
        mysqli_query($mysqli, "ALTER TABLE daily_control ADD INDEX idx_control_date (control_date)");
    }
    
    // Check if columns exist and add them if missing
    $columns_to_check = array(
        'system_active' => 'ALTER TABLE return_settings ADD COLUMN system_active tinyint(1) DEFAULT 1',
        'weekend_mode' => 'ALTER TABLE return_settings ADD COLUMN weekend_mode tinyint(1) DEFAULT 0',
        'saturday_enabled' => 'ALTER TABLE return_settings ADD COLUMN saturday_enabled tinyint(1) DEFAULT 1',
        'sunday_enabled' => 'ALTER TABLE return_settings ADD COLUMN sunday_enabled tinyint(1) DEFAULT 1'
    );
    
    foreach($columns_to_check as $column => $alter_sql) {
        $column_check = mysqli_query($mysqli, "SHOW COLUMNS FROM return_settings LIKE '$column'");
        if(mysqli_num_rows($column_check) == 0) {
            mysqli_query($mysqli, $alter_sql);
        }
    }
    
    // Check if default settings exist, if not create them
    $check_default = mysqli_query($mysqli, "SELECT id FROM return_settings WHERE id = 1");
    if(mysqli_num_rows($check_default) == 0){
        $default_sql = "INSERT INTO return_settings (
            system_active, weekend_mode, saturday_enabled, sunday_enabled,
            basic_min, basic_max, premium_min, premium_max, vip_min,
            basic_rate_min, basic_rate_max, premium_rate_min, premium_rate_max,
            vip_rate_min, vip_rate_max, min_balance_threshold, max_return_per_day,
            updated_by
        ) VALUES (
            1, 0, 1, 1,
            100, 999, 1000, 4999, 5000,
            0.3, 0.5, 0.5, 0.7,
            0.8, 1.0, 10, 1000000,
            'system'
        )";
        mysqli_query($mysqli, $default_sql);
    }

    // Handle form submissions
    if(isset($_POST['save_settings'])){
        $transaction_pin = trim($_POST['transaction_pin']);
        
        if(empty($transaction_pin)){
            $error = "Transaction PIN is required";
        } else {
            // Verify transaction PIN
            $pin_check = mysqli_query($mysqli, "SELECT * FROM admin WHERE user_id='".$_SESSION['Admin']."' AND tr_password='".$transaction_pin."'");
            if(mysqli_num_rows($pin_check) == 0){
                $error = "Invalid Transaction PIN";
            } else {
                // Process settings
                $system_active = isset($_POST['system_active']) ? 1 : 0;
                $weekend_mode = isset($_POST['weekend_mode']) ? 1 : 0;
                $saturday_enabled = isset($_POST['saturday_enabled']) ? 1 : 0;
                $sunday_enabled = isset($_POST['sunday_enabled']) ? 1 : 0;
                
                // Package ranges
                $basic_min = (float)$_POST['basic_min'];
                $basic_max = (float)$_POST['basic_max'];
                $premium_min = (float)$_POST['premium_min'];
                $premium_max = (float)$_POST['premium_max'];
                $vip_min = (float)$_POST['vip_min'];
                
                // Return rates
                $basic_rate_min = (float)$_POST['basic_rate_min'];
                $basic_rate_max = (float)$_POST['basic_rate_max'];
                $premium_rate_min = (float)$_POST['premium_rate_min'];
                $premium_rate_max = (float)$_POST['premium_rate_max'];
                $vip_rate_min = (float)$_POST['vip_rate_min'];
                $vip_rate_max = (float)$_POST['vip_rate_max'];
                
                // Additional settings
                $min_balance_threshold = (float)$_POST['min_balance_threshold'];
                $max_return_per_day = (float)$_POST['max_return_per_day'];
                
                // Check if settings exist
                $check = mysqli_query($mysqli, "SELECT id FROM return_settings WHERE id = 1");
                
                if(mysqli_num_rows($check) > 0){
                    // Update existing settings
                    $sql = "UPDATE return_settings SET 
                        system_active = '$system_active',
                        weekend_mode = '$weekend_mode',
                        saturday_enabled = '$saturday_enabled',
                        sunday_enabled = '$sunday_enabled',
                        basic_min = '$basic_min',
                        basic_max = '$basic_max',
                        premium_min = '$premium_min',
                        premium_max = '$premium_max',
                        vip_min = '$vip_min',
                        basic_rate_min = '$basic_rate_min',
                        basic_rate_max = '$basic_rate_max',
                        premium_rate_min = '$premium_rate_min',
                        premium_rate_max = '$premium_rate_max',
                        vip_rate_min = '$vip_rate_min',
                        vip_rate_max = '$vip_rate_max',
                        min_balance_threshold = '$min_balance_threshold',
                        max_return_per_day = '$max_return_per_day',
                        last_updated = NOW(),
                        updated_by = '".$_SESSION['Admin']."'
                        WHERE id = 1";
                } else {
                    // Insert new settings
                    $sql = "INSERT INTO return_settings (
                        system_active, weekend_mode, saturday_enabled, sunday_enabled,
                        basic_min, basic_max, premium_min, premium_max, vip_min,
                        basic_rate_min, basic_rate_max, premium_rate_min, premium_rate_max,
                        vip_rate_min, vip_rate_max, min_balance_threshold, max_return_per_day,
                        created_at, updated_by
                    ) VALUES (
                        '$system_active', '$weekend_mode', '$saturday_enabled', '$sunday_enabled',
                        '$basic_min', '$basic_max', '$premium_min', '$premium_max', '$vip_min',
                        '$basic_rate_min', '$basic_rate_max', '$premium_rate_min', '$premium_rate_max',
                        '$vip_rate_min', '$vip_rate_max', '$min_balance_threshold', '$max_return_per_day',
                        NOW(), '".$_SESSION['Admin']."'
                    )";
                }
                
                if(mysqli_query($mysqli, $sql)){
                    $success = "Settings saved successfully!";
                } else {
                    $error = "Error saving settings: " . mysqli_error($mysqli);
                }
            }
        }
    }

    // Daily Control - Disable/Enable specific dates
    if(isset($_POST['daily_control_action'])){
        $transaction_pin = trim($_POST['daily_control_pin']);
        $control_date = trim($_POST['control_date']);
        $action = $_POST['daily_control_action'];
        $reason = trim($_POST['disable_reason']);
        
        if(empty($transaction_pin)){
            $error = "Transaction PIN is required";
        } elseif(empty($control_date)){
            $error = "Date is required";
        } elseif(!preg_match('/^\d{4}-\d{2}-\d{2}$/', $control_date)){
            $error = "Invalid date format";
        } else {
            // Verify transaction PIN
            $pin_check = mysqli_query($mysqli, "SELECT * FROM admin WHERE user_id='".$_SESSION['Admin']."' AND tr_password='".$transaction_pin."'");
            if(mysqli_num_rows($pin_check) == 0){
                $error = "Invalid Transaction PIN";
            } else {
                // Check if there's already a record for today to prevent duplicate actions
                $today_check = mysqli_query($mysqli, "SELECT * FROM daily_control WHERE control_date = '$control_date' ORDER BY disabled_at DESC LIMIT 1");
                $existing_control = mysqli_fetch_assoc($today_check);
                
                if($action == 'disable'){
                    // Check if already disabled
                    if($existing_control && $existing_control['is_disabled'] == 1) {
                        $error = "Date $control_date is already disabled!";
                    } else {
                        // Disable the date - Always insert new record for audit trail
                        $disable_sql = "INSERT INTO daily_control (control_date, is_disabled, reason, disabled_by) 
                                       VALUES ('$control_date', 1, '$reason', '".$_SESSION['Admin']."')";
                        if(mysqli_query($mysqli, $disable_sql)){
                            $success = "Date $control_date has been disabled successfully!";
                        } else {
                            $error = "Error disabling date: " . mysqli_error($mysqli);
                        }
                    }
                } elseif($action == 'enable'){
                    // Check if already enabled or no control exists
                    if(!$existing_control || $existing_control['is_disabled'] == 0) {
                        $error = "Date $control_date is already enabled or not controlled!";
                    } else {
                        // Enable the date - Always insert new record for audit trail
                        $enable_reason = !empty($reason) ? $reason : 'Re-enabled by admin';
                        $enable_sql = "INSERT INTO daily_control (control_date, is_disabled, reason, disabled_by) 
                                      VALUES ('$control_date', 0, '$enable_reason', '".$_SESSION['Admin']."')";
                        if(mysqli_query($mysqli, $enable_sql)){
                            $success = "Date $control_date has been enabled successfully!";
                        } else {
                            $error = "Error enabling date: " . mysqli_error($mysqli);
                        }
                    }
                }
            }
        }
    }

    // Manual execution
    if(isset($_POST['manual_execute'])){
        $transaction_pin = trim($_POST['manual_pin']);
        
        if(empty($transaction_pin)){
            $error = "Transaction PIN is required";
        } else {
            // Verify transaction PIN
            $pin_check = mysqli_query($mysqli, "SELECT * FROM admin WHERE user_id='".$_SESSION['Admin']."' AND tr_password='".$transaction_pin."'");
            if(mysqli_num_rows($pin_check) == 0){
                $error = "Invalid Transaction PIN";
            } else {
                // Execute daily returns only (generation bonuses separate)
                require_once '../db/invest_return.php';
                $success = "Daily returns executed successfully! Note: Generation bonuses should be run separately.";
            }
        }
    }

    // Generation bonus execution (separate from daily returns)
    if(isset($_POST['manual_generation'])){
        $transaction_pin = trim($_POST['generation_pin']);
        $target_date = trim($_POST['generation_date']);
        
        if(empty($transaction_pin)){
            $error = "Transaction PIN is required";
        } elseif(empty($target_date)){
            $error = "Date is required for generation bonus processing";
        } else {
            // Verify transaction PIN
            $pin_check = mysqli_query($mysqli, "SELECT * FROM admin WHERE user_id='".$_SESSION['Admin']."' AND tr_password='".$transaction_pin."'");
            if(mysqli_num_rows($pin_check) == 0){
                $error = "Invalid Transaction PIN";
            } else {
                // Check user count to warn about potential timeout
                $user_count_check = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT COUNT(DISTINCT m.user) as total FROM `member` m INNER JOIN `upgrade` u ON m.user = u.user WHERE DATE(m.time)<='".$target_date."' AND m.paid='1'"));
                $total_users = ($user_count_check && $user_count_check['total']) ? (int)$user_count_check['total'] : 0;
                
                if($total_users > 200) {
                    $error = "⚠️ Large user base ($total_users users) detected.<br><br>
                             <div style='background: #fff3cd; padding: 15px; border-radius: 5px; border: 1px solid #ffeaa7; margin: 10px 0;'>
                                <h4 style='margin: 0 0 10px 0; color: #856404;'>🚀 Processing Options:</h4>
                                <p style='margin: 5px 0;'><strong>Option 1 (Recommended):</strong> <a href='generation_batch_processor.php?date=$target_date' target='_blank' style='background: #007cba; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; display: inline-block; margin-left: 10px;'>Use Web-Based Batch Processor →</a></p>
                                <p style='margin: 5px 0; color: #6c757d; font-size: 0.9em;'>Processes 100 users at a time safely (~18 batches for $total_users users)</p>
                                <p style='margin: 5px 0;'><strong>Option 2:</strong> Use cron job: <code style='background: #f8f9fa; padding: 2px 5px; border-radius: 3px;'>php db/cron_generation_bonus.php $target_date</code></p>
                             </div>
                             <div style='background: #f8d7da; padding: 10px; border-radius: 5px; border: 1px solid #f5c6cb; margin: 10px 0;'>
                                <p style='margin: 0; color: #721c24; font-size: 0.9em;'><strong>Warning:</strong> Processing $total_users users directly through web interface may cause server timeout.</p>
                             </div>";
                } else {
                    // Execute generation bonuses for smaller user bases
                    require_once '../db/generation.php';
                    ob_start();
                    $result = Generationoncome($target_date);
                    $output = ob_get_clean();
                    
                    if($result) {
                        $success = "Generation bonuses processed successfully for $target_date! Processed $total_users users.";
                    } else {
                        $error = "Generation bonus processing failed. Output: " . $output;
                    }
                }
            }
        }
    }

    // Load current settings
    $settings_query = mysqli_query($mysqli, "SELECT * FROM return_settings WHERE id = 1");
    $settings = mysqli_fetch_assoc($settings_query);

    // Fallback default values if database operation fails
    if(!$settings){
        $settings = array(
            'system_active' => 1,
            'weekend_mode' => 0,
            'saturday_enabled' => 1,
            'sunday_enabled' => 1,
            'basic_min' => 100,
            'basic_max' => 999,
            'premium_min' => 1000,
            'premium_max' => 4999,
            'vip_min' => 5000,
            'basic_rate_min' => 0.3,
            'basic_rate_max' => 0.5,
            'premium_rate_min' => 0.5,
            'premium_rate_max' => 0.7,
            'vip_rate_min' => 0.8,
            'vip_rate_max' => 1.0,
            'min_balance_threshold' => 10,
            'max_return_per_day' => 1000000
        );
    }

    // Get statistics with proper null handling
    $total_users_query = mysqli_query($mysqli, "SELECT COUNT(DISTINCT user) as total FROM upgrade");
    $total_users_result = mysqli_fetch_assoc($total_users_query);
    $total_users = ($total_users_result && isset($total_users_result['total'])) ? (int)$total_users_result['total'] : 0;

    $total_investment_query = mysqli_query($mysqli, "SELECT SUM(amount) as total FROM upgrade");
    $total_investment_result = mysqli_fetch_assoc($total_investment_query);
    $total_investment = ($total_investment_result && isset($total_investment_result['total']) && $total_investment_result['total'] !== null) ? (float)$total_investment_result['total'] : 0.00;

    $today_returns_query = mysqli_query($mysqli, "SELECT SUM(curent_bal) as total FROM game_return WHERE DATE(date) = CURDATE()");
    $today_returns_result = mysqli_fetch_assoc($today_returns_query);
    $today_returns = ($today_returns_result && isset($today_returns_result['total']) && $today_returns_result['total'] !== null) ? (float)$today_returns_result['total'] : 0.00;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title><?php echo $Adminnb; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300,400' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>
    <!-- CSS Libs -->
    <link rel="stylesheet" type="text/css" href="lib/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/animate.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/bootstrap-switch.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/checkbox3.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/dataTables.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="lib/css/select2.min.css">
    <!-- CSS App -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/themes/flat-blue.css">
    
    <style>
        .settings-card {
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .slider {
            background-color: #2196F3;
        }
        input:checked + .slider:before {
            transform: translateX(26px);
        }
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .package-card {
            border-left: 4px solid;
        }
        .basic-card { border-left-color: #28a745; }
        .premium-card { border-left-color: #fd7e14; }
        .vip-card { border-left-color: #dc3545; }
        .execution-card {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }
    </style>
</head>

<body class="flat-blue">
    <div class="app-container expanded">
        <div class="row content-container">
            <?php require_once'menu.php'?>
            <!-- Main Content -->
            <div class="container-fluid">
                <div class="side-body padding-top">
                    <?php require_once'topshow.php'?>
                    
                    <div class="row no-margin-bottom">
                        <div class="col-sm-12 col-xs-12">
                            <!-- Page Header -->
                            <div class="row">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <i class="fa fa-cogs fa-fw"></i> Daily Return System Settings
                                        <div class="pull-right">
                                            <small>Package-wise Return Management</small>
                                        </div>
                                    </div>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        
                                        <?php if(isset($error)): ?>
                                            <div class="alert alert-danger">
                                                <i class="fa fa-exclamation-triangle"></i> <?php echo $error; ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if(isset($success)): ?>
                                            <div class="alert alert-success">
                                                <i class="fa fa-check"></i> <?php echo $success; ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!-- Statistics Row -->
                                        <div class="row" style="margin-bottom: 20px;">
                                            <div class="col-md-3">
                                                <div class="panel panel-primary">
                                                    <div class="panel-body stats-card text-center">
                                                        <h3><?php echo number_format((int)$total_users); ?></h3>
                                                        <p>Active Investors</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="panel panel-info">
                                                    <div class="panel-body text-center" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white;">
                                                        <h3>$<?php echo number_format((float)$total_investment, 2); ?></h3>
                                                        <p>Total Investment</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="panel panel-success">
                                                    <div class="panel-body text-center" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white;">
                                                        <h3>$<?php echo number_format((float)$today_returns, 2); ?></h3>
                                                        <p>Today's Returns</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="panel panel-warning">
                                                    <div class="panel-body text-center execution-card">
                                                        <h3><i class="fa fa-clock-o"></i></h3>
                                                        <p>System Status: <?php echo (isset($settings['system_active']) && $settings['system_active']) ? 'Active' : 'Inactive'; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Settings Form -->
                                        <form method="POST">
                                            <!-- System Settings -->
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <i class="fa fa-power-off"></i> System Controls
                                                </div>
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>System Status</label>
                                                                <div>
                                                                    <label class="switch">
                                                                        <input type="checkbox" name="system_active" <?php echo (isset($settings['system_active']) && $settings['system_active']) ? 'checked' : ''; ?>>
                                                                        <span class="slider"></span>
                                                                    </label>
                                                                    <span style="margin-left: 10px;">Enable Daily Returns System</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Weekend Trading</label>
                                                                <div>
                                                                    <label class="switch">
                                                                        <input type="checkbox" name="weekend_mode" <?php echo (isset($settings['weekend_mode']) && $settings['weekend_mode']) ? 'checked' : ''; ?>>
                                                                        <span class="slider"></span>
                                                                    </label>
                                                                    <span style="margin-left: 10px;">Enable Weekend Returns</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Saturday Trading</label>
                                                                <div>
                                                                    <label class="switch">
                                                                        <input type="checkbox" name="saturday_enabled" <?php echo (isset($settings['saturday_enabled']) && $settings['saturday_enabled']) ? 'checked' : ''; ?>>
                                                                        <span class="slider"></span>
                                                                    </label>
                                                                    <span style="margin-left: 10px;">Enable Saturday Returns</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Sunday Trading</label>
                                                                <div>
                                                                    <label class="switch">
                                                                        <input type="checkbox" name="sunday_enabled" <?php echo (isset($settings['sunday_enabled']) && $settings['sunday_enabled']) ? 'checked' : ''; ?>>
                                                                        <span class="slider"></span>
                                                                    </label>
                                                                    <span style="margin-left: 10px;">Enable Sunday Returns</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Package Settings -->
                                            <div class="row">
                                                <!-- Basic Package -->
                                                <div class="col-md-4">
                                                    <div class="panel panel-default package-card basic-card">
                                                        <div class="panel-heading">
                                                            <i class="fa fa-star-o"></i> Basic Package
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <label>Range Min ($)</label>
                                                                <input type="number" class="form-control" name="basic_min" value="<?php echo isset($settings['basic_min']) ? $settings['basic_min'] : '100'; ?>" step="0.01">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Range Max ($)</label>
                                                                <input type="number" class="form-control" name="basic_max" value="<?php echo isset($settings['basic_max']) ? $settings['basic_max'] : '999'; ?>" step="0.01">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Min Rate (%)</label>
                                                                <input type="number" class="form-control" name="basic_rate_min" value="<?php echo isset($settings['basic_rate_min']) ? $settings['basic_rate_min'] : '0.3'; ?>" step="0.01">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Max Rate (%)</label>
                                                                <input type="number" class="form-control" name="basic_rate_max" value="<?php echo isset($settings['basic_rate_max']) ? $settings['basic_rate_max'] : '0.5'; ?>" step="0.01">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Premium Package -->
                                                <div class="col-md-4">
                                                    <div class="panel panel-default package-card premium-card">
                                                        <div class="panel-heading">
                                                            <i class="fa fa-star-half-o"></i> Premium Package
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <label>Range Min ($)</label>
                                                                <input type="number" class="form-control" name="premium_min" value="<?php echo isset($settings['premium_min']) ? $settings['premium_min'] : '1000'; ?>" step="0.01">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Range Max ($)</label>
                                                                <input type="number" class="form-control" name="premium_max" value="<?php echo isset($settings['premium_max']) ? $settings['premium_max'] : '4999'; ?>" step="0.01">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Min Rate (%)</label>
                                                                <input type="number" class="form-control" name="premium_rate_min" value="<?php echo isset($settings['premium_rate_min']) ? $settings['premium_rate_min'] : '0.5'; ?>" step="0.01">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Max Rate (%)</label>
                                                                <input type="number" class="form-control" name="premium_rate_max" value="<?php echo isset($settings['premium_rate_max']) ? $settings['premium_rate_max'] : '0.7'; ?>" step="0.01">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- VIP Package -->
                                                <div class="col-md-4">
                                                    <div class="panel panel-default package-card vip-card">
                                                        <div class="panel-heading">
                                                            <i class="fa fa-star"></i> VIP Package
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <label>Range Min ($)</label>
                                                                <input type="number" class="form-control" name="vip_min" value="<?php echo isset($settings['vip_min']) ? $settings['vip_min'] : '5000'; ?>" step="0.01">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Min Rate (%)</label>
                                                                <input type="number" class="form-control" name="vip_rate_min" value="<?php echo isset($settings['vip_rate_min']) ? $settings['vip_rate_min'] : '0.8'; ?>" step="0.01">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Max Rate (%)</label>
                                                                <input type="number" class="form-control" name="vip_rate_max" value="<?php echo isset($settings['vip_rate_max']) ? $settings['vip_rate_max'] : '1.0'; ?>" step="0.01">
                                                            </div>
                                                            <div class="alert alert-info">
                                                                <small><i class="fa fa-info-circle"></i> VIP starts from $<?php echo isset($settings['vip_min']) ? $settings['vip_min'] : '5000'; ?> and above</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Advanced Settings -->
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <i class="fa fa-cog"></i> Advanced Settings
                                                </div>
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Minimum Balance Threshold ($)</label>
                                                                <input type="number" class="form-control" name="min_balance_threshold" value="<?php echo isset($settings['min_balance_threshold']) ? $settings['min_balance_threshold'] : '10'; ?>" step="0.01">
                                                                <small class="text-muted">Users with balance below this won't get returns</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Max Daily Return Limit ($)</label>
                                                                <input type="number" class="form-control" name="max_return_per_day" value="<?php echo isset($settings['max_return_per_day']) ? $settings['max_return_per_day'] : '1000000'; ?>" step="0.01">
                                                                <small class="text-muted">Maximum return per user per day</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Save Settings -->
                                            <div class="panel panel-warning">
                                                <div class="panel-heading">
                                                    <i class="fa fa-lock"></i> Security Verification
                                                </div>
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Transaction PIN <span class="text-danger">*</span></label>
                                                                <input type="password" class="form-control" name="transaction_pin" placeholder="Enter your transaction PIN" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>&nbsp;</label>
                                                                <div>
                                                                    <button type="submit" name="save_settings" class="btn btn-primary btn-lg">
                                                                        <i class="fa fa-save"></i> Save Settings
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        
                                        <!-- Daily Control -->
                                        <div class="panel panel-warning">
                                            <div class="panel-heading">
                                                <i class="fa fa-calendar"></i> Daily Control - Disable/Enable Specific Business Days
                                            </div>
                                            <div class="panel-body">
                                                <form method="POST">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Date <span class="text-danger">*</span></label>
                                                                <input type="date" class="form-control" name="control_date" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Action <span class="text-danger">*</span></label>
                                                                <select class="form-control" name="daily_control_action" required>
                                                                    <option value="">Select Action</option>
                                                                    <option value="disable">Disable Returns</option>
                                                                    <option value="enable">Enable Returns</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Transaction PIN <span class="text-danger">*</span></label>
                                                                <input type="password" class="form-control" name="daily_control_pin" placeholder="Enter your transaction PIN" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <label>Reason (optional)</label>
                                                                <input type="text" class="form-control" name="disable_reason" placeholder="e.g., Market closed, System maintenance, Holiday, Back to normal operation">
                                                                <small class="text-muted">Reason for this date control action</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>&nbsp;</label>
                                                                <div>
                                                                    <button type="submit" class="btn btn-warning btn-lg">
                                                                        <i class="fa fa-calendar-o"></i> Apply Date Control
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                
                                                <!-- Recent Daily Controls -->
                                                <div class="table-responsive" style="margin-top: 20px;">
                                                    <h4><i class="fa fa-history"></i> Recent Date Controls</h4>
                                                    <table class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Status</th>
                                                                <th>Reason</th>
                                                                <th>Controlled By</th>
                                                                <th>Date/Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            // Get current status per date (latest record for each date)
                                                            $recent_controls = mysqli_query($mysqli, 
                                                                "SELECT dc1.* FROM daily_control dc1
                                                                INNER JOIN (
                                                                    SELECT control_date, MAX(disabled_at) as latest_time
                                                                    FROM daily_control 
                                                                    GROUP BY control_date
                                                                ) dc2 ON dc1.control_date = dc2.control_date AND dc1.disabled_at = dc2.latest_time
                                                                ORDER BY dc1.control_date DESC LIMIT 15"
                                                            );
                                                            if($recent_controls && mysqli_num_rows($recent_controls) > 0){
                                                                while($control = mysqli_fetch_assoc($recent_controls)){
                                                                    $status_class = $control['is_disabled'] ? 'label-danger' : 'label-success';
                                                                    $status_text = $control['is_disabled'] ? 'DISABLED' : 'ENABLED';
                                                                    echo "<tr>
                                                                        <td>".date('Y-m-d (D)', strtotime($control['control_date']))."</td>
                                                                        <td><span class='label $status_class'>$status_text</span></td>
                                                                        <td>".(empty($control['reason']) ? '-' : htmlspecialchars($control['reason']))."</td>
                                                                        <td>".htmlspecialchars($control['disabled_by'])."</td>
                                                                        <td>".date('Y-m-d H:i:s', strtotime($control['disabled_at']))."</td>
                                                                    </tr>";
                                                                }
                                                            } else {
                                                                echo "<tr><td colspan='5' class='text-center'>No date controls found</td></tr>";
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                
                                                <!-- Complete History (Collapsible) -->
                                                <div class="panel-group" id="history-accordion" style="margin-top: 20px;">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#history-accordion" href="#complete-history">
                                                                    <i class="fa fa-clock-o"></i> Complete Audit Trail (All Changes)
                                                                    <span class="pull-right"><i class="fa fa-chevron-down"></i></span>
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="complete-history" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <div class="table-responsive">
                                                                    <table class="table table-striped table-bordered table-condensed">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Date</th>
                                                                                <th>Action</th>
                                                                                <th>Reason</th>
                                                                                <th>Admin</th>
                                                                                <th>Timestamp</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            // Show complete history of all changes
                                                                            $all_history = mysqli_query($mysqli, "SELECT * FROM daily_control ORDER BY disabled_at DESC LIMIT 50");
                                                                            if($all_history && mysqli_num_rows($all_history) > 0){
                                                                                while($history = mysqli_fetch_assoc($all_history)){
                                                                                    $action_class = $history['is_disabled'] ? 'label-danger' : 'label-success';
                                                                                    $action_text = $history['is_disabled'] ? 'DISABLED' : 'ENABLED';
                                                                                    echo "<tr>
                                                                                        <td>".date('Y-m-d (D)', strtotime($history['control_date']))."</td>
                                                                                        <td><span class='label $action_class'>$action_text</span></td>
                                                                                        <td>".(empty($history['reason']) ? '-' : htmlspecialchars($history['reason']))."</td>
                                                                                        <td>".htmlspecialchars($history['disabled_by'])."</td>
                                                                                        <td>".date('M d, Y H:i:s', strtotime($history['disabled_at']))."</td>
                                                                                    </tr>";
                                                                                }
                                                                            } else {
                                                                                echo "<tr><td colspan='5' class='text-center'>No history found</td></tr>";
                                                                            }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Manual Execution -->
                                        <div class="panel panel-danger">
                                            <div class="panel-heading">
                                                <i class="fa fa-play-circle"></i> Manual Execution
                                            </div>
                                            <div class="panel-body">
                                                <form method="POST" onsubmit="return confirm('Are you sure you want to execute daily returns manually?');">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Transaction PIN <span class="text-danger">*</span></label>
                                                                <input type="password" class="form-control" name="manual_pin" placeholder="Enter your transaction PIN" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>&nbsp;</label>
                                                                <div>
                                                                    <button type="submit" name="manual_execute" class="btn btn-danger btn-lg">
                                                                        <i class="fa fa-play"></i> Execute Now
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="alert alert-warning">
                                                        <i class="fa fa-warning"></i> <strong>Warning:</strong> This will immediately process daily returns for all eligible users. Use with caution!
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        
                                        <!-- Generation Bonus Execution (Separate) -->
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <i class="fa fa-sitemap"></i> Generation Bonus Processing
                                            </div>
                                            <div class="panel-body">
                                                <form method="POST" onsubmit="return confirm('Are you sure you want to process generation bonuses? This may take several minutes for large user bases.');">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Target Date <span class="text-danger">*</span></label>
                                                                <input type="date" class="form-control" name="generation_date" value="<?php echo date('Y-m-d'); ?>" required>
                                                                <small class="text-muted">Date for generation bonus processing</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Transaction PIN <span class="text-danger">*</span></label>
                                                                <input type="password" class="form-control" name="generation_pin" placeholder="Enter your transaction PIN" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>&nbsp;</label>
                                                                <div>
                                                                    <button type="submit" name="manual_generation" class="btn btn-info btn-lg">
                                                                        <i class="fa fa-sitemap"></i> Process Generation
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="alert alert-info">
                                                        <i class="fa fa-info-circle"></i> <strong>Info:</strong> 
                                                        This processes 33% generation bonuses for all users. For large user bases (>200 users), consider using the cron script:
                                                        <br><code style="background: #f5f5f5; padding: 2px 5px;">php db/cron_generation_bonus.php YYYY-MM-DD</code>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include JS libraries -->
    <script type="text/javascript" src="lib/js/jquery.min.js"></script>
    <script type="text/javascript" src="lib/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="lib/js/Chart.min.js"></script>
    <script type="text/javascript" src="lib/js/bootstrap-switch.min.js"></script>
    <script type="text/javascript" src="lib/js/jquery.matchHeight-min.js"></script>
    <script type="text/javascript" src="lib/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="lib/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="lib/js/select2.full.min.js"></script>
    <script type="text/javascript" src="lib/js/ace/ace.js"></script>
    <script type="text/javascript" src="lib/js/ace/mode-html.js"></script>
    <script type="text/javascript" src="lib/js/ace/theme-github.js"></script>
    <!-- Javascript -->
    <script type="text/javascript" src="js/app.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
    
</body>
</html>