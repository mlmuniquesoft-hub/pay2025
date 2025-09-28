<?php
// Database setup for wallet history table
require_once('../db/db.php');

// Create wallet_history table if it doesn't exist
$create_wallet_history = "CREATE TABLE IF NOT EXISTS wallet_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    type ENUM('deposit', 'withdrawal', 'bonus', 'deduction') NOT NULL,
    description TEXT,
    balance_before DECIMAL(10,2) DEFAULT 0,
    balance_after DECIMAL(10,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user_registration(id) ON DELETE CASCADE
)";

if (mysqli_query($con, $create_wallet_history)) {
    echo "Wallet history table created successfully or already exists.\n";
} else {
    echo "Error creating wallet history table: " . mysqli_error($con) . "\n";
}

mysqli_close($con);
?>