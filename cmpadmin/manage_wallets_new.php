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
        // Use wallet_type to match existing manual_wallets schema
        $wallet_type = strtoupper(mysqli_real_escape_string($mysqli, $_POST['crypto_type']));
        $wallet_address = mysqli_real_escape_string($mysqli, $_POST['wallet_address']);
        
        // Insert or update using wallet_type and wallet_address
        $insert_sql = "INSERT INTO manual_wallets (wallet_type, wallet_address) VALUES ('$wallet_type', '$wallet_address')
                       ON DUPLICATE KEY UPDATE wallet_address = VALUES(wallet_address)";
        
        if($mysqli->query($insert_sql)) {
            $_SESSION['success'] = 'Wallet added/updated successfully!';
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
    
    header("Location: manage_wallets_new.php");
    exit();
}

// Get all wallets ordered by wallet_type
$wallets_result = $mysqli->query("SELECT * FROM manual_wallets ORDER BY wallet_type ASC, created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Deposit Wallets - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300,400' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>
    <!-- CSS Libs -->
    <link rel="stylesheet" type="text/css" href="lib/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/animate.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/bootstrap-switch.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/checkbox3.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/dataTables.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="lib/css/select2.min.css">
    <!-- CSS App -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/themes/flat-blue.css">
</head>

<body class="flat-blue">
    <div class="app-container expanded">
        <div class="row content-container">
        <?php require_once'menu.php'?>
            <!-- Main Content -->
            <div class="container-fluid">
                <div class="side-body padding-top">
                    <?php require_once'topshow.php'?>
                    
                    <!-- Success/Error Messages -->
                    <?php if(isset($_SESSION['success'])): ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <i class="fa fa-check-circle"></i> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <i class="fa fa-exclamation-circle"></i> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="row no-margin-bottom">
                        <div class="col-sm-12 col-xs-12">
                            
                            <!-- Add New Wallet -->
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <i class="fa fa-plus fa-fw"></i> Add New Wallet
                                </div>
                                <div class="panel-body">
                                    <form method="post" class="form-horizontal">
                                        <input type="hidden" name="action" value="add_wallet">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Crypto Type:</label>
                                            <div class="col-sm-3">
                                                <select name="crypto_type" class="form-control" required>
                                                    <option value="">Select Crypto</option>
                                                    <option value="BTC">Bitcoin (BTC)</option>
                                                    <option value="ETH">Ethereum (ETH)</option>
                                                    <option value="USDT">Tether (USDT)</option>
                                                    <option value="LTC">Litecoin (LTC)</option>
                                                    <option value="BNB">Binance Coin (BNB)</option>
                                                    <option value="ADA">Cardano (ADA)</option>
                                                    <option value="DOT">Polkadot (DOT)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Wallet Address:</label>
                                            <div class="col-sm-6">
                                                <input type="text" name="wallet_address" class="form-control" placeholder="Enter wallet address" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-save"></i> Add Wallet
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Existing Wallets -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-wallet fa-fw"></i> Manage Deposit Wallets
                                </div>
                                <div class="panel-body">
                                    <?php if($wallets_result && mysqli_num_rows($wallets_result) > 0): ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Crypto Type</th>
                                                        <th>Wallet Address</th>
                                                        <th>Status</th>
                                                        <th>Created</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while($wallet = mysqli_fetch_assoc($wallets_result)): ?>
                                                        <tr>
                                                            <td><?php echo $wallet['id']; ?></td>
                                                            <td>
                                                                <strong><?php echo $wallet['wallet_type']; ?></strong>
                                                            </td>
                                                            <td>
                                                                <code><?php echo htmlspecialchars($wallet['wallet_address']); ?></code>
                                                                <button class="btn btn-xs btn-default" onclick="copyToClipboard('<?php echo htmlspecialchars($wallet['wallet_address']); ?>')">
                                                                    <i class="fa fa-copy"></i>
                                                                </button>
                                                            </td>
                                                            <td>
                                                                <?php if($wallet['is_active']): ?>
                                                                    <span class="label label-success">Active</span>
                                                                <?php else: ?>
                                                                    <span class="label label-default">Inactive</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td><?php echo date('M j, Y', strtotime($wallet['created_at'])); ?></td>
                                                            <td>
                                                                <!-- Toggle Status -->
                                                                <form method="post" style="display: inline;">
                                                                    <input type="hidden" name="action" value="toggle_status">
                                                                    <input type="hidden" name="wallet_id" value="<?php echo $wallet['id']; ?>">
                                                                    <input type="hidden" name="new_status" value="<?php echo $wallet['is_active'] ? '0' : '1'; ?>">
                                                                    <button type="submit" class="btn btn-xs <?php echo $wallet['is_active'] ? 'btn-warning' : 'btn-success'; ?>">
                                                                        <i class="fa <?php echo $wallet['is_active'] ? 'fa-pause' : 'fa-play'; ?>"></i>
                                                                        <?php echo $wallet['is_active'] ? 'Deactivate' : 'Activate'; ?>
                                                                    </button>
                                                                </form>
                                                                
                                                                <!-- Delete -->
                                                                <form method="post" style="display: inline;">
                                                                    <input type="hidden" name="action" value="delete_wallet">
                                                                    <input type="hidden" name="wallet_id" value="<?php echo $wallet['id']; ?>">
                                                                    <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Delete this wallet?')">
                                                                        <i class="fa fa-trash"></i> Delete
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    <?php endwhile; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-info">
                                            <i class="fa fa-info-circle"></i> No wallets configured yet. Add your first wallet above.
                                        </div>
                                    <?php endif; ?>
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
            <script type="text/javascript" src="lib/js/bootstrap-switch.min.js"></script>
            <script type="text/javascript" src="lib/js/jquery.dataTables.min.js"></script>
            <script type="text/javascript" src="lib/js/dataTables.bootstrap.min.js"></script>
            <!-- Javascript -->
            <script type="text/javascript" src="js/app.js"></script>
            <script type="text/javascript" src="js/index.js"></script>
            
            <script>
                function copyToClipboard(text) {
                    navigator.clipboard.writeText(text).then(function() {
                        alert('Wallet address copied to clipboard!');
                    });
                }
            </script>
        </div>
</body>
</html>