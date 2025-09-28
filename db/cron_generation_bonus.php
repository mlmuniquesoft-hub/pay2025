<?php
/**
 * Generation Bonus Processing Script
 * 
 * This script processes generation bonuses independently to avoid web timeout issues.
 * Should be run via cron job for large user bases.
 * 
 * Usage: php cron_generation_bonus.php [date]
 * Example: php cron_generation_bonus.php 2025-09-29
 */

// Set execution environment for command line
set_time_limit(0); // No time limit for CLI
ini_set('memory_limit', '1G');
error_reporting(-1);

// Output start message immediately
echo "🎯 Generation Bonus Processing Script Starting...\n";
echo "PHP SAPI: " . php_sapi_name() . "\n";

// Check if running from command line (allow both cli and cgi-fcgi for flexibility)
$allowed_sapis = ['cli', 'cgi-fcgi', 'cli-server'];
if(!in_array(php_sapi_name(), $allowed_sapis)) {
    echo "❌ This script should be run from command line only.\n";
    echo "Current SAPI: " . php_sapi_name() . "\n";
    exit(1);
}

// Include required files
require_once 'db.php';
require_once 'functions.php';
require_once 'generation.php';

// Test database connection first
if (!$mysqli) {
    echo "❌ Database connection failed: " . mysqli_connect_error() . "\n";
    exit(1);
}

echo "✅ Database connection successful\n";

// Set timezone
$timezone = "Asia/Dacca";
if(function_exists('date_default_timezone_set')) {
    date_default_timezone_set($timezone);
}

// Get date from command line argument or use today
$date = isset($argv[1]) ? $argv[1] : date("Y-m-d");

// Validate date format
if(!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    echo "❌ Invalid date format. Use YYYY-MM-DD format.\n";
    exit(1);
}

echo "🎯 Starting Generation Bonus Processing for: $date\n";
echo "⏰ Started at: " . date('Y-m-d H:i:s') . "\n";
echo str_repeat('=', 50) . "\n";

$start_time = time();

// Process generation bonuses
$result = Generationoncome($date);

$end_time = time();
$duration = $end_time - $start_time;

echo str_repeat('=', 50) . "\n";
echo "⏰ Completed at: " . date('Y-m-d H:i:s') . "\n";
echo "⏱️ Total duration: " . gmdate('H:i:s', $duration) . "\n";

if($result) {
    echo "🎉 Generation Bonus Processing Completed Successfully!\n";
    exit(0);
} else {
    echo "❌ Generation Bonus Processing Failed!\n";
    exit(1);
}
?>