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
    
    if(!isset($_GET['dfgfd'])) {
        echo json_encode(['sts' => 'error', 'mess' => 'No username provided']);
        exit;
    }
    
    $user0 = mysqli_real_escape_string($mysqli, trim($_GET['dfgfd']));
    $rett = array();
    
    if(empty($user0)) {
        $rett['sts'] = 'error';
        $rett['mess'] = "Username is required";
        echo json_encode($rett);
        exit;
    }
    
    $ccvv = strlen($user0);
    if($ccvv < 4) {
        $rett['sts'] = 'error';
        $rett['mess'] = "Enter At Least 4 Character User Name";
        echo json_encode($rett);
        exit;
    }
    if($ccvv > 10) {
        $rett['sts'] = 'error';
        $rett['mess'] = "Enter 4-10 Character User Name";
        echo json_encode($rett);
        exit;
    }
    
    // Check for spaces
    $GHsdfs = explode(" ", $user0);
    if(count($GHsdfs) > 1) {
        $rett['sts'] = 'error';
        $rett['mess'] = "Space Not Allowed In User Name";
        echo json_encode($rett);
        exit;
    }
    
    // Check for special characters (allow only alphanumeric and underscore)
    if(!preg_match('/^[a-zA-Z0-9_]+$/', $user0)) {
        $rett['sts'] = 'error';
        $rett['mess'] = "Only letters, numbers and underscore allowed";
        echo json_encode($rett);
        exit;
    }
    
    // Check database connection
    if(!$mysqli || mysqli_connect_error()) {
        $rett['sts'] = 'error';
        $rett['mess'] = "Database connection failed";
        echo json_encode($rett);
        exit;
    }
    
    // Check if username already exists
    $query = "SELECT user FROM member WHERE user = '$user0'";
    $result = mysqli_query($mysqli, $query);
    
    if($result === false) {
        $rett['sts'] = 'error';
        $rett['mess'] = "Database query failed";
        echo json_encode($rett);
        exit;
    }
    
    if(mysqli_num_rows($result) > 0) {
        $rett['sts'] = 'error';
        $rett['mess'] = "Username already exists";
    } else {
        $rett['sts'] = 'success';
        $rett['mess'] = "Username is available";
    }
    
    echo json_encode($rett);
    
} catch(Exception $e) {
    ob_clean();
    header('Content-Type: application/json');
    echo json_encode(['sts' => 'error', 'mess' => 'Server error: ' . $e->getMessage()]);
}
?>