	<div class="wrapper main-wrapper row" style='height:100vh'>
		<div class="col-lg-12">
			<section class="box" style="background:#211c8896">
				<header class="panel_header">
					<h2 class="title pull-left">💼 Account Activation Report</h2>
					<div class="actions panel_actions pull-right">
						<a class="box_toggle fa fa-chevron-down"></a>
						<a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
						<a class="box_close fa fa-times"></a>
					</div>
				</header>
				<div class="content-body">
					<div class="row">
						<div class="col-xs-12">
							
							<!-- Summary Cards -->
							<div class="row" style="margin-bottom: 20px;">
								<div class="col-md-3">
									<div style="background: #059669; color: white; padding: 15px; border-radius: 8px; text-align: center;">
										<?php
											$totalActivations = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(*) as total FROM `upgrade` WHERE `user`='".$member."'"));
										?>
										<h3 style="margin: 0; font-size: 24px;"><?php echo $totalActivations['total']; ?></h3>
										<small>Total Activations</small>
									</div>
								</div>
								<div class="col-md-3">
									<div style="background: #3b82f6; color: white; padding: 15px; border-radius: 8px; text-align: center;">
										<?php
											$totalInvested = mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) as total FROM `upgrade` WHERE `user`='".$member."'"));
										?>
										<h3 style="margin: 0; font-size: 24px;">$<?php echo number_format($totalInvested['total'] ?? 0, 2); ?></h3>
										<small>Total Invested</small>
									</div>
								</div>
								<div class="col-md-3">
									<div style="background: #dc2626; color: white; padding: 15px; border-radius: 8px; text-align: center;">
										<?php
											$totalFees = mysqli_fetch_assoc($mysqli->query("SELECT SUM(charge) as total FROM `upgrade` WHERE `user`='".$member."'"));
										?>
										<h3 style="margin: 0; font-size: 24px;">$<?php echo number_format($totalFees['total'] ?? 0, 2); ?></h3>
										<small>Total Activation Fees</small>
									</div>
								</div>
								<div class="col-md-3">
									<div style="background: #7c3aed; color: white; padding: 15px; border-radius: 8px; text-align: center;">
										<?php
											$totalBonus = mysqli_fetch_assoc($mysqli->query("SELECT SUM(bonus) as total FROM `upgrade` WHERE `user`='".$member."'"));
										?>
										<h3 style="margin: 0; font-size: 24px;">$<?php echo number_format($totalBonus['total'] ?? 0, 2); ?></h3>
										<small>Sponsor Bonus Generated</small>
									</div>
								</div>
							</div>

							<div class="table-responsive" data-pattern="priority-columns">
								<table id="activation-report-table" class="table vm trans table-small-font no-mb table-bordered table-striped">
									<thead>
										<tr style="background: #f8fafc;">
											<th style="color: #374151; font-weight: bold;">Date</th>
											<th style="color: #374151; font-weight: bold;">Time</th>
											<th style="color: #374151; font-weight: bold;">Package</th>
											<th style="color: #374151; font-weight: bold;">Investment</th>
											<th style="color: #374151; font-weight: bold;">Activation Fee</th>
											<th style="color: #374151; font-weight: bold;">Sponsor Bonus</th>
											<th style="color: #374151; font-weight: bold;">Invoice</th>
											<th style="color: #374151; font-weight: bold;">Status</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$activationQuery = $mysqli->query("SELECT * FROM `upgrade` WHERE `user`='".$member."' ORDER BY `date` DESC LIMIT 30");
											if(mysqli_num_rows($activationQuery) > 0) {
												while($activation = mysqli_fetch_assoc($activationQuery)){
													// Determine package range based on amount
													$amount = floatval($activation['amount']);
													$packageRange = '';
													$packageColor = '';
													if($amount >= 100 && $amount <= 999) {
														$packageRange = 'Basic Range (0.5% Daily)';
														$packageColor = '#059669';
													} elseif($amount >= 1000 && $amount <= 4999) {
														$packageRange = 'Premium Range (0.7% Daily)';
														$packageColor = '#dc2626';
													} else {
														$packageRange = 'VIP Range (1.0% Daily)';
														$packageColor = '#7c3aed';
													}
										?>
										<tr style="border-bottom: 1px solid #e5e7eb;">
											<td style="color: #374151; font-weight: 500;">
												<?php echo date("d M Y", strtotime($activation['date'])); ?>
											</td>
											<td style="color: #6b7280;">
												<?php echo date("H:i:s", strtotime($activation['date'])); ?>
											</td>
											<td>
												<div style="color: <?php echo $packageColor; ?>; font-weight: bold; font-size: 13px;">
													<?php echo $packageRange; ?>
												</div>
												<small style="color: #9ca3af;">$<?php echo number_format($activation['amount'], 2); ?></small>
											</td>
											<td>
												<span style="color: #059669; font-weight: bold; font-size: 14px;">
													$<?php echo number_format($activation['amount'], 2); ?>
												</span>
											</td>
											<td>
												<span style="color: #dc2626; font-weight: bold;">
													$<?php echo number_format($activation['charge'], 2); ?>
												</span>
											</td>
											<td>
												<span style="color: #3b82f6; font-weight: bold;">
													$<?php echo number_format($activation['bonus'], 2); ?>
												</span>
											</td>
											<td>
												<code style="background: #f3f4f6; padding: 3px 6px; border-radius: 4px; font-size: 11px; color: #374151;">
													<?php echo htmlspecialchars($activation['invoice']); ?>
												</code>
											</td>
											<td>
												<span class="badge round-success" style="background: #dcfce7; color: #166534; padding: 4px 8px; border-radius: 20px; font-size: 11px;">
													✅ Activated
												</span>
											</td>
										</tr>
										<?php 
												}
											} else {
										?>
										<tr>
											<td colspan="8" style="text-align: center; padding: 40px; color: #9ca3af;">
												<div style="font-size: 48px; margin-bottom: 10px;">📊</div>
												<h4 style="color: #6b7280; margin: 0 0 5px 0;">No Activation History</h4>
												<p style="margin: 0; font-size: 14px;">Your investment activations will appear here once you make your first investment.</p>
												<a href="index.php?route=activation_details&paccg=<?php echo base64_encode('investment/package/1'); ?>&tild=<?php echo base64_encode(time()); ?>&title=" 
												   class="btn btn-primary" style="margin-top: 15px; background: linear-gradient(135deg, #1e3a8a, #3b82f6); border: none; padding: 10px 20px;">
													🚀 Start Investing
												</a>
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
	</div>

	<style>
		.badge.round-success {
			font-size: 11px !important;
			padding: 4px 8px !important;
			border-radius: 20px !important;
		}
		
		#activation-report-table tbody tr:hover {
			background-color: #f8fafc;
			transition: background-color 0.2s ease;
		}
		
		.table-responsive {
			border-radius: 8px;
			overflow: hidden;
			box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
		}
		
		.table thead th {
			border-bottom: 2px solid #e5e7eb !important;
			padding: 12px 8px !important;
		}
		
		.table tbody td {
			padding: 10px 8px !important;
			vertical-align: middle !important;
		}
	</style>