<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include_once('../../db/db.php');
include_once('../../db/functions.php');

// Check if user is logged in
if(!isset($_SESSION['roboMember'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in', 'debug_session' => $_SESSION]);
    exit;
}

$member = $_SESSION['roboMember'];

// Check if form was submitted with POST method
if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

// Validate required fields
$required_fields = ['deposit_type', 'wallet_address', 'amount', 'txn_hash'];
foreach($required_fields as $field) {
    if(!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
        echo json_encode(['status' => 'error', 'message' => 'Field ' . $field . ' is required']);
        exit;
    }
}

// Validate file upload
if(!isset($_FILES['screenshot']) || $_FILES['screenshot']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['status' => 'error', 'message' => 'Screenshot upload is required']);
    exit;
}

// Sanitize inputs
$deposit_type = mysqli_real_escape_string($mysqli, trim($_POST['deposit_type']));
$wallet_address = mysqli_real_escape_string($mysqli, trim($_POST['wallet_address']));
$amount = floatval($_POST['amount']);
$txn_hash = mysqli_real_escape_string($mysqli, trim($_POST['txn_hash']));
$notes = isset($_POST['notes']) ? mysqli_real_escape_string($mysqli, trim($_POST['notes'])) : '';

// Validate amount
if($amount <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Amount must be greater than 0']);
    exit;
}

// Validate deposit type
$valid_types = ['BTC', 'USDT_TRC20', 'USDT_BEP20'];
if(!in_array($deposit_type, $valid_types)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid deposit type']);
    exit;
}

// Check if transaction hash already exists
$check_txn = $mysqli->query("SELECT id FROM manual_deposits WHERE txn_hash = '$txn_hash'");
if($check_txn && mysqli_num_rows($check_txn) > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Transaction hash already exists']);
    exit;
}

// Validate and process file upload
$file = $_FILES['screenshot'];
$upload_dir = '../../uploads/deposit_screenshots/';
$allowed_types = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
$max_size = 5 * 1024 * 1024; // 5MB

// Check file type
$file_type = $file['type'];
if(!in_array($file_type, $allowed_types)) {
    echo json_encode(['status' => 'error', 'message' => 'Only JPG, PNG and GIF files are allowed']);
    exit;
}

// Check file size
if($file['size'] > $max_size) {
    echo json_encode(['status' => 'error', 'message' => 'File size too large. Maximum 5MB allowed']);
    exit;
}

// Generate unique filename
$file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = $member . '_' . time() . '_' . uniqid() . '.' . $file_extension;
$file_path = $upload_dir . $filename;

// Create upload directory if it doesn't exist
if(!is_dir($upload_dir)) {
    if(!mkdir($upload_dir, 0755, true)) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to create upload directory']);
        exit;
    }
}

// Check if directory is writable
if(!is_writable($upload_dir)) {
    echo json_encode(['status' => 'error', 'message' => 'Upload directory is not writable']);
    exit;
}

// Move uploaded file
if(!move_uploaded_file($file['tmp_name'], $file_path)) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to upload screenshot']);
    exit;
}

try {
    // Check if manual_deposits table exists and has proper structure
    $table_check = $mysqli->query("SHOW TABLES LIKE 'manual_deposits'");
    if(mysqli_num_rows($table_check) == 0) {
        // Create manual_deposits table
        $create_table_sql = "CREATE TABLE manual_deposits (
            id INT PRIMARY KEY AUTO_INCREMENT,
            user VARCHAR(255) NOT NULL,
            deposit_type VARCHAR(50) NOT NULL,
            wallet_address VARCHAR(255) NOT NULL,
            amount DECIMAL(10,2) NOT NULL,
            txn_hash VARCHAR(255) NOT NULL UNIQUE,
            screenshot VARCHAR(255) NOT NULL,
            notes TEXT,
            status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
            admin_note TEXT,
            verified_by VARCHAR(255),
            verified_at TIMESTAMP NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        
        if(!$mysqli->query($create_table_sql)) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to create table: ' . $mysqli->error]);
            exit;
        }
    } else {
        // Check if table has all required columns and add missing ones
        $columns_check = $mysqli->query("DESCRIBE manual_deposits");
        $existing_columns = [];
        while($col = mysqli_fetch_assoc($columns_check)) {
            $existing_columns[] = $col['Field'];
        }
        
        $required_columns = [
            'notes' => 'TEXT',
            'admin_note' => 'TEXT',
            'verified_by' => 'VARCHAR(255)',
            'verified_at' => 'TIMESTAMP NULL',
            'updated_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ];
        
        foreach($required_columns as $column => $definition) {
            if(!in_array($column, $existing_columns)) {
                $alter_sql = "ALTER TABLE manual_deposits ADD COLUMN `$column` $definition";
                if(!$mysqli->query($alter_sql)) {
                    echo json_encode(['status' => 'error', 'message' => "Failed to add column $column: " . $mysqli->error]);
                    exit;
                }
            }
        }
    }
    
    // Insert deposit record
    $sql = "INSERT INTO manual_deposits (
        user, 
        deposit_type, 
        wallet_address, 
        amount, 
        txn_hash, 
        screenshot, 
        notes, 
        status, 
        created_at
    ) VALUES (
        '$member', 
        '$deposit_type', 
        '$wallet_address', 
        '$amount', 
        '$txn_hash', 
        '$filename', 
        '$notes', 
        'pending', 
        NOW()
    )";
    
    $result = $mysqli->query($sql);
    
    if($result) {
        $deposit_id = $mysqli->insert_id;
        
        // Send notification to admin (optional - you can implement email notification here)
        // sendAdminNotification($deposit_id, $member, $amount, $deposit_type);
        
        echo json_encode([
            'status' => 'success', 
            'message' => 'Deposit submitted successfully',
            'deposit_id' => $deposit_id
        ]);
    } else {
        // Delete uploaded file if database insert failed
        if(file_exists($file_path)) {
            unlink($file_path);
        }
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $mysqli->error]);
    }
    
} catch(Exception $e) {
    // Delete uploaded file if there was an error
    if(file_exists($file_path)) {
        unlink($file_path);
    }
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
}

$mysqli->close();
?>