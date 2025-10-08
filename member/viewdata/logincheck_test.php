<?php
// Simple test login endpoint
// Clean any previous output
if (ob_get_level()) ob_clean();

// Set proper JSON header
header('Content-Type: application/json; charset=utf-8');

$rett = array();

// Check if POST data exists
if (!isset($_POST['user']) || !isset($_POST['pass'])) {
    $rett[0] = 0;
    $rett[1] = "Missing login credentials";
    echo json_encode($rett);
    exit;
}

$user = $_POST['user'];
$pass = $_POST['pass'];

// For testing purposes, let's accept any login and redirect directly
if (!empty($user) && !empty($pass)) {
    session_start();
    $_SESSION['roboMember'] = strtolower($user); // Set the main session for logged in user
    $rett[0] = 1;
    $rett[1] = "index.php"; // Direct redirect to dashboard
} else {
    $rett[0] = 0;
    $rett[1] = "Please enter both username and password";
}

// Ensure clean JSON output
if (ob_get_level()) ob_clean();
echo json_encode($rett, JSON_UNESCAPED_UNICODE);
exit;
?>