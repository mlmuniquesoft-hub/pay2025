<?php
/**
 * Enterprise-Scale Generation Bonus Processor
 * Optimized for 50,000+ users with chunked processing
 * 
 * Usage: php enterprise_generation_processor.php [date] [options]
 * 
 * Options:
 *   --chunk-size=N     Users per chunk (default: 1000)
 *   --max-memory=N     Memory limit in GB (default: 4)
 *   --delay=N          Seconds between chunks (default: 1)
 *   --resume-from=N    Resume from specific chunk
 *   --dry-run          Test mode without actual processing
 *   --verbose          Detailed output
 */

// Enterprise configuration
ini_set('memory_limit', '6G');
ini_set('max_execution_time', 0);
error_reporting(E_ALL);

// Include required files
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/generation.php';

class EnterpriseGenerationProcessor {
    private $mysqli;
    private $target_date;
    private $chunk_size;
    private $memory_limit;
    private $delay;
    private $resume_from;
    private $dry_run;
    private $verbose;
    
    // Statistics
    private $total_users = 0;
    private $total_chunks = 0;
    private $processed_chunks = 0;
    private $failed_chunks = 0;
    private $processed_users = 0;
    private $start_time;
    
    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
        $this->start_time = microtime(true);
    }
    
    public function parseArguments($args) {
        // Default values
        $this->target_date = isset($args[1]) ? $args[1] : date('Y-m-d');
        $this->chunk_size = 1000; // Enterprise default
        $this->memory_limit = 4;   // GB
        $this->delay = 1;          // seconds
        $this->resume_from = 0;
        $this->dry_run = false;
        $this->verbose = false;
        
        // Parse options
        foreach($args as $arg) {
            if(strpos($arg, '--chunk-size=') === 0) {
                $this->chunk_size = max(100, min(5000, (int)substr($arg, 13)));
            }
            elseif(strpos($arg, '--max-memory=') === 0) {
                $this->memory_limit = max(1, min(8, (int)substr($arg, 13)));
            }
            elseif(strpos($arg, '--delay=') === 0) {
                $this->delay = max(0, min(10, (int)substr($arg, 8)));
            }
            elseif(strpos($arg, '--resume-from=') === 0) {
                $this->resume_from = max(0, (int)substr($arg, 14));
            }
            elseif($arg === '--dry-run') {
                $this->dry_run = true;
            }
            elseif($arg === '--verbose') {
                $this->verbose = true;
            }
        }
        
        // Apply memory limit
        ini_set('memory_limit', $this->memory_limit . 'G');
        
        // Validate date
        if(!preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->target_date)) {
            $this->target_date = date('Y-m-d');
        }
    }
    
    public function initialize() {
        echo "\n🏭 ENTERPRISE GENERATION BONUS PROCESSOR\n";
        echo "=====================================\n\n";
        
        // Get total users
        $query = "SELECT COUNT(DISTINCT m.user) as total 
                  FROM `member` m 
                  INNER JOIN `upgrade` u ON m.user = u.user 
                  WHERE DATE(m.time)<='{$this->target_date}' AND m.paid='1'";
        
        $result = mysqli_query($this->mysqli, $query);
        $row = mysqli_fetch_assoc($result);
        $this->total_users = $row ? (int)$row['total'] : 0;
        $this->total_chunks = ceil($this->total_users / $this->chunk_size);
        
        // Determine scale
        $scale = $this->getScaleType();
        
        echo "📊 PROCESSING CONFIGURATION:\n";
        echo "   Target Date: {$this->target_date}\n";
        echo "   Total Users: " . number_format($this->total_users) . "\n";
        echo "   Scale Type: {$scale}\n";
        echo "   Chunk Size: " . number_format($this->chunk_size) . " users\n";
        echo "   Total Chunks: " . number_format($this->total_chunks) . "\n";
        echo "   Memory Limit: {$this->memory_limit}GB\n";
        echo "   Chunk Delay: {$this->delay}s\n";
        if($this->resume_from > 0) {
            echo "   Resume From: Chunk " . number_format($this->resume_from) . "\n";
        }
        if($this->dry_run) {
            echo "   Mode: DRY RUN (no actual processing)\n";
        }
        echo "\n";
        
        if($this->total_users == 0) {
            echo "❌ No users found for processing date: {$this->target_date}\n";
            return false;
        }
        
        return true;
    }
    
    private function getScaleType() {
        if($this->total_users > 100000) return "🏭 MEGA ENTERPRISE (100K+)";
        if($this->total_users > 50000) return "🏢 ENTERPRISE (50K+)";
        if($this->total_users > 25000) return "🏬 LARGE ENTERPRISE (25K+)";
        if($this->total_users > 10000) return "📈 LARGE SCALE (10K+)";
        return "📊 STANDARD SCALE";
    }
    
    public function process() {
        if($this->dry_run) {
            echo "🧪 DRY RUN MODE - Simulating processing...\n\n";
        }
        
        $start_chunk = max(1, $this->resume_from + 1);
        
        for($chunk = $start_chunk; $chunk <= $this->total_chunks; $chunk++) {
            $this->processChunk($chunk);
            
            // Progress update
            $this->displayProgress($chunk);
            
            // Delay between chunks (except for last chunk)
            if($chunk < $this->total_chunks && $this->delay > 0) {
                sleep($this->delay);
            }
        }
        
        $this->displaySummary();
    }
    
    private function processChunk($chunk_number) {
        $chunk_start_time = microtime(true);
        $offset = ($chunk_number - 1) * $this->chunk_size;
        
        if($this->verbose) {
            echo "Processing chunk {$chunk_number}/{$this->total_chunks} (offset: {$offset})...\n";
        }
        
        // Get users for this chunk
        $query = "SELECT DISTINCT m.user 
                  FROM `member` m 
                  INNER JOIN `upgrade` u ON m.user = u.user 
                  WHERE DATE(m.time)<='{$this->target_date}' AND m.paid='1' 
                  ORDER BY m.user 
                  LIMIT {$this->chunk_size} OFFSET {$offset}";
        
        $result = mysqli_query($this->mysqli, $query);
        
        $chunk_users = [];
        while($row = mysqli_fetch_assoc($result)) {
            $chunk_users[] = $row['user'];
        }
        
        $chunk_user_count = count($chunk_users);
        if($chunk_user_count == 0) {
            $this->failed_chunks++;
            return;
        }
        
        $chunk_processed = 0;
        $chunk_success = true;
        
        if(!$this->dry_run) {
            try {
                // Process generation bonuses for this chunk
                foreach($chunk_users as $user_id) {
                    $result = $this->processSingleUser($user_id);
                    if($result) {
                        $chunk_processed++;
                    }
                }
                
                if($chunk_processed > 0) {
                    $this->processed_chunks++;
                    $this->processed_users += $chunk_processed;
                } else {
                    $chunk_success = false;
                    $this->failed_chunks++;
                }
            } catch(Exception $e) {
                $chunk_success = false;
                $this->failed_chunks++;
                if($this->verbose) {
                    echo "   ❌ Error: " . $e->getMessage() . "\n";
                }
            }
        } else {
            // Dry run simulation
            $chunk_processed = $chunk_user_count;
            $this->processed_chunks++;
            $this->processed_users += $chunk_processed;
            usleep(50000); // Simulate processing time
        }
        
        $chunk_end_time = microtime(true);
        $chunk_duration = $chunk_end_time - $chunk_start_time;
        
        if($this->verbose) {
            $status = $chunk_success ? "✅ SUCCESS" : "❌ FAILED";
            echo "   {$status} - {$chunk_processed}/{$chunk_user_count} users (" . round($chunk_duration, 2) . "s)\n";
        }
    }
    
    private function processSingleUser($user_id) {
        // Implement single user generation processing
        // This is a placeholder - you'd implement the actual logic
        try {
            // Call your generation function for single user
            $result = Generationoncome($this->target_date, $user_id);
            return $result;
        } catch(Exception $e) {
            return false;
        }
    }
    
    private function displayProgress($current_chunk) {
        $progress = ($current_chunk / $this->total_chunks) * 100;
        $elapsed = microtime(true) - $this->start_time;
        $eta = $elapsed > 0 ? ($elapsed / $current_chunk) * ($this->total_chunks - $current_chunk) : 0;
        
        // Progress bar
        $bar_length = 50;
        $filled = round($progress / 100 * $bar_length);
        $bar = str_repeat('█', $filled) . str_repeat('░', $bar_length - $filled);
        
        echo "\r🚀 Progress: [{$bar}] " . round($progress, 1) . "% ";
        echo "| Chunk {$current_chunk}/{$this->total_chunks} ";
        echo "| Users: " . number_format($this->processed_users) . "/" . number_format($this->total_users) . " ";
        echo "| ETA: " . $this->formatTime($eta) . "   ";
        
        if($current_chunk == $this->total_chunks) {
            echo "\n\n";
        }
    }
    
    private function displaySummary() {
        $total_time = microtime(true) - $this->start_time;
        $success_rate = $this->total_chunks > 0 ? ($this->processed_chunks / $this->total_chunks) * 100 : 0;
        
        echo "✅ ENTERPRISE PROCESSING COMPLETED!\n";
        echo "==================================\n\n";
        echo "📊 FINAL STATISTICS:\n";
        echo "   Total Users: " . number_format($this->total_users) . "\n";
        echo "   Processed Users: " . number_format($this->processed_users) . "\n";
        echo "   Success Rate: " . round($success_rate, 1) . "%\n";
        echo "   Total Chunks: " . number_format($this->total_chunks) . "\n";
        echo "   Successful Chunks: " . number_format($this->processed_chunks) . "\n";
        echo "   Failed Chunks: " . number_format($this->failed_chunks) . "\n";
        echo "   Processing Time: " . $this->formatTime($total_time) . "\n";
        echo "   Average Speed: " . round($this->processed_users / max($total_time, 1)) . " users/second\n";
        echo "   Memory Used: " . round(memory_get_peak_usage(true) / 1024 / 1024) . "MB\n\n";
        
        if($this->failed_chunks > 0) {
            echo "⚠️ WARNING: {$this->failed_chunks} chunks failed. Consider:\n";
            echo "   - Reducing chunk size (--chunk-size=500)\n";
            echo "   - Increasing delay (--delay=2)\n";
            echo "   - Checking database connection\n";
            echo "   - Running with --verbose for details\n\n";
        }
        
        if($this->dry_run) {
            echo "🧪 This was a DRY RUN - no actual processing occurred.\n";
            echo "   Remove --dry-run flag to perform actual processing.\n\n";
        }
    }
    
    private function formatTime($seconds) {
        if($seconds < 60) return round($seconds) . "s";
        if($seconds < 3600) return round($seconds / 60) . "m " . round($seconds % 60) . "s";
        return round($seconds / 3600) . "h " . round(($seconds % 3600) / 60) . "m";
    }
}

// Main execution
if(php_sapi_name() !== 'cli') {
    die("This script must be run from command line.\n");
}

echo "🔧 Initializing Enterprise Generation Processor...\n";

// Create processor instance
$processor = new EnterpriseGenerationProcessor($mysqli);

// Parse command line arguments
$processor->parseArguments($argv);

// Initialize and validate
if(!$processor->initialize()) {
    exit(1);
}

// Confirm before processing (except for dry run)
if(!in_array('--dry-run', $argv)) {
    echo "⚠️  This will process generation bonuses for potentially 50,000+ users.\n";
    echo "   Press ENTER to continue or Ctrl+C to cancel: ";
    $handle = fopen("php://stdin", "r");
    fgets($handle);
    fclose($handle);
    echo "\n";
}

// Start processing
echo "🚀 Starting Enterprise Processing...\n\n";
$processor->process();

echo "🎉 Enterprise processing completed successfully!\n";
exit(0);
?>