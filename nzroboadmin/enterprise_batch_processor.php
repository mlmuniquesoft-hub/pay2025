<?php
session_start(); 
if(!isset($_SESSION['Admin'])){
    header("Location:logout.php");
    exit();
}

require '../db/db.php';
require '../db/functions.php';
require_once '../db/generation.php';

// Enterprise-scale configuration
$DEFAULT_CHUNK_SIZE = 500; // Larger chunks for enterprise scale
$MAX_CHUNK_SIZE = 1000;    // Maximum chunk size
$MIN_CHUNK_SIZE = 100;     // Minimum chunk size
$PROCESSING_DELAY = 2;     // Seconds between chunks (prevent server overload)

$target_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$chunk_size = isset($_GET['chunk_size']) ? max($MIN_CHUNK_SIZE, min((int)$_GET['chunk_size'], $MAX_CHUNK_SIZE)) : $DEFAULT_CHUNK_SIZE;
$start_batch = isset($_GET['start_batch']) ? (int)$_GET['start_batch'] : 1;
$auto_resume = isset($_GET['auto_resume']) ? true : false;

// Validate date
if(!preg_match('/^\d{4}-\d{2}-\d{2}$/', $target_date)) {
    $target_date = date('Y-m-d');
}

// Get total users count
$total_users_query = mysqli_query($mysqli, "SELECT COUNT(DISTINCT m.user) as total FROM `member` m INNER JOIN `upgrade` u ON m.user = u.user WHERE DATE(m.time)<='".$target_date."' AND m.paid='1'");
$total_users_result = mysqli_fetch_assoc($total_users_query);
$total_users = ($total_users_result && $total_users_result['total']) ? (int)$total_users_result['total'] : 0;

$total_batches = ceil($total_users / $chunk_size);
$current_batch = $start_batch;

// Determine scale type
$scale_type = "STANDARD";
$scale_color = "#28a745";
$scale_icon = "📊";
if($total_users > 50000) {
    $scale_type = "MEGA ENTERPRISE";
    $scale_color = "#dc3545";
    $scale_icon = "🏭";
} elseif($total_users > 25000) {
    $scale_type = "ENTERPRISE";
    $scale_color = "#fd7e14";
    $scale_icon = "🏢";
} elseif($total_users > 10000) {
    $scale_type = "LARGE ENTERPRISE";
    $scale_color = "#17a2b8";
    $scale_icon = "🏬";
} elseif($total_users > 5000) {
    $scale_type = "LARGE SCALE";
    $scale_color = "#6610f2";
    $scale_icon = "📈";
}

// Processing logic
$processing = false;
$completed_batches = 0;
$failed_batches = 0;
$processed_users = 0;
$processing_log = array();

