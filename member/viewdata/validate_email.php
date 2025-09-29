<?php
// Prevent any output before JSON
ob_start();

try {
    // Set session token to prevent redirects
    session_start();
    $_SESSION['token'] = "dfgdfgdf";
    
    // Include database connection
    require_once("../../db/db.php");
    
    // Clear any buffer and set JSON header
    ob_clean();
    header('Content-Type: application/json');
    
    if(!isset($_GET['email'])) {
        echo json_encode(['status' => 'error', 'message' => 'No email provided']);
        exit;
    }
    
    $email = mysqli_real_escape_string($mysqli, trim($_GET['email']));
    
    if(empty($email)) {
        echo json_encode(['status' => 'error', 'message' => 'Email is required']);
        exit;
    }
    
    // Validate email format
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email format']);
        exit;
    }
    
    // Check database connection
    if(!$mysqli || mysqli_connect_error()) {
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
        exit;
    }
    
    // Check if email already exists
    $query = "SELECT user, name FROM profile WHERE email = '$email'";
    $result = mysqli_query($mysqli, $query);
    
    if($result === false) {
        echo json_encode(['status' => 'error', 'message' => 'Database query failed']);
        exit;
    }
    
    if(mysqli_num_rows($result) > 0) {
        echo json_encode([
            'status' => 'error', 
            'message' => 'Email already exists'
        ]);
    } else {
        echo json_encode([
            'status' => 'success', 
            'message' => 'Email is available'
        ]);
    }
    
} catch(Exception $e) {
    ob_clean();
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()]);
}
?>