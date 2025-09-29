<?php
/**
 * Generation Bonus Processing Script - Enhanced for Live Servers
 * 
 * This script processes generation bonuses with improved reliability for cron jobs.
 * Optimized for 1800+ users with chunked processing and timeout prevention.
 * 
 * Usage: php cron_generation_bonus.php [date] [options]
 * Example: php cron_generation_bonus.php 2025-09-29
 * Options: --chunk-size=N --max-memory=N --timeout=N --verbose
 */

// Enhanced execution environment for live servers
set_time_limit(0); // No time limit for CLI
ini_set('memory_limit', '2G'); // Increased for 1800+ users
ini_set('max_execution_time', 0);
error_reporting(E_ALL);

// Register shutdown function for cleanup
register_shutdown_function('cleanup_on_exit');

// Output buffering for better cron logging
ob_start();

// Output start message immediately and flush
echo "🎯 Generation Bonus Cron Script - Live Server Edition\n";
echo "=====================================================\n";
echo "Started: " . date('Y-m-d H:i:s') . " | SAPI: " . php_sapi_name() . "\n";
flush();
ob_flush();

// Check if running from appropriate environment
$allowed_sapis = ['cli', 'cgi-fcgi', 'cli-server'];
if(!in_array(php_sapi_name(), $allowed_sapis)) {
    echo "❌ This script should be run from command line or cron.\n";
    echo "Current SAPI: " . php_sapi_name() . "\n";
    exit(1);
}

// Parse command line arguments
$options = parseArguments($argv);
$date = $options['date'];
$chunk_size = $options['chunk_size'];
$max_memory = $options['max_memory'];
$timeout = $options['timeout'];
$verbose = $options['verbose'];

// Apply parsed options
ini_set('memory_limit', $max_memory . 'G');
if($timeout > 0) set_time_limit($timeout);

echo "Configuration: Date=$date | Chunks=$chunk_size | Memory={$max_memory}G | Verbose=" . ($verbose ? 'Yes' : 'No') . "\n";
flush();

// Determine the correct script directory
$script_dir = __DIR__;
$project_root = dirname($script_dir);

echo "🔍 Script directory: $script_dir\n";
echo "🔍 Project root: $project_root\n";

// Define possible paths for required files
$possible_paths = [
    $script_dir,                    // Same directory (db/)
    $project_root . '/db',          // Parent/db/ 
    dirname(__FILE__),              // Directory of current file
    getcwd(),                       // Current working directory
    '/home/username/public_html/db', // Common cPanel path
    '/home/username/httpdocs/db',   // Another common path
    realpath($script_dir),          // Resolved path
];

// Include required files with intelligent path detection
$required_files = ['cron_db.php', 'functions.php', 'generation.php'];
$included_files = [];

foreach($required_files as $file) {
    $file_found = false;
    
    foreach($possible_paths as $path) {
        $full_path = rtrim($path, '/') . '/' . $file;
        
        if(file_exists($full_path)) {
            require_once $full_path;
            $included_files[$file] = $full_path;
            echo "✅ Found and included: $full_path\n";
            $file_found = true;
            break;
        }
    }
    
    if(!$file_found) {
        echo "❌ Required file missing: $file\n";
        echo "🔍 Searched in paths:\n";
        foreach($possible_paths as $path) {
            echo "   - " . rtrim($path, '/') . '/' . $file . "\n";
        }
        
        // Additional debugging
        echo "🔍 Current working directory: " . getcwd() . "\n";
        echo "🔍 Script file path: " . __FILE__ . "\n";
        echo "🔍 Available files in script directory:\n";
        
        $files_in_dir = glob($script_dir . '/*');
        if($files_in_dir) {
            foreach($files_in_dir as $available_file) {
                echo "   - " . basename($available_file) . "\n";
            }
        } else {
            echo "   - No files found or directory not accessible\n";
        }
        
        exit(1);
    }
}

