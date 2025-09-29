<?php
/**
 * Generation Bonus Cron Script - Absolute Path Version
 * 
 * This version uses absolute paths for better compatibility with cron jobs
 * and different server configurations (cPanel, DirectAdmin, etc.)
 * 
 * IMPORTANT: Update the paths below to match your server setup
 */

// ========================================
// CONFIGURATION - UPDATE THESE PATHS
// ========================================

// Update these paths to match your server structure:
$BASE_PATH = '/home/username/public_html';  // Change 'username' to your actual username
// Alternative common paths:
// $BASE_PATH = '/home/username/httpdocs';   // Some servers use httpdocs
// $BASE_PATH = '/var/www/html';             // Apache default
// $BASE_PATH = '/usr/local/apache/htdocs';  // Some configurations

$DB_PATH = $BASE_PATH . '/db';

// ========================================
// SCRIPT EXECUTION
// ========================================

// Enhanced execution environment for live servers
set_time_limit(0);
ini_set('memory_limit', '2G');
ini_set('max_execution_time', 0);
error_reporting(E_ALL);

echo "🎯 Generation Bonus Cron Script - Absolute Path Edition\n";
echo "=========================================================\n";
echo "Started: " . date('Y-m-d H:i:s') . " | SAPI: " . php_sapi_name() . "\n";

// Parse arguments
$date = isset($argv[1]) ? $argv[1] : date("Y-m-d");
$chunk_size = 100;
$verbose = in_array('--verbose', $argv);

// Parse additional options
foreach($argv as $arg) {
    if(strpos($arg, '--chunk-size=') === 0) {
        $chunk_size = max(50, min(500, (int)substr($arg, 13)));
    }
}

echo "Configuration: Date=$date | Chunks=$chunk_size | Base Path=$BASE_PATH\n";

// Validate date format
if(!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    echo "❌ Invalid date format. Use YYYY-MM-DD format.\n";
    exit(1);
}

// Check if base path exists
if(!is_dir($BASE_PATH)) {
    echo "❌ Base path does not exist: $BASE_PATH\n";
    echo "🔧 Please update the \$BASE_PATH variable in this script to match your server structure.\n";
    echo "💡 Common paths to try:\n";
    echo "   - /home/yourusername/public_html\n";
    echo "   - /home/yourusername/httpdocs\n";
    echo "   - /var/www/html\n";
    echo "   - Current directory: " . getcwd() . "\n";
    exit(1);
}

// Check if db directory exists
if(!is_dir($DB_PATH)) {
    echo "❌ DB directory does not exist: $DB_PATH\n";
    echo "🔍 Looking for db directory in base path...\n";
    
    // Try to find db directory
    $possible_db_paths = [
        $BASE_PATH . '/db',
        $BASE_PATH . '/nzrobo/db',
        $BASE_PATH . '/public_html/db',
        $BASE_PATH . '/htdocs/db'
    ];
    
    foreach($possible_db_paths as $possible_path) {
        if(is_dir($possible_path)) {
            $DB_PATH = $possible_path;
            echo "✅ Found db directory: $DB_PATH\n";
            break;
        }
    }
    
    if(!is_dir($DB_PATH)) {
        echo "❌ Could not find db directory in any common location.\n";
        exit(1);
    }
}

echo "✅ Using DB path: $DB_PATH\n";

// Include required files with absolute paths
$required_files = [
    'db.php' => $DB_PATH . '/db.php',
    'functions.php' => $DB_PATH . '/functions.php', 
    'generation.php' => $DB_PATH . '/generation.php'
];

foreach($required_files as $name => $path) {
    if(!file_exists($path)) {
        echo "❌ Required file missing: $path\n";
        echo "🔍 Files in DB directory:\n";
        $files = glob($DB_PATH . '/*.php');
        foreach($files as $file) {
            echo "   - " . basename($file) . "\n";
        }
        exit(1);
    }
    
    require_once $path;
    echo "✅ Included: $name from $path\n";
}

// Test database connection
if (!isset($mysqli) || !$mysqli) {
    echo "❌ Database connection failed: " . (isset($mysqli) ? mysqli_connect_error() : 'mysqli not initialized') . "\n";
    exit(1);
}

// Test with a simple query
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
echo str_repeat('=', 60) . "\n";

$start_time = microtime(true);
$success = false;

try {
    // Get total user count first
    $count_query = "SELECT COUNT(DISTINCT m.user) as total 
                    FROM `member` m 
                    INNER JOIN `upgrade` u ON m.user = u.user 
                    WHERE DATE(m.time)<='$date' AND m.paid='1'";
    
    $count_result = mysqli_query($mysqli, $count_query);
    if(!$count_result) {
        echo "❌ Failed to get user count: " . mysqli_error($mysqli) . "\n";
        exit(1);
    }
    
    $total_users = mysqli_fetch_assoc($count_result)['total'];
    echo "👥 Total users to process: " . number_format($total_users) . "\n";
    
    if($total_users == 0) {
        echo "⚠️ No users found for processing date: $date\n";
        $success = true;
    } else {
        $total_batches = ceil($total_users / $chunk_size);
        echo "📦 Processing in $total_batches batches of $chunk_size users each\n";
        echo str_repeat('-', 40) . "\n";
        
        $processed_users = 0;
        $current_batch = 1;
        
        // Process in chunks
        for($offset = 0; $offset < $total_users; $offset += $chunk_size) {
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
                echo "❌ Failed - " . mysqli_error($mysqli) . "\n";
                continue;
            }
            
            $batch_users = [];
            while($row = mysqli_fetch_assoc($batch_result)) {
                $batch_users[] = $row['user'];
            }
            
            $batch_processed = 0;
            
            // Process each user in the batch
            foreach($batch_users as $user_id) {
                try {
                    $result = user_update11($user_id, $date);
                    if($result) {
                        $batch_processed++;
                    }
                } catch(Exception $e) {
                    if($verbose) echo "\n   ⚠️ User $user_id failed: " . $e->getMessage();
                    continue;
                }
            }
            
            $processed_users += $batch_processed;
            $progress = ($current_batch / $total_batches) * 100;
            
            echo "✅ $batch_processed/" . count($batch_users) . " users [" . number_format($progress, 1) . "%]\n";
            
            $current_batch++;
            usleep(100000); // 0.1 second delay
        }
        
        echo str_repeat('-', 40) . "\n";
        echo "📊 PROCESSING SUMMARY:\n";
        echo "   Processed Successfully: " . number_format($processed_users) . "/" . number_format($total_users) . "\n";
        echo "   Success Rate: " . number_format(($processed_users / max($total_users, 1)) * 100, 1) . "%\n";
        
        $success = ($processed_users > 0);
    }
    
} catch(Exception $e) {
    echo "❌ Exception during processing: " . $e->getMessage() . "\n";
} catch(Error $e) {
    echo "❌ Fatal error during processing: " . $e->getMessage() . "\n";
}

$end_time = microtime(true);
$duration = $end_time - $start_time;

echo str_repeat('=', 60) . "\n";
echo "⏰ Completed: " . date('Y-m-d H:i:s') . "\n";
echo "⏱️ Duration: " . number_format($duration, 1) . "s\n";
echo "💾 Peak Memory: " . number_format(memory_get_peak_usage(true) / 1024 / 1024, 1) . "MB\n";

if($success) {
    echo "🎉 Generation Bonus Processing Completed Successfully!\n";
    exit(0);
} else {
    echo "❌ Generation Bonus Processing Failed!\n";
    exit(1);
}
?>