if(isset($_POST['start_processing']) || $auto_resume) {
    $processing = true;
    set_time_limit(0); // No time limit for enterprise processing
    ini_set('memory_limit', '6G'); // Maximum memory for enterprise scale
    
    // Get users in batches
    $offset = ($current_batch - 1) * $chunk_size;
    
    while($current_batch <= $total_batches) {
        $batch_start_time = microtime(true);
        
        // Get batch of users
        $users_query = mysqli_query($mysqli, "
            SELECT DISTINCT m.user 
            FROM `member` m 
            INNER JOIN `upgrade` u ON m.user = u.user 
            WHERE DATE(m.time)<='".$target_date."' AND m.paid='1' 
            ORDER BY m.user 
            LIMIT $chunk_size OFFSET $offset
        ");
        
        $batch_users = array();
        while($user_row = mysqli_fetch_assoc($users_query)) {
            $batch_users[] = $user_row['user'];
        }
        
        $batch_user_count = count($batch_users);
        if($batch_user_count == 0) break;
        
        // Process this batch
        ob_start();
        $batch_success = true;
        $batch_processed = 0;
        
        try {
            // Process generation bonuses for this batch
            foreach($batch_users as $user_id) {
                $individual_result = processSingleUserGeneration($user_id, $target_date);
                if($individual_result) {
                    $batch_processed++;
                }
            }
            
            if($batch_processed > 0) {
                $completed_batches++;
                $processed_users += $batch_processed;
            } else {
                $batch_success = false;
                $failed_batches++;
            }
        } catch(Exception $e) {
            $batch_success = false;
            $failed_batches++;
        }
        
        $batch_output = ob_get_clean();
        $batch_end_time = microtime(true);
        $batch_duration = round($batch_end_time - $batch_start_time, 2);
        
        // Log batch processing
        $processing_log[] = array(
            'batch' => $current_batch,
            'users' => $batch_user_count,
            'processed' => $batch_processed,
            'success' => $batch_success,
            'duration' => $batch_duration,
            'timestamp' => date('H:i:s')
        );
        
        // Real-time progress update
        if(!$auto_resume) {
            echo "<script>updateProgress($current_batch, $total_batches, $processed_users, $total_users, '$scale_type');</script>";
            flush();
        }
        
        $current_batch++;
        $offset += $chunk_size;
        
        // Delay between batches to prevent server overload
        if($current_batch <= $total_batches) {
            sleep($PROCESSING_DELAY);
        }
    }
}

// Helper function to process single user generation
function processSingleUserGeneration($user_id, $date) {
    global $mysqli;
    
    try {
        // This is a simplified version - you'd implement the actual generation logic here
        // For now, we'll call the main generation function with a single user filter
        ob_start();
        $result = Generationoncome($date, $user_id); // Assuming you modify the function to accept user filter
        ob_get_clean();
        return $result;
    } catch(Exception $e) {
        return false;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Enterprise Batch Processor - Generation Bonuses</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="lib/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/font-awesome.min.css">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .enterprise-container { background: white; border-radius: 15px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); margin: 20px auto; max-width: 1200px; }
        .enterprise-header { background: <?php echo $scale_color; ?>; color: white; padding: 25px; border-radius: 15px 15px 0 0; text-align: center; }
        .scale-badge { background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 20px; display: inline-block; margin: 10px 0; }
        .progress-container { background: #f8f9fa; padding: 20px; margin: 20px; border-radius: 10px; }
        .batch-progress { height: 30px; background: #e9ecef; border-radius: 15px; overflow: hidden; position: relative; margin: 20px 0; }
        .batch-progress-bar { height: 100%; background: linear-gradient(45deg, <?php echo $scale_color; ?>, <?php echo $scale_color; ?>88); transition: width 0.5s ease; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin: 20px; }
        .stat-card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); text-align: center; border-left: 4px solid <?php echo $scale_color; ?>; }
        .processing-log { background: #f8f9fa; border-radius: 10px; margin: 20px; max-height: 400px; overflow-y: auto; }
        .log-entry { padding: 10px; border-bottom: 1px solid #dee2e6; font-family: monospace; font-size: 0.9em; }
        .log-success { background: #d4edda; color: #155724; }
        .log-error { background: #f8d7da; color: #721c24; }
        .enterprise-controls { padding: 30px; background: #f8f9fa; border-radius: 0 0 15px 15px; }
    </style>
</head>
<body>
    <div class="enterprise-container">
        <!-- Enterprise Header -->
        <div class="enterprise-header">
            <h1><?php echo $scale_icon; ?> ENTERPRISE BATCH PROCESSOR</h1>
            <div class="scale-badge">
                <strong><?php echo $scale_type; ?> PROCESSING</strong>
            </div>
            <p style="margin: 10px 0; font-size: 1.2em;">
                <strong><?php echo number_format($total_users); ?></strong> Users • 
                <strong><?php echo $total_batches; ?></strong> Batches • 
                <strong><?php echo $chunk_size; ?></strong> Users/Batch
            </p>
            <p style="margin: 5px 0;">Target Date: <strong><?php echo $target_date; ?></strong></p>
        </div>

        <!-- Statistics Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3 style="color: <?php echo $scale_color; ?>; margin: 0;"><?php echo number_format($total_users); ?></h3>
                <p style="margin: 5px 0; color: #6c757d;">Total Users</p>
            </div>
            <div class="stat-card">
                <h3 style="color: <?php echo $scale_color; ?>; margin: 0;"><?php echo $total_batches; ?></h3>
                <p style="margin: 5px 0; color: #6c757d;">Total Batches</p>
            </div>
            <div class="stat-card">
                <h3 style="color: <?php echo $scale_color; ?>; margin: 0;"><?php echo $chunk_size; ?></h3>
                <p style="margin: 5px 0; color: #6c757d;">Batch Size</p>
            </div>
            <div class="stat-card">
                <h3 style="color: <?php echo $scale_color; ?>; margin: 0;" id="processed-users"><?php echo number_format($processed_users); ?></h3>
                <p style="margin: 5px 0; color: #6c757d;">Processed Users</p>
            </div>
        </div>

        <!-- Progress Container -->
        <?php if($processing || $completed_batches > 0): ?>
        <div class="progress-container">
            <h4><i class="fa fa-cog fa-spin"></i> Processing Progress</h4>
            <div class="batch-progress">
                <div class="batch-progress-bar" id="progress-bar" style="width: <?php echo ($completed_batches / $total_batches) * 100; ?>%;"></div>
                <div style="position: absolute; width: 100%; text-align: center; line-height: 30px; color: #333; font-weight: bold;">
                    <span id="progress-text"><?php echo $completed_batches; ?> / <?php echo $total_batches; ?> Batches (<?php echo round(($completed_batches / $total_batches) * 100, 1); ?>%)</span>
                </div>
            </div>
            
            <!-- Real-time Stats -->
            <div class="row" style="margin: 20px 0;">
                <div class="col-md-3 text-center">
                    <div class="alert alert-success">
                        <h4 id="success-batches"><?php echo $completed_batches; ?></h4>
                        <small>Successful Batches</small>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="alert alert-danger">
                        <h4 id="failed-batches"><?php echo $failed_batches; ?></h4>
                        <small>Failed Batches</small>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="alert alert-info">
                        <h4 id="remaining-batches"><?php echo $total_batches - $completed_batches - $failed_batches; ?></h4>
                        <small>Remaining Batches</small>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="alert alert-warning">
                        <h4 id="eta-minutes"><?php echo ceil(($total_batches - $completed_batches) * ($PROCESSING_DELAY + 2)); ?></h4>
                        <small>ETA Minutes</small>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Processing Controls -->
        <div class="enterprise-controls">
            <?php if(!$processing && $completed_batches == 0): ?>
            <!-- Start Processing Form -->
            <form method="POST">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Batch Size (Users per batch)</label>
                            <select name="chunk_size" class="form-control">
                                <option value="100" <?php echo $chunk_size == 100 ? 'selected' : ''; ?>>100 users (Safe)</option>
                                <option value="200" <?php echo $chunk_size == 200 ? 'selected' : ''; ?>>200 users (Balanced)</option>
                                <option value="500" <?php echo $chunk_size == 500 ? 'selected' : ''; ?>>500 users (Fast) ⭐</option>
                                <option value="1000" <?php echo $chunk_size == 1000 ? 'selected' : ''; ?>>1000 users (Enterprise)</option>
                            </select>
                            <small class="text-muted">Larger batches = faster but more server load</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Start from Batch</label>
                            <input type="number" name="start_batch" class="form-control" value="1" min="1" max="<?php echo $total_batches; ?>">
                            <small class="text-muted">For resuming interrupted processing</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" name="start_processing" class="btn btn-primary btn-lg btn-block">
                                    🚀 START ENTERPRISE PROCESSING
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-info">
                    <h5><i class="fa fa-info-circle"></i> Enterprise Processing Information</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Estimated Time:</strong> <?php echo ceil($total_batches * ($PROCESSING_DELAY + 2) / 60); ?> minutes<br>
                            <strong>Server Load:</strong> <?php echo $scale_type; ?><br>
                            <strong>Memory Usage:</strong> Up to 6GB allocated
                        </div>
                        <div class="col-md-6">
                            <strong>Processing Method:</strong> Chunked batch processing<br>
                            <strong>Batch Delay:</strong> <?php echo $PROCESSING_DELAY; ?> seconds between batches<br>
                            <strong>Auto-Resume:</strong> Available if interrupted
                        </div>
                    </div>
                </div>
            </form>
            
            <?php elseif($processing): ?>
            <!-- Processing Status -->
            <div class="alert alert-warning text-center">
                <h4><i class="fa fa-cog fa-spin"></i> ENTERPRISE PROCESSING IN PROGRESS</h4>
                <p>Processing <?php echo number_format($total_users); ?> users in <?php echo $total_batches; ?> batches...</p>
                <p><strong>DO NOT CLOSE THIS WINDOW</strong> - Processing will continue automatically</p>
            </div>
            
            <?php else: ?>
            <!-- Processing Complete -->
            <div class="alert alert-success text-center">
                <h4><i class="fa fa-check-circle"></i> ENTERPRISE PROCESSING COMPLETED!</h4>
                <p>Successfully processed <strong><?php echo number_format($processed_users); ?></strong> out of <strong><?php echo number_format($total_users); ?></strong> users</p>
                <div class="row" style="margin: 20px 0;">
                    <div class="col-md-4">
                        <strong>Successful Batches:</strong> <?php echo $completed_batches; ?>
                    </div>
                    <div class="col-md-4">
                        <strong>Failed Batches:</strong> <?php echo $failed_batches; ?>
                    </div>
                    <div class="col-md-4">
                        <strong>Success Rate:</strong> <?php echo round(($completed_batches / ($completed_batches + $failed_batches)) * 100, 1); ?>%
                    </div>
                </div>
                
                <div style="margin: 20px 0;">
                    <a href="daily_return_settings.php" class="btn btn-primary">← Back to Settings</a>
                    <a href="?date=<?php echo $target_date; ?>&chunk_size=<?php echo $chunk_size; ?>" class="btn btn-info">🔄 Process Again</a>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Processing Log -->
        <?php if(!empty($processing_log)): ?>
        <div class="processing-log">
            <h4 style="padding: 15px 15px 0 15px;"><i class="fa fa-list"></i> Processing Log</h4>
            <?php foreach(array_reverse($processing_log) as $log): ?>
            <div class="log-entry <?php echo $log['success'] ? 'log-success' : 'log-error'; ?>">
                [<?php echo $log['timestamp']; ?>] 
                Batch <?php echo $log['batch']; ?>/<?php echo $total_batches; ?>: 
                <?php echo $log['processed']; ?>/<?php echo $log['users']; ?> users processed 
                (<?php echo $log['duration']; ?>s)
                <?php echo $log['success'] ? '✅ SUCCESS' : '❌ FAILED'; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <script src="lib/js/jquery.min.js"></script>
    <script src="lib/js/bootstrap.min.js"></script>
    <script>
    function updateProgress(currentBatch, totalBatches, processedUsers, totalUsers, scaleType) {
        const percentage = (currentBatch / totalBatches) * 100;
        
        document.getElementById('progress-bar').style.width = percentage + '%';
        document.getElementById('progress-text').innerHTML = currentBatch + ' / ' + totalBatches + ' Batches (' + Math.round(percentage) + '%)';
        document.getElementById('processed-users').innerHTML = processedUsers.toLocaleString();
        document.getElementById('success-batches').innerHTML = currentBatch;
        document.getElementById('remaining-batches').innerHTML = totalBatches - currentBatch;
        
        // Update ETA
        const remainingBatches = totalBatches - currentBatch;
        const etaMinutes = Math.ceil(remainingBatches * 4 / 60); // Rough estimate
        document.getElementById('eta-minutes').innerHTML = etaMinutes;
        
        // Update page title
        document.title = '(' + Math.round(percentage) + '%) Enterprise Processing - ' + scaleType;
    }
    
    // Auto-refresh for long processing
    <?php if($processing): ?>
    setTimeout(function() {
        if(<?php echo $current_batch; ?> < <?php echo $total_batches; ?>) {
            window.location.href = '?date=<?php echo $target_date; ?>&chunk_size=<?php echo $chunk_size; ?>&start_batch=<?php echo $current_batch + 1; ?>&auto_resume=1';
        }
    }, 5000);
    <?php endif; ?>
    </script>
</body>
</html>