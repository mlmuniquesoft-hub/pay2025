<?php 
session_start();
include('../db/db.php');

// Check admin login
if(!isset($_SESSION['admin_user'])) {
    header("location:index.php");
    exit();
}

// Handle approve/reject actions
if(isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $deposit_id = intval($_GET['id']);
    $admin_user = $_SESSION['admin_user'];
    
    if($action == 'approve') {
        // Get deposit details
        $deposit = $mysqli->query("SELECT * FROM manual_deposits WHERE id = '$deposit_id' AND status = 'pending'")->fetch_assoc();
        
        if($deposit) {
            $user = $deposit['user'];
            $amount = $deposit['amount'];
            
            // Start transaction
            $mysqli->autocommit(FALSE);
            
            try {
                // Update deposit status
                $mysqli->query("UPDATE manual_deposits SET status = 'approved', verified_by = '$admin_user', verified_at = NOW() WHERE id = '$deposit_id'");
                
                // Add balance to user
                $mysqli->query("UPDATE member SET current_balance = current_balance + '$amount' WHERE user = '$user'");
                
                // Insert transaction record
                $mysqli->query("INSERT INTO transaction (user, type, amount, note, date) VALUES ('$user', 'Credit', '$amount', 'Manual Deposit Approved - ID: $deposit_id', NOW())");
                
                $mysqli->commit();
                $success_msg = "Deposit approved and balance added successfully!";
                
            } catch (Exception $e) {
                $mysqli->rollback();
                $error_msg = "Error approving deposit: " . $e->getMessage();
            }
            
            $mysqli->autocommit(TRUE);
        } else {
            $error_msg = "Deposit not found or already processed!";
        }
        
    } elseif($action == 'reject') {
        $reject_reason = isset($_POST['reject_reason']) ? mysqli_real_escape_string($mysqli, $_POST['reject_reason']) : 'Rejected by admin';
        
        $result = $mysqli->query("UPDATE manual_deposits SET status = 'rejected', admin_note = '$reject_reason', verified_by = '$admin_user', verified_at = NOW() WHERE id = '$deposit_id' AND status = 'pending'");
        
        if($result && $mysqli->affected_rows > 0) {
            $success_msg = "Deposit rejected successfully!";
        } else {
            $error_msg = "Error rejecting deposit or deposit already processed!";
        }
    }
}

// Get filter parameters
$status_filter = isset($_GET['status']) ? $_GET['status'] : 'all';
$type_filter = isset($_GET['type']) ? $_GET['type'] : 'all';
$search = isset($_GET['search']) ? mysqli_real_escape_string($mysqli, $_GET['search']) : '';

// Build query
$where_conditions = [];

if($status_filter != 'all') {
    $where_conditions[] = "status = '$status_filter'";
}

if($type_filter != 'all') {
    $where_conditions[] = "deposit_type = '$type_filter'";
}

if(!empty($search)) {
    $where_conditions[] = "(user LIKE '%$search%' OR txn_hash LIKE '%$search%' OR wallet_address LIKE '%$search%')";
}

$where_clause = '';
if(!empty($where_conditions)) {
    $where_clause = 'WHERE ' . implode(' AND ', $where_conditions);
}

// Get deposits
$query = "SELECT * FROM manual_deposits $where_clause ORDER BY created_at DESC LIMIT 50";
$deposits = $mysqli->query($query);

