<?php
session_start();
require_once('../db/db.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Handle deposit verification
if (isset($_POST['action']) && $_POST['action'] === 'verify_deposit') {
    $deposit_id = intval($_POST['deposit_id']);
    $user_id = intval($_POST['user_id']);
    $amount = floatval($_POST['amount']);
    $admin_notes = mysqli_real_escape_string($con, $_POST['admin_notes']);
    
    // Start transaction
    mysqli_begin_transaction($con);
    
    try {
        // Update deposit status to verified
        $update_deposit = "UPDATE manual_deposits SET 
                          status = 'verified', 
                          verified_by = '{$_SESSION['admin_id']}', 
                          verified_at = NOW(),
                          admin_notes = '$admin_notes'
                          WHERE id = $deposit_id";
        
        if (!mysqli_query($con, $update_deposit)) {
            throw new Exception("Error updating deposit: " . mysqli_error($con));
        }
        
        // Add balance to user account
        $update_balance = "UPDATE user_registration SET 
                          wallet = wallet + $amount 
                          WHERE id = $user_id";
        
        if (!mysqli_query($con, $update_balance)) {
            throw new Exception("Error updating user balance: " . mysqli_error($con));
        }
        
        // Add transaction record
        $insert_transaction = "INSERT INTO wallet_history 
                              (user_id, amount, type, description, created_at) 
                              VALUES 
                              ($user_id, $amount, 'deposit', 'Manual deposit verified by admin', NOW())";
        
        if (!mysqli_query($con, $insert_transaction)) {
            throw new Exception("Error inserting transaction: " . mysqli_error($con));
        }
        
        mysqli_commit($con);
        $success_msg = "Deposit verified successfully and balance added to user account!";
        
    } catch (Exception $e) {
        mysqli_rollback($con);
        $error_msg = $e->getMessage();
    }
}

// Handle deposit rejection
if (isset($_POST['action']) && $_POST['action'] === 'reject_deposit') {
    $deposit_id = intval($_POST['deposit_id']);
    $admin_notes = mysqli_real_escape_string($con, $_POST['admin_notes']);
    
    $update_deposit = "UPDATE manual_deposits SET 
                      status = 'rejected', 
                      verified_by = '{$_SESSION['admin_id']}', 
                      verified_at = NOW(),
                      admin_notes = '$admin_notes'
                      WHERE id = $deposit_id";
    
    if (mysqli_query($con, $update_deposit)) {
        $success_msg = "Deposit rejected successfully!";
    } else {
        $error_msg = "Error rejecting deposit: " . mysqli_error($con);
    }
}

// Get filter parameters
$status_filter = isset($_GET['status']) ? $_GET['status'] : 'all';
$crypto_filter = isset($_GET['crypto']) ? $_GET['crypto'] : 'all';

// Build query with filters
$where_conditions = [];
if ($status_filter !== 'all') {
    $where_conditions[] = "md.status = '" . mysqli_real_escape_string($con, $status_filter) . "'";
}
if ($crypto_filter !== 'all') {
    $where_conditions[] = "md.crypto_type = '" . mysqli_real_escape_string($con, $crypto_filter) . "'";
}

$where_clause = '';
if (!empty($where_conditions)) {
    $where_clause = 'WHERE ' . implode(' AND ', $where_conditions);
}

// Get all deposits with user information
$deposits_query = "SELECT md.*, ur.user_name, ur.mobile, ur.email,
                   mw.wallet_name, mw.wallet_address
                   FROM manual_deposits md
                   LEFT JOIN user_registration ur ON md.user_id = ur.id
                   LEFT JOIN manual_wallets mw ON md.wallet_id = mw.id
                   $where_clause
                   ORDER BY md.created_at DESC";

$deposits_result = mysqli_query($con, $deposits_query);

// Get summary statistics
$stats_query = "SELECT 
                COUNT(*) as total_deposits,
                COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending_deposits,
                COUNT(CASE WHEN status = 'verified' THEN 1 END) as verified_deposits,
                COUNT(CASE WHEN status = 'rejected' THEN 1 END) as rejected_deposits,
                SUM(CASE WHEN status = 'verified' THEN amount ELSE 0 END) as total_verified_amount
                FROM manual_deposits";

$stats_result = mysqli_query($con, $stats_query);
$stats = mysqli_fetch_assoc($stats_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Manual Deposits - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .card-header {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
        }
        .screenshot-preview {
            max-width: 200px;
            max-height: 200px;
            border: 1px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        .status-verified {
            background: #d1ecf1;
            color: #0c5460;
        }
        .status-rejected {
            background: #f8d7da;
            color: #721c24;
        }
        .stats-card {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            border: none;
        }
        .crypto-badge {
            font-size: 0.8em;
            padding: 0.25rem 0.5rem;
        }
        .modal-lg {
            max-width: 800px;
        }
    </style>
</head>
<body class="bg-light">

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h3 class="mb-0"><i class="fas fa-wallet me-2"></i>Manual Deposit Management</h3>
                </div>
                <div class="card-body">
                    
                    <?php if (isset($success_msg)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i><?php echo $success_msg; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (isset($error_msg)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i><?php echo $error_msg; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?>

                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card stats-card text-center">
                                <div class="card-body">
                                    <h4><?php echo $stats['total_deposits']; ?></h4>
                                    <p class="mb-0">Total Deposits</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-center">
                                <div class="card-body">
                                    <h4><?php echo $stats['pending_deposits']; ?></h4>
                                    <p class="mb-0">Pending Review</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white text-center">
                                <div class="card-body">
                                    <h4><?php echo $stats['verified_deposits']; ?></h4>
                                    <p class="mb-0">Verified</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white text-center">
                                <div class="card-body">
                                    <h4>$<?php echo number_format($stats['total_verified_amount'], 2); ?></h4>
                                    <p class="mb-0">Total Verified</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form method="GET" class="d-flex gap-2">
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="all" <?php echo $status_filter === 'all' ? 'selected' : ''; ?>>All Status</option>
                                    <option value="pending" <?php echo $status_filter === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="verified" <?php echo $status_filter === 'verified' ? 'selected' : ''; ?>>Verified</option>
                                    <option value="rejected" <?php echo $status_filter === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                                </select>
                                
                                <select name="crypto" class="form-select" onchange="this.form.submit()">
                                    <option value="all" <?php echo $crypto_filter === 'all' ? 'selected' : ''; ?>>All Crypto</option>
                                    <option value="BTC" <?php echo $crypto_filter === 'BTC' ? 'selected' : ''; ?>>Bitcoin</option>
                                    <option value="USDT_TRC20" <?php echo $crypto_filter === 'USDT_TRC20' ? 'selected' : ''; ?>>USDT TRC20</option>
                                    <option value="USDT_BEP20" <?php echo $crypto_filter === 'USDT_BEP20' ? 'selected' : ''; ?>>USDT BEP20</option>
                                </select>
                            </form>
                        </div>
                        <div class="col-md-6 text-end">
                            <button class="btn btn-primary" onclick="location.reload()">
                                <i class="fas fa-refresh me-1"></i>Refresh
                            </button>
                        </div>
                    </div>

                    <!-- Deposits Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Crypto</th>
                                    <th>Amount</th>
                                    <th>Wallet</th>
                                    <th>Screenshot</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($deposits_result) > 0): ?>
                                    <?php while ($deposit = mysqli_fetch_assoc($deposits_result)): ?>
                                    <tr class="status-<?php echo $deposit['status']; ?>">
                                        <td>#<?php echo $deposit['id']; ?></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($deposit['user_name']); ?></strong><br>
                                            <small class="text-muted"><?php echo htmlspecialchars($deposit['mobile']); ?></small>
                                        </td>
                                        <td>
                                            <span class="badge crypto-badge bg-primary">
                                                <?php echo $deposit['crypto_type']; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <strong>$<?php echo number_format($deposit['amount'], 2); ?></strong>
                                        </td>
                                        <td>
                                            <small class="text-monospace">
                                                <?php echo substr($deposit['wallet_address'], 0, 15) . '...'; ?>
                                            </small><br>
                                            <small class="text-muted"><?php echo $deposit['wallet_name']; ?></small>
                                        </td>
                                        <td>
                                            <?php if ($deposit['screenshot_path']): ?>
                                            <img src="../<?php echo $deposit['screenshot_path']; ?>" 
                                                 class="screenshot-preview" 
                                                 data-bs-toggle="modal" 
                                                 data-bs-target="#screenshotModal"
                                                 data-screenshot="../<?php echo $deposit['screenshot_path']; ?>"
                                                 alt="Payment Screenshot">
                                            <?php else: ?>
                                            <span class="text-muted">No screenshot</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?php 
                                                echo $deposit['status'] === 'pending' ? 'warning' : 
                                                    ($deposit['status'] === 'verified' ? 'success' : 'danger'); 
                                            ?>">
                                                <?php echo ucfirst($deposit['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <small><?php echo date('M j, Y H:i', strtotime($deposit['created_at'])); ?></small>
                                        </td>
                                        <td>
                                            <?php if ($deposit['status'] === 'pending'): ?>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-success btn-sm verify-btn" 
                                                        data-deposit-id="<?php echo $deposit['id']; ?>"
                                                        data-user-id="<?php echo $deposit['user_id']; ?>"
                                                        data-amount="<?php echo $deposit['amount']; ?>"
                                                        data-user-name="<?php echo htmlspecialchars($deposit['user_name']); ?>"
                                                        data-crypto="<?php echo $deposit['crypto_type']; ?>">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm reject-btn" 
                                                        data-deposit-id="<?php echo $deposit['id']; ?>"
                                                        data-user-name="<?php echo htmlspecialchars($deposit['user_name']); ?>">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                            <?php else: ?>
                                            <small class="text-muted">
                                                <?php echo $deposit['status'] === 'verified' ? 'Verified' : 'Rejected'; ?>
                                                <?php if ($deposit['verified_at']): ?>
                                                <br><?php echo date('M j, H:i', strtotime($deposit['verified_at'])); ?>
                                                <?php endif; ?>
                                            </small>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <br>No deposits found
                                        </td>
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

<!-- Screenshot Modal -->
<div class="modal fade" id="screenshotModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment Screenshot</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalScreenshot" src="" class="img-fluid" alt="Payment Screenshot">
            </div>
        </div>
    </div>
</div>

<!-- Verify Modal -->
<div class="modal fade" id="verifyModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-check-circle me-2"></i>Verify Deposit
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="verify_deposit">
                    <input type="hidden" name="deposit_id" id="verify_deposit_id">
                    <input type="hidden" name="user_id" id="verify_user_id">
                    <input type="hidden" name="amount" id="verify_amount">
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        You are about to verify a deposit for <strong id="verify_user_name"></strong>.
                        <br>Amount: <strong>$<span id="verify_amount_display"></span></strong>
                        <br>Crypto: <strong id="verify_crypto"></strong>
                    </div>
                    
                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">Admin Notes (Optional)</label>
                        <textarea class="form-control" name="admin_notes" rows="3" placeholder="Add any notes about this verification..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-1"></i>Verify & Add Balance
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-times-circle me-2"></i>Reject Deposit
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="reject_deposit">
                    <input type="hidden" name="deposit_id" id="reject_deposit_id">
                    
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        You are about to reject a deposit for <strong id="reject_user_name"></strong>.
                        <br>This action cannot be easily undone.
                    </div>
                    
                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">Reason for Rejection <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="admin_notes" rows="3" required placeholder="Please provide a reason for rejecting this deposit..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times me-1"></i>Reject Deposit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Screenshot preview
    document.querySelectorAll('.screenshot-preview').forEach(img => {
        img.addEventListener('click', function() {
            document.getElementById('modalScreenshot').src = this.dataset.screenshot;
        });
    });
    
    // Verify button handlers
    document.querySelectorAll('.verify-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('verify_deposit_id').value = this.dataset.depositId;
            document.getElementById('verify_user_id').value = this.dataset.userId;
            document.getElementById('verify_amount').value = this.dataset.amount;
            document.getElementById('verify_user_name').textContent = this.dataset.userName;
            document.getElementById('verify_amount_display').textContent = this.dataset.amount;
            document.getElementById('verify_crypto').textContent = this.dataset.crypto;
            
            new bootstrap.Modal(document.getElementById('verifyModal')).show();
        });
    });
    
    // Reject button handlers
    document.querySelectorAll('.reject-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('reject_deposit_id').value = this.dataset.depositId;
            document.getElementById('reject_user_name').textContent = this.dataset.userName;
            
            new bootstrap.Modal(document.getElementById('rejectModal')).show();
        });
    });
});
</script>

</body>
</html>