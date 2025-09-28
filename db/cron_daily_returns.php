<?php
/**
 * Cron Job Interface for Daily Investment Returns
 * Capitol Money Pay - Automated Scheduling System
 * 
 * This file should be called by cron job or scheduled task
 * Recommended schedule: Daily at 00:30 (12:30 AM)
 */

// Set execution parameters
error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(0);
ini_set('memory_limit', '1024M');

// Security check - only allow execution from command line or specific IPs
$allowedIPs = array('127.0.0.1', '::1', 'localhost');
$isCommandLine = (php_sapi_name() === 'cli');
$isAllowedIP = in_array($_SERVER['REMOTE_ADDR'] ?? '', $allowedIPs);

if (!$isCommandLine && !$isAllowedIP) {
    http_response_code(403);
    die("Access denied. This script is for automated execution only.");
}

// Include the main investment return processing file
require_once(__DIR__ . '/invest_return.php');

// Log execution
$logFile = __DIR__ . '/logs/daily_returns_' . date('Y-m') . '.log';
$logDir = dirname($logFile);

// Create logs directory if it doesn't exist
if (!is_dir($logDir)) {
    mkdir($logDir, 0755, true);
}

// Log the execution
$timestamp = date('Y-m-d H:i:s');
$executionTime = microtime(true) - $timing_start[1];
$logEntry = "[$timestamp] Daily return process executed in " . round($executionTime, 2) . " seconds\n";

file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);

// If accessed via web (for testing), show result
if (!$isCommandLine) {
    echo "<h2>Daily Return Process Completed</h2>";
    echo "<p>Execution time: " . round($executionTime, 2) . " seconds</p>";
    echo "<p>Check logs for details: " . basename($logFile) . "</p>";
}
?>