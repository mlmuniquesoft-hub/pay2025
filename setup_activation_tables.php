<?php
session_start();
require_once('./db/db.php');

echo "<h2>🔧 Database Setup for Activation System</h2>";

// Create balance_record table if it doesn't exist
$balance_record_sql = "CREATE TABLE IF NOT EXISTS `balance_record` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user` VARCHAR(255) NOT NULL,
    `taka` VARCHAR(20) NOT NULL,
    `purpose` TEXT NOT NULL,
    `transaction_id` VARCHAR(255) NOT NULL,
    `date_added` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `user_date` (`user`, `date_added`),
    INDEX `transaction` (`transaction_id`)
)";

// Create commission_record table if it doesn't exist
$commission_record_sql = "CREATE TABLE IF NOT EXISTS `commission_record` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user` VARCHAR(255) NOT NULL,
    `from_user` VARCHAR(255) NOT NULL,
    `amount` DECIMAL(10,2) NOT NULL,
    `type` ENUM('activation', 'trading', 'referral') NOT NULL,
    `level` INT NOT NULL DEFAULT 1,
    `date_added` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `user_type` (`user`, `type`),
    INDEX `from_user` (`from_user`),
    INDEX `date_level` (`date_added`, `level`)
)";

// Create pending_activations table if it doesn't exist
$pending_activations_sql = "CREATE TABLE IF NOT EXISTS `pending_activations` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` VARCHAR(255) NOT NULL,
    `amount` DECIMAL(10,2) NOT NULL,
    `payment_method` ENUM('wallet_balance', 'bitcoin', 'manual_deposit') NOT NULL,
    `status` ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    `admin_note` TEXT,
    `date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `date_processed` TIMESTAMP NULL,
    INDEX `user_status` (`user_id`, `status`),
    INDEX `date_created` (`date_created`)
)";

// Add activation_date column to member table if it doesn't exist
$add_activation_date_sql = "ALTER TABLE `member` ADD COLUMN IF NOT EXISTS `activation_date` TIMESTAMP NULL";

$tables = [
    'balance_record' => $balance_record_sql,
    'commission_record' => $commission_record_sql, 
    'pending_activations' => $pending_activations_sql
];

$success_count = 0;
$error_count = 0;

foreach ($tables as $table_name => $sql) {
    if ($mysqli->query($sql)) {
        echo "<p style='color: green;'>✅ Table '$table_name' created successfully or already exists</p>";
        $success_count++;
    } else {
        echo "<p style='color: red;'>❌ Error creating table '$table_name': " . $mysqli->error . "</p>";
        $error_count++;
    }
}

// Try to add activation_date column
if ($mysqli->query($add_activation_date_sql)) {
    echo "<p style='color: green;'>✅ Added 'activation_date' column to member table</p>";
} else {
    echo "<p style='color: orange;'>⚠️ Could not add activation_date column (may already exist): " . $mysqli->error . "</p>";
}

echo "<hr>";
echo "<h3>📊 Setup Summary</h3>";
echo "<p><strong>Tables Created/Verified:</strong> $success_count</p>";
echo "<p><strong>Errors:</strong> $error_count</p>";

if ($error_count == 0) {
    echo "<p style='color: green; font-weight: bold;'>🎉 All database tables are ready for the activation system!</p>";
} else {
    echo "<p style='color: red; font-weight: bold;'>⚠️ Some tables could not be created. Please check the errors above.</p>";
}

echo "<br><a href='../member/index.php?route=activation' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🔗 Go to Activation Page</a>";

$mysqli->close();
?>