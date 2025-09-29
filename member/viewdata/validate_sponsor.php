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
    
    if(!isset($_GET['sponsor_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'No sponsor ID provided']);
        exit;
    }
    
    $sponsor_id = mysqli_real_escape_string($mysqli, trim($_GET['sponsor_id']));
    
    if(empty($sponsor_id)) {
        echo json_encode(['status' => 'error', 'message' => 'Sponsor ID is required']);
        exit;
    }
    
    // Check database connection
    if(!$mysqli || mysqli_connect_error()) {
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
        exit;
    }
    
    // Check if sponsor exists and is active
    $sponsor_query = "SELECT m.user, m.paid, p.name FROM member m LEFT JOIN profile p ON m.user = p.user OR m.log_user = p.user WHERE m.user = '$sponsor_id'";
    $result = mysqli_query($mysqli, $sponsor_query);
    
    if($result === false) {
        echo json_encode(['status' => 'error', 'message' => 'Database query failed']);
        exit;
    }
    
    if(mysqli_num_rows($result) > 0) {
        $sponsor = mysqli_fetch_assoc($result);
        
        if($sponsor['paid'] == '1') {
            $sponsor_name = $sponsor['name'] ? $sponsor['name'] : 'Member';
            echo json_encode([
                'status' => 'success', 
                'message' => 'Valid sponsor: ' . $sponsor_name,
                'sponsor_name' => $sponsor_name
            ]);
        } else {
            echo json_encode([
                'status' => 'warning', 
                'message' => 'Sponsor account is not activated'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error', 
            'message' => 'Sponsor ID does not exist'
        ]);
    }
    
} catch(Exception $e) {
    ob_clean();
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()]);
}
?>