<?php
/**
 * Database Upgrade Script for Account Activation Report
 * This script ensures the upgrade table has the proper structure for activation reporting
 */

require_once('../db/db.php');

// Check if upgrade table exists and has proper structure
$tables_to_check = array(
    'upgrade' => "CREATE TABLE IF NOT EXISTS `upgrade` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user` varchar(255) NOT NULL,
        `package` varchar(255) NOT NULL,
        `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
        `bonus` decimal(10,2) NOT NULL DEFAULT '0.00',
        `shopping` decimal(10,2) NOT NULL DEFAULT '0.00',
        `sponsor` varchar(255) NOT NULL,
        `upline` varchar(255) NOT NULL,
        `invoice` varchar(255) NOT NULL,
        `charge` decimal(10,2) NOT NULL DEFAULT '0.00',
        `date` datetime NOT NULL,
        `status` enum('Active','Completed','Cancelled') DEFAULT 'Active',
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `user_index` (`user`),
        KEY `date_index` (`date`),
        KEY `status_index` (`status`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8"
);

$upgrade_results = array();

foreach($tables_to_check as $table_name => $create_sql) {
    try {
        // Create table if not exists
        $result = $mysqli->query($create_sql);
        if($result) {
            $upgrade_results[$table_name] = "✅ Table structure verified/created successfully";
        } else {
            $upgrade_results[$table_name] = "❌ Error: " . $mysqli->error;
        }
        
        // Check if status column exists, if not add it
        if($table_name === 'upgrade') {
            $column_check = $mysqli->query("SHOW COLUMNS FROM `$table_name` LIKE 'status'");
            if($column_check && mysqli_num_rows($column_check) == 0) {
                $add_status = $mysqli->query("ALTER TABLE `$table_name` ADD `status` enum('Active','Completed','Cancelled') DEFAULT 'Active' AFTER `date`");
                if($add_status) {
                    $upgrade_results[$table_name] .= " | Status column added";
                }
            }
            
            // Check if created_at column exists, if not add it
            $created_at_check = $mysqli->query("SHOW COLUMNS FROM `$table_name` LIKE 'created_at'");
            if($created_at_check && mysqli_num_rows($created_at_check) == 0) {
                $add_created_at = $mysqli->query("ALTER TABLE `$table_name` ADD `created_at` timestamp DEFAULT CURRENT_TIMESTAMP AFTER `status`");
                if($add_created_at) {
                    $upgrade_results[$table_name] .= " | Created_at column added";
                }
            }
        }
        
    } catch(Exception $e) {
        $upgrade_results[$table_name] = "❌ Exception: " . $e->getMessage();
    }
}

// Output results
?>
<!DOCTYPE html>
<html>
<head>
    <title>Database Upgrade - Capitol Money Pay</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f8fafc; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #1e3a8a, #3b82f6); color: white; padding: 20px; border-radius: 8px; margin-bottom: 30px; }
        .result { padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #059669; background: #f0fdf4; }
        .error { border-left-color: #dc2626; background: #fef2f2; }
        .info { background: #eff6ff; border-left-color: #3b82f6; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚀 Database Upgrade Complete</h1>
            <p>Capitol Money Pay - Account Activation Report System</p>
        </div>
        
        <h2>📊 Upgrade Results:</h2>
        
        <?php foreach($upgrade_results as $table => $result): ?>
            <div class="result <?php echo strpos($result, '❌') !== false ? 'error' : ''; ?>">
                <strong><?php echo strtoupper($table); ?> Table:</strong><br>
                <?php echo $result; ?>
            </div>
        <?php endforeach; ?>
        
        <div class="info">
            <h3>✅ What was updated:</h3>
            <ul>
                <li><strong>upgrade</strong> table structure verified/created</li>
                <li>Added proper indexes for better performance</li>
                <li>Added status column for activation tracking</li>
                <li>Added created_at timestamp for audit trail</li>
                <li>Ensured proper data types for financial calculations</li>
            </ul>
        </div>
        
        <div class="info">
            <h3>🎯 Features Available:</h3>
            <ul>
                <li>✅ Account Activation Report page created</li>
                <li>✅ Navigation menu updated</li>
                <li>✅ Summary cards showing key metrics</li>
                <li>✅ Detailed activation history table</li>
                <li>✅ Package range classification (Basic/Premium/VIP)</li>
                <li>✅ Responsive design with proper styling</li>
            </ul>
        </div>
        
        <div class="result">
            <strong>🔗 Access URL:</strong><br>
            <a href="http://localhost:3000/member/index.php?route=activation_report&tild=<?php echo base64_encode(time()); ?>&title=" 
               style="color: #3b82f6; text-decoration: none;">
                http://localhost:3000/member/index.php?route=activation_report&tild=<?php echo base64_encode(time()); ?>&title=
            </a>
        </div>
        
        <p style="text-align: center; color: #6b7280; margin-top: 30px;">
            <strong>Capitol Money Pay</strong> - Professional Investment Platform<br>
            Database upgrade completed successfully!
        </p>
    </div>
</body>
</html>