// Test database connection
if (!isset($mysqli) || !$mysqli) {
    echo "❌ Database connection failed: " . (isset($mysqli) ? mysqli_connect_error() : 'mysqli not initialized') . "\n";
    exit(1);
}

// Test database with a simple query
$test_query = mysqli_query($mysqli, "SELECT 1 as test");
if(!$test_query) {
    echo "❌ Database test query failed: " . mysqli_error($mysqli) . "\n";
    exit(1);
}

echo "✅ Database connection verified\n";

// Set timezone
$timezone = "Asia/Dacca";
if(function_exists('date_default_timezone_set')) {
    date_default_timezone_set($timezone);
}

echo "🎯 Processing Generation Bonuses for: $date\n";
echo "⏰ Process started: " . date('Y-m-d H:i:s') . "\n";
echo str_repeat('=', 60) . "\n";
flush();

$start_time = microtime(true);
$success = false;

try {
    // Enhanced generation processing with chunking for live servers
    $success = processGenerationBonusesEnhanced($date, $chunk_size, $verbose);
    
} catch(Exception $e) {
    echo "❌ Exception during processing: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
} catch(Error $e) {
    echo "❌ Fatal error during processing: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

$end_time = microtime(true);
$duration = $end_time - $start_time;

echo str_repeat('=', 60) . "\n";
echo "⏰ Process completed: " . date('Y-m-d H:i:s') . "\n";
echo "⏱️ Total duration: " . formatDuration($duration) . "\n";
echo "💾 Peak memory: " . formatBytes(memory_get_peak_usage(true)) . "\n";

if($success) {
    echo "🎉 Generation Bonus Processing Completed Successfully!\n";
    exit(0);
} else {
    echo "❌ Generation Bonus Processing Failed or Incomplete!\n";
    exit(1);
}

/**
 * Enhanced generation processing function for live servers
 */
function processGenerationBonusesEnhanced($date, $chunk_size, $verbose) {
    global $mysqli;
    
    // Get total user count first
    $count_query = "SELECT COUNT(DISTINCT m.user) as total 
                    FROM `member` m 
                    INNER JOIN `upgrade` u ON m.user = u.user 
                    WHERE DATE(m.time)<='$date' AND m.paid='1'";
    
    $count_result = mysqli_query($mysqli, $count_query);
    if(!$count_result) {
        echo "❌ Failed to get user count: " . mysqli_error($mysqli) . "\n";
        return false;
    }
    
    $total_users = mysqli_fetch_assoc($count_result)['total'];
    echo "👥 Total users to process: " . number_format($total_users) . "\n";
    
    if($total_users == 0) {
        echo "⚠️ No users found for processing date: $date\n";
        return true; // Not an error, just no users
    }
    
    $total_batches = ceil($total_users / $chunk_size);
    echo "📦 Processing in $total_batches batches of $chunk_size users each\n";
    echo str_repeat('-', 40) . "\n";
    flush();
    
    $processed_users = 0;
    $failed_users = 0;
    $current_batch = 1;
    
    // Process in chunks to prevent timeout
    for($offset = 0; $offset < $total_users; $offset += $chunk_size) {
        $batch_start = microtime(true);
        
        echo "📊 Batch $current_batch/$total_batches (offset: $offset)... ";
        flush();
        
        // Get batch of users
        $batch_query = "SELECT DISTINCT m.user 
                        FROM `member` m 
                        INNER JOIN `upgrade` u ON m.user = u.user 
                        WHERE DATE(m.time)<='$date' AND m.paid='1' 
                        ORDER BY m.user 
                        LIMIT $chunk_size OFFSET $offset";
        
        $batch_result = mysqli_query($mysqli, $batch_query);
        if(!$batch_result) {
            echo "❌ Failed\n";
            if($verbose) echo "   Error: " . mysqli_error($mysqli) . "\n";
            $failed_users += $chunk_size;
            continue;
        }
        
        $batch_users = [];
        while($row = mysqli_fetch_assoc($batch_result)) {
            $batch_users[] = $row['user'];
        }
        
        $actual_batch_size = count($batch_users);
        $batch_processed = 0;
        
        // Process each user in the batch
        foreach($batch_users as $user_id) {
            try {
                $result = user_update11($user_id, $date);
                if($result) {
                    $batch_processed++;
                }
            } catch(Exception $e) {
                if($verbose) echo "   User $user_id failed: " . $e->getMessage() . "\n";
                continue;
            }
        }
        
        $processed_users += $batch_processed;
        $failed_in_batch = $actual_batch_size - $batch_processed;
        $failed_users += $failed_in_batch;
        
        $batch_time = microtime(true) - $batch_start;
        $progress = ($current_batch / $total_batches) * 100;
        
        echo "✅ $batch_processed/$actual_batch_size users (" . number_format($batch_time, 2) . "s) [" . number_format($progress, 1) . "%]\n";
        
        if($verbose && $failed_in_batch > 0) {
            echo "   ⚠️ Failed: $failed_in_batch users in this batch\n";
        }
        
        // Memory check every 5 batches
        if($current_batch % 5 == 0) {
            $memory_mb = round(memory_get_usage(true) / 1024 / 1024);
            echo "   💾 Memory usage: {$memory_mb}MB\n";
            
            // Force garbage collection
            if(function_exists('gc_collect_cycles')) {
                gc_collect_cycles();
            }
        }
        
        flush();
        $current_batch++;
        
        // Small delay between batches to prevent server overload
        usleep(100000); // 0.1 second
    }
    
    echo str_repeat('-', 40) . "\n";
    echo "📊 PROCESSING SUMMARY:\n";
    echo "   Total Users: " . number_format($total_users) . "\n";
    echo "   Processed Successfully: " . number_format($processed_users) . "\n";
    echo "   Failed/Skipped: " . number_format($failed_users) . "\n";
    echo "   Success Rate: " . number_format(($processed_users / max($total_users, 1)) * 100, 1) . "%\n";
    
    return $processed_users > 0;
}

/**
 * Parse command line arguments
 */
function parseArguments($argv) {
    $options = [
        'date' => isset($argv[1]) ? $argv[1] : date("Y-m-d"),
        'chunk_size' => 100, // Smaller chunks for live server
        'max_memory' => 2,   // 2GB default
        'timeout' => 0,      // No timeout
        'verbose' => false
    ];
    
    foreach($argv as $arg) {
        if(strpos($arg, '--chunk-size=') === 0) {
            $options['chunk_size'] = max(50, min(500, (int)substr($arg, 13)));
        }
        elseif(strpos($arg, '--max-memory=') === 0) {
            $options['max_memory'] = max(1, min(8, (int)substr($arg, 13)));
        }
        elseif(strpos($arg, '--timeout=') === 0) {
            $options['timeout'] = max(0, (int)substr($arg, 10));
        }
        elseif($arg === '--verbose') {
            $options['verbose'] = true;
        }
    }
    
    // Validate date format
    if(!preg_match('/^\d{4}-\d{2}-\d{2}$/', $options['date'])) {
        echo "❌ Invalid date format. Use YYYY-MM-DD format.\n";
        exit(1);
    }
    
    return $options;
}

/**
 * Format duration in human readable format
 */
function formatDuration($seconds) {
    if($seconds < 60) return number_format($seconds, 1) . "s";
    if($seconds < 3600) return floor($seconds / 60) . "m " . ($seconds % 60) . "s";
    return floor($seconds / 3600) . "h " . floor(($seconds % 3600) / 60) . "m";
}

/**
 * Format bytes in human readable format
 */
function formatBytes($bytes) {
    if($bytes < 1024) return $bytes . "B";
    if($bytes < 1048576) return number_format($bytes / 1024, 1) . "KB";
    return number_format($bytes / 1048576, 1) . "MB";
}

/**
 * Cleanup function called on script exit
 */
function cleanup_on_exit() {
    if(ob_get_level() > 0) {
        ob_end_flush();
    }
}

?>