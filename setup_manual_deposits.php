<?php
$mysqli = new mysqli('localhost', 'root', '', 'robo_adminmlm2');
if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

// Create manual deposits table
$sql1 = "CREATE TABLE IF NOT EXISTS `manual_deposits` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user` VARCHAR(255) NOT NULL,
    `deposit_type` ENUM('BTC', 'USDT_TRC20', 'USDT_BEP20') NOT NULL,
    `wallet_address` VARCHAR(255) NOT NULL,
    `amount` DECIMAL(10,2) NOT NULL,
    `txn_hash` VARCHAR(255),
    `screenshot` VARCHAR(255),
    `status` ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    `admin_note` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `verified_at` TIMESTAMP NULL,
    `verified_by` VARCHAR(255),
    INDEX `user_status` (`user`, `status`),
    INDEX `status_created` (`status`, `created_at`)
)";

// Create wallet addresses table for manual system
$sql2 = "CREATE TABLE IF NOT EXISTS `manual_wallets` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `wallet_type` ENUM('BTC', 'USDT_TRC20', 'USDT_BEP20') NOT NULL,
    `wallet_address` VARCHAR(255) NOT NULL,
    `wallet_name` VARCHAR(100),
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY `unique_type_address` (`wallet_type`, `wallet_address`)
)";

if ($mysqli->query($sql1) === TRUE) {
    echo "Manual deposits table created successfully\n";
} else {
    echo "Error creating manual deposits table: " . $mysqli->error . "\n";
}

if ($mysqli->query($sql2) === TRUE) {
    echo "Manual wallets table created successfully\n";
} else {
    echo "Error creating manual wallets table: " . $mysqli->error . "\n";
}

// Insert sample wallet addresses
$sampleWallets = [
    ['BTC', '1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa', 'Main BTC Wallet'],
    ['USDT_TRC20', 'TQn9Y2khEsLJW1ChVWFMSMeRDow5KcbLSE', 'Main USDT TRC20 Wallet'],
    ['USDT_BEP20', '0x8894E0a0c962CB723c1976a4421c95949bE2D4E3', 'Main USDT BEP20 Wallet']
];

foreach($sampleWallets as $wallet) {
    $stmt = $mysqli->prepare("INSERT INTO manual_wallets (wallet_type, wallet_address, wallet_name) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE wallet_name = VALUES(wallet_name)");
    $stmt->bind_param("sss", $wallet[0], $wallet[1], $wallet[2]);
    $stmt->execute();
}

$mysqli->close();
echo "Manual wallet system database setup complete!\n";
?>