<?php
session_start(); 
if(!isset($_SESSION['Admin'])){
    header("Location:logout.php");
    exit();
}

require '../db/db.php';
require '../db/functions.php';
require_once '../db/enterprise_queue_manager.php';

$queue_manager = new EnterpriseQueueManager($mysqli);

// Handle form submissions
if(isset($_POST['queue_processing'])){
    $transaction_pin = trim($_POST['queue_pin']);
    $target_date = trim($_POST['queue_date']);
    $chunk_size = (int)$_POST['chunk_size'];
    $priority = (int)$_POST['priority'];
    
    if(empty($transaction_pin)){
        $error = "Transaction PIN is required";
    } elseif(empty($target_date)){
        $error = "Date is required";
    } else {
        // Verify transaction PIN
        $pin_check = mysqli_query($mysqli, "SELECT * FROM admin WHERE user_id='".$_SESSION['Admin']."' AND tr_password='".$transaction_pin."'");
        if(mysqli_num_rows($pin_check) == 0){
            $error = "Invalid Transaction PIN";
        } else {
            ob_start();
            $result = $queue_manager->queueGenerationProcessing($target_date, $chunk_size, $priority);
            $output = ob_get_clean();
            
            if($result) {
                $success = "✅ Enterprise queue prepared successfully!<br>
                           📦 <strong>Batches Queued:</strong> " . number_format($result['queued_batches']) . "<br>
                           👥 <strong>Total Users:</strong> " . number_format($result['total_users']) . "<br>
                           🎯 <strong>Processing Status:</strong> Ready for execution<br><br>
                           <div style='background: #f8f9fa; padding: 10px; border-radius: 5px; max-height: 300px; overflow-y: auto;'>
                           <strong>Queue Output:</strong><br>" . nl2br(htmlspecialchars($output)) . "</div>";
            } else {
                $error = "❌ Failed to prepare enterprise queue<br><br>
                         <div style='background: #f8f9fa; padding: 10px; border-radius: 5px; max-height: 300px; overflow-y: auto;'>
                         <strong>Error Output:</strong><br>" . nl2br(htmlspecialchars($output)) . "</div>";
            }
        }
    }
}

if(isset($_POST['process_queue'])){
    $transaction_pin = trim($_POST['process_pin']);
    $max_batches = (int)$_POST['max_batches'];
    $timeout_minutes = (int)$_POST['timeout_minutes'];
    
    if(empty($transaction_pin)){
        $error = "Transaction PIN is required";
    } else {
        // Verify transaction PIN
        $pin_check = mysqli_query($mysqli, "SELECT * FROM admin WHERE user_id='".$_SESSION['Admin']."' AND tr_password='".$transaction_pin."'");
        if(mysqli_num_rows($pin_check) == 0){
            $error = "Invalid Transaction PIN";
        } else {
            ob_start();
            $result = $queue_manager->processQueue($max_batches, $timeout_minutes);
            $output = ob_get_clean();
            
            if($result) {
                $success = "✅ Enterprise queue processing completed!<br>
                           📊 <strong>Processed Batches:</strong> " . number_format($result['processed_batches']) . "<br>
                           ❌ <strong>Failed Batches:</strong> " . number_format($result['failed_batches']) . "<br>
                           ⏱️ <strong>Processing Time:</strong> " . round($result['processing_time'], 2) . " seconds<br><br>
                           <div style='background: #f8f9fa; padding: 10px; border-radius: 5px; max-height: 300px; overflow-y: auto;'>
                           <strong>Processing Output:</strong><br>" . nl2br(htmlspecialchars($output)) . "</div>";
            } else {
                $error = "❌ Queue processing encountered issues<br><br>
                         <div style='background: #f8f9fa; padding: 10px; border-radius: 5px; max-height: 300px; overflow-y: auto;'>
                         <strong>Output:</strong><br>" . nl2br(htmlspecialchars($output)) . "</div>";
            }
        }
    }
}

if(isset($_POST['cleanup_queue'])){
    $transaction_pin = trim($_POST['cleanup_pin']);
    $cleanup_days = (int)$_POST['cleanup_days'];
    
    if(empty($transaction_pin)){
        $error = "Transaction PIN is required";
    } else {
        // Verify transaction PIN
        $pin_check = mysqli_query($mysqli, "SELECT * FROM admin WHERE user_id='".$_SESSION['Admin']."' AND tr_password='".$transaction_pin."'");
        if(mysqli_num_rows($pin_check) == 0){
            $error = "Invalid Transaction PIN";
        } else {
            ob_start();
            $deleted_count = $queue_manager->cleanOldEntries($cleanup_days);
            $output = ob_get_clean();
            
            $success = "✅ Queue cleanup completed!<br>
                       🧹 <strong>Entries Removed:</strong> " . number_format($deleted_count) . "<br>
                       📅 <strong>Older than:</strong> $cleanup_days days<br><br>
                       <div style='background: #f8f9fa; padding: 10px; border-radius: 5px;'>
                       <strong>Cleanup Output:</strong><br>" . nl2br(htmlspecialchars($output)) . "</div>";
        }
    }
}

