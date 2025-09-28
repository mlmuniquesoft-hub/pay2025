<?php
// Get user's manual deposit history
$queryManual = "SELECT * FROM manual_deposits WHERE user = '$member' ORDER BY created_at DESC";
$depositsManual = $mysqli->query($queryManual);

// Get user's crypto deposit history from req_fund
$queryCrypto = "SELECT * FROM req_fund WHERE user = '$member' ORDER BY serial DESC";
$depositsCrypto = $mysqli->query($queryCrypto);

// Get summary stats for manual deposits
$statsManual = $mysqli->query("SELECT 
    COUNT(*) as total_deposits,
    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_count,
    SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved_count,
    SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected_count,
    SUM(CASE WHEN status = 'approved' THEN amount ELSE 0 END) as approved_amount
    FROM manual_deposits WHERE user = '$member'")->fetch_assoc();

// Get crypto deposit stats
$statsCrypto = $mysqli->query("SELECT 
    COUNT(*) as total_crypto_deposits,
    SUM(amount) as total_crypto_amount
    FROM req_fund WHERE user = '$member'")->fetch_assoc();
?>

<style>
.status-badge {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: bold;
}
.status-pending { background: #ffc107; color: #000; }
.status-approved { background: #28a745; color: #fff; }
.status-rejected { background: #dc3545; color: #fff; }
.screenshot-thumb {
    max-width: 50px;
    max-height: 50px;
    border: 1px solid #ddd;
    border-radius: 4px;
    cursor: pointer;
}
.round img2 {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    overflow: hidden;
}
.designer-info h6 {
    margin: 0;
    font-size: 12px;
    color: #fff;
}
.green-text { color: #28a745 !important; }
.boldy { font-weight: bold; }
</style>

<div class="wrapper main-wrapper row" style='height:100vh'>
    <div class="col-lg-12">
        <section class="box" style="background:#211c8896">
            <header class="panel_header">
                <h2 class="title pull-left">Deposit History</h2>
                <div class="actions panel_actions pull-right">
                    <a class="box_toggle fa fa-chevron-down"></a>
                    <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                    <a class="box_close fa fa-times"></a>
                </div>
            </header>
            <div class="content-body">
                <div class="row">
                    <div class="col-xs-12">
                        <!-- Statistics Summary -->
                        <div class="row" style="margin-bottom:20px;">
                            <div class="col-md-3">
                                <div class="text-center" style="background: rgba(40,167,69,0.1); padding: 15px; border-radius: 8px;">
                                    <h3 style="color: #28a745; margin:0;"><?php echo $statsManual['total_deposits'] + $statsCrypto['total_crypto_deposits']; ?></h3>
                                    <small style="color: #fff;">Total Deposits</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center" style="background: rgba(255,193,7,0.1); padding: 15px; border-radius: 8px;">
                                    <h3 style="color: #ffc107; margin:0;"><?php echo $statsManual['pending_count']; ?></h3>
                                    <small style="color: #fff;">Pending Manual</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center" style="background: rgba(40,167,69,0.1); padding: 15px; border-radius: 8px;">
                                    <h3 style="color: #28a745; margin:0;"><?php echo $statsManual['approved_count']; ?></h3>
                                    <small style="color: #fff;">Approved Manual</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center" style="background: rgba(23,162,184,0.1); padding: 15px; border-radius: 8px;">
                                    <h3 style="color: #17a2b8; margin:0;">$<?php echo number_format($statsManual['approved_amount'] + $statsCrypto['total_crypto_amount'], 2); ?></h3>
                                    <small style="color: #fff;">Total Credited</small>
                                </div>
                            </div>
                        </div>

                        <!-- Combined Deposits Table -->
                        <div class="table-responsive" id="DepositReport" data-pattern="priority-columns">
                            <table id="tech-companies-1" class="table vm trans table-small-font no-mb table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Transaction/Hash</th>
                                        <th>Screenshot</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Crypto Deposits -->
                                    <?php while($cryptoDeposit = mysqli_fetch_assoc($depositsCrypto)): ?>
                                    <tr>
                                        <td>
                                            <div class="round img2" style="display: inline-block; width: 30px; height: 30px; margin-right: 10px;">
                                                <img src="../data/crypto-dash/coin1.png" alt="" style="width: 100%; height: 100%; border-radius: 50%;">
                                            </div>
                                            <div class="designer-info" style="display: inline-block; vertical-align: top;">
                                                <h6 style="margin: 0; color: #fff;">Bitcoin</h6>
                                                <small style="color: #ccc;">Crypto</small>
                                            </div>
                                        </td>
                                        <td class="green-text boldy">
                                            + $<?php echo number_format($cryptoDeposit['amount'], 2, '.',''); ?>
                                        </td>
                                        <td>
                                            <a class="btn btn-info btn-xs" target="_blank" href="https://www.blockchain.com/btc/tx/<?php echo $cryptoDeposit['uniq_number']; ?>">
                                                <?php echo substr($cryptoDeposit['uniq_number'],0,15) . '...'; ?>
                                            </a>
                                        </td>
                                        <td><span class="text-muted">-</span></td>
                                        <td><span class="badge w-70 round-success">Completed</span></td>
                                        <td><small class="text-muted"><?php echo date("d M-Y H:i:s", strtotime($cryptoDeposit['date'])); ?></small></td>
                                        <td><small class="text-muted">Auto-verified</small></td>
                                    </tr>
                                    <?php endwhile; ?>

                                    <!-- Manual Deposits -->
                                    <?php while($manualDeposit = mysqli_fetch_assoc($depositsManual)): ?>
                                    <tr>
                                        <td>
                                            <div class="round img2" style="display: inline-block; width: 30px; height: 30px; margin-right: 10px;">
                                                <img src="../data/crypto-dash/<?php 
                                                    echo $manualDeposit['deposit_type'] == 'BTC' ? 'coin1.png' : 
                                                        ($manualDeposit['deposit_type'] == 'USDT_TRC20' ? 'coin2.png' : 'coin3.png'); 
                                                ?>" alt="" style="width: 100%; height: 100%; border-radius: 50%;">
                                            </div>
                                            <div class="designer-info" style="display: inline-block; vertical-align: top;">
                                                <h6 style="margin: 0; color: #fff;"><?php echo $manualDeposit['deposit_type']; ?></h6>
                                                <small style="color: #ccc;">Manual</small>
                                            </div>
                                        </td>
                                        <td class="<?php echo $manualDeposit['status'] == 'approved' ? 'green-text' : ($manualDeposit['status'] == 'rejected' ? 'text-danger' : 'text-warning'); ?> boldy">
                                            <?php echo $manualDeposit['status'] == 'approved' ? '+' : ''; ?> $<?php echo number_format($manualDeposit['amount'], 2); ?>
                                        </td>
                                        <td>
                                            <small title="<?php echo $manualDeposit['txn_hash']; ?>">
                                                <?php echo substr($manualDeposit['txn_hash'], 0, 15) . '...'; ?>
                                            </small>
                                        </td>
                                        <td>
                                            <?php if($manualDeposit['screenshot']): ?>
                                                <img src="../uploads/deposit_screenshots/<?php echo $manualDeposit['screenshot']; ?>" 
                                                     class="screenshot-thumb" 
                                                     onclick="showImage('<?php echo $manualDeposit['screenshot']; ?>')">
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="status-badge status-<?php echo $manualDeposit['status']; ?>">
                                                <?php echo ucfirst($manualDeposit['status']); ?>
                                            </span>
                                        </td>
                                        <td><small class="text-muted"><?php echo date("d M-Y H:i:s", strtotime($manualDeposit['created_at'])); ?></small></td>
                                        <td>
                                            <small class="text-muted">
                                                <?php if(!empty($manualDeposit['admin_note'])): ?>
                                                    <?php echo substr($manualDeposit['admin_note'], 0, 20); ?>
                                                    <?php if(strlen($manualDeposit['admin_note']) > 20) echo '...'; ?>
                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </small>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>

                                    <?php 
                                    // If no deposits at all
                                    mysqli_data_seek($depositsManual, 0);
                                    mysqli_data_seek($depositsCrypto, 0);
                                    if(mysqli_num_rows($depositsManual) == 0 && mysqli_num_rows($depositsCrypto) == 0): 
                                    ?>
                                    <tr>
                                        <td colspan="7" class="text-center" style="padding: 50px;">
                                            <h4 style="color: #fff;">No deposits found</h4>
                                            <p style="color: #ccc;">You haven't made any deposits yet.</p>
                                            <a href="index.php?route=deposit&tild=<?php echo base64_encode(time()); ?>&title=<?php echo urlencode('All Deposit History'); ?>" class="btn btn-primary">
                                                <i class="fa fa-plus"></i> Make First Deposit
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
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

<script>
function showImage(filename) {
    $('#modalImage').attr('src', '../uploads/deposit_screenshots/' + filename);
    $('#imageModal').modal('show');
}
</script>