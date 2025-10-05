<?php
session_start();
if(!isset($_SESSION['Admin'])){
    header("location:index.html");
    exit();
}

include('../db/db.php');

// Handle verification actions
if(isset($_POST['action'])) {
    $deposit_id = intval($_POST['deposit_id']);
    $action = $_POST['action'];
    $admin_note = mysqli_real_escape_string($mysqli, $_POST['admin_note'] ?? '');
    
    $status = '';
    switch($action) {
        case 'approve':
            $status = 'approved';
            break;
        case 'reject':
            $status = 'rejected';
            break;
        case 'pending':
            $status = 'pending';
            break;
    }
    
    if($status) {
        // Update deposit status
        $update_sql = "UPDATE manual_deposits SET 
            status = '$status', 
            admin_note = '$admin_note', 
            verified_by = '".$_SESSION['Admin']."', 
            verified_at = NOW() 
            WHERE id = $deposit_id";
        
        if($mysqli->query($update_sql)) {
            // If approved, add balance to user account
            if($status == 'approved') {
                $deposit = $mysqli->query("SELECT * FROM manual_deposits WHERE id = $deposit_id")->fetch_assoc();
                if($deposit) {
                    // Check if user has a profile
                    $user_check = $mysqli->query("SELECT * FROM profile WHERE user = '".$deposit['user']."'");
                    if(mysqli_num_rows($user_check) > 0) {
                        // Update user balance
                        $mysqli->query("UPDATE profile SET balance = balance + ".$deposit['amount']." WHERE user = '".$deposit['user']."'");
                        
                        // Add wallet history entry
                        $mysqli->query("INSERT INTO wallet_history (user, type, amount, description, created_at) 
                                      VALUES ('".$deposit['user']."', 'credit', ".$deposit['amount'].", 'Manual deposit approved - ".$deposit['deposit_type']."', NOW())");
                    }
                }
            }
            $_SESSION['success'] = 'Deposit ' . $action . 'd successfully!';
        } else {
            $_SESSION['error'] = 'Error updating deposit: ' . $mysqli->error;
        }
    }
    
    header("location: manual_deposits_verify.php");
    exit();
}

// Fetch deposits with filters
$status_filter = isset($_GET['status']) ? $_GET['status'] : 'all';
$search = isset($_GET['search']) ? mysqli_real_escape_string($mysqli, $_GET['search']) : '';

$where_conditions = [];
if($status_filter != 'all') {
    $where_conditions[] = "status = '$status_filter'";
}
if($search) {
    $where_conditions[] = "(user LIKE '%$search%' OR txn_hash LIKE '%$search%' OR deposit_type LIKE '%$search%')";
}

$where_clause = empty($where_conditions) ? '' : 'WHERE ' . implode(' AND ', $where_conditions);

$deposits_query = "SELECT * FROM manual_deposits $where_clause ORDER BY created_at DESC";
$deposits_result = $mysqli->query($deposits_query);

// Get statistics
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manual Deposits Verification - Admin Panel</title>
    <link rel="stylesheet" type="text/css" href="lib/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/font-awesome.min.css">
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
            max-width: 100px;
            max-height: 100px;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
        }
        .stats-card {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .verification-actions {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }
        .verification-actions .btn {
            padding: 5px 10px;
            font-size: 12px;
        }
        .deposit-details {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body class="flat-blue">
    <div class="app-container expanded">
        <div class="row content-container">
            <?php require_once'menu.php'?>
            <!-- Main Content -->
            <div class="container-fluid">
                <div class="side-body padding-top">
                    <?php require_once'topshow.php'?>
                    <div class="row  no-margin-bottom">
                        <div class="col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <i class="fa fa-coins fa-fw"></i> Manual Deposits Verification
                                            <div class="pull-right"> </div>
                                        </div>
                                        <div class="panel-body">
                                            <!-- Success/Error Messages -->
                                            <?php if(isset($_SESSION['success'])): ?>
                                                <div class="alert alert-success alert-dismissible">
                                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                    <i class="fa fa-check-circle"></i>
                                                    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                                                </div>
                                            <?php endif; ?>

                                            <?php if(isset($_SESSION['error'])): ?>
                                                <div class="alert alert-danger alert-dismissible">
                                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                    <i class="fa fa-exclamation-circle"></i>
                                                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                                                </div>
                                            <?php endif; ?>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-2">
                <div class="stats-card text-center">
                    <h4 class="mb-0"><?php echo $stats['total_deposits']; ?></h4>
                    <small>Total Deposits</small>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stats-card text-center" style="background: linear-gradient(45deg, #ffc107, #ff8c00);">
                    <h4 class="mb-0"><?php echo $stats['pending_count']; ?></h4>
                    <small>Pending</small>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stats-card text-center" style="background: linear-gradient(45deg, #28a745, #20c997);">
                    <h4 class="mb-0"><?php echo $stats['approved_count']; ?></h4>
                    <small>Approved</small>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stats-card text-center" style="background: linear-gradient(45deg, #dc3545, #c82333);">
                    <h4 class="mb-0"><?php echo $stats['rejected_count']; ?></h4>
                    <small>Rejected</small>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stats-card text-center" style="background: linear-gradient(45deg, #17a2b8, #138496);">
                    <h4 class="mb-0">$<?php echo number_format($stats['approved_amount'], 2); ?></h4>
                    <small>Approved Amount</small>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stats-card text-center" style="background: linear-gradient(45deg, #6f42c1, #5a32a3);">
                    <h4 class="mb-0">$<?php echo number_format($stats['pending_amount'], 2); ?></h4>
                    <small>Pending Amount</small>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Status Filter</label>
                        <select name="status" class="form-select">
                            <option value="all" <?php echo $status_filter == 'all' ? 'selected' : ''; ?>>All Status</option>
                            <option value="pending" <?php echo $status_filter == 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="approved" <?php echo $status_filter == 'approved' ? 'selected' : ''; ?>>Approved</option>
                            <option value="rejected" <?php echo $status_filter == 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Search by username, transaction hash, or crypto type..." value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid gap-2 d-md-flex">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="fas fa-search"></i> Search
                            </button>
                            <a href="manual_deposits_verify.php" class="btn btn-outline-secondary">
                                <i class="fas fa-sync"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Deposits List -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-list"></i>
                    Manual Deposits 
                    <?php if($status_filter != 'all'): ?>
                        <span class="badge bg-primary"><?php echo ucfirst($status_filter); ?></span>
                    <?php endif; ?>
                </h5>
            </div>
            <div class="card-body">
                <?php if($deposits_result && mysqli_num_rows($deposits_result) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Crypto & Amount</th>
                                    <th>Transaction Hash</th>
                                    <th>Screenshot</th>
                                    <th>Status</th>
                                    <th>Submitted</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($deposit = mysqli_fetch_assoc($deposits_result)): ?>
                                <tr>
                                    <td><strong>#<?php echo $deposit['id']; ?></strong></td>
                                    <td>
                                        <div class="fw-bold"><?php echo htmlspecialchars($deposit['user']); ?></div>
                                        <?php if(!empty($deposit['notes'])): ?>
                                            <small class="text-muted">
                                                <i class="fas fa-comment"></i>
                                                <?php echo htmlspecialchars(substr($deposit['notes'], 0, 50)) . (strlen($deposit['notes']) > 50 ? '...' : ''); ?>
                                            </small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge" style="
                                            background: <?php 
                                                echo $deposit['deposit_type'] == 'BTC' ? '#f7931a' : 
                                                    ($deposit['deposit_type'] == 'USDT_TRC20' ? '#26a17b' : '#f3ba2f'); 
                                            ?>; color: white;">
                                            <?php echo $deposit['deposit_type']; ?>
                                        </span>
                                        <div class="fw-bold">$<?php echo number_format($deposit['amount'], 2); ?></div>
                                    </td>
                                    <td>
                                        <small class="font-monospace">
                                            <?php echo substr($deposit['txn_hash'], 0, 20) . '...'; ?>
                                        </small>
                                        <br>
                                        <button class="btn btn-sm btn-outline-primary" onclick="copyText('<?php echo $deposit['txn_hash']; ?>')">
                                            <i class="fas fa-copy"></i>
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
                                        <?php if(!empty($deposit['admin_note'])): ?>
                                            <br><small class="text-info">
                                                <i class="fas fa-note-sticky"></i>
                                                <?php echo htmlspecialchars(substr($deposit['admin_note'], 0, 30)) . (strlen($deposit['admin_note']) > 30 ? '...' : ''); ?>
                                            </small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small><?php echo date('M d, Y H:i', strtotime($deposit['created_at'])); ?></small>
                                        <?php if($deposit['verified_at']): ?>
                                            <br><small class="text-success">
                                                Verified: <?php echo date('M d, H:i', strtotime($deposit['verified_at'])); ?>
                                            </small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="verification-actions">
                                            <button class="btn btn-success btn-sm" onclick="showVerificationModal(<?php echo $deposit['id']; ?>, 'approve', '<?php echo htmlspecialchars($deposit['user']); ?>', <?php echo $deposit['amount']; ?>)">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                            <button class="btn btn-danger btn-sm" onclick="showVerificationModal(<?php echo $deposit['id']; ?>, 'reject', '<?php echo htmlspecialchars($deposit['user']); ?>', <?php echo $deposit['amount']; ?>)">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                            <button class="btn btn-info btn-sm" onclick="showDepositDetails(<?php echo $deposit['id']; ?>)">
                                                <i class="fas fa-eye"></i> Details
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5>No deposits found</h5>
                        <p class="text-muted">No manual deposits match your current filters.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Verification Modal -->
    <div class="modal fade" id="verificationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verificationTitle">Verify Deposit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div id="verificationContent"></div>
                        <div class="mb-3">
                            <label class="form-label">Admin Note</label>
                            <textarea name="admin_note" class="form-control" rows="3" placeholder="Optional note for user..."></textarea>
                        </div>
                        <input type="hidden" name="deposit_id" id="verifyDepositId">
                        <input type="hidden" name="action" id="verifyAction">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn" id="verifySubmitBtn">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Payment Screenshot</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" style="max-width: 100%; height: auto;">
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="lib/js/jquery.min.js"></script>
    <script type="text/javascript" src="lib/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="lib/js/bootstrap-switch.min.js"></script>
    <script>
        function showVerificationModal(depositId, action, username, amount) {
            document.getElementById('verifyDepositId').value = depositId;
            document.getElementById('verifyAction').value = action;
            
            const title = document.getElementById('verificationTitle');
            const content = document.getElementById('verificationContent');
            const submitBtn = document.getElementById('verifySubmitBtn');
            
            if(action === 'approve') {
                title.textContent = 'Approve Deposit';
                content.innerHTML = `
                    <div class="alert alert-success">
                        <h6><i class="fas fa-check-circle"></i> Approve Deposit #${depositId}</h6>
                        <p><strong>User:</strong> ${username}</p>
                        <p><strong>Amount:</strong> $${amount}</p>
                        <p><strong>Action:</strong> This will add $${amount} to user's balance.</p>
                    </div>
                `;
                submitBtn.className = 'btn btn-success';
                submitBtn.innerHTML = '<i class="fas fa-check"></i> Approve Deposit';
            } else if(action === 'reject') {
                title.textContent = 'Reject Deposit';
                content.innerHTML = `
                    <div class="alert alert-danger">
                        <h6><i class="fas fa-times-circle"></i> Reject Deposit #${depositId}</h6>
                        <p><strong>User:</strong> ${username}</p>
                        <p><strong>Amount:</strong> $${amount}</p>
                        <p><strong>Action:</strong> This will mark the deposit as rejected. No balance will be added.</p>
                    </div>
                `;
                submitBtn.className = 'btn btn-danger';
                submitBtn.innerHTML = '<i class="fas fa-times"></i> Reject Deposit';
            }
            
            $('#verificationModal').modal('show');
        }
        
        function showImage(filename) {
            document.getElementById('modalImage').src = '../uploads/deposit_screenshots/' + filename;
            $('#imageModal').modal('show');
        }
        
        function copyText(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Show success feedback
                const btn = event.target;
                const originalHTML = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check"></i>';
                btn.classList.add('btn-success');
                
                setTimeout(function() {
                    btn.innerHTML = originalHTML;
                    btn.classList.remove('btn-success');
                }, 2000);
            });
        }
        
        // Auto refresh pending deposits every 30 seconds
        <?php if($status_filter == 'pending' || $status_filter == 'all'): ?>
        setInterval(function() {
            if(<?php echo $stats['pending_count']; ?> > 0) {
                location.reload();
            }
        }, 30000);
        <?php endif; ?>
    </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php require_once'footer.php'?>
    <div>
        <!-- Javascript Libs -->
        <script type="text/javascript" src="lib/js/jquery.min.js"></script>
        <script type="text/javascript" src="lib/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="lib/js/Chart.min.js"></script>
        <script type="text/javascript" src="lib/js/bootstrap-switch.min.js"></script>
        <script type="text/javascript" src="lib/js/jquery.matchHeight-min.js"></script>
        <script type="text/javascript" src="lib/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="lib/js/dataTables.bootstrap.min.js"></script>
        <script type="text/javascript" src="lib/js/select2.full.min.js"></script>
        <script type="text/javascript" src="lib/js/ace/ace.js"></script>
        <script type="text/javascript" src="lib/js/ace/mode-html.js"></script>
        <script type="text/javascript" src="lib/js/ace/theme-github.js"></script>
        <!-- Javascript -->
        <script type="text/javascript" src="js/app.js"></script>
        <script type="text/javascript" src="js/index.js"></script>
    </div>
</body>
</html>