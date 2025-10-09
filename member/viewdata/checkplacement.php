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
    
    if(!isset($_GET['placement_id'])) {
        echo json_encode(['sts' => 'error', 'mess' => 'No placement ID provided']);
        exit;
    }
    
    $placement_id = mysqli_real_escape_string($mysqli, trim($_GET['placement_id']));
    $position = isset($_GET['position']) ? mysqli_real_escape_string($mysqli, trim($_GET['position'])) : '';
    $rett = array();
    
    if(empty($placement_id)) {
        $rett['sts'] = 'error';
        $rett['mess'] = "Placement ID is required";
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
    
    // Check if placement ID exists and is valid
    $checkPlacement = mysqli_query($mysqli, "SELECT `user`, `pack`, `log_user` FROM `member` WHERE `user`='".$placement_id."'");
    
    if(!$checkPlacement) {
        $rett['sts'] = 'error';
        $rett['mess'] = "Database query error: " . mysqli_error($mysqli);
        echo json_encode($rett);
        exit;
    }
    
    if(mysqli_num_rows($checkPlacement) < 1) {
        $rett['sts'] = 'error';
        $rett['mess'] = "Placement ID does not exist";
        echo json_encode($rett);
        exit;
    }
    
    $placementData = mysqli_fetch_assoc($checkPlacement);
    
    // Get placement member profile information - check both user and log_user fields
    $profileQuery = mysqli_query($mysqli, "SELECT `name` FROM `profile` WHERE `user`='".$placement_id."' OR `user`='".$placementData['log_user']."'");
    if(!$profileQuery) {
        // Fallback: try with just the placement_id
        $profileQuery = mysqli_query($mysqli, "SELECT `name` FROM `profile` WHERE `user`='".$placement_id."'");
    }
    
    $placementProfile = mysqli_fetch_assoc($profileQuery);
    $placementName = ($placementProfile && !empty($placementProfile['name'])) ? $placementProfile['name'] : $placement_id;
    
    // Check position availability if position is provided
    if(!empty($position)) {
        $positionText = ($position == '1') ? 'Left' : (($position == '2') ? 'Right' : 'Unknown');
        
        // Check if the position under this placement is already occupied
        $checkPosition = mysqli_query($mysqli, "SELECT `user` FROM `member` WHERE `upline`='".$placement_id."' AND `position`='".$position."'");
        
        if(!$checkPosition) {
            $rett['sts'] = 'error';
            $rett['mess'] = "Database error checking position: " . mysqli_error($mysqli);
            echo json_encode($rett);
            exit;
        }
        
        if(mysqli_num_rows($checkPosition) > 0) {
            // Position is already occupied
            $rett['sts'] = 'error';
            $rett['mess'] = "Position " . $positionText . " under " . $placementName . " is already filled";
            echo json_encode($rett);
            exit;
        } else {
            // Position is available
            $rett['sts'] = 'success';
            $rett['mess'] = "Valid placement: " . $placementName . " - " . $positionText . " position available";
            $rett['placement_name'] = $placementName;
            $rett['position_text'] = $positionText;
        }
    } else {
        // No position specified, just validate placement exists
        $rett['sts'] = 'success';
        $rett['mess'] = "Valid placement: " . $placementName;
        $rett['placement_name'] = $placementName;
    }
    
    echo json_encode($rett);
    
} catch(Exception $e) {
    ob_clean();
    header('Content-Type: application/json');
    echo json_encode(['sts' => 'error', 'mess' => 'Server error: ' . $e->getMessage()]);
}
?>