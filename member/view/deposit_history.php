<?php
session_start();
include('../db/db.php');
include('../db/functions.php');

// Check if user is logged in
if(!isset($_SESSION['user'])) {
    header("location:../index.php");
    exit();
}

$member = $_SESSION['user'];

// Get user's deposit history
$query = "SELECT * FROM manual_deposits WHERE user = '$member' ORDER BY created_at DESC";
$deposits = $mysqli->query($query);

// Get summary stats for this user
$stats = $mysqli->query("SELECT 
    COUNT(*) as total_deposits,
    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_count,
    SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved_count,
    SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected_count,
    SUM(CASE WHEN status = 'approved' THEN amount ELSE 0 END) as approved_amount,
    SUM(CASE WHEN status = 'pending' THEN amount ELSE 0 END) as pending_amount
    FROM manual_deposits WHERE user = '$member'")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit History</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <style>
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-pending { background: #ffc107; color: #000; }
        .status-approved { background: #28a745; color: #fff; }
        .status-rejected { background: #dc3545; color: #fff; }
        .stats-card {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .stats-item {
            text-align: center;
            border-right: 1px solid #dee2e6;
        }
        .stats-item:last-child { border-right: none; }
        .stats-number { font-size: 24px; font-weight: bold; color: #007bff; }
        .stats-label { font-size: 14px; color: #6c757d; }
        .screenshot-thumb {
            max-width: 60px;
            max-height: 60px;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="wrapper main-wrapper row" style="min-height:100vh">
        <div class="col-lg-12">
            <section class="box" style="background:#211c8896">
                <header class="panel_header">
                    <h2 class="title pull-left">My Deposit History</h2>
                    <div class="pull-right">
                        <a href="deposit.php" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i> New Deposit
                        </a>
                    </div>
                </header>
                <div class="content-body" style="padding:20px;">
                    
                    <!-- Statistics -->
                    <div class="stats-card">
                        <div class="row">
                            <div class="col-md-2 stats-item">
                                <div class="stats-number"><?php echo $stats['total_deposits']; ?></div>
                                <div class="stats-label">Total Deposits</div>
                            </div>
                            <div class="col-md-2 stats-item">
                                <div class="stats-number text-warning"><?php echo $stats['pending_count']; ?></div>
                                <div class="stats-label">Pending</div>
                            </div>
                            <div class="col-md-2 stats-item">
                                <div class="stats-number text-success"><?php echo $stats['approved_count']; ?></div>
                                <div class="stats-label">Approved</div>
                            </div>
                            <div class="col-md-2 stats-item">
                                <div class="stats-number text-danger"><?php echo $stats['rejected_count']; ?></div>
                                <div class="stats-label">Rejected</div>
                            </div>
                            <div class="col-md-2 stats-item">
                                <div class="stats-number text-success">$<?php echo number_format($stats['approved_amount'], 2); ?></div>
                                <div class="stats-label">Total Credited</div>
                            </div>
                            <div class="col-md-2 stats-item">
                                <div class="stats-number text-warning">$<?php echo number_format($stats['pending_amount'], 2); ?></div>
                                <div class="stats-label">Pending Amount</div>
                            </div>
                        </div>
                    </div>

                    <?php if($deposits && mysqli_num_rows($deposits) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Transaction Hash</th>
                                        <th>Screenshot</th>
                                        <th>Status</th>
                                        <th>Submitted</th>
                                        <th>Processed</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($deposit = mysqli_fetch_assoc($deposits)): ?>
                                    <tr>
                                        <td>#<?php echo $deposit['id']; ?></td>
                                        <td>
                                            <span class="label" style="
                                                background: <?php 
                                                    echo $deposit['deposit_type'] == 'BTC' ? '#f7931a' : 
                                                        ($deposit['deposit_type'] == 'USDT_TRC20' ? '#26a17b' : '#f3ba2f'); 
                                                ?>; color: white;">
                                                <?php echo $deposit['deposit_type']; ?>
                                            </span>
                                        </td>
                                        <td><strong>$<?php echo number_format($deposit['amount'], 2); ?></strong></td>
                                        <td>
                                            <small title="<?php echo $deposit['txn_hash']; ?>">
                                                <?php echo substr($deposit['txn_hash'], 0, 20) . '...'; ?>
                                            </small>
                                            <br>
                                            <button class="btn btn-xs btn-default" onclick="copyText('<?php echo $deposit['txn_hash']; ?>')">
                                                <i class="fa fa-copy"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <?php if($deposit['screenshot']): ?>
                                                <img src="../uploads/deposit_screenshots/<?php echo $deposit['screenshot']; ?>" 
                                                     class="screenshot-thumb" 
                                                     onclick="showImage('<?php echo $deposit['screenshot']; ?>')">
                                            <?php else: ?>
                                                <span class="text-muted">No image</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="status-badge status-<?php echo $deposit['status']; ?>">
                                                <?php echo ucfirst($deposit['status']); ?>
                                            </span>
                                            <?php if($deposit['status'] == 'pending'): ?>
                                                <br><small class="text-muted">Under review</small>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo date('M d, Y H:i', strtotime($deposit['created_at'])); ?></td>
                                        <td>
                                            <?php if($deposit['verified_at']): ?>
                                                <?php echo date('M d, Y H:i', strtotime($deposit['verified_at'])); ?>
                                                <?php if($deposit['verified_by']): ?>
                                                    <br><small class="text-muted">by <?php echo $deposit['verified_by']; ?></small>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(!empty($deposit['notes'])): ?>
                                                <small title="<?php echo htmlspecialchars($deposit['notes']); ?>">
                                                    <?php echo substr($deposit['notes'], 0, 30); ?>
                                                    <?php if(strlen($deposit['notes']) > 30) echo '...'; ?>
                                                </small>
                                            <?php endif; ?>
                                            <?php if(!empty($deposit['admin_note'])): ?>
                                                <br><strong>Admin:</strong> 
                                                <small class="text-info"><?php echo htmlspecialchars($deposit['admin_note']); ?></small>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info text-center">
                            <h4>No deposits yet</h4>
                            <p>You haven't made any deposits yet. Start by making your first deposit!</p>
                            <a href="deposit.php" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Make First Deposit
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Payment Screenshot</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" style="max-width: 100%; height: auto;">
                </div>
            </div>
        </div>
    </div>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script>
        function showImage(filename) {
            $('#modalImage').attr('src', '../uploads/deposit_screenshots/' + filename);
            $('#imageModal').modal('show');
        }

        function copyText(text) {
            // Create temporary input element
            var tempInput = document.createElement('input');
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            
            // Show success message
            alert('Transaction hash copied to clipboard!');
        }

        // Auto-refresh pending deposits every 30 seconds
        <?php if($stats['pending_count'] > 0): ?>
        setInterval(function() {
            location.reload();
        }, 30000);
        <?php endif; ?>
    </script>
</body>
</html>