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
        $update_sql = "UPDATE manual_deposits SET status = '$status', admin_note = '$admin_note', updated_at = NOW() WHERE id = $deposit_id";
        
        if($mysqli->query($update_sql)) {
            // If approved, add balance to user account
            if($status == 'approved') {
                $deposit_info = $mysqli->query("SELECT user_id, usd_amount FROM manual_deposits WHERE id = $deposit_id")->fetch_assoc();
                if($deposit_info) {
                    // Add to user balance (you may need to adjust this based on your balance table structure)
                    $mysqli->query("UPDATE balance SET bcpp_taka = bcpp_taka + {$deposit_info['usd_amount']} WHERE user_id = '{$deposit_info['user_id']}'");
                }
            }
            $_SESSION['success'] = "Deposit $status successfully!";
        } else {
            $_SESSION['error'] = 'Error updating deposit: ' . $mysqli->error;
        }
    }
    
    header("Location: manual_deposits_verify_new.php");
    exit();
}

// Get filter parameters
$status_filter = $_GET['status'] ?? 'all';
$limit = intval($_GET['limit'] ?? 20);
$page = intval($_GET['page'] ?? 1);

// Build WHERE clause for filtering
$where_clause = "1=1";
if($status_filter != 'all') {
    $where_clause .= " AND status = '$status_filter'";
}

// Get total count for pagination
$count_result = $mysqli->query("SELECT COUNT(*) as total FROM manual_deposits WHERE $where_clause");
$total_deposits = $count_result ? $count_result->fetch_assoc()['total'] : 0;

// Calculate pagination
$total_pages = ceil($total_deposits / $limit);
$offset = ($page - 1) * $limit;

// Get deposits
$deposits_sql = "SELECT * FROM manual_deposits WHERE $where_clause ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$deposits_result = $mysqli->query($deposits_sql);

