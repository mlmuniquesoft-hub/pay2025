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

							<div class="table-responsive" id="DepositReport" data-pattern="priority-columns">
								<table id="tech-companies-1" class="table vm trans table-small-font no-mb table-bordered table-striped">
									<thead>
										<tr>
											<th>Crypto Wallet</th>
											<th>Transaction Hash</th>
											<th>Time</th>
											<th>Status</th>
											<th>Amount</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$InfoDeposit=$mysqli->query("SELECT * FROM `req_fund` WHERE `user`='".$member."' ORDER BY `serial` DESC");
											while($allDeposit=mysqli_fetch_assoc($InfoDeposit)){
										?>
										<tr>
											<td>
												<div class="round img2">
													<img src="../data/crypto-dash/coin1.png" alt="">
												</div>
												<div class="designer-info">
													<h6>Bitcoin</h6>
												</div>
											</td>
											<td>
												<a class="btn btn-info" target="_blank" href="https://www.blockchain.com/btc/tx/<?php echo $allDeposit['uniq_number']; ?>">
													<?php echo substr($allDeposit['uniq_number'],0,20); ?>
												</a>
											</td>
											<td><small class="text-muted"><?php echo date("d M-Y H:i:s", strtotime($allDeposit['date'])); ?></small></td>
											<td><span class="badge  w-70 round-success">completed</span></td>
											<td class="green-text boldy">
											 <?php 
											
											//echo ($allDeposit['amount']/100000000); ?> 
											+ $<?php echo number_format($allDeposit['amount'], 2, '.',''); ?>
											
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