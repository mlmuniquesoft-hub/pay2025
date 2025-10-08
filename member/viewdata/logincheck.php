<?php
// Clean output buffer and disable all error reporting for clean JSON
ob_clean();
error_reporting(0);
ini_set('display_errors', 0);

session_start();

$rett = array();

// Check if POST data exists
if (!isset($_POST['user']) || !isset($_POST['pass'])) {
    $rett[0] = 0;
    $rett[1] = "Missing login credentials";
    header('Content-Type: application/json');
    echo json_encode($rett);
    exit;
}

// Try to include database file
try {
    require_once '../../db/db.php';
} catch (Exception $e) {
    $rett[0] = 0;
    $rett[1] = "Database connection error";
    header('Content-Type: application/json');
    echo json_encode($rett);
    exit;
}
$loginUserId = $mysqli->real_escape_string($_POST['user']);
$password0 = $mysqli->real_escape_string($_POST['pass']);
$loginPassword = md5($password0);

try {
    // Check if user exists and is active
    $stmt = $mysqli->prepare("SELECT user, password, active FROM member WHERE user=? AND password=?");
    $stmt->bind_param('ss', $loginUserId, $loginPassword);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->num_rows;

    if ($count == 1) {
        $row = $result->fetch_array();
        $active = $row['active'];
        
        if ($active == 1) {
            // Direct login success - set main session and redirect
            $_SESSION['roboMember'] = strtolower($loginUserId);
            $rett[0] = 1;
            $rett[1] = "index.php"; // Direct redirect to dashboard
        } else {
            $rett[0] = 0;
            $rett[1] = "Account is not active. Please contact administrator.";
        }
    } else {
        $rett[0] = 0;
        $rett[1] = "Invalid User ID or Password!";
    }

    $stmt->close();
} catch (Exception $e) {
    $rett[0] = 0;
    $rett[1] = "Login system error. Please try again.";
}
header('Content-Type: application/json');
echo json_encode($rett);
?>