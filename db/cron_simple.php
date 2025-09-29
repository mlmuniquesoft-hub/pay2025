<?php
/**
 * Simple Generation Bonus Cron Script
 * 
 * This is a simplified, reliable version for live servers
 * Uses configuration file for easy server-specific setup
 */

// Basic setup
set_time_limit(0);
ini_set('memory_limit', '2G');
error_reporting(E_ALL);

echo "🎯 Simple Generation Bonus Cron - Live Server\n";
echo "==============================================\n";
echo "Started: " . date('Y-m-d H:i:s') . "\n";

// Get date from command line or use today
$date = isset($argv[1]) ? $argv[1] : date("Y-m-d");

// Validate date
if(!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    echo "❌ Invalid date format. Use: php script.php 2025-09-29\n";
    exit(1);
}

echo "📅 Processing date: $date\n";

// Load configuration
$config_file = __DIR__ . '/cron_config.php';
if(!file_exists($config_file)) {
    echo "❌ Configuration file missing: $config_file\n";
    exit(1);
}

$config = include $config_file;
$db_path = $config['db_path'];
$chunk_size = $config['config']['chunk_size'];

echo "📁 DB Path: $db_path\n";
echo "📦 Chunk Size: $chunk_size users per batch\n";

// Check if DB directory exists
if(!is_dir($db_path)) {
    echo "❌ DB directory not found: $db_path\n";
    echo "🔧 Please update the paths in cron_config.php\n";
    exit(1);
}

// Include required files
$required_files = ['cron_db.php', 'functions.php', 'generation.php'];
foreach($required_files as $file) {
    $file_path = $db_path . '/' . $file;
    if(!file_exists($file_path)) {
        echo "❌ Required file missing: $file_path\n";
        exit(1);
    }
    require_once $file_path;
    echo "✅ Loaded: $file\n";
}

// Test database connection
if(!isset($mysqli) || !$mysqli) {
    echo "❌ Database connection failed\n";
    exit(1);
}

$test = mysqli_query($mysqli, "SELECT 1");
if(!$test) {
    echo "❌ Database test failed: " . mysqli_error($mysqli) . "\n";
    exit(1);
}

echo "✅ Database connection OK\n";

// Set timezone
date_default_timezone_set($config['config']['timezone']);

echo str_repeat('-', 50) . "\n";

// Get user count
$count_query = "SELECT COUNT(DISTINCT m.user) as total 
                FROM `member` m 
                INNER JOIN `upgrade` u ON m.user = u.user 
                WHERE DATE(m.time)<='$date' AND m.paid='1'";

$count_result = mysqli_query($mysqli, $count_query);
if(!$count_result) {
    echo "❌ Failed to count users: " . mysqli_error($mysqli) . "\n";
    exit(1);
}

$total_users = mysqli_fetch_assoc($count_result)['total'];
echo "👥 Total users: " . number_format($total_users) . "\n";

// Show sample user debug info for first few users
if($total_users > 0) {
    echo "🔍 Sample user analysis:\n";
    $debug_query = "SELECT m.user, DATE(m.time) as join_date, m.paid, COUNT(DISTINCT u.id) as upgrade_count,
                    (SELECT COUNT(*) FROM game_return WHERE user = m.user AND DATE(date) = '$date') as roi_today
                    FROM member m 
                    LEFT JOIN upgrade u ON m.user = u.user 
                    WHERE DATE(m.time) <= '$date' AND m.paid = '1' 
                    GROUP BY m.user 
                    ORDER BY m.time DESC 
                    LIMIT 3";
    
    $debug_result = mysqli_query($mysqli, $debug_query);
    if($debug_result) {
        while($debug_user = mysqli_fetch_assoc($debug_result)) {
            echo "   User: {$debug_user['user']} | Join: {$debug_user['join_date']} | Paid: {$debug_user['paid']} | Upgrades: {$debug_user['upgrade_count']} | ROI Today: {$debug_user['roi_today']}\n";
        }
    }
}

if($total_users == 0) {
    echo "✅ No users to process for $date\n";
    exit(0);
}

// Process in simple batches
$processed = 0;
$batch = 1;
$total_batches = ceil($total_users / $chunk_size);

echo "📊 Processing in $total_batches batches...\n";

for($offset = 0; $offset < $total_users; $offset += $chunk_size) {
    echo "Batch $batch/$total_batches... ";
    
    // Get users for this batch
    $batch_query = "SELECT DISTINCT m.user 
                    FROM `member` m 
                    INNER JOIN `upgrade` u ON m.user = u.user 
                    WHERE DATE(m.time)<='$date' AND m.paid='1' 
                    LIMIT $chunk_size OFFSET $offset";
    
    $batch_result = mysqli_query($mysqli, $batch_query);
    if(!$batch_result) {
        echo "❌ Query failed\n";
        continue;
    }
    
    $batch_processed = 0;
    $batch_skipped = 0;
    while($user = mysqli_fetch_assoc($batch_result)) {
        try {
            $result = user_update11($user['user'], $date);
            if($result === true) {
                $batch_processed++;
            } else {
                $batch_skipped++;
            }
        } catch(Exception $e) {
            $batch_skipped++;
            continue;
        }
    }
    
    $processed += $batch_processed;
    $progress = ($batch / $total_batches) * 100;
    echo "✅ $batch_processed users, ⏭️ $batch_skipped skipped (" . number_format($progress, 1) . "%)\n";
    
    $batch++;
    
    // Small delay between batches
    usleep($config['config']['delay_between_batches']);
}

echo str_repeat('-', 50) . "\n";
echo "📊 FINAL RESULTS:\n";
echo "   Total Users: " . number_format($total_users) . "\n";
echo "   Processed: " . number_format($processed) . "\n";
echo "   Success Rate: " . number_format(($processed / $total_users) * 100, 1) . "%\n";
echo "⏰ Completed: " . date('Y-m-d H:i:s') . "\n";

if($processed > 0) {
    echo "🎉 Processing completed successfully!\n";
    exit(0);
} else {
    echo "❌ No users were processed successfully!\n";
    exit(1);
}
?>