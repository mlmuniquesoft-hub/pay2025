<?php
// Simple test file to debug tree page issues
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html>";
echo "<html><head><title>Tree Test</title></head><body>";
echo "<h1>Tree Test Page</h1>";

// Test session
session_start();
if(!isset($_SESSION['roboMember'])){
    echo "<p style='color: red;'>ERROR: No roboMember session found!</p>";
    echo "<p>Please login first at: <a href='../nz-login.html'>Login Page</a></p>";
} else {
    echo "<p style='color: green;'>Session found: " . $_SESSION['roboMember'] . "</p>";
}

// Test database connection
try {
    require_once("../../db/db.php");
    echo "<p style='color: green;'>Database connection successful</p>";
    
    // Test query
    $test_query = $mysqli->query("SELECT COUNT(*) as count FROM member");
    if($test_query) {
        $result = mysqli_fetch_assoc($test_query);
        echo "<p>Total members in database: " . $result['count'] . "</p>";
    } else {
        echo "<p style='color: red;'>Database query failed: " . mysqli_error($mysqli) . "</p>";
    }
    
} catch(Exception $e) {
    echo "<p style='color: red;'>Database error: " . $e->getMessage() . "</p>";
}

echo "</body></html>";
?>