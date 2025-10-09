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
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    
    if(!isset($_GET['sponsor_id'])) {
        echo json_encode(['sts' => 'error', 'mess' => 'No sponsor ID provided']);
        exit;
    }
    
    $sponsor_id = mysqli_real_escape_string($mysqli, trim($_GET['sponsor_id']));
    $rett = array();
    
    if(empty($sponsor_id)) {
        $rett['sts'] = 'error';
        $rett['mess'] = "Sponsor ID is required";
        echo json_encode($rett);
        exit;
    }
    
    // Check if database connection exists
    if(!$mysqli) {
        $rett['sts'] = 'error';
        $rett['mess'] = "Database connection failed";
        echo json_encode($rett);
        exit;
    }
    
    // Check if sponsor ID exists and is valid
    $checkSponsor = mysqli_query($mysqli, "SELECT `user`, `pack`, `log_user` FROM `member` WHERE `user`='".$sponsor_id."'");
    
    if(!$checkSponsor) {
        $rett['sts'] = 'error';
        $rett['mess'] = "Database query error: " . mysqli_error($mysqli);
        echo json_encode($rett);
        exit;
    }
    
    if(mysqli_num_rows($checkSponsor) < 1) {
        $rett['sts'] = 'error';
        $rett['mess'] = "Sponsor ID does not exist";
        echo json_encode($rett);
        exit;
    }
    
    $sponsorData = mysqli_fetch_assoc($checkSponsor);
    
    // Sponsor exists - no activation requirement
    // Get sponsor profile information - check both user and log_user fields
    $profileQuery = mysqli_query($mysqli, "SELECT `name` FROM `profile` WHERE `user`='".$sponsor_id."' OR `user`='".$sponsorData['log_user']."'");
    if(!$profileQuery) {
        // Fallback: try with just the sponsor_id
        $profileQuery = mysqli_query($mysqli, "SELECT `name` FROM `profile` WHERE `user`='".$sponsor_id."'");
    }
    
    $sponsorProfile = mysqli_fetch_assoc($profileQuery);
    $sponsorName = ($sponsorProfile && !empty($sponsorProfile['name'])) ? $sponsorProfile['name'] : $sponsor_id;
    
    $rett['sts'] = 'success';
    $rett['mess'] = "Valid sponsor: " . $sponsorName;
    $rett['sponsor_name'] = $sponsorName;
    
    echo json_encode($rett);
    
} catch(Exception $e) {
    ob_clean();
    header('Content-Type: application/json');
    echo json_encode(['sts' => 'error', 'mess' => 'Server error: ' . $e->getMessage()]);
}
?>