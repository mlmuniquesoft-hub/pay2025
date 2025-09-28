<?php
/**
 * Enterprise Queue Manager for Generation Bonus Processing
 * Handles 50,000+ users with queue-based processing, auto-retry, and scheduling
 */

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

class EnterpriseQueueManager {
    private $mysqli;
    private $queue_table = 'generation_processing_queue';
    private $log_table = 'generation_processing_log';
    
    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
        $this->initializeTables();
    }
    
    private function initializeTables() {
        // Create queue table
        $queue_sql = "CREATE TABLE IF NOT EXISTS `{$this->queue_table}` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `batch_id` varchar(50) NOT NULL,
            `date` date NOT NULL,
            `user_ids` text NOT NULL,
            `status` enum('pending','processing','completed','failed','retry') DEFAULT 'pending',
            `priority` tinyint(4) DEFAULT 5,
            `attempts` tinyint(4) DEFAULT 0,
            `max_attempts` tinyint(4) DEFAULT 3,
            `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
            `started_at` timestamp NULL DEFAULT NULL,
            `completed_at` timestamp NULL DEFAULT NULL,
            `error_message` text,
            `processed_users` int(11) DEFAULT 0,
            `total_users` int(11) DEFAULT 0,
            PRIMARY KEY (`id`),
            KEY `idx_status` (`status`),
            KEY `idx_date` (`date`),
            KEY `idx_priority` (`priority`),
            KEY `idx_batch_id` (`batch_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8";
        
        $log_sql = "CREATE TABLE IF NOT EXISTS `{$this->log_table}` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `batch_id` varchar(50) NOT NULL,
            `date` date NOT NULL,
            `total_batches` int(11) DEFAULT 0,
            `completed_batches` int(11) DEFAULT 0,
            `failed_batches` int(11) DEFAULT 0,
            `total_users` int(11) DEFAULT 0,
            `processed_users` int(11) DEFAULT 0,
            `processing_time` decimal(10,2) DEFAULT 0,
            `status` enum('queued','processing','completed','failed') DEFAULT 'queued',
            `started_at` timestamp NULL DEFAULT NULL,
            `completed_at` timestamp NULL DEFAULT NULL,
            `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `idx_date` (`date`),
            KEY `idx_status` (`status`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8";
        
        mysqli_query($this->mysqli, $queue_sql);
        mysqli_query($this->mysqli, $log_sql);
    }
    
    /**
     * Queue generation processing for enterprise scale
     */
    public function queueGenerationProcessing($date, $chunk_size = 500, $priority = 5) {
        echo "🏭 ENTERPRISE QUEUE MANAGER - Preparing Processing Queue\n";
        echo "========================================================\n";
        echo "Date: $date | Chunk Size: $chunk_size | Priority: $priority\n\n";
        
        // Get all users for the date
        $users_query = "SELECT DISTINCT m.user 
                        FROM `member` m 
                        INNER JOIN `upgrade` u ON m.user = u.user 
                        WHERE DATE(m.time)<='$date' AND m.paid='1' 
                        ORDER BY m.user";
        
        $result = mysqli_query($this->mysqli, $users_query);
        if(!$result) {
            echo "❌ Error getting users: " . mysqli_error($this->mysqli) . "\n";
            return false;
        }
        
        $all_users = array();
        while($row = mysqli_fetch_assoc($result)) {
            $all_users[] = $row['user'];
        }
        
        $total_users = count($all_users);
        $total_chunks = ceil($total_users / $chunk_size);
        
        // Determine scale type
        $scale_type = $this->getScaleType($total_users);
        
        echo "👥 Total Users: " . number_format($total_users) . "\n";
        echo "📦 Total Chunks: " . number_format($total_chunks) . "\n";
        echo "🎯 Scale Type: $scale_type\n";
        echo "⏱️  Estimated Time: " . $this->estimateProcessingTime($total_users, $chunk_size) . "\n\n";
        
        // Create processing log entry
        $log_id = $this->createProcessingLog($date, $total_chunks, $total_users);
        
        // Create batches and queue them
        $batch_number = 1;
        $queued_batches = 0;
        
        for($i = 0; $i < $total_users; $i += $chunk_size) {
            $chunk_users = array_slice($all_users, $i, $chunk_size);
            $batch_id = "batch_" . $date . "_" . str_pad($batch_number, 6, '0', STR_PAD_LEFT);
            
            $queue_sql = "INSERT INTO `{$this->queue_table}` 
                         (batch_id, date, user_ids, total_users, priority) 
                         VALUES 
                         ('$batch_id', '$date', '" . implode(',', $chunk_users) . "', " . count($chunk_users) . ", $priority)";
            
            if(mysqli_query($this->mysqli, $queue_sql)) {
                $queued_batches++;
                echo "✅ Queued: $batch_id (" . count($chunk_users) . " users)\n";
            } else {
                echo "❌ Failed to queue: $batch_id - " . mysqli_error($this->mysqli) . "\n";
            }
            
            $batch_number++;
        }
        
        echo "\n🎉 QUEUE PREPARATION COMPLETED!\n";
        echo "Queued Batches: $queued_batches\n";
        echo "Total Users: " . number_format($total_users) . "\n";
        echo "Ready for processing!\n\n";
        
        return array(
            'log_id' => $log_id,
            'total_batches' => $total_chunks,
            'queued_batches' => $queued_batches,
            'total_users' => $total_users
        );
    }
    
    /**
     * Process queued batches
     */
    public function processQueue($max_batches = 0, $timeout_minutes = 60) {
        $start_time = microtime(true);
        $timeout_seconds = $timeout_minutes * 60;
        $processed_batches = 0;
        $failed_batches = 0;
        
        echo "🚀 ENTERPRISE QUEUE PROCESSOR STARTED\n";
        echo "=====================================\n";
        echo "Max Batches: " . ($max_batches ?: 'Unlimited') . "\n";
        echo "Timeout: {$timeout_minutes} minutes\n\n";
        
        while(true) {
            // Check timeout
            if((microtime(true) - $start_time) > $timeout_seconds) {
                echo "⏰ Timeout reached, stopping processor\n";
                break;
            }
            
            // Check max batches
            if($max_batches > 0 && $processed_batches >= $max_batches) {
                echo "📊 Max batches processed, stopping\n";
                break;
            }
            
            // Get next batch to process
            $batch = $this->getNextBatch();
            if(!$batch) {
                echo "✅ No more batches to process\n";
                break;
            }
            
            // Process the batch
            $batch_result = $this->processBatch($batch);
            
            if($batch_result['success']) {
                $processed_batches++;
                echo "✅ {$batch['batch_id']}: {$batch_result['processed']}/{$batch['total_users']} users processed\n";
            } else {
                $failed_batches++;
                echo "❌ {$batch['batch_id']}: Failed - {$batch_result['error']}\n";
            }
            
            // Small delay between batches
            usleep(100000); // 0.1 second
        }
        
        $total_time = microtime(true) - $start_time;
        
        echo "\n🎯 QUEUE PROCESSING COMPLETED!\n";
        echo "Processed Batches: $processed_batches\n";
        echo "Failed Batches: $failed_batches\n";
        echo "Processing Time: " . $this->formatTime($total_time) . "\n";
        
        return array(
            'processed_batches' => $processed_batches,
            'failed_batches' => $failed_batches,
            'processing_time' => $total_time
        );
    }
    
    private function getNextBatch() {
        $query = "SELECT * FROM `{$this->queue_table}` 
                  WHERE status IN ('pending', 'retry') AND attempts < max_attempts 
                  ORDER BY priority DESC, created_at ASC 
                  LIMIT 1";
        
        $result = mysqli_query($this->mysqli, $query);
        return $result ? mysqli_fetch_assoc($result) : null;
    }
    
    private function processBatch($batch) {
        $batch_id = $batch['batch_id'];
        $date = $batch['date'];
        $user_ids = explode(',', $batch['user_ids']);
        
        // Update status to processing
        mysqli_query($this->mysqli, "UPDATE `{$this->queue_table}` 
                                    SET status = 'processing', started_at = NOW(), attempts = attempts + 1 
                                    WHERE id = {$batch['id']}");
        
        $processed_users = 0;
        $error_message = '';
        
        try {
            require_once __DIR__ . '/generation.php';
            
            foreach($user_ids as $user_id) {
                if(user_update11(trim($user_id), $date)) {
                    $processed_users++;
                }
            }
            
            // Update as completed
            mysqli_query($this->mysqli, "UPDATE `{$this->queue_table}` 
                                        SET status = 'completed', completed_at = NOW(), processed_users = $processed_users 
                                        WHERE id = {$batch['id']}");
            
            return array('success' => true, 'processed' => $processed_users);
            
        } catch(Exception $e) {
            $error_message = $e->getMessage();
            
            // Determine retry or fail
            $status = ($batch['attempts'] + 1 >= $batch['max_attempts']) ? 'failed' : 'retry';
            
            mysqli_query($this->mysqli, "UPDATE `{$this->queue_table}` 
                                        SET status = '$status', error_message = '" . addslashes($error_message) . "', processed_users = $processed_users 
                                        WHERE id = {$batch['id']}");
            
            return array('success' => false, 'error' => $error_message, 'processed' => $processed_users);
        }
    }
    
    /**
     * Get queue status
     */
    public function getQueueStatus($date = null) {
        $where = $date ? "WHERE date = '$date'" : "";
        
        $status_query = "SELECT 
                            status,
                            COUNT(*) as count,
                            SUM(total_users) as total_users,
                            SUM(processed_users) as processed_users
                         FROM `{$this->queue_table}` 
                         $where
                         GROUP BY status";
        
        $result = mysqli_query($this->mysqli, $status_query);
        $status = array();
        
        while($row = mysqli_fetch_assoc($result)) {
            $status[$row['status']] = $row;
        }
        
        return $status;
    }
    
    /**
     * Clean old queue entries
     */
    public function cleanOldEntries($days = 7) {
        $cutoff_date = date('Y-m-d', strtotime("-$days days"));
        
        $deleted_queue = mysqli_query($this->mysqli, "DELETE FROM `{$this->queue_table}` WHERE date < '$cutoff_date'");
        $deleted_log = mysqli_query($this->mysqli, "DELETE FROM `{$this->log_table}` WHERE date < '$cutoff_date'");
        
        $queue_deleted = mysqli_affected_rows($this->mysqli);
        
        echo "🧹 Cleanup completed: $queue_deleted entries removed\n";
        return $queue_deleted;
    }
    
    private function getScaleType($user_count) {
        if($user_count > 100000) return "🏭 MEGA ENTERPRISE (100K+)";
        if($user_count > 50000) return "🏢 ENTERPRISE (50K+)";
        if($user_count > 25000) return "🏬 LARGE ENTERPRISE (25K+)";
        if($user_count > 10000) return "📈 LARGE SCALE (10K+)";
        return "📊 STANDARD SCALE";
    }
    
    private function estimateProcessingTime($users, $chunk_size) {
        $chunks = ceil($users / $chunk_size);
        $seconds_per_chunk = 5; // Estimated
        $total_seconds = $chunks * $seconds_per_chunk;
        return $this->formatTime($total_seconds);
    }
    
    private function createProcessingLog($date, $total_batches, $total_users) {
        $sql = "INSERT INTO `{$this->log_table}` 
                (date, total_batches, total_users, status) 
                VALUES 
                ('$date', $total_batches, $total_users, 'queued')";
        
        mysqli_query($this->mysqli, $sql);
        return mysqli_insert_id($this->mysqli);
    }
    
    private function formatTime($seconds) {
        if($seconds < 60) return round($seconds) . "s";
        if($seconds < 3600) return round($seconds / 60) . "m " . round($seconds % 60) . "s";
        return round($seconds / 3600) . "h " . round(($seconds % 3600) / 60) . "m";
    }
}

// CLI Usage
if(php_sapi_name() === 'cli') {
    $action = isset($argv[1]) ? $argv[1] : 'help';
    $date = isset($argv[2]) ? $argv[2] : date('Y-m-d');
    
    $queue_manager = new EnterpriseQueueManager($mysqli);
    
    switch($action) {
        case 'queue':
            $chunk_size = isset($argv[3]) ? (int)$argv[3] : 500;
            $priority = isset($argv[4]) ? (int)$argv[4] : 5;
            $queue_manager->queueGenerationProcessing($date, $chunk_size, $priority);
            break;
            
        case 'process':
            $max_batches = isset($argv[3]) ? (int)$argv[3] : 0;
            $timeout = isset($argv[4]) ? (int)$argv[4] : 60;
            $queue_manager->processQueue($max_batches, $timeout);
            break;
            
        case 'status':
            $status = $queue_manager->getQueueStatus($date);
            echo "Queue Status for $date:\n";
            foreach($status as $state => $data) {
                echo "  $state: {$data['count']} batches, {$data['total_users']} users\n";
            }
            break;
            
        case 'cleanup':
            $days = isset($argv[3]) ? (int)$argv[3] : 7;
            $queue_manager->cleanOldEntries($days);
            break;
            
        default:
            echo "Enterprise Queue Manager Commands:\n";
            echo "  php enterprise_queue_manager.php queue [date] [chunk_size] [priority]\n";
            echo "  php enterprise_queue_manager.php process [date] [max_batches] [timeout_minutes]\n";
            echo "  php enterprise_queue_manager.php status [date]\n";
            echo "  php enterprise_queue_manager.php cleanup [days]\n";
            break;
    }
}

?>