	<div class="wrapper main-wrapper row" style='height:100vh'>
		<div class="col-lg-12">
			<section class="box" style="background:#211c8896">
				<header class="panel_header">
					<h2 class="title pull-left">Transfer History</h2>
					<div class="actions panel_actions pull-right">
						<a class="box_toggle fa fa-chevron-down"></a>
						<a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
						<a class="box_close fa fa-times"></a>
					</div>
				</header>
				<div class="content-body">
					<div class="row">
						<div class="col-xs-12">

							<div class="table-responsive" data-pattern="priority-columns">
								<table id="tech-companies-1" class="table vm trans table-small-font no-mb table-bordered table-striped">
									<thead>
										<tr>
											<th>Date</th>
											<th>Time</th>
											<th>Transfer To</th>
											<th>Status</th>
											<th>Amount</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$dfjkghfd=$mysqli->query("SELECT * FROM `trans_receive` WHERE `user_trans`='".$member."' AND `type`='Transfer' ORDER BY `serialno` DESC");
											while($AllTrans=mysqli_fetch_assoc($dfjkghfd)){
										?>
										<tr>
											<td>
												<?php echo date("d M-Y", strtotime($AllTrans['time'])); ?>
											</td>
											<td>
												<?php echo date("H:i:s", strtotime($AllTrans['time'])); ?>
											</td>
											<td>
												<?php echo $AllTrans['user_receive']; ?>
											</td>
											<td><span class="badge  w-70 round-success">completed</span></td>
											<td class="red-text boldy">- $<?php echo $AllTrans['ammount']; ?></td>
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