// Get current queue status
$queue_status = $queue_manager->getQueueStatus();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enterprise Queue Manager - Generation Bonuses</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="lib/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/themes/flat-blue.css">
    
    <style>
        .enterprise-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            margin-bottom: 30px;
        }
        .scale-badge {
            background: rgba(255,255,255,0.2);
            padding: 8px 16px;
            border-radius: 20px;
            display: inline-block;
            margin: 10px;
        }
        .queue-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .queue-header {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px 10px 0 0;
            border-bottom: 1px solid #dee2e6;
        }
        .queue-body {
            padding: 20px;
        }
        .status-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        .status-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            border-left: 4px solid #007cba;
        }
        .status-pending { border-left-color: #ffc107; }
        .status-processing { border-left-color: #17a2b8; }
        .status-completed { border-left-color: #28a745; }
        .status-failed { border-left-color: #dc3545; }
        .status-retry { border-left-color: #fd7e14; }
    </style>
</head>

<body class="flat-blue">
    <div class="app-container expanded">
        <div class="row content-container">
            <?php require_once'menu.php'?>
            
            <div class="container-fluid">
                <div class="side-body padding-top">
                    <?php require_once'topshow.php'?>
                    
                    <!-- Enterprise Header -->
                    <div class="enterprise-header">
                        <h1>🏭 ENTERPRISE QUEUE MANAGER</h1>
                        <div class="scale-badge">
                            <strong>50,000+ USER PROCESSING SYSTEM</strong>
                        </div>
                        <p>Advanced queue-based processing for massive user bases</p>
                    </div>

                    <!-- Alert Messages -->
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger">
                            <i class="fa fa-exclamation-triangle"></i> <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if(isset($success)): ?>
                        <div class="alert alert-success">
                            <i class="fa fa-check"></i> <?php echo $success; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Queue Status Overview -->
                    <div class="queue-card">
                        <div class="queue-header">
                            <h3><i class="fa fa-dashboard"></i> Queue Status Overview</h3>
                        </div>
                        <div class="queue-body">
                            <div class="status-grid">
                                <?php 
                                $status_types = array(
                                    'pending' => array('name' => 'Pending', 'icon' => 'clock-o', 'class' => 'status-pending'),
                                    'processing' => array('name' => 'Processing', 'icon' => 'cog fa-spin', 'class' => 'status-processing'),
                                    'completed' => array('name' => 'Completed', 'icon' => 'check', 'class' => 'status-completed'),
                                    'failed' => array('name' => 'Failed', 'icon' => 'times', 'class' => 'status-failed'),
                                    'retry' => array('name' => 'Retry', 'icon' => 'refresh', 'class' => 'status-retry')
                                );
                                
                                foreach($status_types as $status => $info):
                                    $count = isset($queue_status[$status]) ? $queue_status[$status]['count'] : 0;
                                    $users = isset($queue_status[$status]) ? $queue_status[$status]['total_users'] : 0;
                                ?>
                                <div class="status-card <?php echo $info['class']; ?>">
                                    <i class="fa fa-<?php echo $info['icon']; ?> fa-2x"></i>
                                    <h4><?php echo number_format($count); ?></h4>
                                    <p><?php echo $info['name']; ?> Batches</p>
                                    <small><?php echo number_format($users); ?> users</small>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Queue Generation Processing -->
                    <div class="queue-card">
                        <div class="queue-header">
                            <h3><i class="fa fa-plus-circle"></i> Queue Generation Processing</h3>
                            <p>Prepare massive generation bonus processing for enterprise scale</p>
                        </div>
                        <div class="queue-body">
                            <form method="POST">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Target Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="queue_date" value="<?php echo date('Y-m-d'); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Chunk Size (Users per batch)</label>
                                            <select name="chunk_size" class="form-control">
                                                <option value="100">100 users (Safe)</option>
                                                <option value="200">200 users (Balanced)</option>
                                                <option value="500" selected>500 users (Enterprise) ⭐</option>
                                                <option value="1000">1000 users (Mega Enterprise)</option>
                                                <option value="2000">2000 users (Ultra Scale)</option>
                                            </select>
                                            <small class="text-muted">Larger chunks = fewer batches but more memory</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Priority</label>
                                            <select name="priority" class="form-control">
                                                <option value="1">1 - Low</option>
                                                <option value="3">3 - Normal</option>
                                                <option value="5" selected>5 - High</option>
                                                <option value="7">7 - Critical</option>
                                                <option value="9">9 - Emergency</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Transaction PIN <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" name="queue_pin" placeholder="Enter your PIN" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="alert alert-info">
                                    <h5><i class="fa fa-info-circle"></i> Enterprise Queue Information</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>🎯 Purpose:</strong> Prepare processing for 50,000+ users<br>
                                            <strong>📦 Method:</strong> Chunked batch processing<br>
                                            <strong>⚡ Advantages:</strong> No timeouts, resumable, scalable
                                        </div>
                                        <div class="col-md-6">
                                            <strong>🔄 Process:</strong> Queue → Process → Complete<br>
                                            <strong>🛡️ Safety:</strong> Auto-retry on failures<br>
                                            <strong>📊 Monitoring:</strong> Real-time status tracking
                                        </div>
                                    </div>
                                </div>
                                
                                <button type="submit" name="queue_processing" class="btn btn-primary btn-lg">
                                    🚀 PREPARE ENTERPRISE QUEUE
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Process Queue -->
                    <div class="queue-card">
                        <div class="queue-header">
                            <h3><i class="fa fa-play"></i> Process Queued Batches</h3>
                            <p>Execute the prepared generation bonus batches</p>
                        </div>
                        <div class="queue-body">
                            <form method="POST">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Max Batches to Process</label>
                                            <input type="number" class="form-control" name="max_batches" value="0" min="0">
                                            <small class="text-muted">0 = process all pending batches</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Timeout (Minutes)</label>
                                            <select name="timeout_minutes" class="form-control">
                                                <option value="30">30 minutes</option>
                                                <option value="60" selected>60 minutes (1 hour)</option>
                                                <option value="120">120 minutes (2 hours)</option>
                                                <option value="180">180 minutes (3 hours)</option>
                                                <option value="360">360 minutes (6 hours)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Transaction PIN <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" name="process_pin" placeholder="Enter your PIN" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="alert alert-warning">
                                    <h5><i class="fa fa-exclamation-triangle"></i> Processing Warning</h5>
                                    <p>This will start processing queued batches. For 50,000+ users, this may take several hours. 
                                    The process will run in chunks to prevent timeouts and allow for monitoring.</p>
                                </div>
                                
                                <button type="submit" name="process_queue" class="btn btn-success btn-lg">
                                    <i class="fa fa-play"></i> START QUEUE PROCESSING
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Queue Maintenance -->
                    <div class="queue-card">
                        <div class="queue-header">
                            <h3><i class="fa fa-trash"></i> Queue Maintenance</h3>
                            <p>Clean up old queue entries and optimize performance</p>
                        </div>
                        <div class="queue-body">
                            <form method="POST">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Remove Entries Older Than</label>
                                            <select name="cleanup_days" class="form-control">
                                                <option value="3">3 days</option>
                                                <option value="7" selected>7 days (1 week)</option>
                                                <option value="14">14 days (2 weeks)</option>
                                                <option value="30">30 days (1 month)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Transaction PIN <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" name="cleanup_pin" placeholder="Enter your PIN" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <button type="submit" name="cleanup_queue" class="btn btn-warning">
                                    <i class="fa fa-trash"></i> CLEANUP OLD ENTRIES
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Command Line Instructions -->
                    <div class="queue-card">
                        <div class="queue-header">
                            <h3><i class="fa fa-terminal"></i> Command Line Usage</h3>
                            <p>For advanced users and automated processing</p>
                        </div>
                        <div class="queue-body">
                            <div class="alert alert-info">
                                <h5>Enterprise Queue Commands:</h5>
                                <code>php db/enterprise_queue_manager.php queue [date] [chunk_size] [priority]</code><br>
                                <code>php db/enterprise_queue_manager.php process [date] [max_batches] [timeout_minutes]</code><br>
                                <code>php db/enterprise_queue_manager.php status [date]</code><br>
                                <code>php db/enterprise_queue_manager.php cleanup [days]</code><br><br>
                                
                                <h5>Direct Enterprise Processing:</h5>
                                <code>php db/enterprise_generation_processor.php [date] --chunk-size=1000 --max-memory=4 --verbose</code><br>
                                <code>php db/enterprise_generation_processor.php [date] --dry-run --chunk-size=500</code>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="lib/js/jquery.min.js"></script>
    <script src="lib/js/bootstrap.min.js"></script>
    <script>
        // Auto-refresh status every 30 seconds
        setInterval(function() {
            // You could add AJAX here to refresh the status
        }, 30000);
    </script>
</body>
</html>