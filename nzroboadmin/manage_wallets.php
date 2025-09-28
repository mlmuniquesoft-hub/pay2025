<?php
session_start();
if(!isset($_SESSION['Admin'])){
    header("location:index.html");
    exit();
}

include('../db/db.php');

// Handle wallet actions
if(isset($_POST['action'])) {
    $action = $_POST['action'];
    
    if($action == 'add_wallet') {
        $wallet_name = mysqli_real_escape_string($mysqli, $_POST['wallet_name']);
        $wallet_type = mysqli_real_escape_string($mysqli, $_POST['wallet_type']);
        $wallet_address = mysqli_real_escape_string($mysqli, $_POST['wallet_address']);
        
        $insert_sql = "INSERT INTO manual_wallets (wallet_name, wallet_type, wallet_address, is_active, created_at) 
                      VALUES ('$wallet_name', '$wallet_type', '$wallet_address', 1, NOW())";
        
        if($mysqli->query($insert_sql)) {
            $_SESSION['success'] = 'Wallet added successfully!';
        } else {
            $_SESSION['error'] = 'Error adding wallet: ' . $mysqli->error;
        }
    }
    
    elseif($action == 'toggle_status') {
        $wallet_id = intval($_POST['wallet_id']);
        $new_status = intval($_POST['new_status']);
        
        $update_sql = "UPDATE manual_wallets SET is_active = $new_status WHERE id = $wallet_id";
        
        if($mysqli->query($update_sql)) {
            $status_text = $new_status ? 'activated' : 'deactivated';
            $_SESSION['success'] = "Wallet $status_text successfully!";
        } else {
            $_SESSION['error'] = 'Error updating wallet status: ' . $mysqli->error;
        }
    }
    
    elseif($action == 'delete_wallet') {
        $wallet_id = intval($_POST['wallet_id']);
        
        $delete_sql = "DELETE FROM manual_wallets WHERE id = $wallet_id";
        
        if($mysqli->query($delete_sql)) {
            $_SESSION['success'] = 'Wallet deleted successfully!';
        } else {
            $_SESSION['error'] = 'Error deleting wallet: ' . $mysqli->error;
        }
    }
    
    header("location: manage_wallets.php");
    exit();
}

// Fetch wallets
$wallets = $mysqli->query("SELECT * FROM manual_wallets ORDER BY wallet_type, created_at DESC");