// Get summary statistics
$stats = $mysqli->query("SELECT 
    COUNT(*) as total_deposits,
    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_count,
    SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved_count,
    SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected_count,
    SUM(CASE WHEN status = 'approved' THEN amount ELSE 0 END) as approved_amount,
    SUM(CASE WHEN status = 'pending' THEN amount ELSE 0 END) as pending_amount
    FROM manual_deposits")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manual Deposits Management</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
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
        .screenshot-thumb {
            max-width: 80px;
            max-height: 80px;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
        }
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
    </style>
</head>
<body>
    <?php include 'menu.php'; ?>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Manual Deposits Management</h3>
                    </div>
                    <div class="panel-body">
                        <?php if(isset($success_msg)): ?>
                            <div class="alert alert-success"><?php echo $success_msg; ?></div>
                        <?php endif; ?>
                        
                        <?php if(isset($error_msg)): ?>
                            <div class="alert alert-danger"><?php echo $error_msg; ?></div>
                        <?php endif; ?>

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
                                    <div class="stats-label">Approved Amount</div>
                                </div>
                                <div class="col-md-2 stats-item">
                                    <div class="stats-number text-warning">$<?php echo number_format($stats['pending_amount'], 2); ?></div>
                                    <div class="stats-label">Pending Amount</div>
                                </div>
                            </div>
                        </div>

                        <!-- Filters -->
                        <form method="GET" class="row mb-3">
                            <div class="col-md-3">
                                <select name="status" class="form-control">
                                    <option value="all" <?php echo $status_filter == 'all' ? 'selected' : ''; ?>>All Status</option>
                                    <option value="pending" <?php echo $status_filter == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="approved" <?php echo $status_filter == 'approved' ? 'selected' : ''; ?>>Approved</option>
                                    <option value="rejected" <?php echo $status_filter == 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="type" class="form-control">
                                    <option value="all" <?php echo $type_filter == 'all' ? 'selected' : ''; ?>>All Types</option>
                                    <option value="BTC" <?php echo $type_filter == 'BTC' ? 'selected' : ''; ?>>Bitcoin</option>
                                    <option value="USDT_TRC20" <?php echo $type_filter == 'USDT_TRC20' ? 'selected' : ''; ?>>USDT TRC20</option>
                                    <option value="USDT_BEP20" <?php echo $type_filter == 'USDT_BEP20' ? 'selected' : ''; ?>>USDT BEP20</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" class="form-control" placeholder="Search user, txn hash, address...">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-block">Filter</button>
                            </div>
                        </form>

                        <!-- Deposits Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Wallet Address</th>
                                        <th>Transaction Hash</th>
                                        <th>Screenshot</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($deposits && mysqli_num_rows($deposits) > 0): ?>
                                        <?php while($deposit = mysqli_fetch_assoc($deposits)): ?>
                                        <tr>
                                            <td><?php echo $deposit['id']; ?></td>
                                            <td><strong><?php echo $deposit['user']; ?></strong></td>
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
                                                <small><?php echo substr($deposit['wallet_address'], 0, 20) . '...'; ?></small>
                                            </td>
                                            <td>
                                                <small><?php echo substr($deposit['txn_hash'], 0, 20) . '...'; ?></small>
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
                                            </td>
                                            <td><?php echo date('M d, Y H:i', strtotime($deposit['created_at'])); ?></td>
                                            <td>
                                                <?php if($deposit['status'] == 'pending'): ?>
                                                    <button class="btn btn-success btn-xs" onclick="approveDeposit(<?php echo $deposit['id']; ?>)">
                                                        <i class="fa fa-check"></i> Approve
                                                    </button>
                                                    <button class="btn btn-danger btn-xs" onclick="rejectDeposit(<?php echo $deposit['id']; ?>)">
                                                        <i class="fa fa-times"></i> Reject
                                                    </button>
                                                <?php else: ?>
                                                    <span class="text-muted">Processed</span>
                                                <?php endif; ?>
                                                <button class="btn btn-info btn-xs" onclick="viewDetails(<?php echo $deposit['id']; ?>)">
                                                    <i class="fa fa-eye"></i> View
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="10" class="text-center">No deposits found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
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

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reject Deposit</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form id="rejectForm" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Reason for rejection:</label>
                            <textarea name="reject_reason" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Reject Deposit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        function showImage(filename) {
            $('#modalImage').attr('src', '../uploads/deposit_screenshots/' + filename);
            $('#imageModal').modal('show');
        }

        function approveDeposit(id) {
            if(confirm('Are you sure you want to approve this deposit? This will add the amount to user balance.')) {
                window.location.href = '?action=approve&id=' + id;
            }
        }

        function rejectDeposit(id) {
            $('#rejectForm').attr('action', '?action=reject&id=' + id);
            $('#rejectModal').modal('show');
        }

        function viewDetails(id) {
            // You can implement a detailed view modal here
            alert('View details for deposit ID: ' + id);
        }
    </script>
</body>
</html>