// Get statistics
$stats_result = $mysqli->query("SELECT 
    COUNT(*) as total_deposits,
    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_count,
    SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved_count,
    SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected_count,
    SUM(CASE WHEN status = 'approved' THEN amount ELSE 0 END) as approved_amount,
    SUM(CASE WHEN status = 'pending' THEN amount ELSE 0 END) as pending_amount
    FROM manual_deposits");

$stats = $stats_result ? $stats_result->fetch_assoc() : [
    'total_deposits' => 0, 'pending_count' => 0, 'approved_count' => 0, 
    'rejected_count' => 0, 'approved_amount' => 0, 'pending_amount' => 0
];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manual Deposits Verification - Admin Panel</title>
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
    <style>
        .status-pending { background: #f0ad4e; color: #fff; }
        .status-approved { background: #5cb85c; color: #fff; }
        .status-rejected { background: #d9534f; color: #fff; }
        .screenshot-thumb {
            max-width: 80px;
            max-height: 80px;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
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
                            
                            <!-- Statistics Row -->
                            <div class="row">
                                <div class="col-md-2 col-sm-4 col-xs-6">
                                    <div class="panel panel-primary">
                                        <div class="panel-body text-center">
                                            <h3><?php echo $stats['total_deposits']; ?></h3>
                                            <small>Total</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-6">
                                    <div class="panel panel-warning">
                                        <div class="panel-body text-center">
                                            <h3><?php echo $stats['pending_count']; ?></h3>
                                            <small>Pending</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-6">
                                    <div class="panel panel-success">
                                        <div class="panel-body text-center">
                                            <h3><?php echo $stats['approved_count']; ?></h3>
                                            <small>Approved</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-6">
                                    <div class="panel panel-danger">
                                        <div class="panel-body text-center">
                                            <h3><?php echo $stats['rejected_count']; ?></h3>
                                            <small>Rejected</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-6">
                                    <div class="panel panel-info">
                                        <div class="panel-body text-center">
                                            <h3>$<?php echo number_format($stats['approved_amount'], 2); ?></h3>
                                            <small>Approved $</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-6">
                                    <div class="panel panel-default">
                                        <div class="panel-body text-center">
                                            <h3>$<?php echo number_format($stats['pending_amount'], 2); ?></h3>
                                            <small>Pending $</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Filter and Deposits Table -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-coins fa-fw"></i> Manual Deposits 
                                    <?php if($status_filter != 'all'): ?>
                                        <span class="label label-primary"><?php echo ucfirst($status_filter); ?></span>
                                    <?php endif; ?>
                                    
                                    <!-- Filter Buttons -->
                                    <div class="pull-right">
                                        <a href="?status=all" class="btn btn-xs <?php echo $status_filter == 'all' ? 'btn-primary' : 'btn-default'; ?>">All</a>
                                        <a href="?status=pending" class="btn btn-xs <?php echo $status_filter == 'pending' ? 'btn-warning' : 'btn-default'; ?>">Pending</a>
                                        <a href="?status=approved" class="btn btn-xs <?php echo $status_filter == 'approved' ? 'btn-success' : 'btn-default'; ?>">Approved</a>
                                        <a href="?status=rejected" class="btn btn-xs <?php echo $status_filter == 'rejected' ? 'btn-danger' : 'btn-default'; ?>">Rejected</a>
                                    </div>
                                </div>
                                
                                <div class="panel-body">
                                    <?php if($deposits_result && mysqli_num_rows($deposits_result) > 0): ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>User</th>
                                                        <th>Deposit Type</th>
                                                        <th>Amount</th>
                                                        <th>Status</th>
                                                        <th>Date</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while($deposit = mysqli_fetch_assoc($deposits_result)): ?>
                                                        <tr>
                                                            <td><?php echo $deposit['id']; ?></td>
                                                            <td><?php echo htmlspecialchars($deposit['user']); ?></td>
                                                            <td><?php echo $deposit['deposit_type']; ?></td>
                                                            <td>$<?php echo number_format($deposit['amount'], 2); ?></td>
                                                            <td>
                                                                <span class="label status-<?php echo $deposit['status']; ?>">
                                                                    <?php echo ucfirst($deposit['status']); ?>
                                                                </span>
                                                            </td>
                                                            <td><?php echo date('M j, Y H:i', strtotime($deposit['created_at'])); ?></td>
                                                            <td>
                                                                <?php if($deposit['status'] == 'pending'): ?>
                                                                    <form method="post" style="display: inline;">
                                                                        <input type="hidden" name="deposit_id" value="<?php echo $deposit['id']; ?>">
                                                                        <input type="hidden" name="action" value="approve">
                                                                        <button type="submit" class="btn btn-xs btn-success" onclick="return confirm('Approve this deposit?')">
                                                                            <i class="fa fa-check"></i> Approve
                                                                        </button>
                                                                    </form>
                                                                    <form method="post" style="display: inline;">
                                                                        <input type="hidden" name="deposit_id" value="<?php echo $deposit['id']; ?>">
                                                                        <input type="hidden" name="action" value="reject">
                                                                        <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Reject this deposit?')">
                                                                            <i class="fa fa-times"></i> Reject
                                                                        </button>
                                                                    </form>
                                                                <?php else: ?>
                                                                    <span class="text-muted">No actions</span>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    <?php endwhile; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <!-- Pagination -->
                                        <?php if($total_pages > 1): ?>
                                            <div class="text-center">
                                                <?php for($i = 1; $i <= $total_pages; $i++): ?>
                                                    <a href="?status=<?php echo $status_filter; ?>&page=<?php echo $i; ?>&limit=<?php echo $limit; ?>" 
                                                       class="btn btn-sm <?php echo $i == $page ? 'btn-primary' : 'btn-default'; ?>">
                                                        <?php echo $i; ?>
                                                    </a>
                                                <?php endfor; ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                    <?php else: ?>
                                        <div class="alert alert-info">
                                            <i class="fa fa-info-circle"></i> No deposits found.
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
        </div>
</body>
</html>