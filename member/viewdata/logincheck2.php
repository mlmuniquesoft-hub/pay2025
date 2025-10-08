<?php
// Disable error display to prevent HTML in JSON response
error_reporting(0);
ini_set('display_errors', 0);

session_start();
require_once '../../db/db.php';

$rett = array();

// Check if POST data exists
if (!isset($_POST['code'])) {
    $rett[0] = 0;
    $rett[1] = "Missing security code";
    header('Content-Type: application/json');
    echo json_encode($rett);
    exit;
}
$secureCode = $_POST['code'];
$user = $_SESSION['temp_user'];

if (!$user) {
    $rett[0] = 0;
    $rett[1] = "Session expired. Please login again.";
    header('Content-Type: application/json');
    echo json_encode($rett);
    exit;
}

// Check if security code is correct (for now, we'll use a simple check)
// You can modify this to use your actual 2FA system
if ($secureCode == "123456" || $secureCode == "000000") {
    // Login successful
    $_SESSION['roboMember'] = strtolower($user);
    unset($_SESSION['temp_user']);
    
    $rett[0] = 1;
    $rett[1] = "index.php"; // Redirect URL
} else {
    $rett[0] = 0;
    $rett[1] = "Invalid security code. Please try again.";
}

header('Content-Type: application/json');
echo json_encode($rett);
?>