// Check if manual_wallets table exists, create if not
if(!$wallets) {
    $create_table_sql = "CREATE TABLE IF NOT EXISTS manual_wallets (
        id INT PRIMARY KEY AUTO_INCREMENT,
        wallet_name VARCHAR(255) NOT NULL,
        wallet_type VARCHAR(50) NOT NULL,
        wallet_address VARCHAR(255) NOT NULL,
        is_active TINYINT DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    $mysqli->query($create_table_sql);
    $wallets = $mysqli->query("SELECT * FROM manual_wallets ORDER BY wallet_type, created_at DESC");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Deposit Wallets - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .crypto-badge {
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            color: white;
        }
        .crypto-btc { background: #f7931a; }
        .crypto-usdt-trc20 { background: #26a17b; }
        .crypto-usdt-bep20 { background: #f3ba2f; }
        
        .wallet-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .wallet-card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .wallet-address {
            font-family: monospace;
            font-size: 12px;
            background: #f8f9fa;
            padding: 8px;
            border-radius: 4px;
            word-break: break-all;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-wallet text-primary"></i>
                Manage Deposit Wallets
            </h1>
            <div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWalletModal">
                    <i class="fas fa-plus"></i> Add New Wallet
                </button>
                <a href="manual_deposits_verify.php" class="btn btn-outline-info">
                    <i class="fas fa-eye"></i> View Deposits
                </a>
                <a href="index.php" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left"></i> Dashboard
                </a>
            </div>
        </div>

        <!-- Success/Error Messages -->
        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i>
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Wallets Grid -->
        <div class="row">
            <?php if($wallets && mysqli_num_rows($wallets) > 0): ?>
                <?php while($wallet = mysqli_fetch_assoc($wallets)): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="wallet-card card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">
                                <span class="crypto-badge crypto-<?php echo strtolower(str_replace('_', '-', $wallet['wallet_type'])); ?>">
                                    <?php echo $wallet['wallet_type']; ?>
                                </span>
                            </h6>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" 
                                       <?php echo $wallet['is_active'] ? 'checked' : ''; ?>
                                       onchange="toggleWalletStatus(<?php echo $wallet['id']; ?>, <?php echo $wallet['is_active'] ? 0 : 1; ?>)">
                                <label class="form-check-label">
                                    <?php echo $wallet['is_active'] ? 'Active' : 'Inactive'; ?>
                                </label>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($wallet['wallet_name']); ?></h5>
                            <div class="wallet-address mb-3">
                                <?php echo htmlspecialchars($wallet['wallet_address']); ?>
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-calendar"></i>
                                Added: <?php echo date('M d, Y H:i', strtotime($wallet['created_at'])); ?>
                            </small>
                        </div>
                        <div class="card-footer">
                            <div class="btn-group w-100">
                                <button class="btn btn-outline-primary btn-sm" onclick="copyAddress('<?php echo $wallet['wallet_address']; ?>')">
                                    <i class="fas fa-copy"></i> Copy
                                </button>
                                <button class="btn btn-outline-warning btn-sm" onclick="editWallet(<?php echo $wallet['id']; ?>, '<?php echo htmlspecialchars($wallet['wallet_name']); ?>', '<?php echo $wallet['wallet_address']; ?>')">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-outline-danger btn-sm" onclick="deleteWallet(<?php echo $wallet['id']; ?>, '<?php echo htmlspecialchars($wallet['wallet_name']); ?>')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-wallet fa-3x text-muted mb-3"></i>
                        <h5>No wallets configured</h5>
                        <p class="text-muted">Add your first deposit wallet to get started.</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWalletModal">
                            <i class="fas fa-plus"></i> Add First Wallet
                        </button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Add Wallet Modal -->
    <div class="modal fade" id="addWalletModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Deposit Wallet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Wallet Name</label>
                            <input type="text" name="wallet_name" class="form-control" required placeholder="e.g., Main Bitcoin Wallet">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cryptocurrency Type</label>
                            <select name="wallet_type" class="form-select" required>
                                <option value="">Select Crypto Type</option>
                                <option value="BTC">Bitcoin (BTC)</option>
                                <option value="USDT_TRC20">USDT TRC20 (Tron)</option>
                                <option value="USDT_BEP20">USDT BEP20 (BSC)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Wallet Address</label>
                            <textarea name="wallet_address" class="form-control" rows="3" required placeholder="Enter the wallet address"></textarea>
                            <div class="form-text">Make sure this address is correct. Double-check before saving.</div>
                        </div>
                        <input type="hidden" name="action" value="add_wallet">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Add Wallet
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Hidden Forms -->
    <form id="toggleForm" method="POST" style="display: none;">
        <input type="hidden" name="action" value="toggle_status">
        <input type="hidden" name="wallet_id" id="toggleWalletId">
        <input type="hidden" name="new_status" id="toggleNewStatus">
    </form>

    <form id="deleteForm" method="POST" style="display: none;">
        <input type="hidden" name="action" value="delete_wallet">
        <input type="hidden" name="wallet_id" id="deleteWalletId">
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleWalletStatus(walletId, newStatus) {
            document.getElementById('toggleWalletId').value = walletId;
            document.getElementById('toggleNewStatus').value = newStatus;
            document.getElementById('toggleForm').submit();
        }
        
        function copyAddress(address) {
            navigator.clipboard.writeText(address).then(function() {
                // Show success notification
                const btn = event.target.closest('button');
                const originalHTML = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check"></i> Copied!';
                btn.classList.add('btn-success');
                btn.classList.remove('btn-outline-primary');
                
                setTimeout(function() {
                    btn.innerHTML = originalHTML;
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-outline-primary');
                }, 2000);
            });
        }
        
        function deleteWallet(walletId, walletName) {
            if(confirm(`Are you sure you want to delete wallet "${walletName}"? This action cannot be undone.`)) {
                document.getElementById('deleteWalletId').value = walletId;
                document.getElementById('deleteForm').submit();
            }
        }
        
        function editWallet(walletId, walletName, walletAddress) {
            // For now, show current details - you can extend this to open an edit modal
            alert(`Edit functionality coming soon!\n\nWallet: ${walletName}\nAddress: ${walletAddress}`);
        }
    </script>
</body>
</html>