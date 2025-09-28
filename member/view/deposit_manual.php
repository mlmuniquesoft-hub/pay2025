	<style>
	/* Enhanced styling for better text visibility */
	body, html {
		background: #f8f9fa !important;
		color: #333 !important;
	}
	
	/* Modal and form improvements */
	.modal-header {
		background: #fff !important;
		color: #333 !important;
		border-bottom: 1px solid #dee2e6;
	}

	.modal-title {
		color: #333 !important;
		font-weight: bold !important;
	}

	.modal-body {
		background: #fff !important;
		color: #333 !important;
	}

	.modal-footer {
		background: #fff !important;
		border-top: 1px solid #dee2e6;
	}

	.form-label, label {
		color: #333 !important;
		font-weight: bold !important;
		margin-bottom: 8px;
		display: block;
	}

	.form-control {
		border: 1px solid #ddd !important;
		background: #fff !important;
		color: #333 !important;
		padding: 8px 12px !important;
	}

	.form-control:focus {
		border-color: #007bff !important;
		box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25) !important;
		background: #fff !important;
		color: #333 !important;
	}

	/* Main content styling */
	.panel_header h2, h3, h4, h5, h6 {
		color: #333 !important;
		font-weight: bold !important;
	}

	.panel_header {
		background: #f8f9fa !important;
		border-bottom: 1px solid #dee2e6 !important;
		padding: 15px 20px !important;
	}

	.content-body {
		background: #fff !important;
		color: #333 !important;
		padding: 20px !important;
	}

	.wallet-option h4 {
		color: #333 !important;
		font-weight: bold !important;
	}

	.input-group-addon {
		background: #f8f9fa !important;
		border: 1px solid #ddd !important;
		color: #333 !important;
	}

	.nav-tabs .nav-link {
		color: #333 !important;
		background: #f8f9fa !important;
		border: 1px solid #dee2e6 !important;
	}

	.nav-tabs .nav-link.active {
		color: #fff !important;
		background: #007bff !important;
		border-color: #007bff !important;
	}

	/* Button improvements */
	.btn {
		font-weight: bold;
		padding: 8px 16px;
		border-radius: 4px;
	}

	.btn-primary {
		background: #007bff !important;
		border-color: #007bff !important;
		color: #fff !important;
	}

	.btn-success {
		background: #28a745 !important;
		border-color: #28a745 !important;
		color: #fff !important;
	}

	.btn-info {
		background: #17a2b8 !important;
		border-color: #17a2b8 !important;
		color: #fff !important;
	}

	/* Alert styling */
	.alert-info {
		background: #d1ecf1 !important;
		border: 1px solid #bee5eb !important;
		color: #0c5460 !important;
		border-radius: 5px;
	}

	.alert-warning {
		background: #fff3cd !important;
		border: 1px solid #ffeeba !important;
		color: #856404 !important;
		border-radius: 5px;
	}

	/* Table styling */
	.table {
		background: #fff !important;
		color: #333 !important;
	}

	.table thead th {
		background: #343a40 !important;
		color: #fff !important;
		font-weight: bold;
		border: 1px solid #454d55 !important;
	}

	.table tbody tr td {
		color: #333 !important;
		border: 1px solid #dee2e6 !important;
		padding: 12px;
	}

	/* General text improvements */
	p, span, small, .text-muted {
		color: #333 !important;
	}

	.designer-info h6 {
		color: #333 !important;
		font-weight: bold;
	}

	/* Section styling */
	.box {
		background: #fff !important;
		border: 1px solid #dee2e6 !important;
		border-radius: 8px;
		box-shadow: 0 2px 4px rgba(0,0,0,0.1);
	}
	</style>
	<div class="wrapper main-wrapper row" style='min-height:100vh; background: #f8f9fa;'>
		<div class="col-lg-12">
			<section class="box" style="background:#fff; border: 1px solid #dee2e6; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
				<header class="panel_header" style="background: #f8f9fa; border-bottom: 1px solid #dee2e6; padding: 15px 20px; border-radius: 8px 8px 0 0;">
					<h2 class="title pull-left" style="color: #333; font-weight: bold; margin: 0;">Manual Deposit System</h2>
					<div class="pull-right">
						<span class="label label-success" style="background: #28a745; color: #fff; padding: 6px 12px; border-radius: 4px; font-size: 12px; font-weight: bold;">Manual Verification Required</span>
					</div>
				</header>
				<div class="content-body" style="padding:20px; background: #fff; color: #333;">
					<div class="row">
						<div class="col-md-12">
							<div class="alert alert-info" style="background: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460; border-radius: 5px; padding: 15px; margin-bottom: 20px;">
								<strong style="color: #0c5460;">How it works:</strong>
								<ol style="margin-top: 10px; color: #0c5460;">
									<li>Choose your preferred cryptocurrency</li>
									<li>Copy the wallet address and send your payment</li>
									<li>Upload screenshot of your payment</li>
									<li>Admin will verify and add balance to your account</li>
								</ol>
							</div>

							<div class="row tabs-area">
								<ul class="nav nav-tabs crypto-wallet-address vertical col-xs-4 col-md-3 left-aligned primary" style="background: #fff; border: 1px solid #dee2e6; border-radius: 8px;">
									<li class="text-center relative active" style="background: #007bff; border-radius: 8px 8px 0 0;">
										<a href="#btc-tab" data-toggle="tab" aria-expanded="true" style="color: #fff; text-decoration: none; padding: 15px; display: block;">
											<img src="../data/crypto-dash/coin1.png" class="crypto-i" alt="">
											<h4 style="color: #fff; font-weight: bold; margin-top: 10px;">Bitcoin</h4>
										</a>
										<div class="check-span"><i class="fa fa-check" style="color: #fff;"></i></div>
									</li>
									<li class="text-center relative" style="background: #f8f9fa; border-bottom: 1px solid #dee2e6;">
										<a href="#usdt-trc20-tab" data-toggle="tab" aria-expanded="false" style="color: #333; text-decoration: none; padding: 15px; display: block;">
											<img src="../data/crypto-dash/usdt.png" class="crypto-i" alt="" style="width: 32px; height: 32px;">
											<h4 style="color: #333; font-weight: bold; margin-top: 10px;">USDT TRC20</h4>
										</a>
										<div class="check-span"><i class="fa fa-check" style="color: #28a745;"></i></div>
									</li>
									<li class="text-center relative" style="background: #f8f9fa; border-radius: 0 0 8px 8px;">
										<a href="#usdt-bep20-tab" data-toggle="tab" aria-expanded="false" style="color: #333; text-decoration: none; padding: 15px; display: block;">
											<img src="../data/crypto-dash/usdt-bep20.png" class="crypto-i" alt="" style="width: 32px; height: 32px;">
											<h4 style="color: #333; font-weight: bold; margin-top: 10px;">USDT BEP20</h4>
										</a>
										<div class="check-span"><i class="fa fa-check" style="color: #28a745;"></i></div>
									</li>
								</ul>
								<?php 
									// Get manual wallet addresses
									$btcWallets = $mysqli->query("SELECT * FROM `manual_wallets` WHERE `wallet_type`='BTC' AND `is_active`=1");
									$usdtTrc20Wallets = $mysqli->query("SELECT * FROM `manual_wallets` WHERE `wallet_type`='USDT_TRC20' AND `is_active`=1");
									$usdtBep20Wallets = $mysqli->query("SELECT * FROM `manual_wallets` WHERE `wallet_type`='USDT_BEP20' AND `is_active`=1");
								?>
								<div class="tab-content wallet-address-tab vertical col-xs-12 col-lg-9 left-aligned primary" style="padding-right: 0px; background: #fff; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
									<!-- BTC TAB -->
									<div class="tab-pane fade active in" id="btc-tab">
										<div class="row">
											<div class="col-xs-12">
												<div class="option-identity-wrapper mb-15">
													<h3 class="boldy mt-0" style="color: #333; font-weight: bold; margin-bottom: 20px; font-size: 24px;">Bitcoin Deposit</h3>
													<div class="alert alert-warning" style="background: #fff3cd; border: 1px solid #ffeeba; color: #856404; border-radius: 5px; padding: 10px; margin-bottom: 15px;">
														<strong style="color: #856404;">Important:</strong> <span style="color: #856404;">Only send Bitcoin (BTC) to this address. Sending other cryptocurrencies will result in permanent loss.</span>
													</div>
													
													<?php while($btcWallet = mysqli_fetch_assoc($btcWallets)): ?>
													<div class="wallet-option" style="border: 2px solid #007bff; border-radius: 8px; padding: 15px; margin-bottom: 15px; background: rgba(255,255,255,0.95);">
														<h4 style="color: #333; font-weight: bold; margin-bottom: 15px;"><?php echo $btcWallet['wallet_name']; ?></h4>
														<div class="row">
															<div class="col-lg-8">
																<div class="form-group mb-0">
																	<label class="form-label mb-10" style="color: #333; font-weight: bold; margin-bottom: 8px; display: block;">Bitcoin Address</label>
																	<div class="input-group primary">
																		<span class="input-group-addon" style="background: #f8f9fa; border: 1px solid #ddd; color: #333;">                
																		<span class="arrow"></span>
																		<i class="fa fa-bitcoin" style="color: #f7931a;"></i>
																		</span>
																		<input type="text" class="form-control btc-address" value="<?php echo $btcWallet['wallet_address']; ?>" readonly style="background: #f8f9fa; color: #333; border: 1px solid #ddd; font-family: monospace; font-size: 12px;">
																	</div>
																</div>
															</div>
															<div class="col-lg-4 no-pl mt-30">
																<a href="#" class="btn btn-primary btn-corner copy-address" data-address="<?php echo $btcWallet['wallet_address']; ?>" style="margin-right: 10px; color: #fff; background: #007bff; border: 1px solid #007bff;"><i class="fa fa-copy"></i> Copy</a>
																<a href="#" class="btn btn-success btn-corner deposit-btn" data-type="BTC" data-address="<?php echo $btcWallet['wallet_address']; ?>" data-name="<?php echo $btcWallet['wallet_name']; ?>" style="color: #fff; background: #28a745; border: 1px solid #28a745;">Deposit</a>
															</div>
														</div>
													</div>
													<?php endwhile; ?>
												</div>
											</div>
										</div>
									</div>
									
									<!-- USDT TRC20 TAB -->
									<div class="tab-pane fade" id="usdt-trc20-tab">
										<div class="row">
											<div class="col-xs-12">
												<div class="option-identity-wrapper mb-15">
													<h3 class="boldy mt-0" style="color: #333; font-weight: bold; margin-bottom: 20px; font-size: 24px;">USDT TRC20 Deposit</h3>
													<div class="alert alert-info" style="background: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460; border-radius: 5px; padding: 15px; margin-bottom: 15px;">
														<strong style="color: #0c5460;">TRC20 Network:</strong> <span style="color: #0c5460;">This is a TRON (TRC20) USDT address. Lower fees, faster transactions.</span>
													</div>
													
													<?php while($trc20Wallet = mysqli_fetch_assoc($usdtTrc20Wallets)): ?>
													<div class="wallet-option" style="border: 2px solid #26a17b; border-radius: 8px; padding: 15px; margin-bottom: 15px; background: rgba(255,255,255,0.95);">
														<h4 style="color: #333; font-weight: bold; margin-bottom: 15px;"><?php echo $trc20Wallet['wallet_name']; ?></h4>
														<div class="row">
															<div class="col-lg-8">
																<div class="form-group mb-0">
																	<label class="form-label mb-10" style="color: #333; font-weight: bold; margin-bottom: 8px; display: block;">USDT TRC20 Address</label>
																	<div class="input-group primary">
																		<span class="input-group-addon" style="background: #f8f9fa; border: 1px solid #ddd; color: #333;">                
																		<span class="arrow"></span>
																		<i class="fa fa-coins" style="color: #26a17b;"></i>
																		</span>
																		<input type="text" class="form-control trc20-address" value="<?php echo $trc20Wallet['wallet_address']; ?>" readonly style="background: #f8f9fa; color: #333; border: 1px solid #ddd; font-family: monospace; font-size: 12px;">
																	</div>
																</div>
															</div>
															<div class="col-lg-4 no-pl mt-30">
																<a href="#" class="btn btn-success btn-corner copy-address" data-address="<?php echo $trc20Wallet['wallet_address']; ?>" style="margin-right: 10px; color: #fff; background: #28a745; border: 1px solid #28a745;"><i class="fa fa-copy"></i> Copy</a>
																<a href="#" class="btn btn-info btn-corner deposit-btn" data-type="USDT_TRC20" data-address="<?php echo $trc20Wallet['wallet_address']; ?>" data-name="<?php echo $trc20Wallet['wallet_name']; ?>" style="color: #fff; background: #17a2b8; border: 1px solid #17a2b8;">Deposit</a>
															</div>
														</div>
													</div>
													<?php endwhile; ?>
												</div>
											</div>
										</div>
									</div>
									
									<!-- USDT BEP20 TAB -->
									<div class="tab-pane fade" id="usdt-bep20-tab">
										<div class="row">
											<div class="col-xs-12">
												<div class="option-identity-wrapper mb-15">
													<h3 class="boldy mt-0" style="color: #333; font-weight: bold; margin-bottom: 20px; font-size: 24px;">USDT BEP20 Deposit</h3>
													<div class="alert alert-warning" style="background: #fff3cd; border: 1px solid #ffeeba; color: #856404; border-radius: 5px; padding: 15px; margin-bottom: 15px;">
														<strong style="color: #856404;">BEP20 Network:</strong> <span style="color: #856404;">This is a Binance Smart Chain (BEP20) USDT address. Fast and cheap transactions.</span>
													</div>
													
													<?php while($bep20Wallet = mysqli_fetch_assoc($usdtBep20Wallets)): ?>
													<div class="wallet-option" style="border: 2px solid #f3ba2f; border-radius: 8px; padding: 15px; margin-bottom: 15px; background: rgba(255,255,255,0.95);">
														<h4 style="color: #333; font-weight: bold; margin-bottom: 15px;"><?php echo $bep20Wallet['wallet_name']; ?></h4>
														<div class="row">
															<div class="col-lg-8">
																<div class="form-group mb-0">
																	<label class="form-label mb-10" style="color: #333; font-weight: bold; margin-bottom: 8px; display: block;">USDT BEP20 Address</label>
																	<div class="input-group primary">
																		<span class="input-group-addon" style="background: #f8f9fa; border: 1px solid #ddd; color: #333;">                
																		<span class="arrow"></span>
																		<i class="fa fa-coins" style="color: #f3ba2f;"></i>
																		</span>
																		<input type="text" class="form-control bep20-address" value="<?php echo $bep20Wallet['wallet_address']; ?>" readonly style="background: #f8f9fa; color: #333; border: 1px solid #ddd; font-family: monospace; font-size: 12px;">
																	</div>
																</div>
															</div>
															<div class="col-lg-4 no-pl mt-30">
																<a href="#" class="btn btn-warning btn-corner copy-address" data-address="<?php echo $bep20Wallet['wallet_address']; ?>" style="margin-right: 10px; color: #333; background: #ffc107; border: 1px solid #ffc107;"><i class="fa fa-copy"></i> Copy</a>
																<a href="#" class="btn btn-primary btn-corner deposit-btn" data-type="USDT_BEP20" data-address="<?php echo $bep20Wallet['wallet_address']; ?>" data-name="<?php echo $bep20Wallet['wallet_name']; ?>" style="color: #fff; background: #007bff; border: 1px solid #007bff;">Deposit</a>
															</div>
														</div>
													</div>
													<?php endwhile; ?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>

		<!-- Deposit Modal -->
		<div class="modal fade" id="depositModal" tabindex="-1" role="dialog" aria-labelledby="depositModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content" style="color: #333; background: #fff;">
					<div class="modal-header" style="background: #f8f9fa; border-bottom: 1px solid #dee2e6; padding: 15px 20px;">
						<h4 class="modal-title" id="depositModalLabel" style="color: #333; font-weight: bold; margin: 0;">Submit Deposit Confirmation</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #333; opacity: 0.8;">
							<span aria-hidden="true" style="font-size: 24px;">&times;</span>
						</button>
					</div>
					<form id="depositForm" enctype="multipart/form-data">
						<div class="modal-body" style="padding: 20px; color: #333;">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label style="color: #333; font-weight: bold; margin-bottom: 8px; display: block;">Cryptocurrency Type</label>
										<input type="text" id="deposit-type" name="deposit_type" class="form-control" readonly style="background: #f8f9fa; color: #333; border: 1px solid #ddd;">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label style="color: #333; font-weight: bold; margin-bottom: 8px; display: block;">Wallet Name</label>
										<input type="text" id="wallet-name" class="form-control" readonly style="background: #f8f9fa; color: #333; border: 1px solid #ddd;">
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<label style="color: #333; font-weight: bold; margin-bottom: 8px; display: block;">Wallet Address</label>
								<input type="text" id="wallet-address" name="wallet_address" class="form-control" readonly style="background: #f8f9fa; color: #333; border: 1px solid #ddd; font-family: monospace; font-size: 12px;">
							</div>
							
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label style="color: #333; font-weight: bold; margin-bottom: 8px; display: block;">Amount <span class="text-danger">*</span></label>
										<input type="number" name="amount" id="deposit-amount" class="form-control" step="0.01" min="0.01" required style="color: #333; border: 1px solid #ddd; padding: 10px;">
										<small class="form-text text-muted" style="color: #666; font-size: 12px;">Enter the exact amount you sent</small>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label style="color: #333; font-weight: bold; margin-bottom: 8px; display: block;">Transaction Hash/ID <span class="text-danger">*</span></label>
										<input type="text" name="txn_hash" id="txn-hash" class="form-control" required style="color: #333; border: 1px solid #ddd; padding: 10px; font-family: monospace; font-size: 12px;">
										<small class="form-text text-muted" style="color: #666; font-size: 12px;">Transaction ID from your wallet</small>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<label style="color: #333; font-weight: bold; margin-bottom: 8px; display: block;">Upload Payment Screenshot <span class="text-danger">*</span></label>
								<input type="file" name="screenshot" id="deposit-screenshot" class="form-control" accept="image/*" required style="color: #333; border: 1px solid #ddd; padding: 10px;">
								<small class="form-text text-muted" style="color: #666; font-size: 12px;">Upload clear screenshot of your payment confirmation</small>
							</div>
							
							<div class="form-group">
								<label style="color: #333; font-weight: bold; margin-bottom: 8px; display: block;">Additional Notes (Optional)</label>
								<textarea name="notes" class="form-control" rows="3" placeholder="Any additional information..." style="color: #333; border: 1px solid #ddd; padding: 10px; resize: vertical;"></textarea>
							</div>
							
							<div class="alert alert-info" style="background: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460; border-radius: 4px; padding: 15px; margin-bottom: 0;">
								<strong style="color: #0c5460;">Important Instructions:</strong>
								<ul class="mb-0" style="margin-top: 10px; padding-left: 20px; color: #0c5460;">
									<li style="margin-bottom: 5px;">Make sure the transaction hash is correct and valid</li>
									<li style="margin-bottom: 5px;">Upload a clear screenshot of your payment confirmation</li>
									<li style="margin-bottom: 5px;">Admin will verify and add balance within 24 hours</li>
									<li style="margin-bottom: 5px;">Do not submit duplicate deposits for the same transaction</li>
								</ul>
							</div>
						</div>
						<div class="modal-footer" style="background: #f8f9fa; border-top: 1px solid #dee2e6; padding: 15px 20px;">
							<button type="button" class="btn btn-secondary" data-dismiss="modal" style="color: #333; background: #6c757d; border: 1px solid #6c757d; padding: 8px 16px;">Cancel</button>
							<button type="submit" class="btn btn-success" id="submit-deposit" style="color: #fff; background: #28a745; border: 1px solid #28a745; padding: 8px 16px; margin-left: 10px;">Submit Deposit</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="col-lg-12">
			<section class="box" style="background: #fff; border: 1px solid #dee2e6; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
				<header class="panel_header" style="background: #f8f9fa; border-bottom: 1px solid #dee2e6; padding: 15px 20px; border-radius: 8px 8px 0 0;">
					<h2 class="title pull-left" style="color: #333; font-weight: bold; margin: 0;">Deposit History</h2>
				</header>
				<div class="content-body" style="padding: 20px; background: #fff;">
					<div class="row">
						<div class="col-xs-12">
							<div class="table-responsive" id="DepositReport" data-pattern="priority-columns">
								<table id="tech-companies-1" class="table vm trans table-small-font no-mb table-bordered table-striped" style="background: #fff; color: #333;">
									<thead style="background: #343a40; color: #fff;">
										<tr>
											<th style="color: #fff; font-weight: bold; padding: 12px;">Crypto Wallet</th>
											<th style="color: #fff; font-weight: bold; padding: 12px;">Transaction Hash</th>
											<th style="color: #fff; font-weight: bold; padding: 12px;">Time</th>
											<th style="color: #fff; font-weight: bold; padding: 12px;">Status</th>
											<th style="color: #fff; font-weight: bold; padding: 12px;">Amount</th>
										</tr>
									</thead>
									<tbody>
										<?php
											// Show manual deposits first
											$manualDeposits = $mysqli->query("SELECT md.*, mw.wallet_name FROM manual_deposits md LEFT JOIN manual_wallets mw ON md.wallet_id = mw.id WHERE md.user_id='".$member."' ORDER BY md.created_at DESC");
											while($manualDeposit = mysqli_fetch_assoc($manualDeposits)){
												$statusBadge = $manualDeposit['status'] == 'verified' ? 'success' : ($manualDeposit['status'] == 'pending' ? 'warning' : 'danger');
												$cryptoIcon = $manualDeposit['crypto_type'] == 'BTC' ? 'coin1.png' : 'usdt.png';
										?>
										<tr>
											<td>
												<div class="round img2">
													<img src="../data/crypto-dash/<?php echo $cryptoIcon; ?>" alt="">
												</div>
												<div class="designer-info">
													<h6 style="color: #333; font-weight: bold;"><?php echo $manualDeposit['crypto_type']; ?></h6>
													<small style="color: #666;"><?php echo $manualDeposit['wallet_name']; ?></small>
												</div>
											</td>
											<td>
												<span class="text-monospace" style="color: #333; font-size: 12px;">
													<?php echo substr($manualDeposit['txn_hash'], 0, 20) . '...'; ?>
												</span>
											</td>
											<td><small style="color: #333;"><?php echo date("d M-Y H:i:s", strtotime($manualDeposit['created_at'])); ?></small></td>
											<td><span class="badge bg-<?php echo $statusBadge; ?> w-70 round" style="background: <?php echo $statusBadge == 'success' ? '#28a745' : ($statusBadge == 'warning' ? '#ffc107' : '#dc3545'); ?>; color: #fff; padding: 4px 8px; border-radius: 12px;"><?php echo ucfirst($manualDeposit['status']); ?></span></td>
											<td class="green-text boldy" style="color: #28a745; font-weight: bold;">
												+ $<?php echo number_format($manualDeposit['amount'], 2); ?>
											</td>
										</tr>
										<?php } ?>
										
										<?php
											// Show old deposits for backward compatibility
											$InfoDeposit=$mysqli->query("SELECT * FROM `req_fund` WHERE `user`='".$member."'");
											while($allDeposit=mysqli_fetch_assoc($InfoDeposit)){
										?>
										<tr>
											<td>
												<div class="round img2">
													<img src="../data/crypto-dash/coin1.png" alt="">
												</div>
												<div class="designer-info">
													<h6 style="color: #333; font-weight: bold;">Bitcoin</h6>
												</div>
											</td>
											<td>
												<a class="btn btn-info btn-sm" target="_blank" href="https://www.blockchain.com/btc/tx/<?php echo $allDeposit['uniq_number']; ?>" style="color: #fff;">
													<?php echo substr($allDeposit['uniq_number'],0,20); ?>
												</a>
											</td>
											<td><small style="color: #333;"><?php echo date("d M-Y H:i:s", strtotime($allDeposit['date'])); ?></small></td>
											<td><span class="badge bg-success w-70 round" style="background: #28a745; color: #fff; padding: 4px 8px; border-radius: 12px;">completed</span></td>
											<td class="green-text boldy" style="color: #28a745; font-weight: bold;">
												+ $<?php echo number_format($allDeposit['amount']/9803, 2, '.',''); ?>
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>

		<script>
			$(document).ready(function() {
				// Copy address functionality
				$(document).on('click', '.copy-address', function(e) {
					e.preventDefault();
					var address = $(this).data('address');
					
					// Create temporary input element
					var tempInput = document.createElement('input');
					tempInput.value = address;
					document.body.appendChild(tempInput);
					tempInput.select();
					document.execCommand('copy');
					document.body.removeChild(tempInput);
					
					// Show success message
					$(this).html('<i class="fa fa-check"></i> Copied!');
					var button = $(this);
					setTimeout(function() {
						button.html('<i class="fa fa-copy"></i> Copy');
					}, 2000);
				});
				
				// Deposit button functionality
				$(document).on('click', '.deposit-btn', function(e) {
					e.preventDefault();
					var type = $(this).data('type');
					var address = $(this).data('address');
					var name = $(this).data('name');
					
					$('#deposit-type').val(type);
					$('#wallet-address').val(address);
					$('#wallet-name').val(name);
					$('#depositModal').modal('show');
				});
				
				// Form submission
				$('#depositForm').on('submit', function(e) {
					e.preventDefault();
					
					var formData = new FormData(this);
					$('#submit-deposit').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Submitting...');
					
					$.ajax({
						url: 'viewdata/submit_deposit.php',
						type: 'POST',
						data: formData,
						processData: false,
						contentType: false,
						success: function(response) {
							try {
								var result = JSON.parse(response);
								if(result.status === 'success') {
									alert('Deposit submitted successfully! Admin will verify your payment within 24 hours.');
									$('#depositModal').modal('hide');
									$('#depositForm')[0].reset();
									location.reload(); // Reload to show new deposit
								} else {
									alert('Error: ' + result.message);
								}
							} catch(e) {
								alert('Error submitting deposit. Please try again.');
							}
						},
						error: function() {
							alert('Network error. Please try again.');
						},
						complete: function() {
							$('#submit-deposit').prop('disabled', false).html('Submit Deposit');
						}
					});
				});
			});
		</script>
	</div>