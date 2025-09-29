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
        
        // Set session variables for auto-login
        $_SESSION['user'] = $user_data['user'];
        $_SESSION['log_user'] = $user_data['log_user'];
        $_SESSION['name'] = $user_data['name'] ? $user_data['name'] : 'Member';
        $_SESSION['login_type'] = 'auto_verify';
        $_SESSION['login_time'] = time();
        $_SESSION['token'] = bin2hex(random_bytes(16)); // Generate secure token
        
        // Log successful auto-login
        error_log("Auto-login successful for user: " . $userId);
        
        echo 'success';
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