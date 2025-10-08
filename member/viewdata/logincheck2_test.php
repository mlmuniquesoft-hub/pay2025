<?php
// Simple test for step 2 login verification
// Clean any previous output
if (ob_get_level()) ob_clean();

// Set proper JSON header
header('Content-Type: application/json; charset=utf-8');

$rett = array();

if (!isset($_POST['code'])) {
    $rett[0] = 0;
    $rett[1] = "Missing security code";
    echo json_encode($rett);
    exit;
}

$code = $_POST['code'];

// For testing, accept any code
if (!empty($code)) {
    session_start();
    // Set session for successful login
    $_SESSION['roboMember'] = isset($_SESSION['temp_user']) ? $_SESSION['temp_user'] : 'testuser';
    unset($_SESSION['temp_user']);
    
    $rett[0] = 1;
    $rett[1] = "index.php"; // Redirect URL
} else {
    $rett[0] = 0;
    $rett[1] = "Please enter a security code";
}

// Ensure clean JSON output
if (ob_get_level()) ob_clean();
echo json_encode($rett, JSON_UNESCAPED_UNICODE);
exit;
?>