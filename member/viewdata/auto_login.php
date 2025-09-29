<?php
session_start();

// Include database connection
require_once("../../db/db.php");

// Set content type
header('Content-Type: text/plain');

// Validate input
if(!isset($_POST['userId']) || empty($_POST['userId'])) {
    echo 'error';
    exit;
}

$userId = trim($_POST['userId']);

try {
    // Check database connection
    if($mysqli->connect_error) {
        error_log("Database connection failed in auto_login: " . $mysqli->connect_error);
        echo 'error';
        exit;
    }
    
    // Verify user exists and is active using prepared statement
    $stmt = $mysqli->prepare("SELECT m.user, m.log_user, m.password, m.active, p.name FROM member m LEFT JOIN profile p ON m.user = p.user WHERE m.user = ? AND m.active = '1'");
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
        $stmt->close();
        
        // Set session variables matching the actual login system
        $_SESSION['roboMember'] = strtolower($user_data['user']);
        session_write_close();
        
        // Get user IP and location info for logging
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $location = 'Auto-Login';
        $type = 'member';
        
        // Log the auto-login in hacker table (security log)
        $stmt_log = $mysqli->prepare("INSERT INTO `hacker`(`user`, `password`, `ip`, `level`, `location`, `status`) VALUES (?, ?, ?, ?, ?, ?)");
        $password_log = 'auto-verify';
        $status_log = 'Success';
        $stmt_log->bind_param("ssssss", $user_data['user'], $password_log, $ip, $type, $location, $status_log);
        $stmt_log->execute();
        $stmt_log->close();
        
        // Log successful auto-login
        error_log("Auto-login successful for user: " . $userId);
        
        // Return JSON response matching login system format
        $rett = array();
        $rett['sts'] = 'success';
        $rett['url'] = '/member/index.php';
        $rett['mess'] = "Auto-Login Approved, Redirect To Member Panel";
        
        header('Content-Type: application/json');
        echo json_encode($rett);
    } else {
        $stmt->close();
        error_log("Auto-login failed - user not found or inactive: " . $userId);
        echo 'error';
    }
    
} catch(Exception $e) {
    error_log("Auto-login exception: " . $e->getMessage());
    echo 'error';
}
?>