<?php
session_start();
include('../../db/db.php');
include('../../db/functions.php');

// Check if user is logged in
if(!isset($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

$member = $_SESSION['user'];

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
    mkdir($upload_dir, 0755, true);
}

// Move uploaded file
if(!move_uploaded_file($file['tmp_name'], $file_path)) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to upload screenshot']);
    exit;
}

try {
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