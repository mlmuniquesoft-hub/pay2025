<?php
/**
 * Database connection for CRON jobs
 * No sessions, no redirects - just pure database connection
 */

// Auto-detect environment (local vs live server)
$is_live_server = !file_exists('C:\\xampp\\htdocs') && 
                  (strpos(__DIR__, '/var/www/') !== false || 
                   strpos(__DIR__, '/home/') !== false ||
                   strpos(__DIR__, '/httpdocs/') !== false);

if($is_live_server) {
    // Live Server Database Configuration
    $servername = "localhost";
    $username = "robo_adminMlm2"; 
    $password = "sPdt~j^tw1p5lIV8";
    $database = "robo_adminMlm2";
} else {
    // Local Development Database Configuration  
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "nzrobo";
}

// Create connection
$mysqli = new mysqli($servername, $username, $password, $database);

// Check connection
if ($mysqli->connect_error) {
    echo "❌ Database connection failed: " . $mysqli->connect_error . "\n";
    exit(1);
}

// Set charset
$mysqli->set_charset("utf8");

// No session handling for cron jobs
?>